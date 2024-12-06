// Datos de ejemplo (ampliados para incluir todos los tipos de gráficos)
const data = {
    playerChart: [
        { date: '2023-01', count: 100 },
        { date: '2023-02', count: 150 },
        { date: '2023-03', count: 200 },
        { date: '2023-04', count: 180 },
        { date: '2023-05', count: 220 },
    ],
    gameChart: [
        { date: '2023-01', count: 500 },
        { date: '2023-02', count: 750 },
        { date: '2023-03', count: 1000 },
        { date: '2023-04', count: 900 },
        { date: '2023-05', count: 1100 },
    ],
    questionChart: [
        { status: 'Pendiente', count: 50 },
        { status: 'Aprobada', count: 200 },
        { status: 'Rechazada', count: 30 },
        { status: 'Reportada', count: 20 },
        { status: 'Desactivada', count: 10 },
    ],
    createdQuestionChart: [
        { date: '2023-01', count: 20 },
        { date: '2023-02', count: 30 },
        { date: '2023-03', count: 40 },
        { date: '2023-04', count: 35 },
        { date: '2023-05', count: 50 },
    ],
    newUserChart: [
        { date: '2023-01', count: 50 },
        { date: '2023-02', count: 70 },
        { date: '2023-03', count: 90 },
        { date: '2023-04', count: 80 },
        { date: '2023-05', count: 100 },
    ],
    correctAnswerChart: [
        { user: 'Usuario1', percentage: 75 },
        { user: 'Usuario2', percentage: 80 },
        { user: 'Usuario3', percentage: 70 },
        { user: 'Usuario4', percentage: 85 },
        { user: 'Usuario5', percentage: 78 },
    ],
    countryChart: [
        { name: 'Argentina', value: 150 },
        { name: 'Brasil', value: 100 },
        { name: 'Chile', value: 80 },
        { name: 'Otros', value: 70 },
    ],
    genderChart: [
        { name: 'Masculino', value: 200 },
        { name: 'Femenino', value: 180 },
        { name: 'Otro', value: 20 },
    ],
    ageChart: [
        { name: 'Niños', value: 50 },
        { name: 'Adolescentes', value: 300 },
        { name: 'Adultos', value: 50 },
        { name: 'Ancianos', value: 50 },

    ],
};

let currentChart = null;
let currentChartType = '';

function getChartTitle(chartType) {
    const titles = {
        'playerChart': 'Cantidad de Jugadores',
        'gameChart': 'Partidas Jugadas',
        'questionChart': 'Preguntas en Juego',
        'createdQuestionChart': 'Preguntas Creadas',
        'newUserChart': 'Usuarios Nuevos',
        'correctAnswerChart': '% Respuestas Correctas',
        'countryChart': 'Usuarios por País',
        'genderChart': 'Usuarios por Sexo',
        'ageChart': 'Usuarios por Edad'
    };
    return titles[chartType] || '';
}

function showChart(chartType) {
    const chartContainer = document.getElementById('chartContainer');
    chartContainer.style.display = 'block';

    if (currentChart) {
        currentChart.destroy();
    }

    currentChartType = chartType;
    updateChart();

    // Actualizar el título del gráfico
    const chartTitle = document.getElementById('chartTitle');
    chartTitle.textContent = getChartTitle(chartType);

    // Ocultar todos los botones de "Generar PDF"
    document.querySelectorAll('.generate-pdf-button').forEach(button => {
        button.style.display = 'none';
    });

    // Mostrar solo el botón correspondiente al gráfico actual
    const currentPDFButton = document.getElementById(`generatePDF_${chartType}`);
    if (currentPDFButton) {
        currentPDFButton.style.display = 'block';
    }
}

function updateChart() {
    const chartData = data[currentChartType];
    const timeFilter = document.getElementById('timeFilter').value;

    // Filtrar datos según el tiempo (simulado, aquí puedes agregar lógica real)
    const filteredData = chartData; // Si necesitas filtrar, aplica lógica aquí.

    // Crear datasets y labels dependiendo del tipo de gráfico
    let labels = [];
    let values = [];

    if (currentChartType === 'questionChart' || currentChartType === 'countryChart' || currentChartType === 'genderChart' || currentChartType === 'ageChart') {
        labels = filteredData.map(item => item.name || item.status);
        values = filteredData.map(item => item.value || item.count);
    } else if (currentChartType === 'correctAnswerChart') {
        labels = filteredData.map(item => item.user);
        values = filteredData.map(item => item.percentage);
    } else {
        labels = filteredData.map(item => item.date);
        values = filteredData.map(item => item.count);
    }

    // Crear el gráfico con Chart.js
    const ctx = document.getElementById('chart').getContext('2d');
    currentChart = new Chart(ctx, {
        type: currentChartType === 'countryChart' || currentChartType === 'genderChart' || currentChartType === 'ageChart' ? 'pie' : 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Datos',
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: currentChartType === 'countryChart' || currentChartType === 'genderChart' || currentChartType === 'ageChart',
                },
                title: {
                    display: true,
                    text: getChartTitle(currentChartType)
                }
            },
        },
    });

    updateTable(filteredData);
}

function updateTable(data) {
    const tableBody = document.querySelector('#dataTable tbody');
    tableBody.innerHTML = '';
    data.forEach(item => {
        const row = tableBody.insertRow();
        const cell1 = row.insertCell(0);
        const cell2 = row.insertCell(1);
        cell1.textContent = item.date || item.status || item.user || item.name;
        cell2.textContent = item.count || item.percentage || item.value;
    });
}

function generatePDF(chartType) {
    const phpRoute = `/generar-pdf.php?tipo=${chartType}`;
    window.location.href = phpRoute;
}

// Inicializar el primer gráfico al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    showChart('playerChart');
});