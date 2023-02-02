<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} fuga</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="fuga.nombre"
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
                            v-model="fuga.unidad_consumo"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor de emisión CO2e (kg CO2e/gal)</label
                        >
                        <input
                            v-model="fuga.factor_emision_co2"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor de emisión CO2</label
                        >
                        <input
                            v-model="fuga.unidad_factor_emision_co2"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 1</label
                        >
                        <input
                            v-model="fuga.incertidumbre_co2_1"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CO2 2</label
                        >
                        <input
                            v-model="fuga.incertidumbre_co2_2"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica CO2</label
                        >
                        <input
                            v-model="fuga.fuente_bibliografica_co2"
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
import Fuga from "../../../models/Fuga";

export default {
    data() {
        return {
            fuga: new Fuga({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.accion == "Actualizar") {
            this.getFuga();
        }
    },
    methods: {
        async getFuga() {
            this.fuga = await Fuga.find(this.datos.id_fuga);
        },

        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Actualizar") {
                this.fuga.id = this.datos.id_fuga;
            }
            await this.fuga.save();
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
