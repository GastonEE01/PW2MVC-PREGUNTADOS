function mostrarFondo(categoria) {
    var colorFondo;
    console.log('Categoria:', categoria); // Verificar el valor de la categoría

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
let totalTime = 15; // Tiempo total en segundos
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
        // let alertSound = document.getElementById('alertSound');
        //  alertSound.play();

        modal.style.display = "flex";

        closeModal.onclick = function() {
            window.location.href = '/tp-pw2-MiniPreguntados/app/Partida/validarRespuesta';
            modal.style.display = "none"; // Cerrar el modal
        };

        window.onclick = function(event) {
            if (event.target == modal) {
                window.location.href = '/tp-pw2-MiniPreguntados/app/Partida/validarRespuesta';
                modal.style.display = "none"; // Cerrar el modal
            }
        };
    }
}, 1000); // Actualizar cada segundo


function mostrarModalReportar() {
    document.getElementById("reportarPreguntaModal").style.display = "block";
}

// Función para cerrar el modal
document.getElementById("closeModal").onclick = function() {
    document.getElementById("reportarPreguntaModal").style.display = "none";
}

// Función para reportar la pregunta (puedes ajustarla según tu lógica)
function reportarPregunta() {
    let motivo = document.getElementById("motivoReporte").value;
    alert("Pregunta reportada con motivo: " + motivo);
    // Aquí podrías agregar la lógica para enviar el reporte al servidor
    document.getElementById("reportarPreguntaModal").style.display = "none"; // Cerrar el modal después de enviar el reporte
}

/*
const opcionElegida = document.getElementById('opcionElegida');
const mostrarModalCorrecto = document.getElementById('modalCorrecto').style.display = "none";
const mostrarModalInCorrecto = document.getElementById('modalCorrecto').style.display = "none";

if(opcionElegida == 'correcto'){
      document.getElementById('modalCorrecto').style.display = "block";
}else if(opcionElegida == 'incorrecto'){
     document.getElementById('modalCorrecto').style.display = "block";
}*/

// Función para mostrar el modal basado en la respuesta
function mostrarModalResultado(esCorrecto) {
    if (esCorrecto) {
        document.getElementById("modalCorrecto").style.display = "block";
        mostrarModalCorrecto();
    } else if(!esCorrecto){
        document.getElementById("modalIncorrecto").style.display = "block";
        mostrarModalIncorrecto();
    }

    // Opcional: Ocultar el modal automáticamente después de unos segundos
    setTimeout(() => {
        document.getElementById("modalCorrecto").style.display = "none";
       // document.getElementById("modalIncorrecto").style.display = "none";
    }, 3000); // 3 segundos
}

document.getElementById("formValidarRespuesta").onsubmit = function(event) {
    event.preventDefault(); // Evitar recargar la página

    // Simulación de respuesta del servidor
    const esCorrecto = Math.random() > 0.5; // Cambia esto por tu lógica real

    // Mostrar el modal según el resultado
    mostrarModalResultado(esCorrecto);
};

function mostrarModalCorrecto() {
    const modalCorrecto = document.getElementById('modalCorrecto');
    modalCorrecto.style.display = 'flex'; // Mostrar el modal

    // Espera 3 segundos y redirige a la ruleta
    setTimeout(() => {
        window.location.href = '/PreguntadosPWII-main/Partida/usuarioRespondioBien';
    }, 3000);
}

// Función para mostrar el modal
function mostrarModalIncorrecto() {
    const modalIncorrecto = document.getElementById('modalIncorrecto');
    modalIncorrecto.style.display = 'flex'; // Mostrar el modal
}

// Función para cerrar el modal
function cerrarModal() {
    const modalIncorrecto = document.getElementById('modalIncorrecto');
    modalIncorrecto.style.display = 'none'; // Ocultar el modal
}




/*
function mostrarModalOpcionElegida(mostrarModal) {
    const mostrarModalCorrecto = document.getElementById('modalCorrecto');
    const mostrarModalInCorrecto = document.getElementById('modalIncorrecto');

    if(mostrarModal === 'correcto'){
        mostrarModalCorrecto.style.display = "block";
     //   mostrarModalInCorrecto.style.display = "none";
    } else if(mostrarModal === 'incorrecto'){
        //mostrarModalCorrecto.style.display = "none";
        mostrarModalInCorrecto.style.display = "block";
    } else if(mostrarModal === 'NoEligioOpcion'){
        mostrarModalCorrecto.style.display = "none";
        mostrarModalInCorrecto.style.display = "none";
    }

}*/





