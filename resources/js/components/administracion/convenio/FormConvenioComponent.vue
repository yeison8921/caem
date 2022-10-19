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
                            v-model.trim="form.nombre_convenio"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.nombre_convenio.$error,
                                'is-valid': !$v.form.nombre_convenio.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.nombre_convenio.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Nombre de la entidad</label
                        >
                        <input
                            v-model.trim="form.nombre_entidad"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.nombre_entidad.$error,
                                'is-valid': !$v.form.nombre_entidad.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.nombre_entidad.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Código de validación</label
                        >
                        <input
                            v-model.trim="form.codigo"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.codigo.$error,
                                'is-valid': !$v.form.codigo.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.codigo.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Texto legal</label>
                        <textarea
                            v-model.trim="form.texto_legal"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.texto_legal.$error,
                                'is-valid': !$v.form.texto_legal.$invalid,
                            }"
                        >
                        </textarea>
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.texto_legal.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
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
                        <!-- <div class="form-inline mb-3">
                            <div class="form-group mx-sm-1">
                                <button
                                    class="btn btn-default"
                                    type="button"
                                    id="btn-cargar-archivo"
                                    @click="leerData"
                                >
                                    Cargar archivo
                                </button>
                            </div>
                        </div> -->
                    </div>
                    <div class="mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2">Correos</th>
                                    <th>NIT</th>
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
                                                ac.id == ''
                                                    ? 'bg-warning'
                                                    : 'bg-success'
                                            "
                                        >
                                            {{
                                                ac.id == ""
                                                    ? "Correo por agregar"
                                                    : "Correo en sistema"
                                            }}
                                        </span>
                                    </td>

                                    <td>{{ ac.nit }}</td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            title="Eliminar correo"
                                            @click="eliminarCorreo(i)"
                                            array_correos
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button
                            v-if="datos.accion == 'Actualizar'"
                            type="button"
                            class="btn btn-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#modal-agregar-empresario"
                            @click="$v.form_empresario.$reset()"
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
                            <div
                                v-for="(v, i) in $v.form_empresario.$each.$iter"
                                v-bind:key="i"
                            >
                                <div class="mb-3">
                                    <label class="form-label required"
                                        >Correo</label
                                    >
                                    <input
                                        v-model.trim="v.email.$model"
                                        type="text"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': v.email.$error,
                                            'is-valid': !v.email.$invalid,
                                        }"
                                    />
                                    <div class="invalid-feedback">
                                        <span v-if="!v.email.required">{{
                                            required
                                        }}</span>
                                        <span v-if="!v.email.email"
                                            >Debe ingresar un correo
                                            valido</span
                                        >
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required"
                                        >Nit</label
                                    >
                                    <input
                                        v-model.trim="v.nit.$model"
                                        type="text"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': v.nit.$error,
                                            'is-valid': !v.nit.$invalid,
                                        }"
                                    />
                                    <div class="invalid-feedback">
                                        <span v-if="!v.nit.required">{{
                                            required
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                                ref="cerrarModalAgregarBeneficiario"
                            >
                                Cerrar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Guardar
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

export default {
    data() {
        return {
            form: {
                id: "",
                nombre_convenio: "",
                nombre_entidad: "",
                codigo: "",
                texto_legal: "",
            },
            required: "Este campo es requerido",
            form_empresario: [{ email: "", nit: "" }],
            array_correos: "",
            convenio: new Convenio({
                id: "",
                nombre_convenio: "",
                nombre_entidad: "",
                codigo: "",
                texto_legal: "",
                usuario_actualizo_id: "",
            }),
        };
    },
    props: ["datos"],
    validations: {
        form: {
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

        form_empresario: {
            required,

            $each: {
                email: {
                    required,
                    email,
                },
                nit: {
                    required,
                },
            },
        },
    },
    mounted() {
        // this.getNombreTipoParametro();
        // this.getOptionsParametros(1, "options_departamento");
        // this.form.tipo_parametro_id = this.datos.tipo_parametro_id;
        if (this.datos.accion == "Actualizar") {
            this.getConvenioById();
        }
    },
    methods: {
        // async getNombreTipoParametro() {
        //     this.tipo_parametro = await TipoParametro.find(
        //         this.datos.tipo_parametro_id
        //     );
        // },
        async getConvenioById() {
            let convenio = await Convenio.include("emails").find(
                this.datos.id_convenio
            );

            this.form.id = convenio.id;
            this.form.nombre_convenio = convenio.nombre_convenio;
            this.form.nombre_entidad = convenio.nombre_entidad;
            this.form.codigo = convenio.codigo;
            this.form.texto_legal = convenio.texto_legal;

            this.array_correos = convenio.emails;
            // this.form = await Convenio.include("emails").find(
            //     this.datos.id_convenio
            // );
        },
        // async getOptionsParametros(tipo_parametro_id, variable) {
        //     //1 departamentos
        //     this[variable] = await Parametro.where(
        //         "tipo_parametro_id",
        //         tipo_parametro_id
        //     ).get();
        // },

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

        async submit() {
            this.$v.$touch();
            if (!this.$v.form.$invalid) {
                let convenio_id;
                this.convenio.nombre_convenio = this.form.nombre_convenio;
                this.convenio.nombre_entidad = this.form.nombre_entidad;
                this.convenio.codigo = this.form.codigo;
                this.convenio.texto_legal = this.form.texto_legal;
                this.convenio.usuario_actualizo_id = 1;

                if (this.datos.accion == "Actualizar") {
                    this.convenio.id = this.form.id;
                }

                let convenio_creado = await this.convenio.save();

                if (this.array_correos.length != 0) {
                    convenio_id =
                        this.datos.accion == "Actualizar"
                            ? this.datos.id_convenio
                            : convenio_creado.id;

                    await axios
                        .post("/api/agregarCorreosConvenio", {
                            convenio_id: convenio_id,
                            array_correos: this.array_correos,
                        })
                        .then((response) => {});
                }

                setTimeout(() => {
                    window.location.href = "/convenios";
                }, 2000);
            }
        },
        async submitEmpresario() {
            this.$root.mostrarCargando("Guardando empresario");
            this.$v.$touch();
            if (!this.$v.form_empresario.$invalid) {
                await axios
                    .post("/api/agregarCorreosConvenio", {
                        convenio_id: this.datos.id_convenio,
                        array_correos: this.form_empresario,
                    })
                    .then((response) => {
                        Swal.close();
                        this.$root.mostrarMensaje(
                            "Éxito",
                            "Empresario agregado correctamente",
                            "success"
                        );
                        this.$refs.cerrarModalAgregarBeneficiario.click();
                        setTimeout(() => {
                            this.getConvenioById();
                        }, 2000);
                    });
            }
        },
        eliminarCorreo(i) {
            if (this.array_correos[i].id == "") {
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
                        this.$root.mostrarCargando("Desviculando correo");
                        axios
                            .get(
                                "/api/eliminarCorreo/" +
                                    this.array_correos[i].id
                            )
                            .then((response) => {
                                Swal.close();
                                this.$root.mostrarMensaje(
                                    "Éxito",
                                    "Correo desvinculado correctamente",
                                    "success"
                                );
                                setTimeout(() => {
                                    this.getConvenioById();
                                }, 2000);
                            });
                    }
                });
            }
        },
    },
};
</script>
