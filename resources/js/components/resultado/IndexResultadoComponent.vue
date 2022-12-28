<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Resultados</h2>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="16">CONSUMO</th>
                        <th colspan="5">INCERTIDUMBRE DATOS</th>
                        <th colspan="7">EMISIONES CO2</th>
                        <th colspan="7">EMISIONES CH4</th>
                        <th colspan="7">EMISIONES N2O</th>
                        <th colspan="6">EMISIONES COMPUESTOS FLUORADOS</th>
                        <th colspan="7">EMISIONES SF6</th>
                        <th colspan="7">EMISIONES NF3</th>
                        <th rowspan="2">HUELLA DE CARBONO [tonCO2-eq]</th>
                        <th rowspan="2">INCERTIDUMBRE DE LA FUENTE</th>
                    </tr>
                    <tr>
                        <th>FUENTE DE EMISIÓN DE GEI</th>
                        <th>UNIDAD DE CONSUMO</th>
                        <th v-for="i in 12" v-bind:key="i">
                            {{ "DATO " + i }}
                        </th>
                        <th>TOTAL</th>
                        <th>No. DATOS</th>
                        <th>PROMEDIO</th>
                        <th>DESVIACION ESTÁNDAR</th>
                        <th>FACTOR T</th>
                        <th>INCERTIDUMBRE SISTEMATICA ADICIONAL</th>
                        <th>INCERTIDUMBRE DATOS</th>
                        <th colspan="2">FACTOR DE EMISIÓN CO2</th>
                        <th>INCERTIDUMBRE FACTOR EMISIÓN CO2</th>
                        <th>EMISIONES CO2 [tonCO2]</th>
                        <th>EMISIONES CO2 [tonCO2-eq]</th>
                        <th>INCERTIDUMBRE EMISIONES CO2</th>
                        <th>COLUMNA AUXILIAR</th>
                        <th colspan="2">FACTOR DE EMISIÓN CH4</th>
                        <th>INCERTIDUMBRE FACTOR EMISIÓN CH4</th>
                        <th>EMISIONES CH4 [tonCH4]</th>
                        <th>EMISIONES CH4 [tonCO2-eq]</th>
                        <th>INCERTIDUMBRE EMISIONES CH4</th>
                        <th>COLUMNA AUXILIAR</th>
                        <th colspan="2">FACTOR DE EMISIÓN N2O</th>
                        <th>INCERTIDUMBRE FACTOR EMISIÓN N2O</th>
                        <th>EMISIONES N2O [tonN2O]</th>
                        <th>EMISIONES N2O [tonCO2-eq]</th>
                        <th>INCERTIDUMBRE EMISIONES N2O</th>
                        <th>COLUMNA AUXILIAR</th>
                        <th colspan="2">
                            FACTOR DE EMISIÓN COMPUESTOS FLUORADOS
                        </th>
                        <th>
                            INCERTIDUMBRE FACTOR EMISIÓN COMPUESTOS FLUORADOS
                        </th>
                        <th>EMISIONES Compuestos Fluorados [tonCO2-eq]</th>
                        <th>INCERTIDUMBRE EMISIONES Compuestos Fluorados</th>
                        <th>COLUMNA AUXILIAR</th>
                        <th colspan="2">FACTOR DE EMISIÓN SF6</th>
                        <th>INCERTIDUMBRE FACTOR EMISIÓN SF6</th>
                        <th>EMISIONES SF6 [tonSF6]</th>
                        <th>EMISIONES SF6 [tonCO2-eq]</th>
                        <th>INCERTIDUMBRE EMISIONES SF6</th>
                        <th>COLUMNA AUXILIAR</th>
                        <th colspan="2">FACTOR DE EMISIÓN NF3</th>
                        <th>INCERTIDUMBRE FACTOR EMISIÓN NF3</th>
                        <th>EMISIONES NF3 [tonNF3]</th>
                        <th>EMISIONES NF3 [tonCO2-eq]</th>
                        <th>INCERTIDUMBRE EMISIONES NF3</th>
                        <th>COLUMNA AUXILIAR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(r, i) in fuentes" v-bind:key="i">
                        <td>
                            {{
                                r.tipo_mostrar +
                                " - " +
                                r.fuente_emision_mostrar +
                                " - " +
                                r.fuentetable.nombre
                            }}
                        </td>
                        <td>
                            {{ r.fuentetable.unidad_consumo }}
                        </td>
                        <td v-for="i in 12" v-bind:key="i">
                            {{
                                r.resultado["dato_" + i] != null &&
                                r.resultado["dato_" + i] != ""
                                    ? r.resultado["dato_" + i].toLocaleString()
                                    : r.resultado["dato_" + i]
                            }}
                        </td>
                        <td>{{ r.resultado.total.toLocaleString() }}</td>
                        <td>{{ r.resultado.numero_datos }}</td>
                        <td>{{ r.resultado.promedio.toLocaleString() }}</td>
                        <td>
                            {{
                                r.resultado.desviacion_estandar.toLocaleString()
                            }}
                        </td>
                        <td>{{ r.resultado.factor_t }}</td>
                        <td>
                            {{
                                r.resultado.incertidumbre_sistematica_adicional
                            }}
                        </td>
                        <td>+/-{{ r.resultado.incertidumbre_datos * 100 }}%</td>
                        <td>{{ r.resultado.factor_emision_co2 }}</td>
                        <td>{{ r.resultado.unidad_factor_emision_co2 }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_factor_emision_co2 *
                                100
                            }}%
                        </td>
                        <td>{{ r.resultado.emision_co2_ton }}</td>
                        <td>{{ r.resultado.emision_co2_ton_eq }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_emision_co2 * 100
                            }}%
                        </td>
                        <td>
                            {{
                                r.resultado.columna_auxiliar_co2.toLocaleString()
                            }}
                        </td>
                        <td>{{ r.resultado.factor_emision_ch4 }}</td>
                        <td>{{ r.resultado.unidad_factor_emision_ch4 }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_factor_emision_ch4 *
                                100
                            }}%
                        </td>
                        <td>{{ r.resultado.emision_ch4_ton }}</td>
                        <td>{{ r.resultado.emision_ch4_ton_eq }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_emision_ch4 * 100
                            }}%
                        </td>
                        <td>{{ r.resultado.columna_auxiliar_ch4 }}</td>
                        <td>{{ r.resultado.factor_emision_n2o }}</td>
                        <td>{{ r.resultado.unidad_factor_emision_n2o }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_factor_emision_n2o *
                                100
                            }}%
                        </td>
                        <td>{{ r.resultado.emision_n2o_ton }}</td>
                        <td>{{ r.resultado.emision_n2o_ton_eq }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_emision_n2o * 100
                            }}%
                        </td>
                        <td>{{ r.resultado.columna_auxiliar_n2o }}</td>
                        <td>
                            {{
                                r.resultado.factor_emision_compuestos_fluorados
                            }}
                        </td>
                        <td>
                            {{
                                r.resultado
                                    .unidad_factor_emision_compuestos_fluorados
                            }}
                        </td>
                        <td>
                            +/-{{
                                r.resultado
                                    .incertidumbre_factor_emision_compuestos_fluorados *
                                100
                            }}%
                        </td>
                        <td>
                            {{
                                r.resultado.emision_compuestos_fluorados_ton_eq
                            }}
                        </td>
                        <td>
                            +/-{{
                                r.resultado
                                    .incertidumbre_emision_compuestos_fluorados *
                                100
                            }}%
                        </td>
                        <td>
                            {{
                                r.resultado
                                    .columna_auxiliar_compuestos_fluorados
                            }}
                        </td>
                        <td>{{ r.resultado.factor_emision_sf6 }}</td>
                        <td>{{ r.resultado.unidad_factor_emision_sf6 }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_factor_emision_sf6 *
                                100
                            }}%
                        </td>
                        <td>{{ r.resultado.emision_sf6_ton }}</td>
                        <td>{{ r.resultado.emision_sf6_ton_eq }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_emision_sf6 * 100
                            }}%
                        </td>
                        <td>{{ r.resultado.columna_auxiliar_sf6 }}</td>
                        <td>{{ r.resultado.factor_emision_nf3 }}</td>
                        <td>{{ r.resultado.unidad_factor_emision_nf3 }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_factor_emision_nf3 *
                                100
                            }}%
                        </td>
                        <td>{{ r.resultado.emision_nf3_ton }}</td>
                        <td>{{ r.resultado.emision_nf3_ton_eq }}</td>
                        <td>
                            +/-{{
                                r.resultado.incertidumbre_emision_nf3 * 100
                            }}%
                        </td>
                        <td>{{ r.resultado.columna_auxiliar_nf3 }}</td>
                        <td>{{ r.resultado.huella_carbono }}</td>
                        <td>
                            +/-{{ r.resultado.incertidumbre_fuente * 100 }}%
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import ResultadoFuenteEmision from "../../models/ResultadoFuenteEmision";

export default {
    data() {
        return {
            resultado: [],
        };
    },
    mounted() {
        // this.getResultados();
        this.getFuentesEmision();
    },
    computed: {
        fuentes: function () {
            let fuentes = [];
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    fuentes.push(this.resultado[key][k]);
                });
            });

            return fuentes;
        },
    },
    methods: {
        // async getResultados() {
        //     this.resultado = await ResultadoFuenteEmision.where(
        //         "informacion_empresa_id",
        //         1
        //     ).get();
        // },
        async getFuentesEmision() {
            //se debe enviar empresa id y sede id, por el momento se utiliza 1 y 1
            this.$root.mostrarCargando("consultado información");

            axios
                .get("api/getFuentesEmision/1/1")
                .then((response) => {
                    this.resultado = response.data;
                })
                .catch((error) => {});

            Swal.close();
        },
    },
};
</script>
