<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Usuarios</h2>
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
                        class="table table-bordered table-hover table-stripered"
                        id="tabla-usuarios"
                        width="100%"
                    >
                        <thead>
                            <tr>
                                <th>Correo</th>
                                <th>Nombres</th>
                                <th>Rol</th>
                                <th>Empresa</th>
                                <th>Sede</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(u, i) in usuarios" v-bind:key="i">
                                <td>{{ u.email }}</td>
                                <td>{{ u.first_name + " " + u.last_name }}</td>
                                <td>
                                    {{ u.rol.nombre }}
                                </td>
                                <td>
                                    {{
                                        u.empresa == null
                                            ? "No aplica"
                                            : u.empresa.nombre
                                    }}
                                </td>
                                <td>
                                    {{
                                        u.empresa_sede == null
                                            ? "No aplica"
                                            : u.empresa_sede.nombre
                                    }}
                                </td>
                                <td>
                                    <a
                                        :href="'/usuarios/edit/' + u.id"
                                        class="btn btn-success"
                                        title="Actualizar usuario"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
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
            this.usuarios = await User.whereIn("rol_id", [1, 3])
                .include("rol", "empresa", "empresaSede")
                .get();
            Swal.close();
            $("#tabla-usuarios").DataTable().clear().destroy();
            this.$tablaUsuarios("#tabla-usuarios");
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
