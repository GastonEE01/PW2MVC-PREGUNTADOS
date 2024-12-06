function mostrarFondo(categoria) {
    var colorFondo;
    console.log('Categoria:', categoria);

    if (categoria == 'Arte') {
        colorFondo = '#ff9800';
    } else if (categoria == 'Cine') {
        colorFondo = '#9c27b0';
    } else if (categoria == 'Deportes') {
        colorFondo = '#f44336';
    } else if (categoria == 'Historia') {
        colorFondo = '#ffeb3b';
    } else if (categoria == 'Ciencia') {
        colorFondo = '#4caf50';
    } else if (categoria == 'Geografía') {
        colorFondo = '#2196f3';
    }
    document.body.style.backgroundColor = colorFondo;


}
let countdownElement = document.getElementById('countdown');
let progressBar = document.getElementById('progressBar');
let totalTime = 30; // Tiempo total en segundos
let timeLeft = totalTime;
let modal = document.getElementById('timeOverModal');
let closeModal = document.getElementById('closeModal');

// Función para actualizar el contador y la barra de progreso
let countdownInterval = setInterval(() => {
    timeLeft--;
    countdownElement.textContent = timeLeft;

    // Calcular el ancho de la barra de progreso
    let progressPercentage = ((totalTime - timeLeft) / totalTime) * 100;
    progressBar.style.width = progressPercentage + '%';

    if (timeLeft <= 0) {
        clearInterval(countdownInterval); // Detener el temporizador

        // Reproducir el sonido
        // Detener el sonido del temporizador
        let timerAudio = document.getElementById('timer-audio');
        timerAudio.pause(); // Pausar el audio

        closeModal.onclick = function() {
            window.location.href = '/PW2MVC-PREGUNTADOS/Partida/validarRespuesta';
            modal.style.display = "none"; // Cerrar el modal
        };

        closeModal.onclick = function() {
                window.location.href = '/PW2MVC-PREGUNTADOS/Partida/validarRespuesta';
                modal.style.display = "none"; // Cerrar el modal
        };
    }
}, 1000); // Actualizar cada segundo

// Función para cerrar el modal
document.getElementById("closeModal").onclick = function() {
    modal.style.display = "none";
};

function reportarPregunta() {
    let motivo = document.getElementById("motivoReporte").value;
    alert("Pregunta reportada con motivo: " + motivo);
    modal.style.display = "none";
}


function mostrarModalReportar() {
    document.getElementById("reportarPreguntaModal").style.display = "block";
}

// Función para cerrar el modal
document.getElementById("closeModal").onclick = function() {
    document.getElementById("reportarPreguntaModal").style.display = "none";
}

function reportarPregunta() {
    let motivo = document.getElementById("motivoReporte").value;
    alert("Pregunta reportada con motivo: " + motivo);
    // Aquí podrías agregar la lógica para enviar el reporte al servidor
    document.getElementById("reportarPreguntaModal").style.display = "none";
}





