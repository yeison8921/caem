<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} combustible {{ datos.tipo }}</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model="combustible.nombre"
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
                            v-model="combustible.unidad_consumo"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor de emisión CO2</label
                        >
                        <input
                            v-model="combustible.factor_emision_co2"
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
                            v-model="combustible.unidad_factor_emision_co2"
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
                            v-model="combustible.incertidumbre_co2_1"
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
                            v-model="combustible.incertidumbre_co2_2"
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
                            v-model="combustible.fuente_bibliografica_co2"
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor emision CH4(g CH4/t) fuente fija</label
                        ><input
                            v-model="
                                combustible.factor_emision_ch4g_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor emision CH4(kg CH4/t) fuente fija</label
                        ><input
                            v-model="
                                combustible.factor_emision_ch4kg_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor emisión CH4 fuente fija</label
                        ><input
                            v-model="
                                combustible.unidad_factor_emision_ch4_fuente_fija
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Incertidumbre (+/- %) CH4 1 fuente fija</label
                        ><input
                            v-model="
                                combustible.incertidumbre_ch4_1_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Incertidumbre (+/- %) CH4 2 fuente fija</label
                        ><input
                            v-model="
                                combustible.incertidumbre_ch4_2_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Fuente bibliográfica CH4 fuente fija</label
                        ><input
                            v-model="
                                combustible.fuente_bibliografica_ch4_fuente_fija
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Factor emision N2O(g N2O/m3) fuente fija</label
                        ><input
                            v-model="
                                combustible.factor_emision_n2og_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Factor emision N2O(kg N2O/t) fuente fija</label
                        ><input
                            v-model="
                                combustible.factor_emision_n2okg_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Unidad factor emisión N2O fuente fija</label
                        ><input
                            v-model="
                                combustible.unidad_factor_emision_n2o_fuente_fija
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Incertidumbre (+/- %) N2O 1 fuente fija</label
                        ><input
                            v-model="
                                combustible.incertidumbre_n2o_1_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">
                            Incertidumbre (+/- %) N2O 2 fuente fija</label
                        ><input
                            v-model="
                                combustible.incertidumbre_n2o_2_fuente_fija
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica N2O fuente fija</label
                        ><input
                            v-model="
                                combustible.fuente_bibliografica_n2o_fuente_fija
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor emision CH4(g CH4/m3) fuente móvil</label
                        ><input
                            v-model="
                                combustible.factor_emision_ch4g_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor emision CH4(kg CH4/t) fuente móvil</label
                        ><input
                            v-model="
                                combustible.factor_emision_ch4kg_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor emisión CH4 fuente móvil</label
                        ><input
                            v-model="
                                combustible.unidad_factor_emision_ch4_fuente_movil
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CH4 fuente móvil</label
                        ><input
                            v-model="
                                combustible.incertidumbre_ch4_1_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) CH4 fuente móvil</label
                        ><input
                            v-model="
                                combustible.incertidumbre_ch4_2_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica CH4 fuente móvil</label
                        ><input
                            v-model="
                                combustible.fuente_bibliografica_ch4_fuente_movil
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor emision N2O(g N2O/m3) fuente móvil</label
                        ><input
                            v-model="
                                combustible.factor_emision_n2og_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Factor emision N2O(kg N2O/t) fuente móvil</label
                        ><input
                            v-model="
                                combustible.factor_emision_n2okg_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Unidad factor emisión N2O fuente móvil</label
                        ><input
                            v-model="
                                combustible.unidad_factor_emision_n2o_fuente_movil
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) N2O fuente móvil</label
                        ><input
                            v-model="
                                combustible.incertidumbre_n2o_1_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Incertidumbre (+/- %) N2O fuente móvil</label
                        ><input
                            v-model="
                                combustible.incertidumbre_n2o_2_fuente_movil
                            "
                            type="number"
                            step="any"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Fuente bibliográfica N2O fuente móvil</label
                        ><input
                            v-model="
                                combustible.fuente_bibliografica_n2o_fuente_movil
                            "
                            type="text"
                            class="form-control"
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Biogénico</label>
                        <Multiselect
                            v-model="combustible.biogenico"
                            :options="[
                                { value: 0, label: 'No' },
                                { value: 1, label: 'Si' },
                            ]"
                            placeholder="Seleccione una opción"
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
import Combustible from "../../../models/Combustible";

export default {
    data() {
        return {
            combustible: new Combustible({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (
            this.datos.tipo != "liquido" &&
            this.datos.tipo != "solido" &&
            this.datos.tipo != "gaseoso"
        ) {
            this.$root.mostrarMensaje(
                "error",
                "No existe el tipo de combustible especificado",
                "error"
            );
            this.$root.redirectIndex("/fuentes");
        }
        if (this.datos.accion == "Actualizar") {
            this.getCombustible();
        }
    },
    methods: {
        async getCombustible() {
            this.combustible = await Combustible.find(
                this.datos.id_combustible
            );
        },
        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Crear") {
                this.combustible.tipo = this.datos.tipo;
            }
            if (this.datos.accion == "Actualizar") {
                this.combustible.id = this.datos.id_combustible;
            }
            await this.combustible.save();
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
