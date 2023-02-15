<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Empresarios</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
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
                                <th>Celular</th>
                                <th>Empresa</th>
                                <th>Sede</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(u, i) in usuarios" v-bind:key="i">
                                <td>{{ u.email }}</td>
                                <td>{{ u.first_name + " " + u.last_name }}</td>
                                <td>
                                    {{ u.phone }}
                                </td>

                                <td>
                                    {{ u.empresa.nombre }}
                                </td>
                                <td>
                                    {{ u.empresa_sede.nombre }}
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
            this.usuarios = await User.where("rol_id", 2)
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
