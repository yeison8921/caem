<template>
    <canvas :id="id" class="chart-canvas" :height="height"></canvas>
</template>

<script>
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
export default {
    name: "HuellaCarbonoDirectaIndirectaBar",
    grafica: null,
    props: {
        id: {
            type: String,
            default: "huella-carbono-directa-indirecta-bar",
        },
        height: {
            type: [String, Number],
            default: "300",
        },
        chart: {
            type: Object,
            required: true,
            labels: Array,
            datasets: {
                type: Object,
                required: true,
                label: String,
                data: Array,
                backgroundColor: Array,
            },
        },
    },
    mounted() {
        setTimeout(() => {
            this.cargarGrafica();
        }, 500);
    },
    methods: {
        cargarGrafica() {
            // Bar chart
            var ctx = document.getElementById(this.id).getContext("2d");

            if (this.grafica) {
                this.grafica.destroy();
            }

            this.grafica = new Chart(ctx, {
                type: "bar",
                backgroundColor: "red",
                data: {
                    labels: this.chart.labels,
                    datasets: [
                        {
                            label: this.chart.datasets.label,
                            weight: 5,
                            borderWidth: 0,
                            borderRadius: 4,
                            backgroundColor:
                                this.chart.datasets.backgroundColor,
                            data: this.chart.datasets.data,
                            fill: false,
                            maxBarThickness: 35,
                        },
                    ],
                },
                plugins: [ChartDataLabels],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            color: "black",
                            align: "top",
                            anchor: "end",
                            offset: 5,
                            formatter: function (value, context) {
                                return Number(value.toFixed(2)).toLocaleString(
                                    "es-co"
                                );
                            },
                        },
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        y: {
                            grid: {
                                drawBorder: false,
                                display: true,
                                drawOnChartArea: true,
                                drawTicks: false,
                                borderDash: [5, 5],
                            },
                            ticks: {
                                maxRotation: 0,
                                minRotation: 0,
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                display: false,
                                drawOnChartArea: true,
                                drawTicks: true,
                            },
                        },
                    },
                },
            });
        },
    },
};
</script>
