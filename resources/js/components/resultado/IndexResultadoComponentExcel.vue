<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Resultados</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2">
                <form @submit.prevent="getFuentesEmision">
                    <div class="mb-3" v-if="user.rol_id != 2">
                        <Multiselect
                            v-model="empresa"
                            :options="options_empresa"
                            valueProp="id"
                            label="nombre"
                            placeholder="Empresa"
                            required
                            @input="getOptionsSede()"
                        />
                    </div>
                    <div class="mb-3">
                        <Multiselect
                            v-model="sede"
                            :options="options_sede"
                            valueProp="id"
                            label="nombre"
                            placeholder="Sede"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <Multiselect
                            v-model="ar"
                            :options="options_ar"
                            placeholder="Reporte (AR5 / AR6)"
                            required
                        />
                    </div>

                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary">
                            Consultar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row" v-if="mostrar_tablas">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link active"
                        id="indertidumbre-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#indertidumbre"
                        type="button"
                        role="tab"
                        aria-controls="indertidumbre"
                        aria-selected="true"
                    >
                        CORPORATIVA
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button
                        class="nav-link"
                        id="biogenico-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#biogenico"
                        type="button"
                        role="tab"
                        aria-controls="biogenico"
                        aria-selected="false"
                    >
                        BIOGÉNICO
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div
                    class="tab-pane fade show active"
                    id="indertidumbre"
                    role="tabpanel"
                    aria-labelledby="indertidumbre-tab"
                >
                    <br />
                    <div
                        v-for="(array, ia) in array_tablas"
                        v-bind:key="ia"
                        class="col-lg-12"
                    >
                        <div v-for="(el, ei) in array" v-bind:key="ei">
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
                                        <th colspan="6">
                                            EMISIONES COMPUESTOS FLUORADOS
                                        </th>
                                        <th colspan="7">EMISIONES SF6</th>
                                        <th colspan="7">EMISIONES NF3</th>
                                        <th rowspan="2">
                                            HUELLA DE CARBONO [tonCO2-eq]
                                        </th>
                                        <th rowspan="2">
                                            INCERTIDUMBRE DE LA FUENTE
                                        </th>
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
                                        <th>
                                            INCERTIDUMBRE SISTEMATICA ADICIONAL
                                        </th>
                                        <th>INCERTIDUMBRE DATOS</th>

                                        <th>FACTOR DE EMISIÓN CO2</th>
                                        <th>UNIDAD</th>
                                        <!-- <th colspan="2">FACTOR DE EMISIÓN CO2</th> -->
                                        <th>
                                            INCERTIDUMBRE FACTOR EMISIÓN CO2
                                        </th>
                                        <th>EMISIONES CO2 [tonCO2]</th>
                                        <th>EMISIONES CO2 [tonCO2-eq]</th>
                                        <th>INCERTIDUMBRE EMISIONES CO2</th>
                                        <th>COLUMNA AUXILIAR</th>

                                        <th>FACTOR DE EMISIÓN CH4</th>
                                        <th>UNIDADH4</th>
                                        <!-- <th colspan="2">FACTOR DE EMISIÓN CH4</th> -->
                                        <th>
                                            INCERTIDUMBRE FACTOR EMISIÓN CH4
                                        </th>
                                        <th>EMISIONES CH4 [tonCH4]</th>
                                        <th>EMISIONES CH4 [tonCO2-eq]</th>
                                        <th>INCERTIDUMBRE EMISIONES CH4</th>
                                        <th>COLUMNA AUXILIAR</th>

                                        <th>FACTOR DE EMISIÓN N2O</th>
                                        <th>UNIDAD</th>
                                        <!-- <th colspan="2">FACTOR DE EMISIÓN N2O</th> -->
                                        <th>
                                            INCERTIDUMBRE FACTOR EMISIÓN N2O
                                        </th>
                                        <th>EMISIONES N2O [tonN2O]</th>
                                        <th>EMISIONES N2O [tonCO2-eq]</th>
                                        <th>INCERTIDUMBRE EMISIONES N2O</th>
                                        <th>COLUMNA AUXILIAR</th>

                                        <th>
                                            FACTOR DE EMISIÓN COMPUESTOS
                                            FLUORADOS
                                        </th>
                                        <th>UNIDAD</th>
                                        <!-- <th colspan="2">
                                FACTOR DE EMISIÓN COMPUESTOS FLUORADOS
                            </th> -->
                                        <th>
                                            INCERTIDUMBRE FACTOR EMISIÓN
                                            COMPUESTOS FLUORADOS
                                        </th>
                                        <th>
                                            EMISIONES Compuestos Fluorados
                                            [tonCO2-eq]
                                        </th>
                                        <th>
                                            INCERTIDUMBRE EMISIONES Compuestos
                                            Fluorados
                                        </th>
                                        <th>COLUMNA AUXILIAR</th>

                                        <th>FACTOR DE EMISIÓN SF6</th>
                                        <th>UNIDAD</th>
                                        <!-- <th colspan="2">FACTOR DE EMISIÓN SF6</th> -->
                                        <th>
                                            INCERTIDUMBRE FACTOR EMISIÓN SF6
                                        </th>
                                        <th>EMISIONES SF6 [tonSF6]</th>
                                        <th>EMISIONES SF6 [tonCO2-eq]</th>
                                        <th>INCERTIDUMBRE EMISIONES SF6</th>
                                        <th>COLUMNA AUXILIAR</th>

                                        <th>FACTOR DE EMISIÓN NF3</th>
                                        <th>UNIDAD</th>
                                        <!-- <th colspan="2">FACTOR DE EMISIÓN NF3</th> -->
                                        <th>
                                            INCERTIDUMBRE FACTOR EMISIÓN NF3
                                        </th>
                                        <th>EMISIONES NF3 [tonNF3]</th>
                                        <th>EMISIONES NF3 [tonCO2-eq]</th>
                                        <th>INCERTIDUMBRE EMISIONES NF3</th>
                                        <th>COLUMNA AUXILIAR</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="a in el">
                                        <tr :key="a.id" class="table-active">
                                            <td>{{ a[0] }}</td>
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
                                            v-for="(f, fi) in fuentes(
                                                a[0],
                                                a[1],
                                                a[2],
                                                0
                                            )"
                                            v-bind:key="fi"
                                        >
                                            <!-- {{ f.tipo_mostrar }} -->
                                            <td>
                                                {{ f.fuente_emision_mostrar }}
                                                <br />
                                                {{
                                                    f.fuentetable.nombre
                                                        .length > 50
                                                        ? f.fuentetable.nombre.substring(
                                                              0,
                                                              50
                                                          )
                                                        : f.fuentetable.nombre
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.fuentetable.unidad_consumo
                                                }}
                                            </td>
                                            <td
                                                v-for="(i, index) in 12"
                                                v-bind:key="index"
                                            >
                                                {{
                                                    f.resultado["dato_" + i] !=
                                                        null &&
                                                    f.resultado["dato_" + i] !=
                                                        ""
                                                        ? f.resultado[
                                                              "dato_" + i
                                                          ].toLocaleString()
                                                        : f.resultado[
                                                              "dato_" + i
                                                          ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado.total.toLocaleString()
                                                }}
                                            </td>
                                            <td>
                                                {{ f.resultado.numero_datos }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado.promedio.toLocaleString()
                                                }}
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
                                                    f.resultado
                                                        .incertidumbre_datos *
                                                    100
                                                }}%
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "factor_emision_co2" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "unidad_factor_emision_co2" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_factor_emision_co2" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_co2_ton" + ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_co2_ton_eq" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_emision_co2" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "columna_auxiliar_co2" +
                                                            ar
                                                    ].toLocaleString()
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "factor_emision_ch4" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "unidad_factor_emision_ch4" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_factor_emision_ch4" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_ch4_ton" + ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_ch4_ton_eq" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_emision_ch4" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "columna_auxiliar_ch4" +
                                                            ar
                                                    ]
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "factor_emision_n2o" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "unidad_factor_emision_n2o" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_factor_emision_n2o" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_n2o_ton" + ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_n2o_ton_eq" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_emision_n2o" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "columna_auxiliar_n2o" +
                                                            ar
                                                    ]
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "factor_emision_compuestos_fluorados" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "unidad_factor_emision_compuestos_fluorados" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_factor_emision_compuestos_fluorados" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_compuestos_fluorados_ton_eq" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_emision_compuestos_fluorados" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "columna_auxiliar_compuestos_fluorados" +
                                                            ar
                                                    ]
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "factor_emision_sf6" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "unidad_factor_emision_sf6" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_factor_emision_sf6" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_sf6_ton" + ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_sf6_ton_eq" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_emision_sf6" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "columna_auxiliar_sf6" +
                                                            ar
                                                    ]
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "factor_emision_nf3" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "unidad_factor_emision_nf3" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_factor_emision_nf3" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_nf3_ton" + ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_nf3_ton_eq" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_emision_nf3" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "columna_auxiliar_nf3" +
                                                            ar
                                                    ]
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "huella_carbono" + ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_fuente" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                        </tr>
                                        <tr
                                            class="table-active"
                                            style="
                                                border-bottom: 1px solid black;
                                            "
                                            :key="a.id"
                                        >
                                            <td>
                                                <b> {{ a[3] }} </b>
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
                                                    totalEmisionesTonEq(
                                                        a[1],
                                                        a[2],
                                                        "co2"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreEmisiones(
                                                        a[1],
                                                        a[2],
                                                        "co2"
                                                    )
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    totalColumnaAuxiliar(
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
                                                    totalEmisionesTonEq(
                                                        a[1],
                                                        a[2],
                                                        "ch4"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreEmisiones(
                                                        a[1],
                                                        a[2],
                                                        "ch4"
                                                    )
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    totalColumnaAuxiliar(
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
                                                    totalEmisionesTonEq(
                                                        a[1],
                                                        a[2],
                                                        "n2o"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreEmisiones(
                                                        a[1],
                                                        a[2],
                                                        "n2o"
                                                    )
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    totalColumnaAuxiliar(
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
                                                    totalEmisionesTonEq(
                                                        a[1],
                                                        a[2],
                                                        "compuestos_fluorados"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreEmisiones(
                                                        a[1],
                                                        a[2],
                                                        "compuestos_fluorados"
                                                    )
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    totalColumnaAuxiliar(
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
                                                    totalEmisionesTonEq(
                                                        a[1],
                                                        a[2],
                                                        "sf6"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreEmisiones(
                                                        a[1],
                                                        a[2],
                                                        "sf6"
                                                    )
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    totalColumnaAuxiliar(
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
                                                    totalEmisionesTonEq(
                                                        a[1],
                                                        a[2],
                                                        "nf3"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreEmisiones(
                                                        a[1],
                                                        a[2],
                                                        "nf3"
                                                    )
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    totalColumnaAuxiliar(
                                                        a[1],
                                                        a[2],
                                                        "nf3"
                                                    )
                                                }}
                                            </td>

                                            <td>
                                                {{
                                                    totalHuellaCarbono(
                                                        a[1],
                                                        a[2]
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreFuente(
                                                        a[1],
                                                        a[2]
                                                    )
                                                }}%
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <br />
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    id="biogenico"
                    role="tabpanel"
                    aria-labelledby="biogenico-tab"
                >
                    <br />
                    <div
                        v-for="(array, ia) in array_biogenicos"
                        v-bind:key="ia"
                        class="col-lg-12"
                    >
                        <div v-for="(el, ei) in array" v-bind:key="ei">
                            <p>
                                <b>{{ ei }}</b>
                            </p>
                            <table
                                class="table table-fit table-sm table-bordered"
                                :id="'tabla-biogenicos-' + ia"
                            >
                                <thead>
                                    <tr>
                                        <th colspan="16">CONSUMO</th>
                                        <th colspan="5">INCERTIDUMBRE DATOS</th>
                                        <th colspan="7">EMISIONES CO2</th>
                                        <th rowspan="2">
                                            HUELLA DE CARBONO [tonCO2-eq]
                                        </th>
                                        <th rowspan="2">
                                            INCERTIDUMBRE DE LA FUENTE
                                        </th>
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
                                        <th>
                                            INCERTIDUMBRE SISTEMATICA ADICIONAL
                                        </th>
                                        <th>INCERTIDUMBRE DATOS</th>

                                        <th>FACTOR DE EMISIÓN CO2</th>
                                        <th>UNIDAD</th>
                                        <th>
                                            INCERTIDUMBRE FACTOR EMISIÓN CO2
                                        </th>
                                        <th>EMISIONES CO2 [tonCO2]</th>
                                        <th>EMISIONES CO2 [tonCO2-eq]</th>
                                        <th>INCERTIDUMBRE EMISIONES CO2</th>
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
                                        </tr>
                                        <tr
                                            :key="a.id"
                                            v-for="(f, fi) in fuentes(
                                                a[0],
                                                a[1],
                                                a[2],
                                                1
                                            )"
                                            v-bind:key="fi"
                                        >
                                            <!-- {{ f.tipo_mostrar }} -->
                                            <td>
                                                {{ f.fuente_emision_mostrar }}
                                                <br />
                                                {{
                                                    f.fuentetable.nombre
                                                        .length > 50
                                                        ? f.fuentetable.nombre.substring(
                                                              0,
                                                              50
                                                          )
                                                        : f.fuentetable.nombre
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.fuentetable.unidad_consumo
                                                }}
                                            </td>
                                            <td
                                                v-for="(i, index) in 12"
                                                v-bind:key="index"
                                            >
                                                {{
                                                    f.resultado["dato_" + i] !=
                                                        null &&
                                                    f.resultado["dato_" + i] !=
                                                        ""
                                                        ? f.resultado[
                                                              "dato_" + i
                                                          ].toLocaleString()
                                                        : f.resultado[
                                                              "dato_" + i
                                                          ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado.total.toLocaleString()
                                                }}
                                            </td>
                                            <td>
                                                {{ f.resultado.numero_datos }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado.promedio.toLocaleString()
                                                }}
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
                                                    f.resultado
                                                        .incertidumbre_datos *
                                                    100
                                                }}%
                                            </td>

                                            <td>
                                                {{
                                                    f.resultado[
                                                        "factor_emision_co2_biogenico" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "unidad_factor_emision_co2_biogenico" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_factor_emision_co2_biogenico" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_co2_ton_biogenico" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "emision_co2_ton_eq_biogenico" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_emision_co2_biogenico" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "columna_auxiliar_co2_biogenico" +
                                                            ar
                                                    ].toLocaleString()
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    f.resultado[
                                                        "huella_carbono_biogenico" +
                                                            ar
                                                    ]
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    f.resultado[
                                                        "incertidumbre_fuente_biogenico" +
                                                            ar
                                                    ] * 100
                                                }}%
                                            </td>
                                        </tr>
                                        <tr
                                            class="table-active"
                                            style="
                                                border-bottom: 1px solid black;
                                            "
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
                                                    totalEmisionesTonEq(
                                                        a[1],
                                                        a[2],
                                                        "co2",
                                                        "_biogenico"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreEmisiones(
                                                        a[1],
                                                        a[2],
                                                        "co2",
                                                        "_biogenico"
                                                    )
                                                }}%
                                            </td>
                                            <td>
                                                {{
                                                    totalColumnaAuxiliar(
                                                        a[1],
                                                        a[2],
                                                        "co2",
                                                        "_biogenico"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    totalHuellaCarbono(
                                                        a[1],
                                                        a[2],
                                                        "_biogenico"
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                +/-{{
                                                    totalIncertidumbreFuente(
                                                        a[1],
                                                        a[2],
                                                        "_biogenico"
                                                    )
                                                }}%
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ResultadoFuenteEmision from "../../models/ResultadoFuenteEmision";
import User from "../../models/User";
import Empresa from "../../models/Empresa";
import EmpresaSede from "../../models/EmpresaSede";
import InformacionEmpresa from "../../models/InformacionEmpresa";

export default {
    data() {
        return {
            empresa: "",
            sede: "",
            ar: "",
            options_empresa: [],
            options_sede: [],
            options_ar: [
                { value: "_ar5", label: "AR5" },
                { value: "_ar6", label: "AR6" },
            ],
            mostrar_tablas: false,
            resultado: [],

            array_tablas: [
                {
                    "CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI": [
                        [
                            "FUENTES MÓVILES",
                            ["fuentes_moviles"],
                            ["Combustible_liquido", "Combustible_gaseoso"],
                            "SUBTOTAL COMBUSTIBLES FUENTES MÓVILES",
                        ],
                        [
                            "OTROS",
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
                        [
                            "",
                            ["fuentes_fijas", "fuentes_moviles", "emisiones"],
                            [
                                "Combustible_solido",
                                "Combustible_liquido",
                                "Combustible_gaseoso",
                                "Refrigerante",
                                "Extintor",
                                "Lubricante",
                                "Fuga",
                                "Aislamiento",
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
                            "TOTAL CATEGORÍA 1",
                        ],
                    ],
                },
                {
                    "CATEGORIA 2 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR ENERGÍA IMPORTADA":
                        [
                            [
                                "ELECTRICIDAD IMPORTADA",
                                "electricidad_importada",
                                ["Energia_electrica"],
                                "SUBTOTAL ELECTRICIDAD IMPORTADA",
                            ],
                            [
                                "ENERGÍA IMPORTADA",
                                "energia_importada",
                                [
                                    "Combustible_solido",
                                    "Combustible_liquido",
                                    "Combustible_gaseoso",
                                ],
                                "SUBTOTAL ENERGÍA IMPORTADA",
                            ],
                            [
                                "",
                                ["electricidad_importada", "energia_importada"],
                                [
                                    "Combustible_solido",
                                    "Combustible_liquido",
                                    "Combustible_gaseoso",
                                    "Energia_electrica",
                                ],
                                "TOTAL CATEGORÍA 2",
                            ],
                        ],
                },
                {
                    "CATEGORIA 3 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR EL TRANSPORTE":
                        [
                            [
                                "FUENTES MÓVILES",
                                "transportes_fuentes_moviles",
                                ["Combustible_liquido", "Combustible_gaseoso"],
                                "SUBTOTAL COMBUSTIBLES",
                            ],
                            [
                                "FUENTES MÓVILES",
                                "transportes_fuentes_moviles",
                                ["Refrigerante", "Extintor", "Lubricante"],
                                "SUBTOTAL OTROS",
                            ],
                            [
                                "TRANSPORTE CARGA Y PASAJEROS",
                                "transportes_carga_pasajeros",
                                ["Transporte_carga", "Transporte_pasajeros"],
                                "SUBTOTAL VIAJES AÉREOS Y TRANSPORTE DE CARGA",
                            ],
                            [
                                "",
                                [
                                    "transportes_fuentes_moviles",
                                    "transportes_carga_pasajeros",
                                ],
                                [
                                    "Combustible_liquido",
                                    "Combustible_gaseoso",
                                    "Refrigerante",
                                    "Extintor",
                                    "Lubricante",
                                    "Transporte_carga",
                                    "Transporte_pasajeros",
                                ],
                                "TOTAL CATEGORÍA 3",
                            ],
                        ],
                },
                {
                    "CATEGORIA 4 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR PRODUCTOS QUE UTILIZA LA ORGANIZACIÓN":
                        [
                            [
                                "BIENES Y PRODUCTOS",
                                "bienes_productos",
                                [
                                    "Refrigerante",
                                    "Extintor",
                                    "Lubricante",
                                    "Aislamiento",
                                    "Producto",
                                ],
                                "SUBTOTAL PRODUCTOS",
                            ],
                            [
                                "BIENES Y PRODUCTOS",
                                "bienes_productos",
                                ["Equipo"],
                                "SUBTOTAL EQUIPOS",
                            ],
                            [
                                "BIENES Y PRODUCTOS",
                                "bienes_productos",
                                ["Materia_prima"],
                                "SUBTOTAL MATERIAS PRIMAS",
                            ],
                            [
                                "SERVICIOS",
                                "servicios",
                                ["Residuo_organizacional", "Servicio"],
                                "SUBTOTAL SERVICIOS",
                            ],
                            [
                                "",
                                ["bienes_productos", "servicios"],
                                [
                                    "Refrigerante",
                                    "Extintor",
                                    "Lubricante",
                                    "Aislamiento",
                                    "Producto",
                                    "Equipo",
                                    "Materia_prima",
                                    "Servicio",
                                    "Residuo_organizacional",
                                ],
                                "TOTAL CATEGORÍA 4",
                            ],
                        ],
                },
                {
                    "CATEGORIA 5 - EMISIONES INDIRECTAS DE GEI ASOCIADAS CON EL USO DE LOS PRODUCTOS DE LA ORGANIZACIÓN":
                        [
                            [
                                "USO DE PRODUCTOS",
                                "usos",
                                ["Producto"],
                                "SUBTOTAL PRODUCTOS",
                            ],
                            [
                                "FIN DE VIDA",
                                "fines",
                                ["Fin"],
                                "SUBTOTAL FIN DE VIDA",
                            ],
                            [
                                "ACTIVOS ARRENDADOS",
                                "activos",
                                ["Activo"],
                                "SUBTOTAL ACTIVOS",
                            ],
                            [
                                "INVERSIONES",
                                "inversiones",
                                ["Inversion"],
                                "SUBTOTAL INVERSIONES",
                            ],
                            [
                                "",
                                ["usos", "fines", "activos", "inversiones"],
                                ["Producto", "Fin", "Activo", "Inversion"],
                                "TOTAL CATEGORÍA 5",
                            ],
                        ],
                },
                {
                    "CATEGORIA 6 - EMISIONES INDIRECTAS DE GEI PROVENIENTES DE OTRAS FUENTES":
                        [
                            ["OTROS", "otros", ["Otro"], "SUBTOTAL OTROS"],
                            ["", ["otros"], ["Otro"], "TOTAL CATEGORÍA 6"],
                        ],
                },
                {
                    "CATEGORIA 7 - EMISIONES TRASVERSALES": [
                        [
                            "TRASVERSALES",
                            "trasversales",
                            ["Trasversal"],
                            "SUBTOTAL TRASVERSALES",
                        ],
                        [
                            "",
                            ["trasversales"],
                            ["Trasversales"],
                            "TOTAL CATEGORÍA 7",
                        ],
                    ],
                },
            ],
            array_biogenicos: [
                {
                    "CATEGORIA 1 - EMISIONES Y REMOCIONES DIRECTAS DE GEI": [
                        [
                            "FUENTES MÓVILES",
                            "fuentes_moviles",
                            ["Combustible_liquido", "Combustible_gaseoso"],
                            "SUBTOTAL FUENTES MÓVILES",
                        ],
                        [
                            "FUENTES FIJAS",
                            "fuentes_fijas",
                            [
                                "Combustible_solido",
                                "Combustible_liquido",
                                "Combustible_gaseoso",
                            ],
                            "SUBTOTAL FUENTES FIJAS",
                        ],
                        [
                            "",
                            ["fuentes_moviles", "fuentes_fijas"],
                            [
                                "Combustible_solido",
                                "Combustible_liquido",
                                "Combustible_gaseoso",
                            ],
                            "TOTAL CATEGORÍA 1",
                        ],
                    ],
                },
                {
                    "CATEGORIA 2 - EMISIONES INDIRECTAS DE GEI CAUSADAS POR ENERGÍA IMPORTADA":
                        [
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
                            [
                                "",
                                ["energias"],
                                [
                                    "Combustible_solido",
                                    "Combustible_liquido",
                                    "Combustible_gaseoso",
                                ],
                                "TOTAL CATEGORÍA 2",
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
                                "",
                                ["transportes"],
                                ["Combustible_liquido", "Combustible_gaseoso"],
                                "TOTAL CATEGORÍA 3",
                            ],
                        ],
                },
            ],
            user: new User(),
        };
    },
    mounted() {
        this.getUserLogged();
    },
    methods: {
        async getUserLogged() {
            await axios
                .get("api/user")
                .then((response) => {
                    this.user = response.data;
                    if (this.user.rol_id != 2) {
                        this.getOptionsEmpresa();
                    } else {
                        this.empresa = response.data.empresa_id;
                        this.getOptionsSede();
                    }
                })
                .catch((error) => {});
        },
        async getOptionsEmpresa() {
            this.options_empresa = await Empresa.get();
        },
        async getOptionsSede() {
            let options =
                this.user.rol_id != 2
                    ? await EmpresaSede.where(
                          "empresa_id",
                          this.user.empresa_id
                      ).get()
                    : await EmpresaSede.where(
                          "empresa_id",
                          this.user.empresa_id
                      ).get();

            options.forEach((e) => {
                this.options_sede.push(e);
            });
        },
        fuentes(fila, tipo, array_fuente_emision, $biogenico) {
            let fuentes = [];
            if (fila != "") {
                Object.keys(this.resultado).forEach((key) => {
                    Object.keys(this.resultado[key]).forEach((k) => {
                        if ($biogenico) {
                            if (
                                this.resultado[key][k]["tipo"] == tipo &&
                                this.resultado[key][k]["fuentetable"][
                                    "biogenico"
                                ] == $biogenico &&
                                array_fuente_emision.includes(
                                    this.resultado[key][k]["fuente_emision"]
                                )
                            ) {
                                fuentes.push(this.resultado[key][k]);
                            }
                        } else {
                            if (
                                this.resultado[key][k]["tipo"] == tipo &&
                                array_fuente_emision.includes(
                                    this.resultado[key][k]["fuente_emision"]
                                )
                            ) {
                                fuentes.push(this.resultado[key][k]);
                            }
                        }
                    });
                });
            }

            return fuentes;
        },
        totalEmisionesTonEq(
            array_categoria,
            array_fuente_emision,
            emision,
            $biogenico = ""
        ) {
            let suma_incertidumbre = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        array_categoria.includes(
                            this.resultado[key][k]["tipo"]
                        ) &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma_incertidumbre +=
                            this.resultado[key][k]["resultado"][
                                "emision_" +
                                    emision +
                                    "_ton_eq" +
                                    $biogenico +
                                    this.ar
                            ];
                    }
                });
            });
            return suma_incertidumbre;
        },
        totalIncertidumbreEmisiones(
            array_categoria,
            array_fuente_emision,
            emision,
            biogenico = ""
        ) {
            let total = 0;
            let suma_incertidumbre = 0;
            let suma_emisiones = 0;

            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        array_categoria.includes(
                            this.resultado[key][k]["tipo"]
                        ) &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma_emisiones +=
                            this.resultado[key][k]["resultado"][
                                "emision_" +
                                    emision +
                                    "_ton_eq" +
                                    biogenico +
                                    this.ar
                            ];
                        suma_incertidumbre +=
                            this.resultado[key][k]["resultado"][
                                "columna_auxiliar_" +
                                    emision +
                                    biogenico +
                                    this.ar
                            ];
                    }
                });
            });
            if (suma_emisiones > 0) {
                total = (Math.sqrt(suma_incertidumbre) / suma_emisiones) * 100;
            }
            return total;
        },
        totalColumnaAuxiliar(
            array_categoria,
            array_fuente_emision,
            emision,
            biogenico = ""
        ) {
            let total = 0;
            let suma_emisiones = 0;
            let suma_incertidumbre = 0;

            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        array_categoria.includes(
                            this.resultado[key][k]["tipo"]
                        ) &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma_emisiones +=
                            this.resultado[key][k]["resultado"][
                                "emision_" +
                                    emision +
                                    "_ton_eq" +
                                    biogenico +
                                    this.ar
                            ];

                        suma_incertidumbre +=
                            this.resultado[key][k]["resultado"][
                                "columna_auxiliar_" +
                                    emision +
                                    biogenico +
                                    this.ar
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

        totalHuellaCarbono(
            array_categoria,
            array_fuente_emision,
            biogenico = ""
        ) {
            let total = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        array_categoria.includes(
                            this.resultado[key][k]["tipo"]
                        ) &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        total +=
                            this.resultado[key][k]["resultado"][
                                "huella_carbono" + biogenico + this.ar
                            ];
                    }
                });
            });
            return total;
        },

        totalIncertidumbreFuente(
            array_categoria,
            array_fuente_emision,
            biogenico = ""
        ) {
            let total = 0;
            let total_huella = 0;
            let suma = 0;
            Object.keys(this.resultado).forEach((key) => {
                Object.keys(this.resultado[key]).forEach((k) => {
                    if (
                        array_categoria.includes(
                            this.resultado[key][k]["tipo"]
                        ) &&
                        array_fuente_emision.includes(
                            this.resultado[key][k]["fuente_emision"]
                        )
                    ) {
                        suma += Math.pow(
                            this.resultado[key][k]["resultado"][
                                "huella_carbono" + biogenico + this.ar
                            ] *
                                this.resultado[key][k]["resultado"][
                                    "incertidumbre_fuente" + biogenico + this.ar
                                ],
                            2
                        );
                        total_huella +=
                            this.resultado[key][k]["resultado"][
                                "huella_carbono" + biogenico + this.ar
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
            this.$root.mostrarCargando("Consultando información");
            axios
                .get("api/getFuentesEmision/" + this.empresa + "/" + this.sede)
                .then((response) => {
                    this.mostrar_tablas = true;
                    this.resultado = response.data;
                    for (let i = 0; i < 7; i++) {
                        $("#tabla-resultados-" + i)
                            .DataTable()
                            .destroy();

                        $("#tabla-biogenicos-" + i)
                            .DataTable()
                            .destroy();
                    }
                    setTimeout(() => {
                        for (let i = 0; i < 7; i++) {
                            this.$tablaResultadosEmision(
                                "#tabla-resultados-" + i
                            );
                            this.$tablaResultadosEmision(
                                "#tabla-biogenicos-" + i
                            );
                        }

                        Swal.close();
                    }, 1000);
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
