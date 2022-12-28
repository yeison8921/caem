<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} fermentación enterica</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="fermentacion.nombre"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad de consumo</label
                        >
                        <input
                            v-model="fermentacion.unidad_consumo"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor de emisión CH4 (kg CO2e/unidad)</label
                        >
                        <input
                            v-model="fermentacion.factor_emision_ch4"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor de emisión CH4</label
                        >
                        <input
                            v-model="fermentacion.unidad_factor_emision_ch4"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CH4 1</label
                        >
                        <input
                            v-model="fermentacion.incertidumbre_ch4_1"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CH4 2</label
                        >
                        <input
                            v-model="fermentacion.incertidumbre_ch4_2"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica CH4</label
                        >
                        <input
                            v-model="fermentacion.fuente_bibliografica_ch4"
                            type="text"
                            class="form-control"
                            required
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
import Fermentacion from "../../../models/Fermentacion";

export default {
    data() {
        return {
            fermentacion: new Fermentacion({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.accion == "Actualizar") {
            this.getFermentacion();
        }
    },
    methods: {
        async getFermentacion() {
            this.fermentacion = await Fermentacion.find(
                this.datos.id_fermentacion
            );
        },
        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Crear") {
                this.fermentacion.tipo = this.datos.tipo;
            }
            if (this.datos.accion == "Actualizar") {
                this.fermentacion.id = this.datos.id_fermentacion;
            }
            await this.fermentacion.save();
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
