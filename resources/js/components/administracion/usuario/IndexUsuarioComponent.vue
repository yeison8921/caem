<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>Usuarios</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="col-lg-1 offset-lg-11">
                        <div class="d-grid gap-2">
                            <a
                                :href="'/usuarios/create/'"
                                class="btn btn-success"
                                title="Crear usuario"
                            >
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <table
                        class="table table-bordered table-hover table-striped"
                        id="tabla-usuarios"
                        width="100%"
                    >
                        <thead>
                            <tr>
                                <th>Correo</th>
                                <th>Nombres</th>
                                <th>Celular</th>
                                <th>Rol</th>
                                <th>Convenio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(u, i) in usuarios" v-bind:key="i">
                                <td>{{ u.email }}</td>
                                <td>{{ u.first_name + " " + u.last_name }}</td>
                                <td>{{ u.phone }}</td>
                                <td>
                                    {{ u.rol.nombre }}
                                </td>
                                <td>
                                    {{
                                        u.convenio_id == null
                                            ? "No aplica"
                                            : u.convenio.nombre_convenio
                                    }}
                                </td>
                                <td>
                                    <a
                                        :href="'/usuarios/edit/' + u.id"
                                        class="btn btn-warning"
                                        title="Actualizar usuario"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button
                                        v-if="parseInt(u.estado) == 1"
                                        class="btn btn-danger"
                                        title="Desactivar usuario"
                                        :disabled="u.rol_id == 1"
                                        @click="
                                            u.rol_id == 1
                                                ? ''
                                                : confirmarDesactivarUsuario(
                                                      u.id,
                                                      u.first_name,
                                                      u.last_name,
                                                      parseInt(0)
                                                  )
                                        "
                                    >
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                    <button
                                        v-if="parseInt(u.estado) == 0"
                                        class="btn btn-success"
                                        title="Activar usuario"
                                        :disabled="u.rol_id == 1"
                                        @click="
                                            u.rol_id == 1
                                                ? ''
                                                : confirmarDesactivarUsuario(
                                                      u.id,
                                                      u.first_name,
                                                      u.last_name,
                                                      parseInt(1)
                                                  )
                                        "
                                    >
                                        <i class="fa-solid fa-check"></i>
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
import User from "../../../models/User";

export default {
    data() {
        return {
            usuarios: [],
        };
    },
    mounted() {
        this.getUsuarios();
    },
    methods: {
        async getUsuarios() {
            this.$root.mostrarCargando();
            this.usuarios = await User.whereIn("rol_id", [1, 3, 4])
                .include("rol", "empresa", "empresaSede", "convenio")
                .get();
            $("#tabla-usuarios").DataTable().destroy();
            this.$tablaGlobal("#tabla-usuarios");
            Swal.close();
        },
        async confirmarDesactivarUsuario(
            id_usuario,
            first_name,
            last_name,
            estado
        ) {
            let accion = estado ? "activar" : "desactivar";
            Swal.fire({
                title: "Atención",
                html: `¿Está seguro que quiere <b>${accion}</b> el usuario <b>${first_name} ${last_name}</b>?`,
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Si",
            }).then((result) => {
                if (result.isConfirmed) {
                    try {
                        this.desactivarUsuario(id_usuario, estado);
                    } catch (error) {
                        this.$root.mostrarMensaje(
                            "Error",
                            `Ha ocurrido un error al ${accion} el usuario, por favor intentelo nuevamente`,
                            "error"
                        );
                    }
                }
            });
        },
        async desactivarUsuario(id_usuario, estado) {
            let accion = estado ? "activado" : "desactivado";
            this.$root.mostrarCargando("");
            let user = await User.find(id_usuario);
            user.estado = parseInt(estado);
            user.save();
            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                `Usuario ${accion} correctamente`,
                "success"
            );
            setTimeout(() => {
                this.getUsuarios();
            }, 1000);
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
