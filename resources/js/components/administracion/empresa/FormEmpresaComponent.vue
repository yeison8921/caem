<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Actualizar empresa</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label required">Nombre</label>
                        <input
                            v-model.trim="form.nombre"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.nombre.$error,
                                'is-valid': !$v.form.nombre.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.nombre.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nit</label>
                        <input
                            v-model.trim="form.nit"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.nit.$error,
                                'is-valid': !$v.form.nit.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.nit.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Teléfono</label>
                        <input
                            v-model.trim="form.telefono"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.telefono.$error,
                                'is-valid': !$v.form.telefono.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.telefono.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Código CIIU</label>
                        <Multiselect
                            v-model.trim="form.codigo_ciiu_id"
                            :options="options_ciiu"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.form.codigo_ciiu_id.$error,
                                'is-valid':
                                    form.codigo_ciiu_id != ''
                                        ? !$v.form.codigo_ciiu_id.$invalid
                                        : '',
                            }"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Sector</label>
                        <Multiselect
                            v-model.trim="form.sector_id"
                            :options="options_sector"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.form.sector_id.$error,
                                'is-valid':
                                    form.sector_id != ''
                                        ? !$v.form.sector_id.$invalid
                                        : '',
                            }"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Empleados</label>
                        <Multiselect
                            v-model.trim="form.empleado_id"
                            :options="options_empleado"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.form.empleado_id.$error,
                                'is-valid':
                                    form.empleado_id != ''
                                        ? !$v.form.empleado_id.$invalid
                                        : '',
                            }"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Tamaño</label>
                        <Multiselect
                            v-model.trim="form.tamano_id"
                            :options="options_tamano"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.form.tamano_id.$error,
                                'is-valid':
                                    form.tamano_id != ''
                                        ? !$v.form.tamano_id.$invalid
                                        : '',
                            }"
                        />
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
    </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";
import Empresa from "../../../models/Empresa";
import Parametro from "../../../models/Parametro";

export default {
    data() {
        return {
            form: {},
            required: "Este campo es requerido",
            options_sector: [],
            options_ciiu: [],
            options_tamano: [],
            options_empleado: [],

            empresa: new Empresa({
                id: "",
                nombre: "",
                nit: "",
                telefono: "",
                codigo_ciiu_id: "",
                sector_id: "",
                empleado_id: "",
                tamano_id: "",
                usuario_actualizo_id: "",
            }),
        };
    },
    props: ["datos"],
    validations: {
        form: {
            nombre: {
                required,
            },
            nit: {
                required,
            },
            telefono: {
                required,
            },
            codigo_ciiu_id: {
                required,
            },
            sector_id: {
                required,
            },
            empleado_id: {
                required,
            },
            tamano_id: {
                required,
            },
            usuario_actualizo_id: {
                required,
            },
        },
    },
    mounted() {
        this.getOptionsParametros(3, "options_sector");
        this.getOptionsParametros(4, "options_ciiu");
        this.getOptionsParametros(5, "options_tamano");
        this.getOptionsParametros(6, "options_empleado");
        this.getEmpresaById();
    },
    methods: {
        async getOptionsParametros(tipo_parametro_id, variable) {
            //3 sectores
            //4 CIIUs
            //5 tamaños de empresa
            //6 número de empleados
            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },

        async getEmpresaById() {
            let empresa = await Empresa.find(this.datos.id_empresa).catch(
                (error) => {
                    this.$root.mostrarMensaje(
                        "error",
                        "No existe la empresa",
                        "error"
                    );
                    this.$root.redirectIndex("/empresas");
                }
            );
            this.form = empresa;
        },

        async submit() {
            this.$v.$touch();
            if (!this.$v.form.$invalid) {
                this.$root.mostrarCargando("Guardando");
                this.convenio = this.form;
                await this.convenio.save();
                Swal.close();

                this.$root.mostrarMensaje(
                    "Éxito",
                    "Guardado exitosamente",
                    "success"
                );

                this.$root.redirectIndex("/empresas");
            }
        },
    },
};
</script>
