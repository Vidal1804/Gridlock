const map = L.map('map').setView([40.775, -73.972], 15);
let currentTileLayer = null;

window.updateMapTheme = function(theme) {
    if (currentTileLayer) {
        map.removeLayer(currentTileLayer);
    }
    
    const mapStyle = (theme === 'light') ? 'light_all' : 'dark_all';
    
    currentTileLayer = L.tileLayer(`https://{s}.basemaps.cartocdn.com/${mapStyle}/{z}/{x}/{y}{r}.png`, {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);
};

const savedTheme = localStorage.getItem('theme') || 'dark'; // default dark
updateMapTheme(savedTheme);

let globalQueryString = "";
const markersLayer = L.layerGroup().addTo(map);
const heatLayer = L.layerGroup()

const baseMaps = {};
const overlayMaps = {
    "Markers": markersLayer,
    "Heatmap": heatLayer
};
L.control.layers(baseMaps, overlayMaps, { collapsed: false }).addTo(map);

const filterForm = document.getElementById('filter-form');

filterForm.addEventListener('submit', function(event) {
    event.preventDefault(); 

    markersLayer.clearLayers();
    heatLayer.clearLayers();

    const heatPoints = [];

    const formData = new FormData(filterForm);
    
    const queryString = new URLSearchParams(formData).toString();
    globalQueryString = queryString;
    fetch(`/api/accidents?${queryString}`)
        .then(response => response.json()) 
        .then(data => {
            console.log("Accidente gasite: ", data.length); 
            drawAllCharts(data);

            data.forEach(accident => {
                if(accident.start_lat && accident.start_lng) {
                    const marker = L.marker([accident.start_lat, accident.start_lng]);
                    
                    marker.bindPopup(`
                        <strong>City:</strong> ${accident.city || 'Unknown'}<br>
                        <strong>Severity:</strong> ${accident.severity}<br>
                        <strong>Weather:</strong> ${accident.weather_condition}<br>
                        <strong>Date:</strong> ${accident.start_time}
                    `);

                    markersLayer.addLayer(marker);
                    const intensity = accident.severity ? accident.severity * 0.5 : 1.0; 
                    heatPoints.push([accident.start_lat, accident.start_lng, intensity]);
                }
            });

            if (heatPoints.length > 0) {
                const heatInstance = L.heatLayer(heatPoints, {
                    radius: 20,
                    blur: 15,
                    maxZoom: 15,
                    max: 0.5
                });
                heatLayer.addLayer(heatInstance);
            }

            if(data.length > 0 && data[0].start_lat) {
                map.setView([data[0].start_lat, data[0].start_lng], 10);
            }
        })
        .catch(error => console.error('Eroare la aducerea accidentelor:', error));
});

window.addEventListener('DOMContentLoaded', () =>{
    if (window.location.search) {
        const queryString = window.location.search.substring(1);
        customLoad(queryString);
        populateFormFromQuery(queryString);
    }
})

document.getElementById('save-query-btn').addEventListener('click', async () => {
    const dataToSend = {
        id: currentUserId,
        queryString: globalQueryString
    };

    try {
        const response = await fetch('/api/users/savequery', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        });

        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        const result = await response.json();
        alert('Query saved successfully!');
        
    } catch (error) {
        console.error('Failed to save query:', error);
        alert('Could not save your query. Please try again.');
    }
});

async function customLoad(queryString){
    markersLayer.clearLayers();
    heatLayer.clearLayers();
    const heatPoints = [];

    fetch(`/api/accidents?${queryString}`)
        .then(response => response.json()) 
        .then(data => {
            console.log("Accidente gasite: ", data.length); 
            drawAllCharts(data);

            data.forEach(accident => {
                if(accident.start_lat && accident.start_lng) {
                    const marker = L.marker([accident.start_lat, accident.start_lng]);
                    
                    marker.bindPopup(`
                        <strong>City:</strong> ${accident.city || 'Unknown'}<br>
                        <strong>Severity:</strong> ${accident.severity}<br>
                        <strong>Weather:</strong> ${accident.weather_condition}<br>
                        <strong>Date:</strong> ${accident.start_time}
                    `);

                    markersLayer.addLayer(marker);
                    const intensity = accident.severity ? accident.severity * 0.5 : 1.0; 
                    heatPoints.push([accident.start_lat, accident.start_lng, intensity]);
                }
            });

            if (heatPoints.length > 0) {
                const heatInstance = L.heatLayer(heatPoints, {
                    radius: 20,
                    blur: 15,
                    maxZoom: 15,
                    max: 0.5
                });
                heatLayer.addLayer(heatInstance);
            }

            if(data.length > 0 && data[0].start_lat) {
                map.setView([data[0].start_lat, data[0].start_lng], 10);
            }
        })
        .catch(error => console.error('Eroare la aducerea accidentelor:', error));
}

function populateFormFromQuery(queryString) {
    const params = new URLSearchParams(queryString);
    const filterForm = document.getElementById('filter-form');

    params.forEach((value, key) => {
        const input = filterForm.elements[key];

        if (input) {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = (input.value === value);
            } else {
                input.value = value;
            }
        }
    });
}


let timelineChartInst = null;
let stateChartInst = null;
let weatherChartInst = null;
let currentTimelineMode = 'year';
let lastAccidentsData = []; 

function drawAllCharts(accidentsArray) {
    if (!accidentsArray || accidentsArray.length === 0) {
        if (timelineChartInst) timelineChartInst.destroy();
        if (stateChartInst) stateChartInst.destroy();
        if (weatherChartInst) weatherChartInst.destroy();
        lastAccidentsData = []; 
        return; 
    }

    lastAccidentsData = accidentsArray; 
    drawTimelineChart(lastAccidentsData);
    drawStateChart(lastAccidentsData);
    drawWeatherChart(lastAccidentsData);
}

// 1. TIMELINE 
function drawTimelineChart(data) {
    if (!data || data.length === 0) return;
    const counts = {};
    
    data.forEach(acc => {
        if(!acc.start_time) return;
        let key = currentTimelineMode === 'year' ? acc.start_time.substring(0, 4) : acc.start_time.substring(0, 7);
        counts[key] = (counts[key] || 0) + 1;
    });

    const labels = Object.keys(counts).sort();
    const values = labels.map(label => counts[label]);

    const ctx = document.getElementById('timelineChart').getContext('2d');
    if (timelineChartInst) timelineChartInst.destroy();

    timelineChartInst = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Accidents',
                data: values,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.2)',
                tension: 0.3, 
                fill: true
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
}

// 2. STATE DISTRIBUTION 
function drawStateChart(data) {
    if (!data || data.length === 0) return;
    const totalAccidents = data.length;
    const counts = {};

    data.forEach(acc => {
        let state = acc.state || 'Unknown';
        counts[state] = (counts[state] || 0) + 1;
    });

    let labels = Object.keys(counts).sort((a, b) => counts[b] - counts[a]);

    labels = labels.slice(0, 10);

    const percentages = labels.map(state => ((counts[state] / totalAccidents) * 100).toFixed(1));

    const canvas = document.getElementById('stateChart');
    const ctx = canvas.getContext('2d');

    if (stateChartInst) stateChartInst.destroy();

    stateChartInst = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: '% of Accidents',
                data: percentages,
                backgroundColor: '#ef4444',
                borderRadius: 4
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            scales: { 
                y: { max: 100, beginAtZero: true } 
            },
            plugins: { 
                legend: { display: false } 
            } 
        }
    });
}

// 3. WEATHER ANALYSIS
function drawWeatherChart(data) {
    if (!data || data.length === 0) return;
    const counts = {};

    data.forEach(acc => {
        let weather = acc.weather_condition || 'Unknown';
        counts[weather] = (counts[weather] || 0) + 1;
    });

    const labels = Object.keys(counts);
    const values = Object.values(counts);

    const ctx = document.getElementById('weatherChart').getContext('2d');
    if (weatherChartInst) weatherChartInst.destroy();

    weatherChartInst = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: ['#ef4444', '#3b82f6', '#f59e0b', '#10b981', '#8b5cf6', '#64748b']
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { legend: { position: 'right' } }
        }
    });
}

document.addEventListener('click', function(event) {
   if (event.target && event.target.id === 'toggleTimelineBtn') {
        event.preventDefault(); 

        if (!lastAccidentsData || lastAccidentsData.length === 0) {
            return;
        }

        if (currentTimelineMode === 'year') {
            currentTimelineMode = 'month';
            event.target.innerText = 'Show by Year';
        } else {
            currentTimelineMode = 'year';
            event.target.innerText = 'Show by Month';
        }

        drawTimelineChart(lastAccidentsData);
    }
});

//export jpg
document.getElementById('export-webp-btn').addEventListener('click', () => {
    if (!lastAccidentsData.length) return alert("No data available to export.");

    const mapContainer = document.getElementById('map');

    html2canvas(mapContainer, {
        useCORS: true,
        allowTaint: false
    }).then(canvas => {
        canvas.toBlob(blob => {
            createDownload(blob, 'map-export.webp');
        }, 'image/webp', 0.9);
    }).catch(err => {
        console.error('Export failed:', err);
    });
});

//export svg
document.getElementById('export-svg-btn').addEventListener('click', () => {
    if (!lastAccidentsData.length) return alert("No data available to export.");

    const mapContainer = document.getElementById('map');

    html2canvas(mapContainer, {
        useCORS: true,
        allowTaint: false
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const svgString = `
            <svg xmlns="http://www.w3.org/2000/svg" width="${canvas.width}" height="${canvas.height}">
                <image href="${imgData}" width="${canvas.width}" height="${canvas.height}" />
            </svg>
        `;
        
        createDownload(svgString, 'map-export.svg', 'image/svg+xml;charset=utf-8');
    }).catch(err => {
        console.error('Export failed:', err);
    });
});

//helper download function
function createDownload(content, filename, contentType) {
    const fileData = new Blob([content], { type: contentType });
    const url = URL.createObjectURL(fileData);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
}

