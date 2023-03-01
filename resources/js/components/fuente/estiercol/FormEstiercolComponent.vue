<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>{{ datos.accion }} {{ datos.tipo }}</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="estiercol.nombre"
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
                            v-model="estiercol.unidad_consumo"
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
                            v-model="estiercol.factor_emision_ch4"
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
                            v-model="estiercol.unidad_factor_emision_ch4"
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
                            v-model="estiercol.incertidumbre_ch4_1"
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
                            v-model="estiercol.incertidumbre_ch4_2"
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
                            v-model="estiercol.fuente_bibliografica_ch4"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor emision N2O(kg CO2e/unidad)</label
                        ><input
                            v-model="estiercol.factor_emision_n2o"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor emisión N2O</label
                        ><input
                            v-model="estiercol.unidad_factor_emision_n2o"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Incertidumbre (+/- %) N2O 1</label
                        ><input
                            v-model="estiercol.incertidumbre_n2o_1"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Incertidumbre (+/- %) N2O 2</label
                        ><input
                            v-model="estiercol.incertidumbre_n2o_2"
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Fuente bibliográfica N2O</label
                        ><input
                            v-model="estiercol.fuente_bibliografica_n2o"
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
import Estiercol from "../../../models/Estiercol";

export default {
    data() {
        return {
            estiercol: new Estiercol({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.tipo != "estiercol" && this.datos.tipo != "residuo") {
            this.$root.mostrarMensaje(
                "error",
                "No existe el tipo de estiercol especificado",
                "error"
            );
            this.$root.redirectIndex("/fuentes");
        }
        if (this.datos.accion == "Actualizar") {
            this.getEstiercol();
        }
    },
    methods: {
        async getEstiercol() {
            this.estiercol = await Estiercol.find(this.datos.id_estiercol);
        },
        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Crear") {
                this.estiercol.tipo = this.datos.tipo;
            }
            if (this.datos.accion == "Actualizar") {
                this.estiercol.id = this.datos.id_estiercol;
            }
            await this.estiercol.save();
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
