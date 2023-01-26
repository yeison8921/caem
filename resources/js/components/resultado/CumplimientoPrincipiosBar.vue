<template>
    <canvas :id="id" class="chart-canvas" :height="height"></canvas>
</template>

<script>
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
export default {
    name: "CumplimientoPrincipiosBar",
    grafica: "",
    props: {
        id: {
            type: String,
            default: "cumplimiento-principios-bar",
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
            // Bar chart horizontal
            var ctx = document.getElementById(this.id).getContext("2d");

            if (this.grafica) {
                this.grafica.destroy();
            }

            this.grafica = new Chart(ctx, {
                type: "bar",
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
                            // backgroundColor: "#3A416F",
                            data: this.chart.datasets.data,
                            fill: false,
                        },
                    ],
                },
                plugins: [ChartDataLabels],
                options: {
                    indexAxis: "y",
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        datalabels: {
                            color: "black",
                            align: "end",
                            anchor: "end",
                            offset: 10,
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
                        },
                        x: {
                            min: 0,
                            max: 100,
                            ticks: {
                                stepSize: 20,
                            },

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
