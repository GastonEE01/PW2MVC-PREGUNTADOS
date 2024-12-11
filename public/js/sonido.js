const audio = document.getElementById('background-audio');
const muteIcon = document.getElementById('mute-icon');
const muteTimer = document.getElementById('timer-audio');

// inicio el sonido desactivado
let isMuted = false;

function apagarSonido() {
    isMuted = !isMuted;
    if (isMuted) {
        audio.pause();
        muteIcon.src = "../public/imagenes/sonido/mute.png";
        muteIcon.alt = "Sonido desactivado";
    } else {
        audio.play();
        muteIcon.src = "../public/imagenes/sonido/sonido.png";
        muteIcon.alt = "Sonido activado";
    }
}

function apagarSonidoPartida() {
    isMuted = !isMuted;
    if (isMuted) {
        audio.pause();
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/mute.png";
        muteIcon.alt = "Sonido desactivado";
    } else {
        audio.play();
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/sonido.png";
        muteIcon.alt = "Sonido activado";
    }
}


function apagarSonidoFondoYTemporalizador() {
    isMuted = !isMuted;

    if (isMuted) {
        audio.pause();
        muteTimer.pause();
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/mute.png";
        muteIcon.alt = "Sonido desactivado";
    } else {
        audio.play();
        muteTimer.play();
        muteIcon.src = "/PW2MVC-PREGUNTADOS/public/imagenes/sonido/sonido.png";
        muteIcon.alt = "Sonido activado";
    }
}
