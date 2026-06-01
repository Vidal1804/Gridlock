const map = L.map('map').setView([40.775, -73.972], 15);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

L.marker([[40.775, -73.972]]).addTo(map)
    .bindPopup('merge mapa')
    .openPopup();
