<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Procesos</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active"
                            id="formulario-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#formulario"
                            type="button"
                            role="tab"
                            aria-controls="formulario"
                            aria-selected="true"
                        >
                            Formulario
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="construccion-proceso-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#construccion-proceso"
                            type="button"
                            role="tab"
                            aria-controls="construccion-proceso"
                            aria-selected="false"
                        >
                            Construcción del proceso productivo de la empresa
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link"
                            id="construccion-anio-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#construccion-anio"
                            type="button"
                            role="tab"
                            aria-controls="construccion-anio"
                            aria-selected="false"
                            @click="tablaEmisiones()"
                        >
                            Construcción de año base de emisiones de GEI
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div
                        class="tab-pane fade show active"
                        id="formulario"
                        role="tabpanel"
                        aria-labelledby="formulario-tab"
                    >
                        <div class="mb-3">
                            <label class="form-label required">Año</label>
                            <Multiselect
                                v-model="anio"
                                :options="options_anio"
                                label="nombre"
                                valueProp="valor"
                                placeholder="Seleccione una opción"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Mes</label>
                            <Multiselect
                                v-model="mes"
                                :options="options_mes"
                                label="nombre"
                                valueProp="valor"
                                placeholder="Seleccione una opción"
                            />
                        </div>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="construccion-proceso"
                        role="tabpanel"
                        aria-labelledby="construccion-proceso-tab"
                    >
                        <div class="mb-3">
                            <div class="accordion" id="acordeon-procesos">
                                <div
                                    class="accordion-item"
                                    v-for="(v, i) in $v.procesos.$each.$iter"
                                    v-bind:key="i"
                                >
                                    <h2
                                        class="accordion-header"
                                        :id="'panelsStayOpen-heading-' + i"
                                    >
                                        <button
                                            class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            :data-bs-target="
                                                '#panelsStayOpen-collapse-' + i
                                            "
                                            aria-expanded="true"
                                            :aria-controls="
                                                'panelsStayOpen-collapse-' + i
                                            "
                                        >
                                            {{ v.nombre.$model }}
                                        </button>
                                    </h2>

                                    <div
                                        :id="'panelsStayOpen-collapse-' + i"
                                        class="accordion-collapse collapse show"
                                        :aria-labelledby="
                                            'panelsStayOpen-heading-' + i
                                        "
                                    >
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Nombre del proceso</label
                                                >
                                                <input
                                                    v-model.trim="
                                                        v.nombre.$model
                                                    "
                                                    type="text"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            v.nombre.$error,
                                                        'is-valid':
                                                            !v.nombre.$invalid,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="
                                                            !v.nombre.required
                                                        "
                                                        >{{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Descripción del
                                                    proceso</label
                                                >
                                                <textarea
                                                    v-model.trim="
                                                        v.descripcion.$model
                                                    "
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            v.descripcion
                                                                .$error,
                                                        'is-valid':
                                                            !v.descripcion
                                                                .$invalid,
                                                    }"
                                                >
                                                </textarea>
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="
                                                            !v.descripcion
                                                                .required
                                                        "
                                                        >{{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Equipo de consumo (fuente
                                                    GEI)</label
                                                >
                                                <Multiselect
                                                    v-model.trim="
                                                        v.equipo.$model
                                                    "
                                                    :options="options"
                                                    placeholder="Seleccione una opción"
                                                    :class="{
                                                        'is-invalid':
                                                            v.equipo.$error,
                                                        'is-valid':
                                                            !v.equipo.$invalid,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="v.equipo.required"
                                                    >
                                                        {{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label
                                                    class="form-label required"
                                                    >Energéticos
                                                    utilizados</label
                                                >
                                                <Multiselect
                                                    v-model.trim="
                                                        v.energetico.$model
                                                    "
                                                    :options="options"
                                                    placeholder="Seleccione una opción"
                                                    :class="{
                                                        'is-invalid':
                                                            v.energetico.$error,
                                                        'is-valid':
                                                            !v.energetico
                                                                .$invalid,
                                                    }"
                                                />
                                                <div class="invalid-feedback">
                                                    <span
                                                        v-if="
                                                            v.energetico
                                                                .required
                                                        "
                                                    >
                                                        {{ required }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            <button
                                class="btn btn-success"
                                @click="agregarElementoProceso()"
                            >
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div
                        class="tab-pane fade"
                        id="construccion-anio"
                        role="tabpanel"
                        aria-labelledby="construccion-anio-tab"
                    >
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Energético</th>
                                        <th
                                            v-for="(c, i) in cabecera_tabla"
                                            v-bind:key="i"
                                        >
                                            {{ c }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(e, i) in energeticos"
                                        v-bind:key="i"
                                    >
                                        <td>Energético {{ i + 1 }}</td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import Parametro from "../../models/Parametro";

export default {
    data() {
        return {
            procesos: [
                {
                    nombre: "Proceso 1",
                    descripcion: "",
                    equipo: "",
                    energetico: "",
                },
            ],
            options_anio: [],
            options_mes: [],

            anio: "",
            mes: "",
            fecha_base: "",

            cabecera_tabla: [],

            array_meses: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],
            energeticos: [{ nombre: "" }, { nombre: "" }],
            required: "Este campo es requerido",
            options: [{ value: 1, label: "1" }],
        };
    },
    validations: {
        procesos: {
            required,

            $each: {
                nombre: {
                    required,
                },
                descripcion: {
                    required,
                },
                equipo: {
                    required,
                },
                energetico: {
                    required,
                },
            },
        },
    },
    mounted() {
        this.getParametros(7, "options_anio");
        this.getParametros(8, "options_mes");
    },
    methods: {
        async getParametros(tipo_parametro_id, variable) {
            //1 departamentos
            //3 sectores
            //4 CIIUs
            //5 tamaños de empresa
            //6 número de empleados
            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },
        agregarElementoProceso() {
            this.procesos.push({
                nombre: "",
                descripcion: "",
                equipo: "",
                energetico: "",
            });
        },
        tablaEmisiones() {
            this.cabecera_tabla = [];
            this.fecha_base = new Date(
                this.anio + "-" + this.mes + "-01 00:00"
            );

            for (var i = 0; i < 12; i++) {
                var future = new Date(
                    this.fecha_base.getFullYear(),
                    this.fecha_base.getMonth() + i,
                    1
                );
                var month = this.array_meses[future.getMonth()];
                var year = future.getFullYear();
                this.cabecera_tabla.push(
                    "Mes " + (i + 1) + " (" + month + " " + year + ")"
                );
            }
        },
    },
};
</script>
