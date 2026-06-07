const map = L.map('map').setView([40.775, -73.972], 15);

L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 20
}).addTo(map);

let globalQueryString = "";
const markersLayer = L.layerGroup().addTo(map);

const filterForm = document.getElementById('filter-form');

filterForm.addEventListener('submit', function(event) {
    event.preventDefault(); 

    markersLayer.clearLayers();

    const formData = new FormData(filterForm);
    
    const queryString = new URLSearchParams(formData).toString();
    globalQueryString = queryString;
    fetch(`/api/accidents?${queryString}`)
        .then(response => response.json()) 
        .then(data => {
            console.log("Accidente gasite: ", data.length); 

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
                }
            });

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
        history.replaceState(null, '', window.location.pathname);
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
    fetch(`/api/accidents?${queryString}`)
        .then(response => response.json()) 
        .then(data => {
            console.log("Accidente gasite: ", data.length); 

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
                }
            });

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

