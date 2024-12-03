
document.addEventListener('DOMContentLoaded', function () {
    // Obtén los valores de las variables directamente del DOM
    var ciudadElegida = document.getElementById('ciudad').value;
    var paisElegido = document.getElementById('pais').value;

    var coords = {
        'Canarana': [-5.05, -52.24],
        // falta agregarle las cordenadas para eso modificar la tabla usuario y pasarle las coordenadas
    };

    const coordsSeleccionadas = coords[ciudadElegida] || [-34.61, -58.38];
    var map = L.map('map').setView(coordsSeleccionadas, 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    L.marker(coordsSeleccionadas).addTo(map)
        .bindPopup('<b>' + ciudadElegida + '</b><br>' + paisElegido)
        .openPopup();
});

