<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Resultados</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <form @submit.prevent="getDatosGraficas">
                    <div class="mb-3" v-if="user.rol_id != 2">
                        <Multiselect
                            v-model="empresa"
                            :options="options_empresa"
                            valueProp="id"
                            label="nombre"
                            placeholder="Empresa"
                            :searchable="true"
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
                            :searchable="true"
                            required
                            @input="getOptionsPeriodo()"
                        />
                    </div>
                    <div class="mb-3">
                        <Multiselect
                            v-model="periodo"
                            :options="options_periodo"
                            placeholder="Periodo"
                            :searchable="true"
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
                    <div class="mb-3">
                        <Multiselect
                            v-model="reporte"
                            :options="options_reporte"
                            placeholder="Reporte"
                            required
                        />
                    </div>
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary">
                            Calcular
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-9" v-if="mostrar_graficas">
                <div class="row mb-5">
                    <div class="col-lg-6 mb-3">
                        <div
                            class="card text-center justify-content-center"
                            style="height: 360px"
                        >
                            <div>
                                <h5>
                                    Total Huella de Carbono<br />
                                    CO2 Equivalente
                                </h5>
                                <br />
                                <br />
                                <h2>{{ total_huella_carbono }} ton</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <h6 class="text-center">
                                Huella de Carbono emisiones directas e
                                indirectas<br />
                                (Ton CO2 eq)
                            </h6>
                            <div class="chart">
                                <huella-carbono-directa-indirecta-bar
                                    ref="huellaCarbonoDirectaIndirecta"
                                    :chart="{
                                        labels: huella_carbono_directa_indirecta[0],
                                        datasets: {
                                            label: 'Total huella carbono por categoría',
                                            data: huella_carbono_directa_indirecta[1],
                                            backgroundColor:
                                                huella_carbono_directa_indirecta[2],
                                        },
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <h6 class="text-center">
                                Huella de Carbono por Categoría<br />
                                (Ton CO2 eq)
                            </h6>
                            <div class="chart">
                                <huella-carbono-categoria-bar
                                    ref="huellaCarbonoCategoria"
                                    :chart="{
                                        labels: array_huella_carbono_categoria[0],
                                        datasets: {
                                            label: 'Total huella carbono por categoría',
                                            data: array_huella_carbono_categoria[1],
                                            backgroundColor:
                                                array_huella_carbono_categoria[2],
                                        },
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <h6 class="text-center">
                                Huella de Carbono por GEI<br />
                                (Ton CO2 eq)
                            </h6>
                            <div class="chart">
                                <huella-carbono-gei-bar
                                    ref="huellaCarbonoGeiBar"
                                    :chart="{
                                        labels: array_huella_carbono_gei[0],
                                        datasets: {
                                            label: 'Total huella carbono por GEI',
                                            data: array_huella_carbono_gei[1],
                                            backgroundColor:
                                                array_huella_carbono_gei[2],
                                        },
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <h6 class="text-center">
                                Huella de Carbono por Fuente
                                <br />
                                (Ton CO2 eq)
                            </h6>
                            <div class="chart">
                                <huella-carbono-fuente-bar
                                    ref="huellaCarbonoFuenteBar"
                                    :chart="{
                                        labels: array_huella_carbono_fuente[0],
                                        datasets: {
                                            label: 'Total huella carbono por fuente',
                                            data: array_huella_carbono_fuente[1],
                                            backgroundColor:
                                                array_huella_carbono_fuente[2],
                                        },
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <h6 class="text-center">
                                Huella de Carbono por Fuente
                                <br />
                                (Ton CO2 eq)
                            </h6>
                            <div class="chart">
                                <huella-carbono-fuente-pie
                                    ref="huellaCarbonoFuentePie"
                                    id="pie-chart-component"
                                    height="300"
                                    :chart="{
                                        labels: array_huella_carbono_fuente_torta[0],
                                        datasets: {
                                            label: 'Total huella carbono por fuente',
                                            data: array_huella_carbono_fuente_torta[1],
                                            backgroundColor:
                                                array_huella_carbono_fuente_torta[2],
                                        },
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <h6 class="text-center">
                                Huella de Carbono por Tipo o clase<br />
                                (Ton CO2 eq)
                            </h6>

                            <div class="chart">
                                <huella-carbono-tipo-bar
                                    ref="huellaCarbonoTipoBar"
                                    :chart="{
                                        labels: array_huella_carbono_tipo[0],
                                        datasets: {
                                            label: 'Huella de carbono por fuente de emisión',
                                            data: array_huella_carbono_tipo[1],
                                            backgroundColor:
                                                array_huella_carbono_tipo[2],
                                        },
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="card">
                            <h6 class="text-center">
                                Cumplimiento de principios
                            </h6>
                            <div class="chart">
                                <cumplimiento-principios-bar
                                    ref="cumplimientoPrincipiosBar"
                                    :chart="{
                                        labels: [
                                            'PERTINENCIA',
                                            'INTEGRALIDAD',
                                            'COHERENCIA',
                                            'EXACTITUD',
                                            'TRANSPARENCIA',
                                        ],
                                        datasets: {
                                            label: 'Porcentaje de cumplimiento',
                                            data: array_cumplimiento[0],
                                            backgroundColor:
                                                array_cumplimiento[1],
                                        },
                                    }"
                                />
                            </div>
                            <div class="p-3 text-start">
                                <p>
                                    <b>
                                        {{ promedio_cumplimiento }}
                                    </b>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-6 offset-lg-6 mb-3">
                        <div
                            class="card text-center justify-content-center"
                            style="height: 360px"
                        >
                            <div>
                                <h6>
                                    Total Huella de Carbono CO2 eq<br />por
                                    unidad de producción
                                </h6>
                                <br />
                                <br />

                                <h5>
                                    {{
                                        total_huella_carbono_unidad_produccion ==
                                        0
                                            ? "No se registró información"
                                            : ""
                                    }}
                                    {{
                                        total_huella_carbono_unidad_produccion ==
                                        0
                                            ? ""
                                            : total_huella_carbono_unidad_produccion +
                                              " ton/u"
                                    }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="col-lg-9 offset-lg-3 text-start"
                v-if="mostrar_graficas && user.rol_id != 2"
            >
                <a
                    href="resultados-excel"
                    target="_blank"
                    class="btn btn-primary"
                >
                    Descargar resultados globales
                </a>
            </div>
        </div>
    </div>
</template>
<script>
import User from "../../models/User";
import Empresa from "../../models/Empresa";
import EmpresaSede from "../../models/EmpresaSede";
import Convenio from "../../models/Convenio";
import InformacionEmpresa from "../../models/InformacionEmpresa";
import HuellaCarbonoDirectaIndirectaBar from "./HuellaCarbonoDirectaIndirectaBar.vue";
import HuellaCarbonoCategoriaBar from "./HuellaCarbonoCategoriaBar.vue";
import HuellaCarbonoGeiBar from "./HuellaCarbonoGeiBar.vue";
import HuellaCarbonoFuenteBar from "./HuellaCarbonoFuenteBar.vue";
import HuellaCarbonoFuentePie from "./HuellaCarbonoFuentePie.vue";
import HuellaCarbonoTipoBar from "./HuellaCarbonoTipoBar.vue";
import CumplimientoPrincipiosBar from "./CumplimientoPrincipiosBar.vue";

export default {
    name: "Charts",
    components: {
        HuellaCarbonoDirectaIndirectaBar,
        HuellaCarbonoCategoriaBar,
        HuellaCarbonoGeiBar,
        HuellaCarbonoFuenteBar,
        HuellaCarbonoFuentePie,
        HuellaCarbonoTipoBar,
        CumplimientoPrincipiosBar,
    },

    data() {
        return {
            convenio: "",
            empresa: "",
            sede: "",
            periodo: "",
            ar: "",
            reporte: "",
            total_huella_carbono: "",
            mostrar_graficas: false,
            huella_carbono_directa_indirecta: [],
            array_huella_carbono_categoria: [],
            array_huella_carbono_gei: [],
            array_huella_carbono_fuente: [],
            array_huella_carbono_fuente_torta: [],
            array_huella_carbono_tipo: [],
            array_cumplimiento: [],
            promedio_cumplimiento: "",
            total_huella_carbono_unidad_produccion: "",
            options_convenio: [],
            options_empresa: [],
            options_sede: [{ id: -1, nombre: "Todas" }],
            options_periodo: [],
            options_ar: [
                { value: "_ar5", label: "AR5" },
                { value: "_ar6", label: "AR6" },
            ],
            options_reporte: [
                { value: "corporativo", label: "CORPORATIVO" },
                { value: "_biogenico", label: "BIOGÉNICO" },
            ],
            options_si_no: [{ value: 1, label: 1 }],
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
            user: new User(),
        };
    },
    mounted() {
        this.getUserLogged();
    },
    computed: {},
    methods: {
        async getUserLogged() {
            await axios
                .get("api/user")
                .then((response) => {
                    this.user = response.data;
                    if (this.user.rol_id != 2) {
                        this.user.rol_id == 4
                            ? this.getOptionsEmpresa(this.user.convenio_id)
                            : this.getOptionsEmpresa();
                    } else {
                        this.empresa = response.data.empresa_id;
                        this.getOptionsSede();
                    }
                })
                .catch((error) => {});
        },
        async getOptionsEmpresa(convenio_id = "") {
            if (convenio_id == "") {
                this.options_empresa = await Empresa.get();
            } else {
                this.options_empresa = await Empresa.where(
                    "convenios.id",
                    convenio_id
                ).get();
            }
        },
        async getOptionsSede() {
            this.options_sede = [];
            this.sede = "";
            this.options_periodo = [];
            this.periodo = "";

            if (this.empresa != "" && this.empresa != null) {
                this.options_sede = [{ id: -1, nombre: "Todas" }];
                let options =
                    this.user.rol_id != 2
                        ? await EmpresaSede.where(
                              "empresa_id",
                              this.empresa
                          ).get()
                        : await EmpresaSede.where(
                              "empresa_id",
                              this.user.empresa_id
                          ).get();

                options.forEach((e) => {
                    this.options_sede.push(e);
                });
            }
        },
        async getOptionsPeriodo() {
            this.options_periodo = [];
            this.periodo = "";
            if (this.sede != "" && this.sede != null) {
                var informacion_empresa;
                if (this.sede == -1) {
                    informacion_empresa = await InformacionEmpresa.where({
                        empresa_id: this.empresa,
                    }).get();
                    this.options_periodo.push({ value: -1, label: "TODOS" });
                } else {
                    informacion_empresa = await InformacionEmpresa.where({
                        empresa_id: this.empresa,
                        sede_id: this.sede,
                    }).get();
                }

                informacion_empresa.forEach((e) => {
                    if (e.anio_inicio != null) {
                        let fecha_base = new Date(
                            e.anio_inicio + "-" + e.mes_inicio + "-01 00:00"
                        );

                        var future = new Date(
                            fecha_base.getFullYear(),
                            fecha_base.getMonth() + 12,
                            1
                        );

                        let mes_fecha_base =
                            this.array_meses[fecha_base.getMonth()];

                        var mes_futuro = this.array_meses[future.getMonth()];
                        var anio_futuro = future.getFullYear();

                        var json = {
                            value: e.id,
                            label:
                                mes_fecha_base +
                                " " +
                                e.anio_inicio +
                                " a " +
                                mes_futuro +
                                " " +
                                anio_futuro,
                        };
                        this.options_periodo.push(json);
                    }
                });
            }
        },
        getDatosGraficas() {
            this.$root.mostrarCargando("Cargando información");
            axios
                .post("api/getDatosGraficas", {
                    empresa_id: this.empresa,
                    sede_id: this.sede,
                    periodo: this.periodo,
                    ar: this.ar,
                    reporte: this.reporte,
                })
                .then((response) => {
                    if (response.data["total_huella_carbono"] != 0) {
                        this.mostrar_graficas = true;

                        this.total_huella_carbono = Number(
                            response.data["total_huella_carbono"].toFixed(1)
                        ).toLocaleString("es-co");
                        this.huella_carbono_directa_indirecta =
                            response.data["huella_carbono_directa_indirecta"];
                        this.array_huella_carbono_categoria =
                            response.data["huella_carbono_categoria"];
                        this.array_huella_carbono_gei =
                            response.data["huella_carbono_gei"];
                        this.array_huella_carbono_fuente =
                            response.data["huella_carbono_fuente"];
                        this.array_huella_carbono_fuente_torta =
                            response.data["huella_carbono_fuente_torta"];
                        this.array_huella_carbono_tipo =
                            response.data["huella_carbono_tipo"];
                        this.array_cumplimiento = response.data["cumplimiento"];
                        this.total_huella_carbono_unidad_produccion = Number(
                            response.data[
                                "total_huella_carbono_unidad_produccion"
                            ].toFixed(2)
                        ).toLocaleString("es-co");
                        this.promedio_cumplimiento =
                            "Total obtenido = " +
                            Number(
                                response.data["promedio_cumplimiento"].toFixed(
                                    1
                                )
                            ).toLocaleString("es-co") +
                            " %";

                        setTimeout(() => {
                            this.$refs.huellaCarbonoCategoria.cargarGrafica();
                            this.$refs.huellaCarbonoGeiBar.cargarGrafica();
                            this.$refs.huellaCarbonoTipoBar.cargarGrafica();
                            this.$refs.huellaCarbonoFuenteBar.cargarGrafica();
                            this.$refs.huellaCarbonoFuentePie.cargarGrafica();
                            this.$refs.cumplimientoPrincipiosBar.cargarGrafica();
                            Swal.close();
                        }, 1000);
                    } else {
                        this.mostrar_graficas = false;
                        Swal.close();
                        this.$root.mostrarMensaje(
                            "Atención",
                            "No se ha registrado Información para la sede seleccionada",
                            "warning"
                        );
                    }
                })
                .catch((error) => {
                    Swal.close();
                    this.$root.mostrarMensaje(
                        "Atención",
                        "No se ha registrado Información para la sede seleccionada",
                        "warning"
                    );
                });
        },
    },
};
</script>
<style>
table.table {
    width: auto;
}
:root {
    --ms-font-size: 14px;
    --ms-option-font-size: 12px;
}
</style>
