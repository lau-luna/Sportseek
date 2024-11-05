/* */

// Obtener una referencia al elemento canvas del DOM
const $grafico = document.querySelector("#grafico");
// Las etiquetas son las que van en el eje X.
const etiquetasAlimentos = ["Frutas", "Verduras", "Carnes", "Lácteos", "Legumbres"];
// Podemos tener varios conjuntos de datos.
const datosAlimentos = {
    label: "Tipos de alimentos consumidos por una persona en una semana",
    data: [10, 25, 40, 5, 20]
};
new Chart($grafico, {
    type: 'pie',
    data: {
        labels: etiquetasAlimentos,
        datasets: [
            datosAlimentos]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false
                }
            }],
        },
    }
});