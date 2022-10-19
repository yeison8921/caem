<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Administración parámetros</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <Multiselect
                        v-model="tipo_parametro_id"
                        :options="options_tipo_parametro"
                        label="nombre"
                        valueProp="id"
                        placeholder="Seleccione una opción"
                        required
                        @input="getParametros()"
                    />
                </div>
                <div
                    v-if="tipo_parametro_id != '' && tipo_parametro_id != null"
                >
                    <div class="mb-3">
                        <div class="col-lg-1 offset-lg-11">
                            <div class="d-grid gap-2">
                                <a
                                    :href="
                                        '/parametros/create/' +
                                        tipo_parametro_id
                                    "
                                    class="btn btn-success"
                                    title="Crear parametro"
                                >
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <table
                            class="table table-bordered table-hover table-stripered"
                            id="tabla-parametros"
                            width="100%"
                        >
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(p, i) in parametros" v-bind:key="i">
                                    <td>
                                        {{
                                            tipo_parametro_id == 2
                                                ? p.nombre +
                                                  " - " +
                                                  p.parametro.nombre
                                                : p.nombre
                                        }}
                                    </td>
                                    <td>
                                        <a
                                            :href="
                                                '/parametros/edit/' +
                                                tipo_parametro_id +
                                                '/' +
                                                p.id
                                            "
                                            class="btn btn-warning"
                                            title="Actualizar parametro"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            title="Eliminar parametro"
                                            @click="confirmarEliminar(p.id)"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Parametro from "../../../models/Parametro";
import TipoParametro from "../../../models/TipoParametro";

export default {
    data() {
        return {
            tipo_parametro_id: "",
            options_tipo_parametro: [],
            parametros: "",
        };
    },
    mounted() {
        this.getOptionsTipoParametro();
    },
    methods: {
        async getOptionsTipoParametro() {
            this.options_tipo_parametro = await TipoParametro.get();
        },

        async getParametros() {
            this.$root.mostrarCargando();
            this.parametros = await Parametro.include("parametro")
                .where("tipo_parametro_id", this.tipo_parametro_id)
                .get();
            Swal.close();
            $("#tabla-parametros").DataTable().destroy();
            this.$tablaResultados("#tabla-parametros");
        },
        async confirmarEliminar(id_parametro) {
            Swal.fire({
                title: "¿Está seguro que desea desactivar este parámetro?",
                html: "El parámetro no se mostrará mas en el sistema pero los datos relacionados persistirán",
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Si, eliminar",
                confirmButtonColor: "rgb(48, 133, 214)",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.eliminarParametro(id_parametro);
                }
            });
        },
        async eliminarParametro(id_parametro) {
            this.$root.mostrarCargando("Eliminando parámetro");
            try {
                let parametro = await Parametro.find(id_parametro);
                parametro.delete();
                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Parámetro eliminado exitosamente",
                    "success"
                );
                setTimeout(() => {
                    this.getParametros();
                }, 2000);
            } catch (e) {}
        },
    },
};
</script>
<style>
.required:after {
    content: " *";
    color: red;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
