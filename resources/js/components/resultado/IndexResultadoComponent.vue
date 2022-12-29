<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Resultados</h2>
            </div>
        </div>

        <div
            v-for="(array, ia) in array_tablas"
            v-bind:key="ia"
            class="col-lg-12"
        >
            <div v-for="(el, ei) in array" v-bind:key="ei">
                <br />
                <p>
                    <b>{{ ei }}</b>
                </p>
                <table
                    class="table table-fit table-sm table-bordered"
                    :id="'tabla-resultados-' + ia"
                >
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
                            <th>DATO 1</th>
                            <th>DATO 2</th>
                            <th>DATO 3</th>
                            <th>DATO 4</th>
                            <th>DATO 5</th>
                            <th>DATO 6</th>
                            <th>DATO 7</th>
                            <th>DATO 8</th>
                            <th>DATO 9</th>
                            <th>DATO 10</th>
                            <th>DATO 11</th>
                            <th>DATO 12</th>
                            <th>TOTAL</th>
                            <th>No. DATOS</th>

                            <th>PROMEDIO</th>
                            <th>DESVIACION ESTÁNDAR</th>
                            <th>FACTOR T</th>
                            <th>INCERTIDUMBRE SISTEMATICA ADICIONAL</th>
                            <th>INCERTIDUMBRE DATOS</th>

                            <th>FACTOR DE EMISIÓN CO2</th>
                            <th>UNIDAD</th>
                            <!-- <th colspan="2">FACTOR DE EMISIÓN CO2</th> -->
                            <th>INCERTIDUMBRE FACTOR EMISIÓN CO2</th>
                            <th>EMISIONES CO2 [tonCO2]</th>
                            <th>EMISIONES CO2 [tonCO2-eq]</th>
                            <th>INCERTIDUMBRE EMISIONES CO2</th>
                            <th>COLUMNA AUXILIAR</th>

                            <th>FACTOR DE EMISIÓN CH4</th>
                            <th>UNIDADH4</th>
                            <!-- <th colspan="2">FACTOR DE EMISIÓN CH4</th> -->
                            <th>INCERTIDUMBRE FACTOR EMISIÓN CH4</th>
                            <th>EMISIONES CH4 [tonCH4]</th>
                            <th>EMISIONES CH4 [tonCO2-eq]</th>
                            <th>INCERTIDUMBRE EMISIONES CH4</th>
                            <th>COLUMNA AUXILIAR</th>

                            <th>FACTOR DE EMISIÓN N2O</th>
                            <th>UNIDAD</th>
                            <!-- <th colspan="2">FACTOR DE EMISIÓN N2O</th> -->
                            <th>INCERTIDUMBRE FACTOR EMISIÓN N2O</th>
                            <th>EMISIONES N2O [tonN2O]</th>
                            <th>EMISIONES N2O [tonCO2-eq]</th>
                            <th>INCERTIDUMBRE EMISIONES N2O</th>
                            <th>COLUMNA AUXILIAR</th>

                            <th>FACTOR DE EMISIÓN COMPUESTOS FLUORADOS</th>
                            <th>UNIDAD</th>
                            <!-- <th colspan="2">
                                FACTOR DE EMISIÓN COMPUESTOS FLUORADOS
                            </th> -->
                            <th>
                                INCERTIDUMBRE FACTOR EMISIÓN COMPUESTOS
                                FLUORADOS
                            </th>
                            <th>EMISIONES Compuestos Fluorados [tonCO2-eq]</th>
                            <th>
                                INCERTIDUMBRE EMISIONES Compuestos Fluorados
                            </th>
                            <th>COLUMNA AUXILIAR</th>

                            <th>FACTOR DE EMISIÓN SF6</th>
                            <th>UNIDAD</th>
                            <!-- <th colspan="2">FACTOR DE EMISIÓN SF6</th> -->
                            <th>INCERTIDUMBRE FACTOR EMISIÓN SF6</th>
                            <th>EMISIONES SF6 [tonSF6]</th>
                            <th>EMISIONES SF6 [tonCO2-eq]</th>
                            <th>INCERTIDUMBRE EMISIONES SF6</th>
                            <th>COLUMNA AUXILIAR</th>

                            <th>FACTOR DE EMISIÓN NF3</th>
                            <th>UNIDAD</th>
                            <!-- <th colspan="2">FACTOR DE EMISIÓN NF3</th> -->
                            <th>INCERTIDUMBRE FACTOR EMISIÓN NF3</th>
                            <th>EMISIONES NF3 [tonNF3]</th>
                            <th>EMISIONES NF3 [tonCO2-eq]</th>
                            <th>INCERTIDUMBRE EMISIONES NF3</th>
                            <th>COLUMNA AUXILIAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="a in el">
                            <tr :key="a.id" class="table-active">
                                <td>
                                    {{ a[0] }}
                                </td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                                <td style="display;none"></td>
                            </tr>
                            <tr
                                :key="a.id"
                                v-for="(f, fi) in fuentes(a[1], a[2])"
                                v-bind:key="fi"
                            >
                                <!-- {{ f.tipo_mostrar }} -->
                                <td>
                                    {{ f.fuente_emision_mostrar }}
                                    <br />
                                    {{
                                        f.fuentetable.nombre.length > 50
                                            ? f.fuentetable.nombre.substring(
                                                  0,
                                                  50
                                              )
                                            : f.fuentetable.nombre
                                    }}
                                </td>
                                <td>{{ f.fuentetable.unidad_consumo }}</td>
                                <td v-for="(i, index) in 12" v-bind:key="index">
                                    {{
                                        f.resultado["dato_" + i] != null &&
                                        f.resultado["dato_" + i] != ""
                                            ? f.resultado[
                                                  "dato_" + i
                                              ].toLocaleString()
                                            : f.resultado["dato_" + i]
                                    }}
                                </td>
                                <td>
                                    {{ f.resultado.total.toLocaleString() }}
                                </td>
                                <td>{{ f.resultado.numero_datos }}</td>
                                <td>
                                    {{ f.resultado.promedio.toLocaleString() }}
                                </td>
                                <td>
                                    {{
                                        f.resultado.desviacion_estandar.toLocaleString()
                                    }}
                                </td>
                                <td>{{ f.resultado.factor_t }}</td>
                                <td>
                                    {{
                                        f.resultado
                                            .incertidumbre_sistematica_adicional
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado.incertidumbre_datos * 100
                                    }}%
                                </td>

                                <td>{{ f.resultado.factor_emision_co2 }}</td>
                                <td>
                                    {{ f.resultado.unidad_factor_emision_co2 }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado
                                            .incertidumbre_factor_emision_co2 *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.emision_co2_ton }}</td>
                                <td>{{ f.resultado.emision_co2_ton_eq }}</td>
                                <td>
                                    +/-{{
                                        f.resultado.incertidumbre_emision_co2 *
                                        100
                                    }}%
                                </td>
                                <td>
                                    {{
                                        f.resultado.columna_auxiliar_co2.toLocaleString()
                                    }}
                                </td>

                                <td>{{ f.resultado.factor_emision_ch4 }}</td>
                                <td>
                                    {{ f.resultado.unidad_factor_emision_ch4 }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado
                                            .incertidumbre_factor_emision_ch4 *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.emision_ch4_ton }}</td>
                                <td>{{ f.resultado.emision_ch4_ton_eq }}</td>
                                <td>
                                    +/-{{
                                        f.resultado.incertidumbre_emision_ch4 *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.columna_auxiliar_ch4 }}</td>

                                <td>{{ f.resultado.factor_emision_n2o }}</td>
                                <td>
                                    {{ f.resultado.unidad_factor_emision_n2o }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado
                                            .incertidumbre_factor_emision_n2o *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.emision_n2o_ton }}</td>
                                <td>{{ f.resultado.emision_n2o_ton_eq }}</td>
                                <td>
                                    +/-{{
                                        f.resultado.incertidumbre_emision_n2o *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.columna_auxiliar_n2o }}</td>

                                <td>
                                    {{
                                        f.resultado
                                            .factor_emision_compuestos_fluorados
                                    }}
                                </td>
                                <td>
                                    {{
                                        f.resultado
                                            .unidad_factor_emision_compuestos_fluorados
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado
                                            .incertidumbre_factor_emision_compuestos_fluorados *
                                        100
                                    }}%
                                </td>
                                <td>
                                    {{
                                        f.resultado
                                            .emision_compuestos_fluorados_ton_eq
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado
                                            .incertidumbre_emision_compuestos_fluorados *
                                        100
                                    }}%
                                </td>
                                <td>
                                    {{
                                        f.resultado
                                            .columna_auxiliar_compuestos_fluorados
                                    }}
                                </td>

                                <td>{{ f.resultado.factor_emision_sf6 }}</td>
                                <td>
                                    {{ f.resultado.unidad_factor_emision_sf6 }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado
                                            .incertidumbre_factor_emision_sf6 *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.emision_sf6_ton }}</td>
                                <td>{{ f.resultado.emision_sf6_ton_eq }}</td>
                                <td>
                                    +/-{{
                                        f.resultado.incertidumbre_emision_sf6 *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.columna_auxiliar_sf6 }}</td>

                                <td>{{ f.resultado.factor_emision_nf3 }}</td>
                                <td>
                                    {{ f.resultado.unidad_factor_emision_nf3 }}
                                </td>
                                <td>
                                    +/-{{
                                        f.resultado
                                            .incertidumbre_factor_emision_nf3 *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.emision_nf3_ton }}</td>
                                <td>{{ f.resultado.emision_nf3_ton_eq }}</td>
                                <td>
                                    +/-{{
                                        f.resultado.incertidumbre_emision_nf3 *
                                        100
                                    }}%
                                </td>
                                <td>{{ f.resultado.columna_auxiliar_nf3 }}</td>

                                <td>{{ f.resultado.huella_carbono }}</td>
                                <td>
                                    +/-{{
                                        f.resultado.incertidumbre_fuente * 100
                                    }}%
                                </td>
                            </tr>
                            <tr
                                class="table-active"
                                style="border-bottom: 1px solid black"
                                :key="a.id"
                            >
                                <td>
                                    <b>
                                        {{ a[3] }}
                                    </b>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                    {{
                                        subTotalEmisionesTonEq(
                                            a[1],
                                            a[2],
                                            "co2"
                                        )
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        subTotalIncertidumbreEmisiones(
                                            a[1],
                                            a[2],
                                            "co2"
                                        )
                                    }}%
                                </td>
                                <td>
                                    {{
                                        subTotalColumnaAuxiliar(
                                            a[1],
                                            a[2],
                                            "co2"
                                        )
                                    }}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                    {{
                                        subTotalEmisionesTonEq(
                                            a[1],
                                            a[2],
                                            "ch4"
                                        )
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        subTotalIncertidumbreEmisiones(
                                            a[1],
                                            a[2],
                                            "ch4"
                                        )
                                    }}%
                                </td>
                                <td>
                                    {{
                                        subTotalColumnaAuxiliar(
                                            a[1],
                                            a[2],
                                            "ch4"
                                        )
                                    }}
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                    {{
                                        subTotalEmisionesTonEq(
                                            a[1],
                                            a[2],
                                            "n2o"
                                        )
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        subTotalIncertidumbreEmisiones(
                                            a[1],
                                            a[2],
                                            "n2o"
                                        )
                                    }}%
                                </td>
                                <td>
                                    {{
                                        subTotalColumnaAuxiliar(
                                            a[1],
                                            a[2],
                                            "n2o"
                                        )
                                    }}
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                    {{
                                        subTotalEmisionesTonEq(
                                            a[1],
                                            a[2],
                                            "compuestos_fluorados"
                                        )
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        subTotalIncertidumbreEmisiones(
                                            a[1],
                                            a[2],
                                            "compuestos_fluorados"
                                        )
                                    }}%
                                </td>
                                <td>
                                    {{
                                        subTotalColumnaAuxiliar(
                                            a[1],
                                            a[2],
                                            "compuestos_fluorados"
                                        )
                                    }}
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                    {{
                                        subTotalEmisionesTonEq(
                                            a[1],
                                            a[2],
                                            "sf6"
                                        )
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        subTotalIncertidumbreEmisiones(
                                            a[1],
                                            a[2],
                                            "sf6"
                                        )
                                    }}%
                                </td>
                                <td>
                                    {{
                                        subTotalColumnaAuxiliar(
                                            a[1],
                                            a[2],
                                            "sf6"
                                        )
                                    }}
                                </td>

                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>
                                    {{
                                        subTotalEmisionesTonEq(
                                            a[1],
                                            a[2],
                                            "nf3"
                                        )
                                    }}
                                </td>
                                <td>
                                    +/-{{
                                        subTotalIncertidumbreEmisiones(
                                            a[1],
                                            a[2],
                                            "nf3"
                                        )
                                    }}%
                                </td>
                                <td>
                                    {{
                                        subTotalColumnaAuxiliar(
                                            a[1],
                                            a[2],
                                            "nf3"
                                        )
                                    }}
                                </td>

                                <td>
                                    {{ SubTotalHuellaCarbono(a[1], a[2]) }}
                                </td>
                                <td>
                                    +/-{{
                                        subTotalIncertidumbreFuente(a[1], a[2])
                                    }}%
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import ResultadoFuenteEmision from "../../models/ResultadoFuenteEmision";

export default {
    data() {
        return {
            resultado: [],

            array_tablas: [
                {
                    "CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI": [
                        [
                            "FUENTES MÓVILES",
                            "fuentes_moviles",
                            ["Combustible_liquido", "Combustible_gaseoso"],
                            "SUBTOTAL COMBUSTIBLES FUENTES MÓVILES",
                        ],
                        [
                            "FUENTES MÓVILES",
                            "fuentes_moviles",
                            ["Refrigerante", "Extintor", "Lubricante"],
                            "SUBTOTAL OTROS FUENTES MÓVILES",
                        ],
                        [
                            "FUENTES FIJAS",
                            "fuentes_fijas",
                            [
                                "Combustible_solido",
                                "Combustible_liquido",
                                "Combustible_gaseoso",
                            ],
                            "SUBTOTAL COMBUSTIBLES FUENTES FIJAS",
                        ],
                        [
                            "FUENTES FIJAS",
                            "fuentes_fijas",
                            [
                                "Refrigerante",
                                "Extintor",
                                "Lubricante",
                                "Fuga",
                                "Aislamiento",
                            ],
                            "SUBTOTAL OTROS FUENTES FIJAS",
                        ],
                        [
                            "EMISIONES DE PROCESO",
                            "emisiones",
                            [
                                "Embalse",
                                "Mineria",
                                "Industrial",
                                "Fermentacion",
                                "Estiercol",
                                "Cal",
                                "Residuo_organizacional",
                                "Residuo_agropecuario",
                                "Fertilizante",
                            ],
                            "SUBTOTAL EMISIONES DE PROCESO",
                        ],
                    ],
                },
                {
                    "CATEGORIA 2 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR ENERGÍA IMPORTADA":
                        [
                            [
                                "ELECTRICIDAD IMPORTADA",
                                "energias",
                                ["Energia_electrica"],
                                "SUBTOTAL ELECTRICIDAD IMPORTADA",
                            ],
                            [
                                "ENERGÍA IMPORTADA",
                                "energias",
                                [
                                    "Combustible_solido",
                                    "Combustible_liquido",
                                    "Combustible_gaseoso",
                                ],
                                "SUBTOTAL ENERGÍA IMPORTADA",
                            ],
                        ],
                },
                {
                    "CATEGORIA 3 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR EL TRANSPORTE":
                        [
                            [
                                "FUENTES MÓVILES",
                                "transportes",
                                ["Combustible_liquido", "Combustible_gaseoso"],
                                "SUBTOTAL COMBUSTIBLES",
                            ],
                            [
                                "FUENTES MÓVILES",
                                "transportes",
                                ["Refrigerante", "Extintor", "Lubricante"],
                                "SUBTOTAL OTROS",
                            ],
                            [
                                "TRANSPORTE CARGA Y PASAJEROS",
                                "transportes",
                                ["Transporte"],
                                "SUBTOTAL VIAJES AÉREOS Y TRANSPORTE DE CARGA",
                            ],
                        ],
                },
                {
                    "CATEGORIA 4 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR PRODUCTOS QUE UTILIZA LA ORGANIZACIÓN":
                        [
                            [
                                "BIENES Y PRODUCTOS",
                                "productos",
                                [
                                    "Refrigerante",
                                    "Extintor",
                                    "Lubricante",
                                    "Aislamiento",
                                ],
                                "SUBTOTAL PRODUCTOS",
                            ],
                            [
                                "BIENES Y PRODUCTOS",
                                "productos",
                                ["Equipo"],
                                "SUBTOTAL BIENES DE CAPITAL",
                            ],
                            [
                                "BIENES Y PRODUCTOS",
                                "productos",
                                ["Materia_prima"],
                                "SUBTOTAL MATERIAS PRIMAS",
                            ],
                            [
                                "SERVICIOS",
                                "productos",
                                ["Residuo"],
                                "SUBTOTAL SERVICIOS",
                            ],
                        ],
                },
            ],
        };
    },
    mounted() {
        this.getFuentesEmision();
    },
    computed: {
        // fuentes: function () {
        //     let fuentes = [];
        //     Object.keys(this.resultado).forEach((key) => {
        //         Object.keys(this.resultado[key]).forEach((k) => {
        //             if (
        //                 this.resultado[key][k]["tipo"] == "fuentes_moviles" &&
        //                 (this.resultado[key][k]["fuente_emision"] ==
        //                     "Combustible_liquido" ||
        //                     this.resultado[key][k]["fuente_emision"] ==
        //                         "Combustible_gaseoso")
        //             ) {
        //                 fuentes.push(this.resultado[key][k]);
        //             }
        //             // fuentes.push(this.resultado[key][k]);
        //         });
        //     });
        //     return fuentes;
        // },
        totalIncertidumbre() {
            let total = 0;
            let total_huella = 0;
            let suma = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    suma += Math.pow(
                        this.resultado[key][k]["resultado"]["huella_carbono"] *
                            this.resultado[key][k]["resultado"][
                                "incertidumbre_fuente"
                            ],
                        2
                    );

                    total_huella +=
                        this.resultado[key][k]["resultado"]["huella_carbono"];
                });
            });
            total = (Math.sqrt(suma) / total_huella) * 100;
            return total;
        },
        totalHuella() {
            let total = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    total +=
                        this.resultado[key][k]["resultado"]["huella_carbono"];
                });
            });
            return total;
        },
    },
    methods: {
        fuentes(tipo, array_fuente_emision) {
            let fuentes = [];
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        this.resultado[key][k]["tipo"] == tipo &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        fuentes.push(this.resultado[key][k]);
                    }
                });
            });
            return fuentes;
        },
        subTotalEmisionesTonEq(tipo, array_fuente_emision, emision) {
            let suma_incertidumbre = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        this.resultado[key][k]["tipo"] == tipo &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma_incertidumbre +=
                            this.resultado[key][k]["resultado"][
                                "emision_" + emision + "_ton_eq"
                            ];
                    }
                });
            });
            return suma_incertidumbre;
        },
        subTotalIncertidumbreEmisiones(tipo, array_fuente_emision, emision) {
            let total = 0;
            let suma_incertidumbre = 0;
            let suma_emisiones = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        this.resultado[key][k]["tipo"] == tipo &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma_emisiones +=
                            this.resultado[key][k]["resultado"][
                                "emision_" + emision + "_ton_eq"
                            ];
                        suma_incertidumbre +=
                            this.resultado[key][k]["resultado"][
                                "columna_auxiliar_" + emision
                            ];
                    }
                });
            });
            if (suma_emisiones > 0) {
                total = (Math.sqrt(suma_incertidumbre) / suma_emisiones) * 100;
            }
            return total;
        },
        subTotalColumnaAuxiliar(tipo, array_fuente_emision, emision) {
            let total = 0;
            let suma_emisiones = 0;
            let suma_incertidumbre = 0;

            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        this.resultado[key][k]["tipo"] == tipo &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma_emisiones +=
                            this.resultado[key][k]["resultado"][
                                "emision_" + emision + "_ton_eq"
                            ];

                        suma_incertidumbre +=
                            this.resultado[key][k]["resultado"][
                                "columna_auxiliar_" + emision
                            ];
                    }
                });
            });

            if (suma_emisiones > 0) {
                total = Math.pow(
                    suma_emisiones *
                        (Math.sqrt(suma_incertidumbre) / suma_emisiones),
                    2
                );
            }

            return total;
        },
        SubTotalHuellaCarbono(tipo, array_fuente_emision) {
            let total = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        this.resultado[key][k]["tipo"] == tipo &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        total +=
                            this.resultado[key][k]["resultado"][
                                "huella_carbono"
                            ];
                    }
                });
            });
            return total;
        },
        subTotalIncertidumbreFuente(tipo, array_fuente_emision) {
            let total = 0;
            let total_huella = 0;
            let suma = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        this.resultado[key][k]["tipo"] == tipo &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma += Math.pow(
                            this.resultado[key][k]["resultado"][
                                "huella_carbono"
                            ] *
                                this.resultado[key][k]["resultado"][
                                    "incertidumbre_fuente"
                                ],
                            2
                        );

                        total_huella +=
                            this.resultado[key][k]["resultado"][
                                "huella_carbono"
                            ];
                    }
                });
            });
            if (total_huella > 0) {
                total = (Math.sqrt(suma) / total_huella) * 100;
            }
            return total;
        },
        async getFuentesEmision() {
            //se debe enviar empresa id y sede id, por el momento se utiliza 1 y 1

            this.$root.mostrarCargando("consultado información");

            axios
                .get("api/getFuentesEmision/1/1")
                .then((response) => {
                    this.resultado = response.data;
                    setTimeout(() => {
                        for (let i = 0; i < 5; i++) {
                            $("#tabla-resultados-" + i)
                                .DataTable()
                                .destroy();
                            this.$tablaResultadosEmision(
                                "#tabla-resultados-" + i
                            );
                        }
                        Swal.close();
                    }, 2000);
                })
                .catch((error) => {});
        },
    },
};
</script>
<style>
table.table {
    width: auto;
}
</style>
