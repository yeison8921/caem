<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>Autorizacion de Huellas</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <table
                        class="table table-bordered table-hover table-stripered"
                        id="tabla-huellas"
                        width="100%"
                    >
                        <thead>
                            <tr>
                                <th>Empresa</th>
                                <th>Sede</th>
                                <th>Nombre Huella</th>
                                <th>Periodo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(e, i) in huellas" v-bind:key="i">
                                <td>
                                    {{ e.empresa.nombre }}
                                </td>
                                <td>
                                    {{ e.empresa_sede?.nombre }}
                                </td>
                                <td>
                                    {{ e.nombre }}
                                </td>
                                <td>{{ e.periodo }}</td>
                                <td>
                                    {{
                                        e.estado == "1"
                                            ? "Finalizado"
                                            : "Sin Finalizar"
                                    }}
                                </td>
                                <td>
                                    <button
                                        v-if="!e.esta_aprobado"
                                        type="button"
                                        class="btn btn-success"
                                        title="Autorizar"
                                        @click="actualizarHuella(e, true)"
                                    >
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button
                                        v-if="e.esta_aprobado"
                                        type="button"
                                        class="btn btn-danger"
                                        title="Rechazar"
                                        @click="actualizarHuella(e, false)"
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
import InformacionEmpresa from "../../../models/InformacionEmpresa";

export default {
    data() {
        return {
            estado_selected: 0,
            huellas: "",
            usuario: "",
        };
    },
    mounted() {
        this.getHuellas();
    },
    methods: {
        async getHuellas() {
            this.huellas = [];
            this.$root.mostrarCargando("");
            let huellas = InformacionEmpresa.include("empresa", "empresaSede");
            this.huellas = await huellas.get();

            $("#tabla-huellas").DataTable().clear().destroy();
            this.$tablaHuellas("#tabla-huellas");

            Swal.close();
        },
        async actualizarHuella(huella, esta_aprobado) {
            Swal.fire({
                title: esta_aprobado
                    ? "¿Autorizar huella?"
                    : "¿Rechazar huella?",
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: esta_aprobado ? "Autorizar" : "Rechazar",
                confirmButtonColor: "rgb(48, 133, 214)",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$root.mostrarCargando("");
                    huella.esta_aprobado = esta_aprobado;
                    huella.fecha_aprobacion = new Date();
                    huella.save().then(() => {
                        this.$root.mostrarMensaje(
                            "Éxito",
                            "Huella " +
                                (esta_aprobado ? "autorizada" : "rechazada") +
                                " correctamente",
                            "success"
                        );
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
