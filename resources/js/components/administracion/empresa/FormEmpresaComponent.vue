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
                            v-model.trim="empresa.nombre"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.empresa.nombre.$error,
                                'is-valid': !$v.empresa.nombre.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.nombre.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nit</label>
                        <input
                            v-model.trim="empresa.nit"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.empresa.nit.$error,
                                'is-valid': !$v.empresa.nit.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.nit.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Teléfono</label>
                        <input
                            v-model.trim="empresa.telefono"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.empresa.telefono.$error,
                                'is-valid': !$v.empresa.telefono.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.telefono.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Código CIIU</label>
                        <Multiselect
                            v-model.trim="empresa.codigo_ciiu_id"
                            :options="options_ciiu"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.empresa.codigo_ciiu_id.$error,
                                'is-valid':
                                    empresa.codigo_ciiu_id != ''
                                        ? !$v.empresa.codigo_ciiu_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.codigo_ciiu_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Sector</label>
                        <Multiselect
                            v-model.trim="empresa.sector_id"
                            :options="options_sector"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.empresa.sector_id.$error,
                                'is-valid':
                                    empresa.sector_id != ''
                                        ? !$v.empresa.sector_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.sector_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Empleados</label>
                        <Multiselect
                            v-model.trim="empresa.empleado_id"
                            :options="options_empleado"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.empresa.empleado_id.$error,
                                'is-valid':
                                    empresa.empleado_id != ''
                                        ? !$v.empresa.empleado_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.empleado_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Tamaño</label>
                        <Multiselect
                            v-model.trim="empresa.tamano_id"
                            :options="options_tamano"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.empresa.tamano_id.$error,
                                'is-valid':
                                    empresa.tamano_id != ''
                                        ? !$v.empresa.tamano_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.empresa.tamano_id.required">
                                {{ required }}</span
                            >
                        </div>
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
        empresa: {
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
            // usuario_actualizo_id: {
            //     required,
            // },
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
            this.empresa = await Empresa.find(this.datos.id_empresa).catch(
                (error) => {
                    this.$root.mostrarMensaje(
                        "error",
                        "No existe la empresa",
                        "error"
                    );
                    this.$root.redirectIndex("/empresas");
                }
            );
        },

        async submit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.$root.mostrarCargando("Guardando");
                await this.empresa.save();
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
