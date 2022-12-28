<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} emisión {{ datos.tipo }}</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="emision.nombre"
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
                            v-model="emision.unidad_consumo"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div v-if="datos.tipo == 'industrial'">
                        <div class="mb-3">
                            <label class="form-label required"
                                >Factor de emisión CO2</label
                            >
                            <input
                                v-model="emision.factor_emision_co2"
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
                                v-model="emision.unidad_factor_emision_co2"
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
                                v-model="emision.incertidumbre_co2_1"
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
                                v-model="emision.incertidumbre_co2_2"
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
                                v-model="emision.fuente_bibliografica_co2"
                                type="text"
                                class="form-control"
                                required
                            />
                        </div>
                    </div>
                    <div v-if="datos.tipo != 'industrial'">
                        <div class="mb-3">
                            <label class="form-label required"
                                >Factor emision CH4</label
                            ><input
                                v-model="emision.factor_emision_ch4"
                                type="number"
                                step="any"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required"
                                >Unidad factor emisión CH4</label
                            ><input
                                v-model="emision.unidad_factor_emision_ch4"
                                type="text"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">
                                Incertidumbre (+/- %) CH4 1</label
                            ><input
                                v-model="emision.incertidumbre_ch4_1"
                                type="number"
                                step="any"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">
                                Incertidumbre (+/- %) CH4 2</label
                            ><input
                                v-model="emision.incertidumbre_ch4_2"
                                type="number"
                                step="any"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">
                                Fuente bibliográfica CH4</label
                            ><input
                                v-model="emision.fuente_bibliografica_ch4"
                                type="text"
                                class="form-control"
                                required
                            />
                        </div>
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
import Emision from "../../../models/Emision";

export default {
    data() {
        return {
            emision: new Emision({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (
            this.datos.tipo != "embalse" &&
            this.datos.tipo != "mineria" &&
            this.datos.tipo != "industrial" &&
            this.datos.tipo != "residuo"
        ) {
            this.$root.mostrarMensaje(
                "error",
                "No existe el tipo de emisión especificado",
                "error"
            );
            this.$root.redirectIndex("/fuentes");
        }
        if (this.datos.accion == "Actualizar") {
            this.getEmision();
        }
    },
    methods: {
        async getEmision() {
            this.emision = await Emision.find(this.datos.id_emision);
        },
        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Crear") {
                this.emision.tipo = this.datos.tipo;
            }
            if (this.datos.accion == "Actualizar") {
                this.emision.id = this.datos.id_emision;
            }
            await this.emision.save();
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
