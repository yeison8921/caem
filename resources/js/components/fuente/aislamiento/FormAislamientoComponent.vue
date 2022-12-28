<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} aislamiento</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="aislamiento.nombre"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad de consumo 1</label
                        >
                        <input
                            v-model="aislamiento.unidad_consumo"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor de emisión CO2e (kg CO2e/kg) 1</label
                        >
                        <input
                            v-model="aislamiento.factor_emision_co2"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor de emisión CO2 1</label
                        >
                        <input
                            v-model="aislamiento.unidad_factor_emision_co2"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 1</label
                        >
                        <input
                            v-model="aislamiento.incertidumbre_co2_1"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 2</label
                        >
                        <input
                            v-model="aislamiento.incertidumbre_co2_2"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica CO2 1</label
                        >
                        <input
                            v-model="aislamiento.fuente_bibliografica_co2"
                            type="text"
                            class="form-control"
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad de consumo 2</label
                        >
                        <input
                            v-model="aislamiento.unidad_consumo_2"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor de emisión CO2e (kg CO2e/kg) 2</label
                        >
                        <input
                            v-model="aislamiento.factor_emision_co2_2"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor de emisión CO2 2</label
                        >
                        <input
                            v-model="aislamiento.unidad_factor_emision_co2_2"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 1</label
                        >
                        <input
                            v-model="aislamiento.incertidumbre_co2_1_2"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 2</label
                        >
                        <input
                            v-model="aislamiento.incertidumbre_co2_2_2"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica CO2 2</label
                        >
                        <input
                            v-model="aislamiento.fuente_bibliografica_co2_2"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <div class="col-lg-4 offset-lg-4">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import Aislamiento from "../../../models/Aislamiento";

export default {
    data() {
        return {
            aislamiento: new Aislamiento({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.accion == "Actualizar") {
            this.getExtintor();
        }
    },
    methods: {
        async getExtintor() {
            this.aislamiento = await Aislamiento.find(
                this.datos.id_aislamiento
            );
        },

        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Actualizar") {
                this.aislamiento.id = this.datos.id_aislamiento;
            }
            await this.aislamiento.save();
            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                "Guardado exitosamente",
                "success"
            );
            this.$root.redirectIndex("/fuentes");
        },
    },
};
</script>
