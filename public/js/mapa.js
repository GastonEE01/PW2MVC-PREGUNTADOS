
document.addEventListener('DOMContentLoaded', function () {
    // Crear el mapa y establecer la vista inicial
    var map = L.map('map').setView([-34.61, -58.38], 12); // Coordenadas de Buenos Aires

    // Cargar los tiles de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Agregar un marcador en la ubicación inicial
    var marker = L.marker([-34.61, -58.38]).addTo(map)
        .bindPopup('<b>Buenos Aires</b><br>¡Bienvenido a la ciudad!')
        .openPopup();

    // Manejar clics en el mapa
    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // Mover el marcador a la posición donde se hizo clic
        marker.setLatLng([lat, lng]);

        // Obtener la ciudad y el país usando Nominatim
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
            .then(response => response.json())
            .then(data => {
                // Extraer ciudad y país de la respuesta
                var ciudad = data.address.city || data.address.town || data.address.village || "Desconocido";
                var pais = data.address.country || "Desconocido";

                // Mostrar un popup con la información
                marker.bindPopup(`Ubicación seleccionada:<br>Latitud: ${lat}<br>Longitud: ${lng}<br>Ciudad: ${ciudad}<br>País: ${pais}`).openPopup();

                // Guardar las coordenadas, ciudad y país en los campos ocultos del formulario
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                document.getElementById('ciudad').value = ciudad;
                document.getElementById('pais').value = pais;
            })
            .catch(error => {
                console.error('Error al obtener la información de la ubicación:', error);
                // Manejar errores, si es necesario
            });
    });
});


