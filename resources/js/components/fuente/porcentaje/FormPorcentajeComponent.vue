<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>{{ datos.accion }} otro</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            :value="porcentaje_combustible.nombre"
                            type="text"
                            class="form-control"
                            disabled
                            required
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Valor</label>
                        <input
                            v-model="porcentaje_combustible.valor"
                            type="number"
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
import PorcentajeCombustible from "../../../models/PorcentajeCombustible";

export default {
    data() {
        return {
            porcentaje_combustible: new PorcentajeCombustible({}),
        };
    },
    props: ["datos"],

    mounted() {
        if (this.datos.accion == "Actualizar") {
            this.getPorcentaje();
        }
    },
    methods: {
        async getPorcentaje() {
            this.porcentaje_combustible = await PorcentajeCombustible.find(
                this.datos.id_porcentaje
            ).catch((error) => {
                this.$root.mostrarMensaje(
                    "Error",
                    "No existe el id especificado",
                    "error"
                );
                this.$root.redirectIndex("/fuentes");
            });
        },

        async submit() {
            this.$root.mostrarCargando("Guardando");
            if (this.datos.accion == "Actualizar") {
                this.porcentaje_combustible.id = this.datos.id_porcentaje;
            }
            await this.porcentaje_combustible.save();
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
