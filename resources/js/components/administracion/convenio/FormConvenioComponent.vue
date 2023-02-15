<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} convenio</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required"
                            >Nombre del convenio</label
                        >
                        <input
                            v-model.trim="convenio.nombre_convenio"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid':
                                    $v.convenio.nombre_convenio.$error,
                                'is-valid':
                                    !$v.convenio.nombre_convenio.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span
                                v-if="!$v.convenio.nombre_convenio.required"
                                >{{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Nombre de la entidad</label
                        >
                        <input
                            v-model.trim="convenio.nombre_entidad"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.convenio.nombre_entidad.$error,
                                'is-valid':
                                    !$v.convenio.nombre_entidad.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.convenio.nombre_entidad.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Código de validación</label
                        >
                        <input
                            v-model.trim="convenio.codigo"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.convenio.codigo.$error,
                                'is-valid': !$v.convenio.codigo.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.convenio.codigo.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Texto legal</label>
                        <textarea
                            v-model.trim="convenio.texto_legal"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.convenio.texto_legal.$error,
                                'is-valid': !$v.convenio.texto_legal.$invalid,
                            }"
                        >
                        </textarea>
                        <div class="invalid-feedback">
                            <span v-if="!$v.convenio.texto_legal.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="formFile" class="form-label"
                            >Selecionar excel empresarios</label
                        >
                        <input
                            class="form-control"
                            type="file"
                            id="archivo-correos"
                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                            @change="leerData"
                        />
                    </div> -->
                    <div class="mb-3 table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Correo</th>
                                    <th>Estado</th>
                                    <th>NIT</th>
                                    <th>Sede</th>
                                    <th>Departamento</th>
                                    <th>Ciudad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(ac, i) in array_correos"
                                    v-bind:key="i"
                                >
                                    <td>{{ ac.email }}</td>
                                    <td>
                                        <span
                                            class="badge"
                                            :class="
                                                ac.id_correo == ''
                                                    ? 'bg-warning'
                                                    : 'bg-success'
                                            "
                                        >
                                            {{
                                                ac.id_correo == ""
                                                    ? "Correo por agregar"
                                                    : "Correo en sistema"
                                            }}
                                        </span>
                                    </td>
                                    <td>{{ ac.nit }}</td>
                                    <td>
                                        {{
                                            ac.id_sede == -1
                                                ? "Sede nueva - " +
                                                  ac.nombre_sede
                                                : ac.nombre_sede
                                        }}
                                    </td>
                                    <td>{{ ac.nombre_departamento }}</td>
                                    <td>{{ ac.nombre_ciudad }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            title="Eliminar correo"
                                            @click="
                                                confirmarEliminacionCorreo(i)
                                            "
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-agregar-empresario"
                            @click="resetFormsEmpresario()"
                        >
                            Agregar empresario
                        </button>
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
        <!-- Modal -->
        <div class="modal fade" id="modal-agregar-empresario" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="submitEmpresario()">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Agregar empresario
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Seleccionar nit empresa</label
                                >
                                <Multiselect
                                    v-model.trim="nit"
                                    :options="options_empresa"
                                    placeholder="Seleccione una opción"
                                    valueProp="id"
                                    label="nit"
                                    @input="formularioNit()"
                                    :class="{
                                        'is-invalid': $v.nit.$error,
                                        'is-valid': !$v.nit.$invalid,
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span v-if="!$v.nit.required">{{
                                        required
                                    }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nit</label>
                                <input
                                    v-model.trim="convenio_email.nit"
                                    type="text"
                                    class="form-control"
                                    :disabled="nit != -1"
                                    :class="{
                                        'is-invalid':
                                            $v.convenio_email.nit.$error,
                                        'is-valid':
                                            !$v.convenio_email.nit.$invalid,
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span
                                        v-if="!$v.convenio_email.nit.required"
                                        >{{ required }}</span
                                    >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Correo</label
                                >
                                <input
                                    v-model.trim="convenio_email.email"
                                    type="text"
                                    class="form-control"
                                    :class="{
                                        'is-invalid':
                                            $v.convenio_email.email.$error,
                                        'is-valid':
                                            !$v.convenio_email.email.$invalid,
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span
                                        v-if="!$v.convenio_email.email.required"
                                        >{{ required }}</span
                                    >
                                    <span v-if="!$v.convenio_email.email.email"
                                        >Debe ingresar un correo valido</span
                                    >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Sede</label>
                                <Multiselect
                                    v-model.trim="sede.id"
                                    :options="options_sede"
                                    placeholder="Seleccione una opción"
                                    valueProp="id"
                                    label="nombre"
                                    @input="getSedeById()"
                                    :class="{
                                        'is-invalid': $v.sede.id.$error,
                                        'is-valid':
                                            sede.id != ''
                                                ? !$v.sede.id.$invalid
                                                : '',
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span v-if="!$v.sede.id.required">
                                        {{ required }}</span
                                    >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Nombre sede</label
                                >
                                <input
                                    v-model.trim="sede.nombre"
                                    type="text"
                                    class="form-control"
                                    :disabled="sede.id != -1"
                                    :class="{
                                        'is-invalid': $v.sede.nombre.$error,
                                        'is-valid': !$v.sede.nombre.$invalid,
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span v-if="!$v.sede.nombre.required">{{
                                        required
                                    }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Departamento</label
                                >
                                <Multiselect
                                    v-model.trim="sede.departamento_id"
                                    :options="options_departamento"
                                    placeholder="Seleccione una opción"
                                    valueProp="id"
                                    label="nombre"
                                    @input="getOptionsCiudad()"
                                    :disabled="sede.id != -1"
                                    :class="{
                                        'is-invalid':
                                            $v.sede.departamento_id.$error,
                                        'is-valid':
                                            sede.departamento_id != ''
                                                ? !$v.sede.departamento_id
                                                      .$invalid
                                                : '',
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span
                                        v-if="!$v.sede.departamento_id.required"
                                    >
                                        {{ required }}</span
                                    >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required"
                                    >Ciudad o municipio</label
                                >
                                <Multiselect
                                    v-model.trim="sede.ciudad_id"
                                    :options="options_ciudad"
                                    placeholder="Seleccione una opción"
                                    valueProp="id"
                                    label="nombre"
                                    :disabled="sede.id != -1"
                                    :class="{
                                        'is-invalid': $v.sede.ciudad_id.$error,
                                        'is-valid':
                                            $v.sede.ciudad_id != ''
                                                ? !$v.sede.ciudad_id.$invalid
                                                : '',
                                    }"
                                />
                                <div class="invalid-feedback">
                                    <span v-if="!$v.sede.ciudad_id.required">
                                        {{ required }}</span
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                                ref="cerrarModalAgregarEmpresario"
                            >
                                Cerrar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Agregar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import * as XLSX from "xlsx";
import { required, email } from "vuelidate/lib/validators";
import Convenio from "../../../models/Convenio";
import ConvenioEmail from "../../../models/ConvenioEmail";
import Empresa from "../../../models/Empresa";
import EmpresaSede from "../../../models/EmpresaSede";
import Parametro from "../../../models/Parametro";

export default {
    data() {
        return {
            nit: "",
            required: "Este campo es requerido",

            array_correos: [],
            convenio_email: new ConvenioEmail({
                email: "",
                nit: "",
                convenio_id: "",
                sede_id: "",
            }),
            convenio: new Convenio({
                id: "",
                nombre_convenio: "",
                nombre_entidad: "",
                codigo: "",
                texto_legal: "",
                //Reemplazar por usuario logueado
                usuario_actualizo_id: 1,
            }),
            sede: new EmpresaSede({
                id: "",
                nombre: "",
                departamento_id: "",
                ciudad_id: "",
            }),
            empresa: new Empresa({
                nit: "",
            }),

            empresas: "",
            options_departamento: [],
            options_ciudad: [],
            options_empresa: [],
            options_sede: [],
        };
    },
    props: ["datos"],
    validations: {
        convenio: {
            nombre_convenio: {
                required,
            },
            nombre_entidad: {
                required,
            },
            codigo: {
                required,
            },
            texto_legal: {
                required,
            },
        },

        convenio_email: {
            email: {
                required,
                email,
            },
            nit: {
                required,
            },
        },

        sede: {
            id: {
                required,
            },
            nombre: {
                required,
            },
            departamento_id: {
                required,
            },
            ciudad_id: {
                required,
            },
        },

        nit: {
            required,
        },
    },
    mounted() {
        if (this.datos.accion == "Actualizar") {
            this.getConvenioById();
        }
        this.getParametros(1, "options_departamento");
        this.getOptionsNit();
    },
    methods: {
        async getParametros(tipo_parametro_id, variable) {
            //1 departamentos
            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },
        async getConvenioById() {
            let convenio = await Convenio.include(
                "emails.sede.departamento",
                "emails.sede.ciudad"
            )
                .find(this.datos.id_convenio)
                .catch((error) => {
                    this.$root.mostrarMensaje(
                        "error",
                        "No existe el convenio",
                        "error"
                    );
                    this.$root.redirectIndex("/convenios");
                });

            this.convenio.id = convenio.id;
            this.convenio.nombre_convenio = convenio.nombre_convenio;
            this.convenio.nombre_entidad = convenio.nombre_entidad;
            this.convenio.codigo = convenio.codigo;
            this.convenio.texto_legal = convenio.texto_legal;

            this.array_correos = [];
            convenio.emails.forEach((e) => {
                this.array_correos.push({
                    id_correo: e.id,
                    id_empresa: "",
                    email: e.email,
                    nit: e.nit,
                    id_sede: e.sede_id,
                    ciudad_id: e.sede.ciudad_id,
                    departamento_id: e.sede.departamento_id,
                    nombre_sede: e.sede.nombre,
                    nombre_departamento: e.sede.departamento.nombre,
                    nombre_ciudad: e.sede.ciudad.nombre,
                });
            });
        },
        async getOptionsCiudad() {
            this.options_ciudad = [];
            if (
                this.sede.departamento_id != "" &&
                this.sede.departamento_id != null
            ) {
                this.sede.ciudad_id = "";

                this.options_ciudad = await Parametro.where(
                    "parametro_id",
                    this.sede.departamento_id
                ).get();
            }
        },

        leerData() {
            var file = document.getElementById("archivo-correos").files[0];
            // input canceled, return
            if (file == undefined) return;

            // this.$root.mostrarCargando("Validando archivo");
            var FR = new FileReader();
            FR.onload = (e) => {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: "array" });
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

                let array = XLSX.utils.sheet_to_json(firstSheet, {
                    header: 1,
                    defval: "",
                    blankrows: false,
                    raw: false,
                });

                array.splice(0, 1);

                array.forEach((e) => {
                    this.array_correos.push({
                        id: "",
                        email: e[0],
                        nit: e[1],
                    });
                });
            };
            FR.readAsArrayBuffer(file);
        },

        async getOptionsNit() {
            this.options_empresa = [{ id: -1, nit: "Nuevo nit" }];

            this.empresas = await Empresa.select("id", "nit")
                .include("sedes")
                .get();

            this.empresas.forEach((e) => {
                this.options_empresa.push(e);
            });
        },

        async submit() {
            this.$v.$touch();
            if (!this.$v.convenio.$invalid) {
                this.$root.mostrarCargando("Guardando");

                if (this.datos.accion == "Crear") {
                    delete this.convenio["id"];
                }

                let convenio_creado = await this.convenio.save();
                let id_empresa = "";

                if (this.array_correos.length != 0) {
                    for (const e of this.array_correos) {
                        if (e.id_correo == "") {
                            if (e.id_empresa == "") {
                                this.empresa.nit = e.nit;
                                let empresa_creada = await this.empresa.save();
                                id_empresa = empresa_creada.id;
                            } else {
                                id_empresa = e.id_empresa;
                            }

                            let id_sede = "";

                            if (e.id_sede == -1) {
                                delete this.sede["id"];
                                this.sede.empresa_id = id_empresa;
                                this.sede.ciudad_id = e.ciudad_id;
                                this.sede.departamento_id = e.departamento_id;
                                this.sede.nombre = e.nombre_sede;
                                let sede_creada = await this.sede.save();
                                id_sede = sede_creada.id;
                            } else {
                                id_sede = e.id_sede;
                            }

                            this.convenio_email.email = e.email;
                            this.convenio_email.nit = e.nit;
                            this.convenio_email.convenio_id =
                                convenio_creado.id;
                            this.convenio_email.sede_id = id_sede;

                            await this.convenio_email.save();

                            axios
                                .post("/api/crearConvenioEmpresa", {
                                    convenio_id: convenio_creado.id,
                                    empresa_id: id_empresa,
                                })
                                .then((response) => {})
                                .catch((error) => {
                                    this.$root.mostrarMensaje(
                                        "error",
                                        "No se pudo asociar la empresa al convenio, por favor intentelo de nuevo",
                                        "error"
                                    );
                                });
                        }
                    }
                }

                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Guardado exitosamente",
                    "success"
                );
                this.$root.redirectIndex("/convenios");
            }
        },
        formularioNit() {
            this.limpiarFormSede();
            this.options_sede = [{ id: -1, nombre: "Nueva sede" }];
            if (this.nit != -1) {
                this.empresas.forEach((e, i) => {
                    if (e.id == this.nit) {
                        this.convenio_email.nit = e.nit;
                        this.empresas[i].sedes.forEach((es) => {
                            this.options_sede.push(es);
                        });
                    }
                });
            } else {
            }
        },

        async getSedeById() {
            this.sede.nombre = "";
            this.sede.departamento_id = "";
            this.sede.ciudad_id = "";

            if (this.sede.id != -1 && this.sede.id != null) {
                let sede = await EmpresaSede.include("empresa").find(
                    this.sede.id
                );
                this.sede.id = sede.id;
                this.sede.nombre = sede.nombre;
                this.sede.empresa_id = sede.empresa_id;
                this.sede.departamento_id = sede.departamento_id;
                this.getOptionsCiudad();
                this.sede.ciudad_id = sede.ciudad_id;
            }
        },
        resetFormsEmpresario() {
            this.nit = "";
            this.$v.nit.$reset();
            this.$v.convenio_email.$reset();
            this.$v.sede.$reset();
            this.limpiarFormSede();
            this.limpiarFormConveniEmail();
        },
        limpiarFormSede() {
            Object.keys(this.sede).forEach((key) => {
                this.sede[key] = "";
            });
        },
        limpiarFormConveniEmail() {
            Object.keys(this.convenio_email).forEach((key) => {
                this.convenio_email[key] = "";
            });
        },

        async submitEmpresario() {
            this.$v.$touch();
            if (!this.$v.convenio_email.$invalid && !this.$v.sede.$invalid) {
                let option_sede = this.options_sede.filter(
                    (el) => el.id === this.sede.id
                );

                let nombre_departamento = this.options_departamento.filter(
                    (el) => el.id === this.sede.departamento_id
                );

                let nombre_ciudad = this.options_ciudad.filter(
                    (el) => el.id === this.sede.ciudad_id
                );

                let id_empresa = "";

                if (this.nit != -1) {
                    this.empresas.forEach((e, i) => {
                        if (e.id == this.nit) {
                            id_empresa = e.id;
                        }
                    });
                }

                this.array_correos.push({
                    id_correo: "",
                    id_empresa: id_empresa,
                    email: this.convenio_email.email,
                    nit: this.convenio_email.nit,
                    id_sede: this.sede.id,
                    ciudad_id: this.sede.ciudad_id,
                    departamento_id: this.sede.departamento_id,
                    nombre_sede: this.sede.nombre,
                    nombre_departamento: nombre_departamento[0].nombre,
                    nombre_ciudad: nombre_ciudad[0].nombre,
                });
                this.$v.convenio.$reset();
                this.$refs.cerrarModalAgregarEmpresario.click();
            }
        },
        confirmarEliminacionCorreo(i) {
            if (this.array_correos[i].id_correo == "") {
                this.array_correos.splice(i, 1);
            } else {
                Swal.fire({
                    title: "Atención",
                    html: "¿Está seguro que desea desvincular este correo?",
                    icon: "question",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    confirmButtonText: "Si, desvincular",
                    confirmButtonColor: "rgb(48, 133, 214)",
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.eliminarCorreo(this.array_correos[i].id_correo);
                    }
                });
            }
        },

        async eliminarCorreo(id_convenio_email) {
            this.$root.mostrarCargando("Desviculando correo");
            let convenio_email = await ConvenioEmail.find(id_convenio_email);
            convenio_email.delete();
            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                "Correo desvinculado correctamente",
                "success"
            );
            setTimeout(() => {
                this.getConvenioById();
            }, 2000);
        },
    },
};
</script>
