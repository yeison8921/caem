<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} {{ datos.tipo }}</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="fertilizante.nombre"
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
                            v-model="fertilizante.unidad_consumo"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div v-if="datos.tipo == 'cal'">
                        <div class="mb-3">
                            <label class="form-label required"
                                >Factor de emisión CO2 (kg CO2e/kg)</label
                            >
                            <input
                                v-model="fertilizante.factor_emision_co2"
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
                                v-model="fertilizante.unidad_factor_emision_co2"
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
                                v-model="fertilizante.incertidumbre_co2_1"
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
                                v-model="fertilizante.incertidumbre_co2_2"
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
                                v-model="fertilizante.fuente_bibliografica_co2"
                                type="text"
                                class="form-control"
                                required
                            />
                        </div>
                    </div>

                    <div v-if="datos.tipo != 'cal'">
                        <div class="mb-3">
                            <label class="form-label required"
                                >Factor emision N2O(kg CO2e/kg)</label
                            ><input
                                v-model="fertilizante.factor_emision_n2o"
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
                                v-model="fertilizante.unidad_factor_emision_n2o"
                                type="text"
                                class="form-control"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">
                                Incertidumbre (+/- %) N2O 1</label
                            ><input
                                v-model="fertilizante.incertidumbre_n2o_1"
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
                                v-model="fertilizante.incertidumbre_n2o_2"
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
                                v-model="fertilizante.fuente_bibliografica_n2o"
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
import Fertilizante from "../../../models/Fertilizante";

export default {
    data() {
        return {
            fertilizante: new Fertilizante({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.tipo != "fertilizante" && this.datos.tipo != "cal") {
            this.$root.mostrarMensaje(
                "error",
                "No existe el tipo de fertilizante especificado",
                "error"
            );
            this.$root.redirectIndex("/fuentes");
        }
        if (this.datos.accion == "Actualizar") {
            this.getFertilizante();
        }
    },
    methods: {
        async getFertilizante() {
            this.fertilizante = await Fertilizante.find(
                this.datos.id_fertilizante
            );
        },
        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Crear") {
                this.fertilizante.tipo = this.datos.tipo;
            }
            if (this.datos.accion == "Actualizar") {
                this.fertilizante.id = this.datos.id_fertilizante;
            }
            await this.fertilizante.save();
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
