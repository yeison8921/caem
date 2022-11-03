<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Empresas</h2>
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
                            @input="getEmpresas()"
                        />
                    </div>
                </div>

                <div class="mb-3">
                    <table
                        class="table table-bordered table-hover table-stripered"
                        id="tabla-empresas"
                        width="100%"
                    >
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Nit</th>
                                <th>Teléfono</th>
                                <th>Sedes</th>
                                <th>Convenio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(e, i) in empresas" v-bind:key="i">
                                <td>
                                    {{
                                        e.nombre == null
                                            ? "Sin definir"
                                            : e.nombre
                                    }}
                                </td>
                                <td>
                                    {{ e.nit }}
                                </td>
                                <td>
                                    {{
                                        e.telefono == null
                                            ? "Sin definir"
                                            : e.telefono
                                    }}
                                </td>
                                <td>
                                    <ul>
                                        <li
                                            v-for="(s, is) in e.sedes"
                                            v-bind:key="is"
                                        >
                                            {{ s.nombre }}
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li
                                            v-for="(c, i) in e.convenios"
                                            v-bind:key="i"
                                        >
                                            {{ c.nombre_convenio }}
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <a
                                        :href="'/empresas/edit/' + e.id"
                                        class="btn btn-warning"
                                        title="Actualizar empresa"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button
                                        type="button"
                                        class="btn btn-info"
                                        title="Ver información completa"
                                        @click="getEmpresaById(e.id)"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-ver-empresa"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal ver empresa-->
        <div
            class="modal fade"
            id="modal-ver-empresa"
            tabindex="-1"
            aria-labelledby="modal-ver-empresaLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-ver-empresaLabel">
                            Detalle de la empresa
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <table class="table" v-if="empresa != ''">
                            <tbody>
                                <tr>
                                    <td><b>Nombre:</b></td>
                                    <td>
                                        {{
                                            empresa.nombre == null
                                                ? "Sin definir"
                                                : empresa.nombre
                                        }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Nit:</b></td>
                                    <td>{{ empresa.nit }}</td>
                                </tr>
                                <tr>
                                    <td><b>Teléfono:</b></td>
                                    <td>
                                        {{
                                            empresa.telefono == null
                                                ? "Sin definir"
                                                : empresa.telefono
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Código CIIU:</b></td>
                                    <td>
                                        {{
                                            empresa.codigo == null
                                                ? "Sin definir"
                                                : empresa.codigo.nombre
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Sector:</b></td>
                                    <td>
                                        {{
                                            empresa.sector == null
                                                ? "Sin definir"
                                                : empresa.sector.nombre
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Empleados:</b></td>
                                    <td>
                                        {{
                                            empresa.empleado == null
                                                ? "Sin definir"
                                                : empresa.empleado.nombre
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Tamaño:</b></td>
                                    <td>
                                        {{
                                            empresa.tamano == null
                                                ? "Sin definir"
                                                : empresa.tamano.nombre
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Sedes:</b></td>
                                    <td>
                                        <ul>
                                            <li
                                                v-for="(s, i) in empresa.sedes"
                                                v-bind:key="i"
                                            >
                                                {{ s.nombre }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>Convenio:</b></td>
                                    <td>
                                        <ul>
                                            <li
                                                v-for="(
                                                    c, i
                                                ) in empresa.convenios"
                                                v-bind:key="i"
                                            >
                                                {{ c.nombre_convenio }}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Convenio from "../../../models/Convenio";
import Empresa from "../../../models/Empresa";

export default {
    data() {
        return {
            convenio_id: -1,
            options_convenio: [{ id: -1, nombre_convenio: "Todos" }],
            empresas: "",
            empresa: "",
        };
    },
    mounted() {
        this.getConvenios();
        this.getEmpresas();
    },
    methods: {
        async getConvenios() {
            let convenios = await Convenio.get();
            convenios.forEach((e) => {
                this.options_convenio.push(e);
            });
        },
        async getEmpresas() {
            this.empresas = [];
            this.$root.mostrarCargando("");
            if (this.convenio_id != "" && this.convenio_id != null) {
                let empresas = Empresa.include("sedes", "convenios");
                if (this.convenio_id != -1) {
                    empresas = empresas.where("convenios.id", this.convenio_id);
                }
                this.empresas = await empresas.get();
            }

            $("#tabla-empresas").DataTable().clear().destroy();
            this.$tablaEmpresas("#tabla-empresas");

            Swal.close();
        },
        async getEmpresaById(id_empresa) {
            this.empresa = await Empresa.include(
                "codigo",
                "sector",
                "empleado",
                "tamano",
                "convenios",
                "sedes"
            ).find(id_empresa);
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
