<template>
    <div>
        <button
            type="button"
            v-on:click="handleGenerarReporte"
            :class="
                'btn btn-success btn-sm ' + (disabled ? 'bg-secondary' : '')
            "
            :disabled="Object.keys(base64Images).length === 0"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            :title="
                disabled
                    ? 'No es posible descargar el reporte porque aún no se ha autorizado la descarga.'
                    : ''
            "
        >
            Descargar reporte
        </button>
    </div>
</template>

<script>
import PdfMake from "pdfmake/build/pdfmake";
import PdfFonts from "pdfmake/build/vfs_fonts";
import InformacionEmpresa from "../../models/InformacionEmpresa";
const footerImagePath = require("/images/pdf/footer.png");
export default {
    name: "GenerarReporteComponent",
    grafica: null,
    props: {
        empresa_id: {
            type: Number,
            default: 0,
        },
        sede_id: {
            type: Number,
            default: 0,
        },
        periodo_id: {
            type: Number,
            default: 0,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        ar: {
            type: String,
            default: "_ar5",
        },
    },
    data() {
        return {
            images: {
                footer: "/images/pdf/footer.png",
                firstPage: "/images/pdf/first-page-content.png",
                watermark: "/images/pdf/watermark.png",
            },
            base64Images: {},
            informacion_empresa: {},
            array_meses: [
                "ENERO",
                "FEBRERO",
                "MARZO",
                "ABRIL",
                "MAYO",
                "JUNIO",
                "JULIO",
                "AGOSTO",
                "SEPTIEMBRE",
                "OCTUBRE",
                "NOVIEMBRE",
                "DICIEMBRE",
            ],
            resultados: {},
        };
    },
    mounted() {
        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        this.loadAndConvertImages();
    },
    methods: {
        async loadAndConvertImages() {
            try {
                const promises = Object.entries(this.images).map(
                    async ([key, imageUrl]) => {
                        const base64Image =
                            await this.loadImageAndConvertToBase64(imageUrl);
                        return [key, base64Image];
                    }
                );
                const resolvedImages = await Promise.all(promises);
                this.base64Images = Object.fromEntries(resolvedImages);
                console.log(
                    "All images converted to base64:",
                    this.base64Images
                );
            } catch (error) {
                console.error(
                    "Error while loading and converting images:",
                    error
                );
            }
        },
        convertCanvasToBase64(elementId) {
            const canvas = document.getElementById(elementId);

            const tempCanvas = document.createElement("canvas");
            tempCanvas.width = canvas.width;
            tempCanvas.height = canvas.height;

            const ctx = tempCanvas.getContext("2d");

            //white transparent background
            ctx.fillStyle = "#ffffffb3";
            ctx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

            ctx.drawImage(canvas, 0, 0);

            return tempCanvas.toDataURL("image/png");
        },
        loadImageAndConvertToBase64(imageUrl) {
            return new Promise((resolve, reject) => {
                const image = new Image();
                image.crossOrigin = "Anonymous";
                image.src = imageUrl;

                image.onload = () => {
                    const canvas = document.createElement("canvas");
                    const context = canvas.getContext("2d");
                    canvas.width = image.width;
                    canvas.height = image.height;
                    context.drawImage(image, 0, 0);
                    const base64Image = canvas.toDataURL("image/jpeg");
                    resolve(base64Image);
                };

                image.onerror = () => {
                    reject(new Error(`Failed to load image: ${imageUrl}`));
                };
            });
        },
        parseTableContentGeneral(_fuente) {
            return [
                _fuente.fuente_emision_mostrar,
                _fuente.fuentetable.nombre,
                _fuente.fuentetable.unidad_consumo,
                _fuente.resultado
                    ? this.parseTwoDecimals(
                          this.parseDotToComma(_fuente.resultado.promedio)
                      )
                    : "NR",
                _fuente.resultado
                    ? this.parseDotToComma(
                          this.parseTwoDecimals(
                              _fuente.resultado["huella_carbono" + this.ar]
                          )
                      )
                    : "NR",
                "+/- " +
                    (_fuente.resultado
                        ? this.parseDotToComma(
                              this.parseTwoDecimals(
                                  _fuente.resultado[
                                      "incertidumbre_fuente" + this.ar
                                  ] * 100
                              )
                          )
                        : "NR") +
                    "%",
            ];
        },
        parseDotToComma(_value) {
            return _value.toString().replace(".", ",");
        },
        parseTwoDecimals(_value) {
            if (typeof _value === "number" && !isNaN(_value)) {
                return _value.toFixed(2);
            }
            return _value;
        },
        getRepresentacion(value, total, withPercentage = true) {
            let percentage = (parseFloat(value) / parseFloat(total)) * 100;
            if (isNaN(percentage)) {
                percentage = 0;
            }
            let res =
                this.parseDotToComma(this.parseTwoDecimals(percentage)) +
                (withPercentage ? " %" : "");

            return res;
        },
        async getReportData() {
            this.$root.mostrarCargando("Consultando información");
            this.informacion_empresa = await InformacionEmpresa.include(
                "empresa",
                "empresaSede",
                "empresaSede.ciudad",
                "empresaSede.departamento"
            ).find(this.periodo_id);

            let fecha_base = new Date(
                this.informacion_empresa.anio_inicio +
                    "-" +
                    this.informacion_empresa.mes_inicio +
                    "-01 00:00"
            );

            var future = new Date(
                fecha_base.getFullYear(),
                fecha_base.getMonth() + 11,
                1
            );

            let mes_fecha_base = this.array_meses[fecha_base.getMonth()];

            var mes_futuro = this.array_meses[future.getMonth()];
            var anio_futuro = future.getFullYear();
            var label =
                mes_fecha_base +
                " " +
                this.informacion_empresa.anio_inicio +
                " a " +
                mes_futuro +
                " " +
                anio_futuro;

            this.informacion_empresa.label = label;

            this.resultados.fuentes_moviles = {};

            let tablasAndTotals = await this.getTablesAndTotals(
                this.empresa_id,
                this.sede_id,
                this.periodo_id,
                this.ar
            );
            this.resultados.fuentes_moviles.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_moviles.total_huella_carbono
                    )
                );
            this.resultados.fuentes_moviles.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_moviles
                            .total_incertidumbre_fuente * 100
                    )
                );
            this.resultados.tabla1Body = [
                // CREAR TABLA
                [
                    { text: "", style: "headerTableResult" },
                    {
                        colSpan: 5,
                        text: "FUENTES MÓVILES",
                        style: "headerTableResult",
                    },
                    {},
                    {},
                    {},
                    {},
                ],
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        style: "headerTableResult",
                    },
                    {
                        rowSpan: 2,
                        text: "TIPO DE COMBUSTIBLE / REFRIGERANTE",
                        style: "headerTableResult",
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        style: "headerTableResult",
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        style: "headerTableResult",
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        style: "headerTableResult",
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        style: "headerTableResult",
                    },
                    {
                        text: "CANTIDAD",
                        style: "headerTableResult",
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.fuentes_moviles.data.forEach((_fuente) => {
                this.resultados.tabla1Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });

            this.resultados.tabla1Body.push([
                // Footer of TABLA
                {
                    colSpan: 4,
                    text: "SUBTOTAL FUENTES MÓVILES",
                    style: "footerTableResult",
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.fuentes_moviles.total_huella_carbono
                        )
                    ),
                    fillColor: "#348c4f",
                    style: "footerTableResult",
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.fuentes_moviles
                                    .total_incertidumbre_fuente
                            )
                        ) +
                        "%",
                    fillColor: "#348c4f",
                    style: "footerTableResult",
                },
            ]);

            // TODO: this.resultados.fuentes_moviles.total_porcentaje_huella_total =

            // Fientes Fijas
            this.resultados.fuentes_fijas = {};
            this.resultados.fuentes_fijas.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_fijas.total_huella_carbono
                    )
                );
            this.resultados.fuentes_fijas.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_fijas
                            .total_incertidumbre_fuente * 100
                    )
                );
            this.resultados.tabla2Body = [
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        style: "headerTableResult",
                    },
                    {
                        rowSpan: 2,
                        text: "TIPO DE COMBUSTIBLE / REFRIGERANTE",
                        style: "headerTableResult",
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        style: "headerTableResult",
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        style: "headerTableResult",
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        style: "headerTableResult",
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        style: "headerTableResult",
                    },
                    {
                        text: "CANTIDAD",
                        style: "headerTableResult",
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.fuentes_fijas.data?.forEach((_fuente) => {
                // TODO:  push rows to table
                this.resultados.tabla2Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });

            this.resultados.tabla2Body.push([
                // Footer of TABLA
                {
                    colSpan: 4,
                    text: "SUBTOTAL FUENTES FIJAS",
                    style: "footerTableResult",
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.fuentes_fijas.total_huella_carbono
                        )
                    ),
                    fillColor: "#348c4f",
                    style: "footerTableResult",
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.fuentes_fijas
                                    .total_incertidumbre_fuente
                            )
                        ) +
                        "%",
                    fillColor: "#348c4f",
                    style: "footerTableResult",
                },
            ]);

            // emisiones

            this.resultados.emisiones = {};
            this.resultados.emisiones.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.emisiones.total_huella_carbono
                    )
                );
            this.resultados.emisiones.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.emisiones.total_incertidumbre_fuente *
                            100
                    )
                );
            this.resultados.tabla3Body = [
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        style: "headerTableResult",
                    },
                    {
                        rowSpan: 2,
                        text: "TIPO DE COMBUSTIBLE / REFRIGERANTE",
                        style: "headerTableResult",
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        style: "headerTableResult",
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        style: "headerTableResult",
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        style: "headerTableResult",
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        style: "headerTableResult",
                    },
                    {
                        text: "CANTIDAD",
                        style: "headerTableResult",
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.emisiones.data?.forEach((_fuente) => {
                // TODO:  push rows to table
                this.resultados.tabla3Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });

            this.resultados.tabla3Body.push([
                // Footer of TABLA
                {
                    colSpan: 4,
                    text: "SUBTOTAL EMISIONES",
                    style: "footerTableResult",
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.resultados.emisiones.total_huella_carbono
                    ),
                    fillColor: "#348c4f",
                    style: "footerTableResult",
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.resultados.emisiones.total_incertidumbre_fuente
                        ) +
                        "%",
                    fillColor: "#348c4f",
                    style: "footerTableResult",
                },
            ]);

            // Tabla 4 Resultados de Fuentes Directas
            this.resultados.fuentes_directas = {};
            this.resultados.fuentes_directas.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_directas.total_huella_carbono
                    )
                );
            this.resultados.fuentes_directas.total_incertidumbre =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_directas.total_incertidumbre *
                            100
                    )
                );
            this.resultados.fuentes_directas.total_porcentaje_huella_total = 0; //TODO: calcular
            this.resultados.fuentes_directas.nivel_precision = "SIN CALCULAR"; //TODO: calcular
            this.resultados.tabla4Body = [
                [
                    {
                        text: "FUENTES",
                        style: "headerTableResult",
                    },
                    {
                        text: "HUELLA CARBONO TOTAL [Ton CO2 eq/AÑO]",
                        style: "headerTableResult",
                    },
                    {
                        text: "REPRESENTACIÓN",
                        style: "headerTableResult",
                    },
                    {
                        text: "INCERTIDUMBRE",
                        style: "headerTableResult",
                    },
                ],
                [
                    "Fuentes Móviles",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.fuentes_moviles.total_huella_carbono
                        )
                    ),
                    this.getRepresentacion(
                        this.resultados.fuentes_moviles.total_huella_carbono,
                        this.resultados.fuentes_directas.total_huella_carbono
                    ),
                    "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.fuentes_moviles
                                    .total_incertidumbre_fuente
                            )
                        ) +
                        "%",
                ],
                [
                    "Fuentes Fijas",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.fuentes_fijas.total_huella_carbono
                        )
                    ),
                    this.getRepresentacion(
                        this.resultados.fuentes_fijas.total_huella_carbono,
                        this.resultados.fuentes_directas.total_huella_carbono
                    ),
                    "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.fuentes_fijas
                                    .total_incertidumbre_fuente
                            )
                        ) +
                        "%",
                ],
                [
                    "Emisiones de Proceso",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.emisiones.total_huella_carbono
                        )
                    ),
                    this.getRepresentacion(
                        this.resultados.emisiones.total_huella_carbono,
                        this.resultados.fuentes_directas.total_huella_carbono
                    ),
                    "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.emisiones
                                    .total_incertidumbre_fuente
                            )
                        ) +
                        "%",
                ],
                [
                    {
                        text: "SUBTOTAL",
                        style: "footerTableResult",
                    },
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.fuentes_directas
                                .total_huella_carbono
                        )
                    ),
                    "100 %",
                    "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.fuentes_directas
                                    .total_incertidumbre
                            )
                        ) +
                        "%",
                ],
            ];

            ////////////////// tabla 5 //////////////////////////////

            this.resultados.fuentes_indirectas = {};
            this.resultados.fuentes_indirectas.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_indirectas.total_huella_carbono
                    )
                );
            this.resultados.fuentes_indirectas.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_indirectas
                            .total_incertidumbre_fuente * 100
                    )
                );
            this.resultados.tabla5Body = [
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        fillColor: "#fabf8f",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "FACTOR DE EMISION USADO",
                        fillColor: "#fabf8f",
                        bold: true,
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        fillColor: "#fabf8f",
                        bold: true,
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        fillColor: "#fabf8f",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        fillColor: "#fabf8f",
                        bold: true,
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        fillColor: "#fabf8f",
                        bold: true,
                    },
                    {
                        text: "CANTIDAD",
                        fillColor: "#fabf8f",
                        bold: true,
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.fuentes_indirectas.data?.forEach((_fuente) => {
                // TODO:  push rows to table
                this.resultados.tabla5Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });
            this.resultados.tabla5Body.push([
                // Footer of TABLA
                {
                    colSpan: 4,
                    text: "SUBTOTAL EMISIONES INDIRECTAS",
                    style: "footerTableResult",
                    fillColor: "#fabf8f",
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.fuentes_indirectas
                                .total_huella_carbono
                        )
                    ),
                    fillColor: "#fabf8f",
                    style: "footerTableResult",
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.fuentes_indirectas
                                    .total_incertidumbre_fuente
                            )
                        ) +
                        "%",
                    fillColor: "#fabf8f",
                    style: "footerTableResult",
                },
            ]);

            //this.resultados.tabla5Body.push();

            ////////////////Emisiones Indirectas por transporte - categoría 3 - Tabla 6 fuentes_C3 //////////////
            this.resultados.fuentes_C3 = {};
            this.resultados.fuentes_C3.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C3.total_huella_carbono
                    )
                );
            this.resultados.fuentes_C3.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C3.total_incertidumbre_fuente *
                            100
                    )
                );
            this.resultados.tabla6Body = [
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "CARGA AMBIENTAL",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        text: "CANTIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.fuentes_C3.data?.forEach((_fuente) => {
                // TODO:  push rows to table
                this.resultados.tabla6Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });
            this.resultados.tabla6Body.push([
                {
                    colSpan: 4,
                    text: "SUBTOTAL OTRAS FUENTES",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.resultados.fuentes_C3.total_huella_carbono
                    ),
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.resultados.fuentes_C3
                                .total_incertidumbre_fuente
                        ) +
                        "%",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
            ]);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////Emisiones Indirectas por productos que utiliza la organización - categoría 4 - Tabla 7 fuentes_C4 //////////////
            this.resultados.fuentes_C4 = {};
            this.resultados.fuentes_C4.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C4.total_huella_carbono
                    )
                );
            this.resultados.fuentes_C4.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C4.total_incertidumbre_fuente *
                            100
                    )
                );
            this.resultados.tabla7Body = [
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "CARGA AMBIENTAL",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        text: "CANTIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.fuentes_C4.data?.forEach((_fuente) => {
                // TODO:  push rows to table
                this.resultados.tabla7Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });
            this.resultados.tabla7Body.push([
                {
                    colSpan: 4,
                    text: "SUBTOTAL OTRAS FUENTES",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.resultados.fuentes_C4.total_huella_carbono
                    ),
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.resultados.fuentes_C4
                                .total_incertidumbre_fuente
                        ) +
                        "%",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
            ]);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////Emisiones Indirectas por uso de productos de la organización - categoría 5 - Tabla 8 fuentes_C5 //////////////
            this.resultados.fuentes_C5 = {};
            this.resultados.fuentes_C5.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C5.total_huella_carbono
                    )
                );
            this.resultados.fuentes_C5.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C5.total_incertidumbre_fuente *
                            100
                    )
                );
            this.resultados.tabla8Body = [
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "CARGA AMBIENTAL",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        text: "CANTIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.fuentes_C5.data?.forEach((_fuente) => {
                // TODO:  push rows to table
                this.resultados.tabla8Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });
            this.resultados.tabla8Body.push([
                {
                    colSpan: 4,
                    text: "SUBTOTAL OTRAS FUENTES",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.resultados.fuentes_C5.total_huella_carbono
                    ),
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.resultados.fuentes_C5
                                .total_incertidumbre_fuente
                        ) +
                        "%",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
            ]);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            ////////////////Emisiones Indirectas proveniente de otras fuentes - categoría 6 - Tabla 9 fuentes_C6 //////////////
            this.resultados.fuentes_C6 = {};
            this.resultados.fuentes_C6.total_huella_carbono =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C6.total_huella_carbono
                    )
                );
            this.resultados.fuentes_C6.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.fuentes_C6.total_incertidumbre_fuente *
                            100
                    )
                );
            this.resultados.tabla9Body = [
                [
                    {
                        rowSpan: 2,
                        text: "FUENTE DE EMISIÓN DE GEI",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "CARGA AMBIENTAL",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        colSpan: 2,
                        text: "CONSUMO",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {
                        rowSpan: 2,
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq)",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        rowSpan: 2,
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                ],
                [
                    {},
                    {},
                    {
                        text: "UNIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {
                        text: "CANTIDAD",
                        fillColor: "#e5b8b7",
                        bold: true,
                    },
                    {},
                    {},
                ],
            ];
            tablasAndTotals.fuentes_C6.data?.forEach((_fuente) => {
                // TODO:  push rows to table
                this.resultados.tabla9Body.push(
                    this.parseTableContentGeneral(_fuente)
                );
            });
            this.resultados.tabla9Body.push([
                {
                    colSpan: 4,
                    text: "SUBTOTAL OTRAS FUENTES",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                "",
                "",
                "",
                {
                    text: this.parseDotToComma(
                        this.parseTwoDecimals(
                            this.resultados.fuentes_C6.total_huella_carbono
                        )
                    ),
                    fillColor: "#e5b8b7",
                    bold: true,
                },
                {
                    text:
                        "+/- " +
                        this.parseDotToComma(
                            this.parseTwoDecimals(
                                this.resultados.fuentes_C6
                                    .total_incertidumbre_fuente
                            )
                        ) +
                        "%",
                    fillColor: "#e5b8b7",
                    bold: true,
                },
            ]);

            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////  Tabla 10  /////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            this.resultados.tabla_10 = {};
            this.resultados.tabla10Body = [
                [
                    {
                        text: "GAS EFECTO INVERNADERO (GEI)",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "CANTIDAD GEI \n [ton GEI/año]",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "EMISIONES DIRECTAS \n [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "REPRESENTACIÓN DIRECTAS",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                ],
            ];
            this.resultados.tabla10Body.push(
                [
                    "CO2",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_CO2.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_CO2.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_CO2.representacion
                        )
                    ) + "%",
                ],
                [
                    "CH4",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_CH4.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_CH4.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_CH4.representacion
                        )
                    ) + "%",
                ],
                [
                    "N2O",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_N2O.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_N2O.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_N2O.representacion
                        )
                    ) + "%",
                ],
                [
                    "Compuestos Fluorados",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_compuestos_fluorados
                                .cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_compuestos_fluorados
                                .emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_compuestos_fluorados
                                .representacion
                        )
                    ) + "%",
                ],
                [
                    "SF6",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_SF6.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_SF6.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_10.total_SF6.representacion
                        )
                    ) + "%",
                ],
                [
                    {
                        text: "TOTAL ALCANCE 1",
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.tabla_10.total_cantidad
                            )
                        ),
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.tabla_10.total_emisiones
                            )
                        ),
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                    {
                        text:
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.tabla_10
                                        .total_representacion
                                )
                            ) + "%",
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                ]
            );
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////  Tabla 11  /////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            this.resultados.tabla_11 = {};
            this.resultados.tabla11Body = [
                [
                    {
                        text: "GAS EFECTO INVERNADERO (GEI)",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "CANTIDAD GEI \n [ton GEI/año]",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "EMISIONES  \n [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "REPRESENTACIÓN",
                        fillColor: "#215967",
                        bold: true,
                        color: "white",
                    },
                ],
            ];
            this.resultados.tabla11Body.push(
                [
                    "CO2",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_CO2.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_CO2.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_CO2.representacion
                        )
                    ) + "%",
                ],
                [
                    "CH4",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_CH4.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_CH4.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_CH4.representacion
                        )
                    ) + "%",
                ],
                [
                    "N2O",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_N2O.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_N2O.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_N2O.representacion
                        )
                    ) + "%",
                ],
                [
                    "Compuestos Fluorados",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_compuestos_fluorados
                                .cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_compuestos_fluorados
                                .emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_compuestos_fluorados
                                .representacion
                        )
                    ) + "%",
                ],
                [
                    "SF6",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_SF6.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_SF6.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_11.total_SF6.representacion
                        )
                    ) + "%",
                ],
                [
                    {
                        text: "TOTAL ALCANCE 1",
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.tabla_11.total_cantidad
                            )
                        ),
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.tabla_11.total_emisiones
                            )
                        ),
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                    {
                        text:
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.tabla_11
                                        .total_representacion
                                )
                            ) + "%",
                        fillColor: "#31869b",
                        bold: true,
                        color: "white",
                    },
                ]
            );

            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////  Tabla 12  /////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            this.resultados.tabla_12 = {};
            this.resultados.tabla12Body = [
                [
                    {
                        text: "Fuente de Emisión",
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "Carga Ambiental",
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "HUELLA DE CARBONO \n (Ton CO2 eq) ",
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: "INCERTIDUMBRE DE LA FUENTE",
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                ],
            ];
            this.resultados.tabla12Body.push(
                [
                    "CO2",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_CO2.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_CO2.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_CO2.representacion
                        )
                    ) + "%",
                ],
                [
                    "CH4",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_CH4.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_CH4.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_CH4.representacion
                        )
                    ) + "%",
                ],
                [
                    "N2O",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_N2O.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_N2O.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_N2O.representacion
                        )
                    ) + "%",
                ],
                [
                    "Compuestos Fluorados",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_compuestos_fluorados
                                .cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_compuestos_fluorados
                                .emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_compuestos_fluorados
                                .representacion
                        )
                    ) + "%",
                ],
                [
                    "SF6",
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_SF6.cantidad
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_SF6.emisiones
                        )
                    ),
                    this.parseDotToComma(
                        this.parseTwoDecimals(
                            tablasAndTotals.tabla_12.total_SF6.representacion
                        )
                    ) + "%",
                ],

                [
                    {
                        text: "TOTAL ALCANCE 1",
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.tabla_12.total_cantidad
                            )
                        ),
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.tabla_12.total_emisiones
                            )
                        ),
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                    {
                        text:
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.tabla_12
                                        .total_representacion
                                )
                            ) + "%",
                        fillColor: "#4f6228",
                        bold: true,
                        color: "white",
                    },
                ]
            );

            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////  Tabla 13  /////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////////////////////////////
            this.resultados.tabla13 = {};
            this.resultados.tabla13.total_huella_carbono = this.parseDotToComma(
                this.parseTwoDecimals(
                    tablasAndTotals.subtotals.totals.total_huella_carbono
                )
            );
            this.resultados.tabla13.total_incertidumbre_fuente =
                this.parseDotToComma(
                    this.parseTwoDecimals(
                        tablasAndTotals.subtotals.totals
                            .total_incertidumbre_fuente * 100
                    )
                );
            this.resultados.tabla13Body = [
                [
                    {
                        text: "EMISON",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "FUENTES",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "EMISIONES CO2 [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "EMISIONES CH4 [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "EMISIONES N2O [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "EMISIONES Compuestos Fluorados [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "EMISIONES SF6 [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "HUELLA CARBONO TOTAL [Ton CO2 eq/año]",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "REPRESENTACIÓN",
                        fillColor: "#215967",
                        color: "white",
                    },
                    {
                        text: "INCERTIDUMBRE ",
                        fillColor: "#215967",
                        color: "white",
                    },
                ],
                [
                    {
                        rowSpan: 4,
                        text: "Directas Categoría 1",
                        fillColor: "#73cb8e",
                    },
                    {
                        text: "Fuentes Móviles",
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_moviles
                                    .emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_moviles
                                    .emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_moviles
                                    .emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_moviles
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_moviles
                                    .emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_moviles
                                    .total_huella_carbono
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.fuentes_moviles
                                .total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.fuentes_moviles
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#aae0bb",
                    },
                ],
                [
                    {
                        text: "Directas Categoría 1",
                        fillColor: "#aae0bb",
                    },
                    {
                        text: "Fuentes Fijas",
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_fijas.emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_fijas.emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_fijas.emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_fijas
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_fijas.emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_fijas
                                    .total_huella_carbono
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.fuentes_fijas.total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.fuentes_fijas
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#aae0bb",
                    },
                ],
                [
                    {
                        text: "Directas Categoría 1",
                        fillColor: "#aae0bb",
                    },
                    {
                        text: "Emisiones de Proceso",
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.emisiones.emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.emisiones.emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.emisiones.emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.emisiones
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.emisiones.emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.emisiones.total_huella_carbono
                            )
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.emisiones.total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#aae0bb",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.emisiones
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#aae0bb",
                    },
                ],
                [
                    {
                        text: "Directas Categoría 1",
                        fillColor: "#aae0bb",
                    },
                    {
                        text: "SUBTOTAL",
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_directas
                                    .emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_directas
                                    .emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_directas
                                    .emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_directas
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_directas
                                    .emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_directas
                                    .total_huella_carbono
                            )
                        ),
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.subtotals.emisiones_directas
                                .total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.subtotals.emisiones_directas
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#348c4f",
                        style: "subtotal",
                    },
                ],
                [
                    {
                        rowSpan: 2,
                        text: "Indirectas Categoría 2",
                        fillColor: "#f4b084",
                    },
                    {
                        text: "Energía Adquirida",
                        fillColor: "#fabf8f",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_indirectas
                                    .emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#fabf8f",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_indirectas
                                    .emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#fabf8f",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_indirectas
                                    .emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#fabf8f",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_indirectas
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#fabf8f",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_indirectas
                                    .emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#fabf8f",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_indirectas
                                    .total_huella_carbono
                            )
                        ),
                        fillColor: "#fabf8f",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.fuentes_indirectas
                                .total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#fabf8f",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.fuentes_indirectas
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#fabf8f",
                    },
                ],
                [
                    {
                        text: "Indirectas Categoría 2",
                        fillColor: "#fabf8f",
                    },
                    {
                        text: "SUBTOTAL",
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_indirectas
                                    .emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_indirectas
                                    .emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_indirectas
                                    .emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_indirectas
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_indirectas
                                    .emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.emisiones_indirectas
                                    .total_huella_carbono
                            )
                        ),
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.subtotals.emisiones_indirectas
                                .total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.subtotals
                                        .emisiones_indirectas
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#ff9966",
                        style: "subtotal",
                    },
                ],
                [
                    {
                        rowSpan: 5,
                        text: "Otras Indirectas",
                        fillColor: "#e39a98",
                    },
                    {
                        text: "Categoría 3",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C3.emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C3.emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C3.emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C3
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C3.emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C3.total_huella_carbono
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.fuentes_C3.total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.fuentes_C3
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#e6b8b7",
                    },
                ],
                [
                    {
                        text: "Otras Indirectas",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: "Categoría 4",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C4.emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C4.emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C4.emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C4
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C4.emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C4.total_huella_carbono
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.fuentes_C4.total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.fuentes_C4
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#e6b8b7",
                    },
                ],
                [
                    {
                        text: "Otras Indirectas",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: "Categoría 5",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C5.emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C5.emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C5.emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C5
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C5.emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C5.total_huella_carbono
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.fuentes_C5.total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.fuentes_C5
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#e6b8b7",
                    },
                ],
                [
                    {
                        text: "Otras Indirectas",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: "Categoría 6",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C6.emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C6.emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C6.emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C6
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C6.emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.fuentes_C6.total_huella_carbono
                            )
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.fuentes_C6.total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#e6b8b7",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.fuentes_C6
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#e6b8b7",
                    },
                ],
                [
                    {
                        text: "Otras Indirectas",
                        fillColor: "#e6b8b7",
                    },
                    {
                        text: "SUBTOTAL",
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals
                                    .emisiones_otras_indirectas
                                    .emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals
                                    .emisiones_otras_indirectas
                                    .emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals
                                    .emisiones_otras_indirectas
                                    .emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals
                                    .emisiones_otras_indirectas
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals
                                    .emisiones_otras_indirectas
                                    .emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals
                                    .emisiones_otras_indirectas
                                    .total_huella_carbono
                            )
                        ),
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.subtotals.emisiones_otras_indirectas
                                .total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.subtotals
                                        .emisiones_otras_indirectas
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#963634",
                        style: "subtotal",
                    },
                ],
                [
                    {
                        colSpan: 2,
                        text: "TOTAL HCC",
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {},
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.totals
                                    .emision_co2_ton_eq
                            )
                        ),
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.totals
                                    .emision_ch4_ton_eq
                            )
                        ),
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.totals
                                    .emision_n2o_ton_eq
                            )
                        ),
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.totals
                                    .emision_compuestos_fluorados_ton_eq
                            )
                        ),
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.totals
                                    .emision_sf6_ton_eq
                            )
                        ),
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {
                        text: this.parseDotToComma(
                            this.parseTwoDecimals(
                                tablasAndTotals.subtotals.totals
                                    .total_huella_carbono
                            )
                        ),
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {
                        text: this.getRepresentacion(
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono,
                            tablasAndTotals.subtotals.totals
                                .total_huella_carbono
                        ),
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                    {
                        text:
                            "+/- " +
                            this.parseDotToComma(
                                this.parseTwoDecimals(
                                    tablasAndTotals.subtotals.totals
                                        .total_incertidumbre_fuente * 100
                                )
                            ) +
                            "%",
                        fillColor: "#215967",
                        style: "subtotal",
                    },
                ],
            ];

            Swal.close();
        },
        getCalificacionInventario(value) {
            value = parseFloat(value.toString().replace(",", "."));
            let listaIncertidumbre = [
                { name: "High  (alta)", value: 5 },
                { name: "Good (buena)", value: 15 },
                { name: "Fair (favorable)", value: 30 },
                { name: "Poor (pobre)", value: 30 },
            ];
            let clasificacion = "";
            if (value <= listaIncertidumbre[0].value) {
                clasificacion = listaIncertidumbre[0].name;
            } else if (value <= listaIncertidumbre[1].value) {
                clasificacion = listaIncertidumbre[1].name;
            } else if (value <= listaIncertidumbre[2].value) {
                clasificacion = listaIncertidumbre[2].name;
            } else if (value >= listaIncertidumbre[3].value) {
                clasificacion = listaIncertidumbre[3].name;
            }
            return clasificacion;
        },
        getFuentesEmision(empresa_id, sede_id, informacion_empresa_id) {
            return new Promise((resolve, reject) => {
                axios
                    .post("api/getFuentesEmision", {
                        empresa_id: empresa_id,
                        sede_id: sede_id,
                        informacion_empresa_id: informacion_empresa_id,
                    })
                    .then((response) => {
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        getTablesAndTotals(empresa_id, sede_id, informacion_empresa_id, ar) {
            return new Promise((resolve, reject) => {
                axios
                    .post("api/getTablesAndTotals", {
                        empresa_id: empresa_id,
                        sede_id: sede_id,
                        informacion_empresa_id: informacion_empresa_id,
                        informacion_empresa_id: informacion_empresa_id,
                        ar: ar,
                    })
                    .then((response) => {
                        resolve(response.data);
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        async handleGenerarReporte() {
            if (!this.disabled) {
                await this.getReportData();
                if (PdfMake.vfs == undefined) {
                    PdfMake.vfs = PdfFonts.pdfMake.vfs;
                }
                var docDefinition = {
                    pageMargins: [40, 90, 40, 90],
                    footer: (currentPage, pageCount, pageSize) => {
                        if (currentPage === 1) return null;
                        return [
                            {
                                image: this.base64Images.footer,
                                height: 90,
                                width: 610,
                            },
                        ];
                    },
                    background: (currentPage, pageCount, pageSize) => {
                        if (currentPage === 1)
                            return {
                                image: this.base64Images.firstPage,
                                width: 595.28,
                                height: 842,
                                alignment: "center",
                                margin: [0, 0, 0, 0],
                            };
                        return [
                            {
                                image: this.base64Images.watermark,
                                width: 350,
                                alignment: "center",
                                margin: [0, 150, 0, 0],
                            },
                        ];
                    },
                    content: [
                        {
                            image: this.base64Images.firstPage,
                            width: 595.28,
                            height: 755,
                            margin: [-40, -60, -40, -90],
                            //pageBreak: "after",
                        },
                        {
                            margin: [0, 90, 0, 0],
                            text: [
                                {
                                    text: "CONTENIDO",
                                    alignment: "center",
                                    bold: true,
                                },
                            ],
                        },
                        {
                            text: [
                                {
                                    text: "",
                                    alignment: "right",
                                    bold: true,
                                },
                            ],
                        },
                        {
                            style: "tableExample",
                            table: {
                                widths: ["*", 20],
                                heights: function (row) {
                                    return 22;
                                },
                                body: [
                                    ["INTRODUCCIÓN", ""],
                                    ["1. DESCRIPCIÓN DE LA ORGANIZACIÓN", ""],
                                    ["1.1. Objetivo del reporte GEI", ""],
                                    [
                                        "2. LÍMITES ORGANIZACIONALES Y DE INFORME",
                                        "",
                                    ],
                                    ["2.1 Ubicación", ""],
                                    [
                                        "3. DESCRIPCIÓN DEL AÑO BASE Y SEGUIMIENTO A LAS EMISIONES",
                                        "",
                                    ],
                                    [
                                        "3.1 Descripción del año base seleccionado",
                                        "",
                                    ],
                                    [
                                        "3.2 Seguimiento de las emisiones a través del tiempo",
                                        "",
                                    ],
                                    ["4. LÍMITES DE INFORME", ""],
                                    [
                                        "4.1 Emisiones Directas - Categoría 1",
                                        "",
                                    ],
                                    [
                                        "4.1.1 Fuentes Móviles Emisiones Directas",
                                        "",
                                    ],
                                    [
                                        "4.1.2 Fuentes fijas Emisiones Directas",
                                        "",
                                    ],
                                    ["4.1.3 Emisiones de Proceso", ""],
                                    [
                                        "1.1.1. Resultados de Emisiones Directas",
                                        "",
                                    ],
                                    [
                                        "4.2 Emisiones Indirectas Por Energía Importada - Categoría 2",
                                        "",
                                    ],
                                    [
                                        "4.3 Emisiones Indirectas por transporte - categoría 3",
                                        "",
                                    ],
                                    [
                                        "4.4 Emisiones Indirectas por productos que utiliza la organización - categoría 4",
                                        "",
                                    ],
                                    [
                                        "4.5 Emisiones Indirectas por uso de productos de la organización - categoría 5",
                                        "",
                                    ],
                                    [
                                        "4.6 Emisiones Indirectas proveniente de otras fuentes - categoría 6",
                                        "",
                                    ],
                                    ["4.7 Emisiones discriminadas por GEI", ""],
                                    [
                                        "5. RESULTADOS TOTALES DEL INVENTARIO",
                                        "",
                                    ],
                                    [
                                        "6. CÁLCULO DE LA INCERTIDUMBRE DEL INVENTARIO",
                                        "",
                                    ],
                                    [
                                        "7. METODOLOGÍA, FCTORES DE EMISIÓN Y PCG UTILIZADOS",
                                        "",
                                    ],
                                    ["8. GESTIÓN DE LA INFORMACIÓN", ""],
                                    ["10. CONCLUSIONES", ""],
                                ],
                            },
                            layout: "noBorders",
                        },
                        {
                            text: [
                                {
                                    text: "Lista de Tablas",
                                    alignment: "center",
                                    bold: true,
                                },
                            ],
                            margin: [0, 0, 0, 20],
                        },
                        {
                            text: [
                                {
                                    text: "",
                                    alignment: "right",
                                    bold: true,
                                },
                            ],
                        },
                        {
                            style: "tableExample",
                            margin: [0, 0, 0, 20],
                            table: {
                                widths: ["*", 20],
                                heights: function (row) {
                                    return 22;
                                },
                                body: [
                                    [
                                        "Tabla 1. Emisiones generadas por fuentes móviles",
                                        "",
                                    ],
                                    ["Tabla 2. Fuentes fijas", ""],
                                    ["Tabla 3. Emisiones de proceso", ""],
                                    [
                                        "Tabla 4 Resultados de Fuentes Directas",
                                        "",
                                    ],
                                    ["Tabla 5. Emisiones Indirectas", ""],
                                    [
                                        "Tabla 6 Emisiones generadas por otras fuentes de emisión",
                                        "",
                                    ],
                                    [
                                        "Tabla 7 Emisiones generadas por otras fuentes de emisión",
                                        "",
                                    ],
                                    [
                                        "Tabla 8 Emisiones generadas por otras fuentes de emisión",
                                        "",
                                    ],
                                    [
                                        "Tabla 9 Emisiones generadas por otras fuentes de emisión",
                                        "",
                                    ],
                                    [
                                        "Tabla 10 Emisiones Directas Discriminadas por GEI",
                                        "",
                                    ],
                                    [
                                        "Tabla 11. Total Emisiones Discriminadas por GEI",
                                        "",
                                    ],
                                    [
                                        "Tabla 12. Resultados totales del inventario corporativo de GEI",
                                        "",
                                    ],
                                    ["Tabla 13. Factores de emisión", ""],
                                    [
                                        "Tabla 14. Potenciales de Calentamiento Global",
                                        "",
                                    ],
                                ],
                            },
                            layout: "noBorders",
                        },
                        {
                            text: [
                                {
                                    text: "Lista de Figuras",
                                    alignment: "center",
                                    bold: true,
                                },
                            ],
                            margin: [0, 0, 0, 20],
                        },
                        {
                            text: [
                                {
                                    text: "",
                                    alignment: "right",
                                    bold: true,
                                },
                            ],
                        },
                        {
                            style: "tableExample",
                            table: {
                                widths: ["*", 20],
                                heights: function (row) {
                                    return 22;
                                },
                                body: [
                                    [
                                        "Figura 1. Distribución de la huella de carbono por categorías",
                                        "",
                                    ],
                                    [
                                        "Figura 2. Distribución porcentual de la huella de carbono por emisiones",
                                        "",
                                    ],
                                ],
                            },
                            layout: "noBorders",
                            pageBreak: "after",
                        },
                        {
                            text: [
                                {
                                    text: "INTRODUCCIÓN",
                                    alignment: "center",
                                    bold: true,
                                },
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                {
                                    text: "La Huella de Carbono Corporativa es un indicador que permite identificar el impacto ambiental de una organización en términos de emisiones de GEI (Gases Efecto Invernadero), causantes del Cambio Climático de origen humano.",
                                    alignment: "justify",
                                },
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                {
                                    text: "Para cuantificar dicha Huella de Carbono Corporativa, las metodologías de mayor reconocimiento y aplicación internacional son: i) el Estándar Corporativo de Contabilidad y Reporte de Gases Efecto Invernadero (GHG Protocol, por su nombre genérico en inglés), desarrollado por el World Resources Institute (WRI) y el World Business Council for Sustainable Development (WBCSD). ii) La ISO 14064-1:2020 que cuenta con revisión y adaptación como Norma Técnica Colombiana NTC. Estas metodologías brindan lineamientos para identificar y clasificar las fuentes de emisión de GEI, de la siguiente manera:",
                                    alignment: "justify",
                                },
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                { text: "Emisiones directas: ", bold: true },
                                "considera todas las fuentes de emisión de GEI que son propiedad de la organización o que se encuentran bajo su control durante el año objeto del cálculo.",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                {
                                    text: "Emisiones indirectas por energía: ",
                                    bold: true,
                                },
                                "considera la energía térmica o eléctrica que se compra en el mercado energético a un tercero.",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                {
                                    text: "Otras fuentes indirectas: ",
                                    bold: true,
                                },
                                "se considera las fuentes de emisión de GEI indirectas en relación con las actividades de la empresa.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "De acuerdo con la ISO 14064-1:2020, las emisiones de GEI se clasifican en las siguientes categorías:",
                            ],
                            style: "paragraph",
                        },
                        {
                            type: "lower-alpha",
                            separator: ")",
                            ol: [
                                {
                                    text: "Emisiones y remociones directas de GEI",
                                    margin: [10, 0, 0, 5],
                                },
                                {
                                    text: "Emisiones indirectas de GEI por energía importada",
                                    margin: [10, 0, 0, 5],
                                },
                                {
                                    text: "Emisiones indirectas de GEI por transporte (transporte tercerizado)",
                                    margin: [10, 0, 0, 5],
                                },
                                {
                                    text: "Emisiones indirectas de GEI por productos utilizados por la organización (bienes y productos, materias primas, servicios- manejo de residuos)",
                                    margin: [10, 0, 0, 5],
                                },
                                {
                                    text: "Emisiones indirectas de GEI asociadas con el uso de productos de la organización (productos, activos arrendados, inversiones)",
                                    margin: [10, 0, 0, 5],
                                },
                                {
                                    text: "Emisiones indirectas de GEI por otras fuentes (consumo de papel, transporte aéreo tercerizado)",
                                    margin: [10, 0, 0, 10],
                                },
                            ],
                        },

                        {
                            text: [
                                "El resultado de la Huella de Carbono Corporativa se expresa en toneladas de CO2 equivalente anuales (Ton CO2 eq/año), las cuales incluyen todos los GEI identificados en el inventario corporativo de emisiones.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Realizar la estimación de la Huella de Carbono Corporativa permite que las empresas tengan un punto de partida para establecer planes de acción con el fin de optimizar el uso de recursos, encontrar eficiencias, fortalecer la gestión de información, implementar nuevas tecnologías, trazarse metas de reducción o compensación de la Huella de Carbono e involucrar a proveedores y clientes en estas y otras potenciales medidas de sostenibilidad.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Teniendo en cuenta lo anterior, la Cámara de Comercio de Bogotá CCB y la Corporación Ambiental Empresarial CAEM, encamina sus esfuerzos para realizar el inventario de los gases de efecto invernadero GEI de ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", con el objetivo de gestionar su emisión de gases de efecto invernadero y así, buscar alternativas para mitigar su impacto. Este ejercicio es ahora parte de las acciones de sostenibilidad y responde directamente a las metas planteadas por los Objetivos de Desarrollo Sostenible (ODS), contenidos dentro de la agenda 2030 de la ONU, además de estar alineada con la reciente Política Nacional de Cambio Climático.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Cada una de las acciones a desarrollar dentro de la cuantificación, gestión y posterior reducción de sus emisiones, permite contribuir directamente a la solución de un problema a escala global, al aumento de la conciencia ambiental de las organizaciones y la sociedad, reducir impactos en la salud, generar ahorros económicos por implementación de buenas prácticas, medidas de eficiencia energética y de uso de energías renovables, reducir sus riesgos técnicos, legales y ambientales y aumento de oportunidades comerciales y de acceso a mercados de carbono, entre otros.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "El presente informe, que responde a los lineamientos de la Norma Técnica Colombiana ISO NTC-ISO 14064-1:2020 y de forma complementaria al Protocolo Corporativo de Gases de Efecto Invernadero1, está orientado a ser un referente técnico para la gestión ambiental interna de la empresa, con el propósito de ser usado como herramienta para informar a los miembros de la Organización sobre la importancia de la medición y gestión de la Huella de Carbono, generando insumos para la toma de decisiones, permitiéndoles conocer un panorama de las fuentes de emisión presentes en la misma y la distribución porcentual de las emisiones de GEI en directas o indirectas, así como una base que les permita realizar un seguimiento a través del tiempo.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["1. DESCRIPCIÓN DE LA ORGANIZACIÓN"],
                            margin: [0, 20, 0, 20],
                            bold: true,
                        },

                        {
                            style: "tableExample",
                            table: {
                                widths: [150, "*"],
                                body: [
                                    [
                                        "Nombre:",
                                        this.informacion_empresa.empresa
                                            .nombre +
                                            " / " +
                                            this.informacion_empresa
                                                .empresa_sede.nombre,
                                    ],
                                    [
                                        "NIT.:",
                                        this.informacion_empresa.empresa.nit,
                                    ],
                                    [
                                        "Dirección:",
                                        this.informacion_empresa.empresa_sede
                                            .direccion
                                            ? this.informacion_empresa
                                                  .empresa_sede.direccion
                                            : "N/R",
                                    ],
                                    [
                                        "Teléfono:",
                                        this.informacion_empresa.empresa
                                            .telefono,
                                    ],
                                ],
                            },
                            fillColor: "#d1e6f6",
                            layout: {
                                hLineColor: "white",
                                vLineColor: "white",
                            },
                        },

                        {
                            text: ["1.1. Objetivo del reporte GEI"],
                            margin: [0, 20, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Presentar los resultados del cálculo de la huella de carbono de la empresa ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                " para el periodo de " +
                                    this.informacion_empresa.label +
                                    ", exponiendo las fuentes de generación de GEI clasificadas por emisiones, como estrategia para la mejora del desempeño ambiental empresarial y la reducción de las emisiones de gases de efecto invernadero en cumplimiento con las políticas nacionales y organizacionales.",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: ["2. LÍMITES ORGANIZACIONALES Y DE INFORME"],
                            margin: [0, 20, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "La organización ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                " reporta sus emisiones de gases de efecto invernadero con enfoque de control en donde se consideran todas las emisiones o remociones de GEI en las instalaciones en las que tiene control operacional y financiera.",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: ["2.1. Ubicación"],
                            margin: [0, 20, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "",
                                this.informacion_empresa.empresa.nombre,
                                " / ",
                                this.informacion_empresa.empresa_sede.nombre,
                                " está localizada en ",
                                this.informacion_empresa.empresa_sede.direccion
                                    ? this.informacion_empresa.empresa_sede
                                          .direccion
                                    : "",
                                ", ",
                                this.informacion_empresa.empresa_sede.ciudad
                                    .nombre,
                                ", ",
                                this.informacion_empresa.empresa_sede
                                    .departamento.nombre,
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "3. DESCRIPCIÓN DEL AÑO BASE Y SEGUIMIENTO A LAS EMISIONES",
                            ],
                            margin: [0, 20, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "3.1. Descripción del año base seleccionado",
                            ],
                            margin: [15, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Con el fin de calcular el inventario GEI de ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                " el presente informe contempla la medición realizada corresponde a la vigencia del periodo comprendido entre " +
                                    this.informacion_empresa.label,
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "3.2. Seguimiento de las emisiones a través del tiempo",
                            ],
                            margin: [15, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Dado el compromiso de ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                " de cuantificar, reportar y gestionar sus emisiones de GEI, la Organización declara que cualquier cambio en el año base será explicado en reportes de inventarios anuales futuros, creando un procedimiento que considere condiciones como: cambios en los límites operativos, propiedad y control de fuentes de GEI, cambios en metodologías de cuantificación, mejoras en la calidad de los datos, cambios en factores de emisión, entre otros, de acuerdo con los lineamientos metodológicos.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["4. LÍMITES DE INFORME"],
                            margin: [0, 20, 0, 20],
                            bold: true,
                        },

                        {
                            text: [
                                "Para el desarrollo del presente reporte, los límites de informe incluyen las emisiones consideradas por el GHG Protocol, relacionados con identificación de emisiones directas asociadas a las actividades de la Organización, las emisiones indirectas asociadas al consumo de electricidad y otras emisiones indirectas, según se describe en los siguientes numerales.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["4.1. Emisiones Directas – Categoría 1"],
                            margin: [0, 20, 0, 20],
                            bold: true,
                        },

                        {
                            text: [
                                "Las emisiones directas corresponden a emisiones generadas por la organización dentro de los límites señalados para el presente informe. El total de emisiones directas es de " +
                                    this.parseDotToComma(
                                        this.resultados.fuentes_directas
                                            .total_huella_carbono
                                    ) +
                                    " Ton CO2 eq, las cuales representa aproximadamente el " +
                                    this.parseDotToComma(
                                        this.resultados.fuentes_directas
                                            .total_porcentaje_huella_total
                                    ) +
                                    "% del total de la huella de carbono de la empresa, con un rango de incertidumbre de +/- " +
                                    this.parseDotToComma(
                                        this.resultados.fuentes_directas
                                            .total_incertidumbre
                                    ) +
                                    "% que, de acuerdo con la orientación de GHG Protocol sobre evaluación de incertidumbre, se considera un nivel de precisión “" +
                                    this.parseDotToComma(
                                        this.getCalificacionInventario(
                                            this.resultados.fuentes_directas
                                                .total_incertidumbre
                                        )
                                    ) +
                                    "”. ",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["4.1.1. Fuentes Móviles Emisiones Directas"],
                            margin: [15, 0, 0, 20],
                            bold: true,
                        },
                        {
                            ul: [
                                {
                                    text: "Emisiones y remociones directas de GEI",
                                },
                            ],
                            bold: true,
                            margin: [0, 0, 0, 10],
                        },
                        {
                            text: [
                                "Con el fin de obtener resultados que minimicen la incertidumbre y proporcionen resultados exactos, coherentes y reproducibles, se realiza el cálculo de las emisiones empleando la metodología que relaciona datos de la actividad con factores de emisión. La fórmula general usada para el cálculo de las emisiones directas de las fuentes móviles es:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Emisiones CO2e = Carga ambiental x Factor de emisión x Potencial de calentamiento global",
                            ],
                            style: "paragraph",
                            alignment: "center",
                            bold: true,
                        },

                        {
                            text: [
                                "Luego de la identificación y recolección de información, se realizó el cálculo de las emisiones GEI asociadas a las fuentes móviles de la empresa, obteniendo los siguientes resultados:",
                            ],
                            style: "paragraph",
                            pageBreak: "after",
                        },

                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////

                        {
                            text: [
                                "Tabla 1. Emisiones generadas por fuentes móviles",
                            ],
                            style: "paragraph",
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 3,
                                body: this.resultados.tabla1Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "El resultado total de las ",
                                {
                                    text:
                                        "emisiones para las fuentes móviles es de " +
                                        this.resultados.fuentes_moviles
                                            .total_huella_carbono +
                                        " Ton CO2 eq",
                                    bold: true,
                                },
                                "; con una ",
                                {
                                    text:
                                        "incertidumbre de +/- " +
                                        this.resultados.fuentes_moviles
                                            .total_incertidumbre_fuente +
                                        "%",
                                    bold: true,
                                },
                                ", que de acuerdo con la orientación de GHG Protocol sobre evaluación de incertidumbre, se considera un nivel de precisión “" +
                                    this.getCalificacionInventario(
                                        this.resultados.fuentes_moviles
                                            .total_incertidumbre_fuente
                                    ) +
                                    "”.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["4.1.2. Fuentes fijas Emisiones Directas"],
                            margin: [15, 0, 0, 20],
                            bold: true,
                        },
                        {
                            ul: [{ text: "Resultados fuentes fijas" }],
                            bold: true,
                            margin: [0, 0, 0, 10],
                        },
                        {
                            text: [
                                "Con el fin de obtener resultados que minimicen la incertidumbre, y proporcionen resultados exactos, coherentes y reproducibles, se realiza el cálculo de las emisiones empleando la metodología que relaciona datos de la actividad con factores de emisión.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "La fórmula general usada para el cálculo de las emisiones directas de las fuentes fijas es:",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Emisiones CO2e= Carga ambiental x Factor de emisión x Potencial de calentamiento global",
                            ],
                            bold: true,
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Para el cálculo de fugas anuales de los sistemas de refrigeración ya sean aires acondicionados, chillers, entre otros, se toma la carga total refrigerante de cada sistema y se multiplica por el porcentaje de fugas determinado según la metodología del IPCC 2019. La empresa no reporta recarga de refrigerante para el periodo de estudio. ",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Emisiones CO2 = Carga ambiental x Potencial de fugas, según sistema de refrigeración",
                            ],
                            bold: true,
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Luego de la identificación y recolección de información, se realizó el cálculo de las emisiones GEI asociadas a las fuentes fijas de la empresa obteniendo los siguientes resultados:",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["Tabla 2. Fuentes fijas"],
                            style: "paragraph",
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 2,
                                body: this.resultados.tabla2Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo CAEM– ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "El resultado total de las ",
                                {
                                    text:
                                        "emisiones para las fuentes fijas es de " +
                                        this.resultados.fuentes_fijas
                                            .total_huella_carbono +
                                        " Ton CO2 eq",
                                    bold: true,
                                },
                                "; con una ",
                                {
                                    text:
                                        "incertidumbre de +/- " +
                                        this.resultados.fuentes_fijas
                                            .total_incertidumbre_fuente +
                                        "%",
                                    bold: true,
                                },
                                ", que de acuerdo con la orientación de GHG Protocol sobre evaluación de incertidumbre, se considera un nivel de precisión “" +
                                    this.getCalificacionInventario(
                                        this.resultados.fuentes_fijas
                                            .total_incertidumbre_fuente
                                    ) +
                                    "”.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["4.1.3. Emisiones de Proceso"],
                            margin: [15, 0, 0, 20],
                            bold: true,
                        },
                        {
                            ul: [{ text: "Resultados emisiones de proceso" }],
                            bold: true,
                            margin: [0, 0, 0, 10],
                        },
                        {
                            text: [
                                "Con el fin de obtener resultados que minimicen la incertidumbre, y proporcionen resultados exactos, coherentes y reproducibles, se realiza el cálculo de las emisiones empleando la metodología que relaciona datos de la actividad con factores de emisión.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Luego de la identificación y recolección de información, se realizó el cálculo de las emisiones GEI asociadas a las emisiones de proceso de la empresa obteniendo los siguientes resultados:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: ["Tabla 3. Emisiones de proceso"],
                            style: "paragraph",
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 2,
                                body: this.resultados.tabla3Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo CAEM– ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },
                        {
                            text: [
                                "El resultado total de las ",
                                {
                                    text:
                                        "emisiones de proceso es de " +
                                        this.resultados.emisiones
                                            .total_huella_carbono +
                                        " Ton CO2 eq",
                                    bold: true,
                                },
                                "; con una ",
                                {
                                    text:
                                        "incertidumbre de +/- " +
                                        this.resultados.emisiones
                                            .total_incertidumbre_fuente +
                                        "%",
                                    bold: true,
                                },
                                " que, de acuerdo con la orientación de GHG Protocol sobre evaluación de incertidumbre, se considera un nivel de precisión “" +
                                    this.getCalificacionInventario(
                                        this.resultados.emisiones
                                            .total_incertidumbre_fuente
                                    ) +
                                    "”.",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["4.1.4. Resultados de Emisiones Directas"],
                            margin: [15, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Luego de la identificación y recolección de información, se realizó el cálculo de las emisiones GEI asociadas a las fuentes móviles y fijas de la empresa, obteniendo los siguientes resultados:",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: ["Tabla 4. Resultados de Fuentes Directas"],
                            style: "paragraph",
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",
                            table: {
                                widths: ["auto", "auto", "auto", "auto"],
                                headerRows: 2,
                                body: this.resultados.tabla4Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de Cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },
                        {
                            text: [
                                "4.2. Emisiones Indirectas Por Energía Importada – Categoría 2",
                            ],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Las emisiones indirectas son las asociadas a la energía eléctrica consumida por la Organización dentro de los límites señalados para el presente informe.",
                            ],
                            style: "paragraph",
                        },

                        {
                            ul: [
                                {
                                    text: "Resultados emisiones indirectas por energía eléctrica.",
                                },
                            ],
                            bold: true,
                            margin: [0, 0, 0, 10],
                        },
                        {
                            text: [
                                "Con el fin de obtener resultados que minimicen la incertidumbre y proporcionen resultados exactos, coherentes y reproducibles, se realiza el cálculo de las emisiones empleando la metodología que relaciona datos de la actividad con factores de emisión. La fórmula general usada para el cálculo de las emisiones indirectas es:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Emisiones CO2e = Carga ambiental x Factor de emisión x Potencial de calentamiento global",
                            ],
                            bold: true,
                            style: "paragraph",
                            alignment: "center",
                        },
                        {
                            text: [
                                "Luego de la identificación y recolección de información, se realizó el cálculo de las emisiones indirectas de GEI, obteniendo los siguientes resultados:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: ["Tabla 5. Emisiones Indirectas"],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 2,
                                body: this.resultados.tabla5Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de Cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },
                        {
                            text: [
                                "El ",
                                {
                                    text:
                                        "total de emisiones indirectas es de " +
                                        this.resultados.fuentes_indirectas
                                            .total_huella_carbono +
                                        " Ton CO2 eq",
                                    bold: true,
                                },
                                ", con un rango de ",
                                {
                                    text:
                                        "incertidumbre de +/- " +
                                        this.resultados.fuentes_indirectas
                                            .total_incertidumbre_fuente +
                                        "%",
                                    bold: true,
                                },
                                " que de acuerdo con la orientación de GHG Protocol sobre evaluación de incertidumbre se considera de “" +
                                    this.getCalificacionInventario(
                                        this.resultados.fuentes_indirectas
                                            .total_incertidumbre_fuente
                                    ) +
                                    "” precisión.",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Con el fin de obtener resultados que minimicen la incertidumbre, y proporcionen resultados exactos, coherentes y reproducibles, se realiza el cálculo de las emisiones empleando la metodología que relaciona datos de la actividad con factores de emisión. La fórmula general usada para el cálculo de las emisiones indirectas es:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Emisiones CO2e = Carga ambiental x Factor de emisión x Potencial de calentamiento global",
                            ],
                            bold: true,
                            style: "paragraph",
                            alignment: "center",
                        },
                        {
                            text: [
                                "4.3. Emisiones Indirectas por transporte– categoría 3",
                            ],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Al respecto en ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", se reportan las siguientes emisiones:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Tabla 6. Emisiones generadas por otras fuentes de emisión",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 2,
                                body: this.resultados.tabla6Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "4.4. Emisiones Indirectas por productos que utiliza la organización – categoría 4",
                            ],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Al respecto en ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", se reportan las siguientes emisiones:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Tabla 7 Emisiones generadas por otras fuentes de emisión",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 2,
                                body: this.resultados.tabla7Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "4.5. Emisiones Indirectas por uso de productos de la organización – categoría 5",
                            ],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Al respecto en ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", se reportan las siguientes emisiones:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Tabla 8 Emisiones generadas por otras fuentes de emisión",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 2,
                                body: this.resultados.tabla8Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "4.6. Emisiones Indirectas proveniente de otras fuentes – categoría 6",
                            ],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Al respecto en ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", se reportan las siguientes emisiones:",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Tabla 9 Emisiones generadas por otras fuentes de emisión",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",

                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 2,

                                body: this.resultados.tabla9Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: ["4.7. Emisiones discriminadas por GEI"],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Según los requerimientos metodológicos de la Norma NTC ISO 14064-1 y el GHG Protocol, es necesario cuantificar la cantidad de emisiones asociada a cada GEI por separado en Ton CO2 eq.",
                                "\nA continuación, se relacionan los valores obtenidos para el inventario de la organización",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Tabla 10 Emisiones Directas Discriminadas por GEI",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },

                        {
                            style: "tableExample",
                            fillColor: "#dce6f1",
                            table: {
                                widths: ["auto", "auto", "auto", "auto"],
                                headerRows: 2,
                                body: this.resultados.tabla10Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "Tabla 11. Total Emisiones Discriminadas por GEI",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },

                        {
                            style: "tableExample",
                            fillColor: "#dce6f1",
                            table: {
                                widths: ["auto", "auto", "auto", "auto"],
                                headerRows: 2,
                                body: this.resultados.tabla11Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: ["Tabla 12. Total Emisiones Biomasa"],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },

                        {
                            style: "tableExample",
                            fillColor: "#d8e4bc",
                            table: {
                                widths: ["auto", "auto", "auto", "auto"],
                                headerRows: 2,
                                body: this.resultados.tabla12Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: ["5. RESULTADOS TOTALES DEL INVENTARIO"],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "La tabla a continuación resume los resultados generales obtenidos en el inventario de GEI de la organización para el " +
                                    this.informacion_empresa.label,
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Tabla 13. Resultados totales del inventario corporativo de GEI",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",
                            fillColor: "#d8e4bc",
                            fontSize: "6",
                            table: {
                                widths: [
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                    "auto",
                                ],
                                headerRows: 1,
                                body: this.resultados.tabla13Body,
                            },
                            alignment: "center",
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "El ",
                                {
                                    text: [
                                        "resultado total de las emisiones de GEI de ",
                                        this.informacion_empresa.empresa
                                            .nombre +
                                            " / " +
                                            this.informacion_empresa
                                                .empresa_sede.nombre,
                                        " para el periodo base fue de " +
                                            this.resultados.tabla13
                                                .total_huella_carbono,
                                        "Ton CO2 eq",
                                    ],
                                    bold: true,
                                },
                                ", con una ",
                                {
                                    text:
                                        "incertidumbre de +/- " +
                                        this.resultados.tabla13
                                            .total_incertidumbre_fuente +
                                        "%",
                                    bold: true,
                                },
                                " que, de acuerdo con la orientación del GHG Protocol sobre evaluación de incertidumbre, se considera un inventario con una precisión “" +
                                    this.getCalificacionInventario(
                                        this.resultados.tabla13
                                            .total_incertidumbre_fuente
                                    ) +
                                    "”.",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "Figura 1. Distribución de la huella de carbono por categorías",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            text: ["(Ton CO2 eq)"],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",
                            color: "#444",
                            alignment: "center",
                            table: {
                                widths: [140, "auto"],
                                body: [
                                    [
                                        {
                                            text: "",
                                            border: [
                                                false,
                                                false,
                                                false,
                                                false,
                                            ],
                                        },
                                        {
                                            //text: ["DIAGRAMA BARRAS"],
                                            image: this.convertCanvasToBase64(
                                                "huella-carbono-directa-indirecta-bar"
                                            ),
                                            width: 250,
                                            alignment: "center",
                                            border: [
                                                false,
                                                false,
                                                false,
                                                false,
                                            ],
                                        },
                                    ],
                                ],
                            },
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        {
                            text: [
                                "Figura 2. Distribución porcentual de la huella de carbono por emisiones",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            text: ["(Ton CO2 eq)"],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            style: "tableExample",
                            color: "#444",
                            alignment: "center",
                            table: {
                                widths: ["auto", "auto"],
                                body: [
                                    [
                                        {
                                            image: this.convertCanvasToBase64(
                                                "huella-carbono-fuente-bar"
                                            ),
                                            width: 250,
                                            alignment: "center",
                                            border: [
                                                false,
                                                false,
                                                false,
                                                false,
                                            ],
                                        },
                                        {
                                            image: this.convertCanvasToBase64(
                                                "huella-carbono-fuente-pie"
                                            ),
                                            width: 250,
                                            alignment: "center",
                                            border: [
                                                false,
                                                false,
                                                false,
                                                false,
                                            ],
                                        },
                                    ],
                                ],
                            },
                        },
                        {
                            text: [
                                "Fuente: Herramienta de cálculo HCC CAEM – ",
                                this.informacion_empresa.empresa.nombre +
                                    " / " +
                                    this.informacion_empresa.empresa_sede
                                        .nombre,
                                ", " + this.informacion_empresa.label,
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },

                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////
                        /////////////////////////////////////

                        {
                            text: [
                                "6. CÁLCULO DE LA INCERTIDUMBRE DEL INVENTARIO",
                            ],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "La estimación de la incertidumbre del inventario se realizó atendiendo a los lineamientos metodológicos propuestos en el documento denominado “GHG Protocol guidance on uncertainty assessment in GHG inventories and calculating statistical parameter uncertainty”, disponible en la página Web del GHG Protocol. ",
                            ],
                            style: "paragraph",
                        },

                        {
                            text: [
                                "El cálculo de la incertidumbre total del inventario combina la incertidumbre de los datos de actividad (cargas ambientales) y la incertidumbre de los factores de emisión.",
                            ],
                            style: "paragraph",
                        },
                        {
                            fillColor: "#dce6f1",
                            margin: [140, 0, 0, 30],
                            alignment: "center",
                            table: {
                                widths: [100, 100],
                                body: [
                                    [
                                        {
                                            text: "High (alta)",
                                            bold: true,
                                            margin: [0, 3, 0, 3],
                                        },
                                        {
                                            text: "+/- 5%",
                                            margin: [0, 3, 0, 3],
                                        },
                                    ],
                                    [
                                        {
                                            text: "Good (buena)",
                                            bold: true,
                                            margin: [0, 3, 0, 3],
                                        },
                                        {
                                            text: "+/- 15%",
                                            margin: [0, 3, 0, 3],
                                        },
                                    ],
                                    [
                                        {
                                            text: "Fair (favorable)",
                                            bold: true,
                                            margin: [0, 3, 0, 3],
                                        },
                                        {
                                            text: "+/- 30%",
                                            margin: [0, 3, 0, 3],
                                        },
                                    ],
                                    [
                                        {
                                            text: "Poor (pobre)",
                                            bold: true,
                                            margin: [0, 3, 0, 3],
                                        },
                                        {
                                            text: "Mas del +/- 30%",
                                            margin: [0, 3, 0, 3],
                                        },
                                    ],
                                ],
                            },
                            style: "paragraph",
                        },

                        {
                            text: [
                                "7. METODOLOGÍA, FACTORES DE EMISIÓN Y PCG UTILIZADOS",
                            ],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "El presente informe ha sido preparado atendiendo a los lineamientos metodológicos del “ESTANDAR CORPORATIVO DE CONTABILIDAD Y REPORTE – GHG PROTOCOL”, desarrollado por el Instituto de Recursos Mundiales (WRI) y el Consejo Mundial Empresarial para el Desarrollo Sustentable (WBCSD) y para reportar las estimaciones de emisiones se realizó según las directrices de la norma NTC-ISO 14064-1:2020.",
                            ],
                            style: "paragraph",
                            margin: [0, 0, 0, 0],
                        },

                        {
                            text: [
                                "El cálculo de la huella de carbono se hizo usando la herramienta desarrollada por la Corporación Ambiental Empresarial (CAEM) y cuyas actualizaciones se han venido desarrollando desde entonces, según actualizaciones de factor de emisión, requerimientos de verificación o de cada organización.",
                            ],
                            style: "paragraph",
                            margin: [0, 0, 0, 0],
                        },

                        {
                            text: [
                                "Los factores de emisión usados, de acuerdo con las recomendaciones metodológicas, derivan de un origen reconocido, son apropiados para las fuentes de GEI involucrados en el inventario, están actualizados en el momento de la realización de este informe, permiten obtener resultados exactos y reproducibles y son coherentes con el uso previsto de este inventario. A continuación, se hace un resumen de los factores de emisión empleados:",
                            ],
                            style: "paragraph",
                        },
                        {
                            stack: [
                                {
                                    text: [
                                        "Tabla 13. Resultados totales del inventario corporativo de GEI",
                                    ],
                                    margin: [0, 0, 0, 10],
                                    alignment: "center",
                                    bold: true,
                                },
                                {
                                    fontSize: 11,
                                    unbreakable: true,
                                    color: "#5e90b3",
                                    alignment: "center",
                                    table: {
                                        widths: ["*", "*", "*", "*"],
                                        body: [
                                            [
                                                {
                                                    text: "Carga Ambiental",
                                                    bold: true,
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                                {
                                                    text: "Factor de emisión",
                                                    bold: true,
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                                {
                                                    text: "Unidad",
                                                    bold: true,
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                                {
                                                    text: "Fuente Bibliográfica",
                                                    bold: true,
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "Fuentes Móviles",
                                                    colSpan: 4,
                                                    bold: true,
                                                    alignment: "left",
                                                },
                                                { text: "" },
                                                { text: "" },
                                                { text: "" },
                                            ],
                                            [
                                                {
                                                    text: "Diesel (ACPM)",
                                                    rowSpan: 3,
                                                    alignment: "left",
                                                },
                                                { text: "10,149" },
                                                { text: "kgCO2/gal" },
                                                { text: "FECOC UPME 2016" },
                                            ],
                                            [
                                                { text: "" },
                                                { text: "0,00001" },
                                                { text: "KgCH4/gal" },
                                                { text: "FECOC UPME 2016" },
                                            ],
                                            [
                                                { text: "" },
                                                { text: "0,00001" },
                                                { text: "kgN2O/gal" },
                                                { text: "FECOC UPME 2016" },
                                            ],
                                            [
                                                {
                                                    text: "Biodiesel Palma",
                                                    rowSpan: 3,
                                                    alignment: "left",
                                                },
                                                { text: "6,88" },
                                                { text: "kgCO2/gal" },
                                                { text: "FECOC UPME 2016" },
                                            ],
                                            [
                                                { text: "" },
                                                { text: "0,00003" },
                                                { text: "KgCH4/gal" },
                                                { text: "FECOC UPME 2016" },
                                            ],
                                            [
                                                { text: "" },
                                                { text: "6,88" },
                                                { text: "kgCO2/gal" },
                                                { text: "FECOC UPME 2016" },
                                            ],
                                            [
                                                {
                                                    text: "Fuentes Fijas",
                                                    colSpan: 4,
                                                    bold: true,
                                                    alignment: "left",
                                                },
                                                { text: "" },
                                                { text: "" },
                                                { text: "" },
                                            ],
                                            [
                                                {
                                                    text: "Extintores CO2",
                                                    alignment: "left",
                                                },
                                                { text: "1" },
                                                { text: "kg CO2 e/kg" },
                                                { text: "IPCC 2019" },
                                            ],
                                            [
                                                {
                                                    text: "Gas Natural Genérico",
                                                    rowSpan: 3,
                                                    alignment: "left",
                                                },
                                                { text: "1,980" },
                                                { text: "kg CO2/m3" },
                                                { text: "IPCC 2019" },
                                            ],
                                            [
                                                { text: "" },
                                                { text: "0,0000357" },
                                                { text: "kg CH4/m3" },
                                                { text: "IPCC 2019" },
                                            ],
                                            [
                                                { text: "" },
                                                { text: "0,00000" },
                                                { text: "kg N2O/m3" },
                                                { text: "IPCC 2019" },
                                            ],
                                            [
                                                {
                                                    text: "Energía Eléctrica",
                                                    colSpan: 4,
                                                    bold: true,
                                                    alignment: "left",
                                                },
                                                { text: "" },
                                                { text: "" },
                                                { text: "" },
                                            ],
                                            [
                                                {
                                                    text: "Energía Eléctrica adquirida",
                                                    alignment: "left",
                                                },
                                                { text: "0,12" },
                                                { text: "kg CO2 e/KWh" },
                                                { text: "FECOC UPME 2021" },
                                            ],
                                            [
                                                {
                                                    text: "Otras Fuentes Indirectas",
                                                    colSpan: 4,
                                                    bold: true,
                                                    alignment: "left",
                                                },
                                                { text: "" },
                                                { text: "" },
                                                { text: "" },
                                            ],
                                            [
                                                {
                                                    text: "Incineración controlada residuos sólidos industriales (continua-cargador mecánico)",
                                                    alignment: "left",
                                                },
                                                { text: "0,00000020" },
                                                { text: "kgCH4/kg húmedo" },
                                                { text: "IPCC 2019" },
                                            ],
                                            [
                                                {
                                                    text: "Incineración controlada residuos sólidos lodos aguas residuales (continua-cargador mecánico)",
                                                    alignment: "left",
                                                },
                                                { text: "0,00000020" },
                                                { text: "kgCH4/kg húmedo" },
                                                { text: "IPCC 2019" },
                                            ],
                                            [
                                                {
                                                    text: "Residuos sólidos a relleno sanitario anaeróbico ",
                                                    alignment: "left",
                                                },
                                                { text: "0,05259000" },
                                                { text: "kgCH4/kg húmedo" },
                                                { text: "IPCC 2019" },
                                            ],
                                        ],
                                    },
                                },
                            ],
                            unbreakable: true,
                        },
                        {
                            text: [
                                "Fuente: Documento de Factores de Emisión – CAEM, MVC COLOMBIA",
                            ],
                            alignment: "center",
                            margin: [0, 0, 0, 30],
                        },
                        {
                            text: [
                                "Tabla 14. Potenciales de Calentamiento Global",
                            ],
                            margin: [0, 0, 0, 10],
                            alignment: "center",
                            bold: true,
                        },
                        {
                            columns: [
                                { width: "*", text: "" },
                                {
                                    width: "auto",
                                    alignment: "center",
                                    table: {
                                        widths: [100, 100],
                                        body: [
                                            [
                                                {
                                                    text: "GEI",
                                                    bold: true,
                                                    style: "cellSpaced",
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                                {
                                                    text: "AR5 (2014) ",
                                                    bold: true,
                                                    style: "cellSpaced",
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "CO2",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "1",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "CH4",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "28",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "N2O",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "265",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "SF6",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "23500",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "NF3",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "16100",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "Compuestos Fluorados",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "Según el tipo de gas",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                        ],
                                    },
                                },
                                { width: "*", text: "" },
                            ],
                        },
                        {
                            text: [
                                { text: "Fuente: ", bold: true },
                                "IPCC 5th Assessment Report",
                            ],
                            margin: [150, 0, 0, 30],
                        },

                        {
                            columns: [
                                { width: "*", text: "" },
                                {
                                    width: "auto",
                                    alignment: "center",
                                    table: {
                                        widths: [100, 100],
                                        body: [
                                            [
                                                {
                                                    text: "GEI",
                                                    bold: true,
                                                    style: "cellSpaced",
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                                {
                                                    text: "AR6 (2021)",
                                                    bold: true,
                                                    style: "cellSpaced",
                                                    fillColor: "#215967",
                                                    color: "white",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "CO2",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "1  ",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "CH4",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "27,9 ",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "N2O",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "273 ",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "SF6",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "25200 ",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "NF3",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "17400 ",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                            [
                                                {
                                                    text: "Compuestos Fluorados",
                                                    style: "cellSpaced",
                                                },
                                                {
                                                    text: "Según el tipo de gas  ",
                                                    style: "cellSpaced",
                                                    color: "#5e90b3",
                                                },
                                            ],
                                        ],
                                    },
                                },
                                { width: "*", text: "" },
                            ],
                        },
                        {
                            text: [
                                { text: "Fuente: ", bold: true },
                                "IPCC 6th Assessment Report ",
                            ],
                            alignment: "center",
                            margin: [10, 0, 0, 30],
                        },

                        {
                            text: [
                                "Dentro de la estructura metodológica empleada, las emisiones se calculan multiplicando los datos de actividad o cargas ambientales por los factores de emisión GEI y los potenciales de calentamiento global. La fórmula general usada para el cálculo de las emisiones GEI en el presente inventario es:",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Emisiones CO2 = Carga ambiental x Factor de emisión x Potencial de calentamiento global",
                            ],
                            alignment: "center",
                            bold: true,
                            style: "paragraph",
                        },

                        {
                            text: [
                                "En el caso de las sustancias refrigerantes, la fórmula se simplifica a:",
                            ],
                            style: "paragraph",
                        },
                        {
                            text: [
                                "Emisiones CO2 = Carga ambiental x Potencial de calentamiento global",
                            ],
                            alignment: "center",
                            bold: true,
                            style: "paragraph",
                        },

                        {
                            text: ["8. GESTIÓN DE LA INFORMACIÓN"],
                            margin: [0, 0, 0, 20],
                            bold: true,
                        },
                        {
                            text: [
                                "Para la gestión de la información relacionada con el inventario de GEI, se adoptó el formato de reporte de gestión de información propuesto por la Corporación Ambiental Empresarial CAEM, como soporte del proceso y como insumo para los procesos de verificación de tercera parte.",
                            ],
                            style: "paragraph",
                        },
                        {
                            stack: [
                                {
                                    text: ["10. CONCLUSIONES"],
                                    margin: [0, 0, 0, 20],
                                    bold: true,
                                },
                                {
                                    ul: [
                                        "Este proceso de elaboración del cálculo y reporte corporativo de emisiones de GEI, es un insumo que no solo reviste importancia para la gestión ambiental de la empresa " +
                                            this.informacion_empresa.empresa
                                                .nombre +
                                            " / " +
                                            this.informacion_empresa
                                                .empresa_sede.nombre +
                                            ", sino que además sirve de insumo para toda la gestión organizacional y toma de decisiones en otros frentes de la compañía.",
                                        "Las incertidumbres asociadas a el inventario de GEI pueden ser clasificadas en incertidumbre científica e incertidumbre de la estimación. La incertidumbre científica surge cuando la ciencia de los procesos existentes de emisión y/o remoción de GEI no ha sido comprendida por completo. Por ejemplo, muchos factores directos e indirectos asociados a valores de potencial de calentamiento global (PCG) que son utilizados para combinar estimaciones de emisiones para varios GEI implican una incertidumbre científica significativa. Analizar y cuantificar tal incertidumbre científica es extremadamente problemático, y puede estar más allá de los medios o capacidades de la mayoría de los programas de inventario de las empresas. En cuanto a la incertidumbre de estimación se divide en dos categorías, incertidumbre del modelo que se refiere a todo aquello relacionado con ecuaciones, matemáticas o modelos utilizados para generar los factores de emisión, y por incertidumbre de parámetros se refiere a la incertidumbre asociada a la cuantificación de los parámetros utilizados como insumos (datos de actividad o factores de emisión) en los modelos de estimación.",
                                    ],
                                    style: "paragraph",
                                    margin: [15, 0, 0, 5],
                                },
                            ],
                            unbreakable: true,
                        },
                    ],
                    styles: {
                        paragraph: {
                            margin: [0, 0, 0, 20],
                            alignment: "justify",
                        },
                        headerTableResult: {
                            fillColor: "#aae0bb",
                            color: "black",
                        },
                        footerTableResult: {
                            bold: true,
                            fillColor: "#348c4f",
                            color: "black",
                        },
                        subtotal: {
                            bold: true,
                            color: "white",
                        },
                    },
                };
                // console.log("docDefinition", JSON.stringify(docDefinition));

                const pdfDoc = pdfMake.createPdf(docDefinition);
                pdfDoc.open();
            }
        },
    },
};
</script>
