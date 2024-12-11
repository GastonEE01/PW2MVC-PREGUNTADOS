document.addEventListener('DOMContentLoaded', function() {
    const ageModal = document.getElementById('ageModal');
    const gameQuestionsModal = document.getElementById('gameQuestionsModal');
    const showAgeStatsBtn = document.getElementById('showAgeStats');
    const showGameQuestionsBtn = document.getElementById('showGameQuestions');
    const closeButtons = document.getElementsByClassName('close');
    const downloadAgePDFBtn = document.getElementById('downloadAgePDF');
    const downloadGameQuestionsPDFBtn = document.getElementById('downloadGameQuestionsPDF');

    // Datos de usuario por edad
    const ninio = document.getElementById('ninio').value;
    const adolescente = document.getElementById('adolecente').value;
    const adulto = document.getElementById('adulto').value;
    const anciano = document.getElementById('anciano').value;

    // Datos de cantidad de pregunta por categoria
    const arte = document.getElementById('arte').value;
    const cine = document.getElementById('cine').value;
    const historia = document.getElementById('historia').value;
    const deporte = document.getElementById('deporte').value;
    const ciencia = document.getElementById('ciencia').value;
    const geografia = document.getElementById('geografia').value;

    // Datos de cantidad de pregunta corectas por categoria
    const arteCorrectas = document.getElementById('arteCorrectas').value;
    const cineCorrectas = document.getElementById('cineCorrectas').value;
    const historiaCorrectas = document.getElementById('historiaCorrectas').value;
    const deporteCorrectas = document.getElementById('deporteCorrectas').value;
    const cienciaCorrectas = document.getElementById('cienciaCorrectas').value;
    const geografiaCorrectas = document.getElementById('geografiaCorrectas').value;

    // Datos de cantidad de pregunta incorectas por categoria
    const arteIncorrectas = document.getElementById('arteIncorrectas').value;
    const cineIncorrectas = document.getElementById('cineIncorrectas').value;
    const historiaIncorrectas = document.getElementById('historiaIncorrectas').value;
    const deporteIncorrectas = document.getElementById('deporteIncorrectas').value;
    const cienciaIncorrectas = document.getElementById('cienciaIncorrectas').value;
    const geografiaIncorrectas = document.getElementById('geografiaIncorrectas').value;

    // Datos del filtro  cantidad de preg facil,normal,dificil de cada categoria
    const cantidadFacilArte = document.getElementById('cantidadFacilArte').value;
    const cantidadFacilCine = document.getElementById('cantidadFacilCine').value;
    const cantidadFacilHistoria = document.getElementById('cantidadFacilHistoria').value;
    const cantidadFacilDeporte = document.getElementById('cantidadFacilDeporte').value;
    const cantidadFacilCiencia = document.getElementById('cantidadFacilCiencia').value;
    const cantidadFacilGeografia = document.getElementById('cantidadFacilGeografia').value;

    const cantidadNormalArte = document.getElementById('cantidadNormalArte').value;
    const cantidadNormalCine = document.getElementById('cantidadNormalCine').value;
    const cantidadNormalHistoria = document.getElementById('cantidadNormalHistoria').value;
    const cantidadNormalDeporte = document.getElementById('cantidadNormalDeporte').value;
    const cantidadNormalCiencia = document.getElementById('cantidadNormalCiencia').value;
    const cantidadNormalGeografia = document.getElementById('cantidadNormalGeografia').value;

    const cantidadDificilArte = document.getElementById('cantidadDificilArte').value;
    const cantidadDificilCine = document.getElementById('cantidadDificilCine').value;
    const cantidadDificilHistoria = document.getElementById('cantidadDificilHistoria').value;
    const cantidadDificilDeporte = document.getElementById('cantidadDificilDeporte').value;
    const cantidadDificilCiencia = document.getElementById('cantidadDificilCiencia').value;
    const cantidadDificilGeografia = document.getElementById('cantidadDificilGeografia').value;

    const ageData = {
        labels: ['Niños', 'Adolescentes', 'Adultos', 'Ancianos'],
        values: [ninio, adolescente,adulto,anciano]
    };

    const gameQuestionsData = {
        labels: ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'],
        values: [arte, cine, deporte, historia, ciencia, geografia],
        preguntaCorrecta: [arteCorrectas,cineCorrectas,deporteCorrectas ,historiaCorrectas , cienciaCorrectas, geografiaCorrectas],
        preguntaIncorrecta: [arteIncorrectas,cineIncorrectas, deporteIncorrectas,historiaIncorrectas, cienciaIncorrectas, geografiaIncorrectas],

    };

    /*
    document.addEventListener("DOMContentLoaded", function () {
        const selectDificultad = document.getElementById('dificultad');

        // Agrega un listener al evento 'change'
        selectDificultad.addEventListener('change', function () {
            // Obtén el valor seleccionado
            const opcion = selectDificultad.value;
            const facil = document.getElementById('facil');
            const normal = document.getElementById('normal');
            const dificil = document.getElementById('dificil');
            const elejirOpcion = selectDificultad.value;

            let gameQuestionsData;

            // Realiza acciones según el valor seleccionado
            if (opcion === elejirOpcion) {
                gameQuestionsData = {
                    labels: ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'],
                    values: [arte, cine, historia, deporte, ciencia, geografia],
                    preguntaCorrecta: [arteCorrectas, cineCorrectas, historiaCorrectas, deporteCorrectas, cienciaCorrectas, geografiaCorrectas],
                    preguntaIncorrecta: [arteIncorrectas, cineIncorrectas, historiaIncorrectas, deporteIncorrectas, cienciaIncorrectas, geografiaIncorrectas]
                };
            } else if (opcion === facil) {
                gameQuestionsData = {
                    labels: ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'],
                    values: [cantidadFacilArte, cantidadFacilCine, cantidadFacilHistoria, cantidadFacilDeporte, cantidadFacilCiencia, cantidadFacilGeografia],
                    preguntaCorrecta: [arteCorrectas, cineCorrectas, historiaCorrectas, deporteCorrectas, cienciaCorrectas, geografiaCorrectas],
                    preguntaIncorrecta: [arteIncorrectas, cineIncorrectas, historiaIncorrectas, deporteIncorrectas, cienciaIncorrectas, geografiaIncorrectas]
                };
            } else if (opcion === normal) {
                gameQuestionsData = {
                    labels: ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'],
                    values: [cantidadNormalArte, cantidadNormalCine, cantidadNormalHistoria, cantidadNormalDeporte, cantidadNormalCiencia, cantidadNormalGeografia],
                    preguntaCorrecta: [arteCorrectas, cineCorrectas, historiaCorrectas, deporteCorrectas, cienciaCorrectas, geografiaCorrectas],
                    preguntaIncorrecta: [arteIncorrectas, cineIncorrectas, historiaIncorrectas, deporteIncorrectas, cienciaIncorrectas, geografiaIncorrectas]
                };
            } else if (opcion === dificil) {
                gameQuestionsData = {
                    labels: ['Arte', 'Cine', 'Historia', 'Deporte', 'Ciencia', 'Geografía'],
                    values: [cantidadDificilArte, cantidadDificilCine, cantidadDificilHistoria, cantidadDificilDeporte, cantidadDificilCiencia, cantidadDificilGeografia],
                    preguntaCorrecta: [arteCorrectas, cineCorrectas, historiaCorrectas, deporteCorrectas, cienciaCorrectas, geografiaCorrectas],
                    preguntaIncorrecta: [arteIncorrectas, cineIncorrectas, historiaIncorrectas, deporteIncorrectas, cienciaIncorrectas, geografiaIncorrectas]
                };
            }
        });
    });*/

    showAgeStatsBtn.onclick = function() {
        ageModal.style.display = 'block';
        createAgeChart();
        populateAgeTable();
    }

    showGameQuestionsBtn.onclick = function() {
        gameQuestionsModal.style.display = 'block';
        createGameQuestionsChart();
        populateGameQuestionsTable();
    }

    Array.from(closeButtons).forEach(function(button) {
        button.onclick = function() {
            ageModal.style.display = 'none';
            gameQuestionsModal.style.display = 'none';
        }
    });

    window.onclick = function(event) {
        if (event.target == ageModal) {
            ageModal.style.display = 'none';
        }
        if (event.target == gameQuestionsModal) {
            gameQuestionsModal.style.display = 'none';
        }
    }

    downloadAgePDFBtn.onclick = function() {
        window.location.href = '/PW2MVC-PREGUNTADOS/Admin/descargarPDFUsuarioPorEdad';
    }

    downloadGameQuestionsPDFBtn.onclick = function() {
        // Implement game questions PDF download logic here
        console.log('Downloading Game Questions PDF');
    }

    function createAgeChart() {
        const ctx = document.getElementById('ageChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ageData.labels,
                datasets: [{
                    data: ageData.values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribución de Usuarios por Edad'
                    }
                }
            }
        });
    }

    function populateAgeTable() {
        const tableBody = document.querySelector('#ageTable tbody');
        tableBody.innerHTML = '';
        ageData.labels.forEach((label, index) => {
            const row = tableBody.insertRow();
            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            cell1.textContent = label;
            cell2.textContent = ageData.values[index];
        });
    }

    function createGameQuestionsChart() {
        const ctx = document.getElementById('gameQuestionsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: gameQuestionsData.labels,
                datasets: [{
                    label: 'Cantidad de Preguntas',
                    data: gameQuestionsData.values,
                    backgroundColor: [
                        '#ff9800', '#9c27b0', '#ffeb3b', '#f44336', '#4caf50', '#2196f3'
                    ],
                    borderColor: '#2C3E50',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#ECF0F1'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Distribución de Preguntas por Categoría',
                        color: '#ECF0F1'
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ECF0F1'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ECF0F1'
                        }
                    }
                }
            }
        });
    }

    function populateGameQuestionsTable() {
        const tableBody = document.querySelector('#gameQuestionsTable tbody');
        tableBody.innerHTML = '';
        gameQuestionsData.labels.forEach((label, index) => {
            const row = tableBody.insertRow();
            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);
            const cell4 = row.insertCell(3);

            cell1.textContent = label;
            cell2.textContent = gameQuestionsData.values[index];
            cell3.textContent = gameQuestionsData.preguntaCorrecta[index];
            cell4.textContent = gameQuestionsData.preguntaIncorrecta[index];
        });
    }
});

// combo select
/*
document.getElementById('dificultadSelect').addEventListener('change', function() {
    let dificultadSeleccionada = this.value;
    if (dificultadSeleccionada) {
        fetch('/ruta-al-servidor-para-obtener-datos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ dificultad: dificultadSeleccionada })
        })
            .then(response => response.json())
            .then(data => {
                actualizarGrafico(data);
            })
            .catch(error => console.error('Error:', error));
    }
});
*/
function actualizarGrafico(data) {
    // Aquí puedes usar una librería de gráficos como Chart.js para actualizar el gráfico
    let ctx = document.getElementById('grafico').getContext('2d');
    if (window.grafico) {
        window.grafico.destroy(); // Destruir el gráfico existente antes de crear uno nuevo
    }
    window.grafico = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Arte', 'Cine', 'Deporte', 'Historia', 'Ciencia', 'Geografía'],
            datasets: [{
                label: `Cantidad de preguntas - Dificultad ${data.dificultad}`,
                data: data.cantidadPorCategoria,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
// FIN

