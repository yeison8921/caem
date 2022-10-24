<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Convenios</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="col-lg-1 offset-lg-11">
                        <div class="d-grid gap-2">
                            <a
                                :href="'/convenios/create'"
                                class="btn btn-success"
                                title="Crear convenio"
                            >
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <table
                        class="table table-bordered table-hover table-stripered"
                        id="tabla-convenios"
                        width="100%"
                    >
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Nombre entidad</th>
                                <th>Código</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(c, i) in convenios" v-bind:key="i">
                                <td>{{ c.nombre_convenio }}</td>
                                <td>{{ c.nombre_entidad }}</td>
                                <td>{{ c.codigo }}</td>
                                <td>
                                    <a
                                        :href="'/convenios/edit/' + c.id"
                                        class="btn btn-warning"
                                        title="Actualizar parametro"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn"
                                        :class="
                                            c.deleted_at == null
                                                ? 'btn-danger'
                                                : 'btn-success'
                                        "
                                        :title="
                                            c.deleted_at == null
                                                ? 'Desactivar convenio'
                                                : 'Activar convenio'
                                        "
                                        @click="
                                            cambiarEstadoConvenio(
                                                c.id,
                                                c.deleted_at
                                            )
                                        "
                                    >
                                        <i
                                            class="fas"
                                            :class="
                                                c.deleted_at == null
                                                    ? 'fa-trash'
                                                    : 'fa-check'
                                            "
                                        ></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Convenio from "../../../models/Convenio";

export default {
    data() {
        return {
            convenios: "",
        };
    },
    mounted() {
        this.getConvenios();
    },
    methods: {
        // async getOptionsTipoParametro() {
        //     this.options_tipo_parametro = await TipoParametro.get();
        // },
        async getConvenios() {
            this.$root.mostrarCargando();
            this.convenios = await Convenio.get();
            Swal.close();
            $("#tabla-convenios").DataTable().destroy();
            this.$tablaConvenios("#tabla-convenios");
        },

        cambiarEstadoConvenio(id_convenio, deleted) {
            let title =
                deleted == null
                    ? "¿Está seguro que desea desactivar este convenio?"
                    : "¿Está seguro que desea activar este convenio?";

            let html =
                deleted == null
                    ? "El convenio quedara inhabilitado y todos sus usuarios no podrán iniciar sesión, pero toda la información relacionada persistirá"
                    : "El convenio quedara habilitado y todos sus usuarios ahora podrán iniciar sesión.";

            let texto_respuesta = deleted == null ? "desactivado" : "activado";

            let confirmButtonText =
                deleted == null ? "Si, desactivar" : "Si, activar";

            let estado = deleted == null ? 0 : 1;

            Swal.fire({
                title: title,
                html: html,
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: confirmButtonText,
                confirmButtonColor: "rgb(48, 133, 214)",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post("/api/cambiarEstadoConvenio", {
                            id_convenio: id_convenio,
                            estado: estado,
                        })
                        .then((response) => {
                            this.$root.mostrarMensaje(
                                "Éxito",
                                "Convenio" + texto_respuesta + "correctamente",
                                "success"
                            );

                            setTimeout(() => {
                                this.getConvenios();
                            }, 2000);
                        });
                }
            });
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
