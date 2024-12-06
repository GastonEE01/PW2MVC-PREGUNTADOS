const audio = document.getElementById('background-audio');
const muteIcon = document.getElementById('mute-icon');
const muteTimer = document.getElementById('timer-audio');

// Inicialmente el sonido está activado
let isMuted = false;

function apagarSonido() {
    isMuted = !isMuted; // Cambiar el estado de mute
    if (isMuted) {
        audio.pause(); // Pausar música
       // muteTimer.pause();
        muteIcon.src = "../public/imagenes/sonido/mute.png"; // Cambiar a icono de sonido desactivado
        muteIcon.alt = "Sonido desactivado";
    } else {
        audio.play(); // Reanudar música
      //  muteTimer.play();
        muteIcon.src = "../public/imagenes/sonido/sonido.png"; // Cambiar a icono de sonido activado
        muteIcon.alt = "Sonido activado";
    }
}

function apagarSonidoPartida() {
    isMuted = !isMuted; // Cambiar el estado de mute
    if (isMuted) {
        audio.pause(); // Pausar música
         muteTimer.pause();
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/mute.png";
        muteIcon.alt = "Sonido desactivado";
    } else {
        audio.play(); // Reanudar música
          muteTimer.play();
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/sonido.png";
        muteIcon.alt = "Sonido activado";
    }
}


function apagarSonidoFondoYTemporalizador() {
    isMuted = !isMuted; // Cambiar el estado de mute

    if (isMuted) {
        audio.pause(); // Pausar música de fondo
        muteTimer.pause(); // Pausar sonido del temporizador
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/mute.png"; // Cambiar a icono de sonido desactivado
        muteIcon.alt = "Sonido desactivado";
    } else {
        audio.play(); // Reanudar música de fondo
        muteTimer.play(); // Reanudar sonido del temporizador
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/sonido.png"; // Cambiar a icono de sonido activado
        muteIcon.alt = "Sonido activado";
    }
}
