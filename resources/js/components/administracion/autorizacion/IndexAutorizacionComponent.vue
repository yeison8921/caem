<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Registros</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="col-lg-4">
                        <label class="form-label">Estado</label>
                        <Multiselect
                            v-model="estado_selected"
                            :options="estados"
                            placeholder="Seleccione una opción"
                            :searchable="true"
                            valueProp="id"
                            label="value"
                            @input="getUsuarios()"
                        />
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
                                <th>NIT</th>
                                <th>Usuario</th>
                                <th>Correo</th>
                                <th>Sede</th>
                                <th>Fecha Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(e, i) in usuarios" v-bind:key="i">
                                <td>
                                    {{ e.empresa.nit }}
                                </td>
                                <td>
                                    {{ e.first_name + " " + e.last_name }}
                                </td>
                                <td>
                                    {{ e.email }}
                                </td>
                                <td>
                                    {{ e.empresa_sede.nombre }}
                                </td>
                                <td>
                                    {{
                                        moment
                                            .utc(
                                                e.created_at,
                                                "YYYY-MM-DD HH:mm:ss"
                                            )
                                            .local()
                                            .format("DD/MM/Y HH:mm:ss")
                                    }}
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-success"
                                        title="Autorizar"
                                        @click="actualizarUsuario(e, 1)"
                                    >
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button
                                        v-if="e.estado != 2"
                                        type="button"
                                        class="btn btn-danger"
                                        title="Rechazar"
                                        @click="actualizarUsuario(e, 2)"
                                    >
                                        <i class="fas fa-times"></i>
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
            estado_selected: 0,
            estados: [
                { id: 0, value: "Por Revisar" },
                { id: 2, value: "No autorizados" },
            ],
            usuarios: "",
            usuario: "",
        };
    },
    mounted() {
        this.getUsuarios();
    },
    methods: {
        async getUsuarios() {
            this.usuarios = [];
            this.$root.mostrarCargando("");
            let usuarios = User.include("empresa", "empresaSede").where({
                estado: this.estado_selected,
                rol_id: 2,
            });
            this.usuarios = await usuarios.get();

            $("#tabla-usuarios").DataTable().clear().destroy();
            this.$tablaUsuarios("#tabla-usuarios");

            Swal.close();
        },
        async actualizarUsuario(usuario, estado) {
            this.$root.mostrarCargando("");
            usuario.estado = estado;
            usuario.save().then(() => {
                if (estado == 1) {
                    axios
                        .post("/api/enviarNotificacionAprobacionSinConvenio", {
                            email: usuario.email,
                        })
                        .then((response) => {
                            this.$root.mostrarMensaje(
                                "Éxito",
                                "Usuario aprobado correctamente",
                                "success"
                            );
                            setTimeout(() => {
                                this.getUsuarios();
                            }, 1000);
                        });
                } else {
                    this.$root.mostrarMensaje(
                        "Éxito",
                        "Usuario rechazado correctamente",
                        "success"
                    );
                    setTimeout(() => {
                        this.getUsuarios();
                    }, 1000);
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
