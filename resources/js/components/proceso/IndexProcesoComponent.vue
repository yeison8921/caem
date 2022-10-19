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
                                :aria-labelledby="'panelsStayOpen-heading-' + i"
                            >
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Nombre del proceso</label
                                        >
                                        <input
                                            v-model.trim="v.nombre.$model"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': v.nombre.$error,
                                                'is-valid': !v.nombre.$invalid,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            <span v-if="!v.nombre.required">{{
                                                required
                                            }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Descripción del proceso</label
                                        >
                                        <textarea
                                            v-model.trim="v.descripcion.$model"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    v.descripcion.$error,
                                                'is-valid':
                                                    !v.descripcion.$invalid,
                                            }"
                                        >
                                        </textarea>
                                        <div class="invalid-feedback">
                                            <span
                                                v-if="!v.descripcion.required"
                                                >{{ required }}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Equipo de consumo (fuente
                                            GEI)</label
                                        >
                                        <Multiselect
                                            v-model.trim="v.equipo.$model"
                                            :options="options"
                                            placeholder="Seleccione una opción"
                                            :class="{
                                                'is-invalid': v.equipo.$error,
                                                'is-valid': !v.equipo.$invalid,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            <span v-if="v.equipo.required">
                                                {{ required }}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label required"
                                            >Energéticos utilizados</label
                                        >
                                        <Multiselect
                                            v-model.trim="v.energetico.$model"
                                            :options="options"
                                            placeholder="Seleccione una opción"
                                            :class="{
                                                'is-invalid':
                                                    v.energetico.$error,
                                                'is-valid':
                                                    !v.energetico.$invalid,
                                            }"
                                        />
                                        <div class="invalid-feedback">
                                            <span v-if="v.energetico.required">
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
        </div>
    </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";
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
    methods: {
        agregarElementoProceso() {
            this.procesos.push({
                nombre: "",
                descripcion: "",
                equipo: "",
                energetico: "",
            });
        },
    },
};
</script>
