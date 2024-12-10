
document.addEventListener("DOMContentLoaded", function () {
    // Abrir el modal al hacer clic en el botón "Modificar"
    document.querySelectorAll(".open-modal").forEach(button => {
        button.addEventListener("click", function () {
            const modalId = this.getAttribute("data-id");
            const modal = document.getElementById(`modal-${modalId}`);
            if (modal) {
                modal.style.display = "block";
            }
        });
    });

    // Cerrar el modal
    /*document.querySelectorAll(".close").forEach(closeButton => {
        closeButton.addEventListener("click", function () {
            const modalId = this.getAttribute("data-id");
            const modal = document.getElementById(`modal-${modalId}`);
            if (modal) {
                modal.style.display = "none";
            }
        });
    });*/

    // Cerrar el modal
    window.addEventListener("click", function (event) {
        document.querySelectorAll(".modal").forEach(modal => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    });
});
