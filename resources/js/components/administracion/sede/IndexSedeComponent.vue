<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>Sedes</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="col-lg-4">
                        <label class="form-label">Convenio</label>
                        <Multiselect
                            v-model="convenio_id"
                            :options="options_convenio"
                            placeholder="Seleccione una opción"
                            :searchable="true"
                            valueProp="id"
                            label="nombre_convenio"
                            @input="getOptionsEmpresas()"
                        />
                    </div>
                </div>
                <div class="mb-3">
                    <div class="col-lg-4">
                        <label class="form-label">Empresa</label>
                        <Multiselect
                            v-model="empresa_id"
                            :options="options_empresa"
                            placeholder="Seleccione una opción"
                            :searchable="true"
                            valueProp="id"
                            label="nombre"
                            @input="getEmpresasSede()"
                        />
                    </div>
                </div>
                <div class="mb-3" v-if="empresa_id != '' && empresa_id != null">
                    <div class="col-lg-1 offset-lg-11">
                        <div class="d-grid gap-2">
                            <a
                                :href="'/sedes/create/' + empresa_id"
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
                        id="tabla-sedes"
                        width="100%"
                    >
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Departamento</th>
                                <th>Ciudad</th>
                                <th>Dirección</th>
                                <th>Empresario(s)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(s, i) in sedes" v-bind:key="i">
                                <td>{{ s.nombre }}</td>
                                <td>{{ s.departamento.nombre }}</td>
                                <td>
                                    {{ s.ciudad.nombre }}
                                </td>
                                <td>{{ s.direccion }}</td>
                                <td>
                                    <ol>
                                        <li
                                            v-for="(e, i) in s.empresarios"
                                            v-bind:key="i"
                                        >
                                            {{ e.first_name }}
                                            {{ e.last_name }} - {{ e.email }}
                                        </li>
                                    </ol>
                                </td>
                                <td>
                                    <a
                                        :href="'/sedes/edit/' + s.id"
                                        class="btn btn-success"
                                        title="Actualizar empresa"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        title="Eliminar sede"
                                        @click="confirmarEliminar(s.id)"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button
                                        v-if="!parseInt(s.permiso_huella)"
                                        type="button"
                                        class="btn btn-info"
                                        @click="
                                            confirmarActivarHuella(
                                                s.id,
                                                s.nombre
                                            )
                                        "
                                    >
                                        Activar huella
                                    </button>
                                    <button
                                        v-else
                                        type="button"
                                        class="btn btn-info"
                                        disabled
                                    >
                                        Huella activada
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
import Empresa from "../../../models/Empresa";
import EmpresaSede from "../../../models/EmpresaSede";

export default {
    data() {
        return {
            convenio_id: -1,
            empresa_id: "",
            options_convenio: [{ id: -1, nombre_convenio: "Todos" }],
            options_empresa: [],
            sedes: [],
        };
    },
    mounted() {
        this.getConvenios();
        this.getOptionsEmpresas();
    },
    methods: {
        async getConvenios() {
            let convenios = await Convenio.get();
            convenios.forEach((e) => {
                this.options_convenio.push(e);
            });
        },
        async getOptionsEmpresas() {
            this.empresa_id = "";
            this.options_empresa = [];
            this.sedes = [];

            if (this.convenio_id != "" && this.convenio_id != null) {
                let empresas = Empresa.include("convenios");
                if (this.convenio_id != -1) {
                    empresas = empresas.where("convenios.id", this.convenio_id);
                }
                this.options_empresa = await empresas.get();
            }
        },
        async getEmpresasSede() {
            this.sedes = [];
            this.$root.mostrarCargando();
            if (this.empresa_id !== "" && this.empresa_id !== null) {
                this.sedes = await EmpresaSede.include(
                    "empresa",
                    "departamento",
                    "ciudad",
                    "empresarios"
                )
                    .where("empresa_id", this.empresa_id)
                    .get();
            }
            Swal.close();
            $("#tabla-sedes").DataTable().clear().destroy();
            this.$tablaSedes("#tabla-sedes");
        },
        async confirmarEliminar(id_sede) {
            Swal.fire({
                title: "¿Está seguro que desea eliminar esta sede?",
                html: "La sede no se mostrará mas en el sistema pero los datos relacionados persistirán",
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Si, eliminar",
                confirmButtonColor: "rgb(48, 133, 214)",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.eliminarSede(id_sede);
                }
            });
        },
        async eliminarSede(id_sede) {
            this.$root.mostrarCargando("Eliminando sede");
            try {
                let sede = await EmpresaSede.find(id_sede);
                sede.delete();
                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Sede eliminada exitosamente",
                    "success"
                );
                setTimeout(() => {
                    this.getEmpresasSede();
                }, 2000);
            } catch (e) {}
        },
        confirmarActivarHuella(id_sede, nombre_sede) {
            Swal.fire({
                title: "Atención",
                html:
                    "¿Está seguro que quiere activar el registro de una nueva huella para la sede " +
                    nombre_sede +
                    "?",
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Si, activar",
                confirmButtonColor: "rgb(48, 133, 214)",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.activarHuella(id_sede);
                }
            });
        },
        async activarHuella(id_sede) {
            this.$root.mostrarCargando("Activando huella");
            let sede = await EmpresaSede.find(id_sede);
            sede.permiso_huella = 1;
            await sede.save();
            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                "Huella activada exitosamente",
                "success"
            );
            setTimeout(() => {
                this.getEmpresasSede();
            }, 2000);
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
