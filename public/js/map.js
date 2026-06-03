const map = L.map('map').setView([40.775, -73.972], 15);

L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 20
}).addTo(map);


const markersLayer = L.layerGroup().addTo(map);

const filterForm = document.getElementById('filter-form');

filterForm.addEventListener('submit', function(event) {
    event.preventDefault(); 

    markersLayer.clearLayers();

    const formData = new FormData(filterForm);
    
    const queryString = new URLSearchParams(formData).toString();

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
                        <strong>Weather:</strong> ${accident.weather_condition}
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
