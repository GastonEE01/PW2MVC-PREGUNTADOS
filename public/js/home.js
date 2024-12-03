// mostrar para crear la pregunta
function openPopup() {
    document.getElementById("popup").style.display = "block"; // Muestra el popup
}

// Función para cerrar el popup
function closePopup() {
    document.getElementById("popup").style.display = "none"; // Oculta el popup
}


// mostrar el ranking
function openRanking() {
    document.getElementById("rankingPopup").style.display = "block";
}

// Función para cerrar el popup de clasificación
function closeRanking() {
    document.getElementById("rankingPopup").style.display = "none";
}


// Cerrar el popup al hacer clic fuera de él
window.onclick = function(event) {
    if (event.target === document.getElementById("rankingPopup")) {
        closeRanking();
    }
    if (event.target === document.getElementById("popup")) {
        closePopup();
    }
}

// Abre un modal específico por su ID
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Cierra un modal específico por su ID
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Cierra el modal si el usuario hace clic fuera de él
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
};

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}
