<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>{{ datos.accion }} lubricante</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="lubricante.nombre"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad de consumo</label
                        >
                        <input
                            v-model="lubricante.unidad_consumo"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor de emisión CO2e (kg CO2e/gal)</label
                        >
                        <input
                            v-model="lubricante.factor_emision_co2"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor de emisión CO2</label
                        >
                        <input
                            v-model="lubricante.unidad_factor_emision_co2"
                            type="text"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 1</label
                        >
                        <input
                            v-model="lubricante.incertidumbre_co2_1"
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
                            v-model="lubricante.incertidumbre_co2_2"
                            type="number"
                            step="any"
                            class="form-control"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica CO2</label
                        >
                        <input
                            v-model="lubricante.fuente_bibliografica_co2"
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
import Lubricante from "../../../models/Lubricante";

export default {
    data() {
        return {
            lubricante: new Lubricante({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.accion == "Actualizar") {
            this.getLubricante();
        }
    },
    methods: {
        async getLubricante() {
            this.lubricante = await Lubricante.find(this.datos.id_lubricante);
        },

        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Actualizar") {
                this.lubricante.id = this.datos.id_lubricante;
            }
            await this.lubricante.save();
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
