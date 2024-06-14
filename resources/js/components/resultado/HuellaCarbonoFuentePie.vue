<template>
    <div class="chart">
        <canvas :id="id" class="chart-canvas" :height="height"></canvas>
    </div>
</template>
<script>
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
export default {
    name: "HuellaCarbonoFuentePie",
    grafica: "",
    props: {
        id: {
            type: String,
            default: "huella-carbono-fuente-pie",
        },
        height: {
            type: [String, Number],
            default: "400",
        },
        title: {
            type: String,
            default: "Pie Chart",
        },
        chart: {
            type: Object,
            required: true,
            labels: Array,
            datasets: {
                type: Object,
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
            var pieChart = document.getElementById(this.id).getContext("2d");

            if (this.grafica) {
                this.grafica.destroy();
            }

            this.grafica = new Chart(pieChart, {
                type: "pie",
                data: {
                    labels: this.chart.labels,
                    datasets: [
                        {
                            label: this.chart.datasets.label,
                            weight: 9,
                            cutout: 0,
                            tension: 0.9,
                            pointRadius: 2,
                            borderWidth: 2,
                            backgroundColor:
                                this.chart.datasets.backgroundColor,
                            data: this.chart.datasets.data,
                            fill: false,
                        },
                    ],
                },
                // plugins: [ChartDataLabels],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        // datalabels: {
                        //     color: "black",
                        //     align: "end",
                        //     formatter: function (value, context) {
                        //         return (
                        //             Number(value.toFixed(2)).toLocaleString(
                        //                 "es-co"
                        //             ) + " %"
                        //         );
                        //     },
                        // },
                        legend: {
                            position: "bottom",
                        },
                    },
                    // interaction: {
                    //     intersect: false,
                    //     mode: "index",
                    // },
                    // scales: {
                    //     y: {
                    //         grid: {
                    //             drawBorder: false,
                    //             display: false,
                    //             drawOnChartArea: false,
                    //             drawTicks: false,
                    //         },
                    //         ticks: {
                    //             display: false,
                    //         },
                    //     },
                    //     x: {
                    //         grid: {
                    //             drawBorder: false,
                    //             display: false,
                    //             drawOnChartArea: false,
                    //             drawTicks: false,
                    //         },
                    //         ticks: {
                    //             display: false,
                    //         },
                    //     },
                    // },
                },
            });
        },
    },
};
</script>
