<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>{{ datos.accion }} sede</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="mb-3">
                        <label class="form-label">Empresa</label>
                        <p>{{ nombre_empresa }}</p>
                    </div>
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
                        <label class="form-label required">Departamento</label>
                        <Multiselect
                            v-model.trim="form.departamento_id"
                            :options="options_departamento"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            @input="getOptionsCiudad()"
                            :class="{
                                'is-invalid': $v.form.departamento_id.$error,
                                'is-valid':
                                    form.departamento_id != ''
                                        ? !$v.form.departamento_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.departamento_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Ciudad o municipio</label
                        >
                        <Multiselect
                            v-model.trim="form.ciudad_id"
                            :options="options_ciudad"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :searchable="true"
                            :class="{
                                'is-invalid': $v.form.ciudad_id.$error,
                                'is-valid':
                                    form.ciudad_id != ''
                                        ? !$v.form.ciudad_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.ciudad_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Dirección</label>
                        <input
                            v-model.trim="form.direccion"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form.direccion.$error,
                                'is-valid': !$v.form.direccion.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.direccion.required">{{
                                required
                            }}</span>
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
import EmpresaSede from "../../../models/EmpresaSede";
import Parametro from "../../../models/Parametro";

export default {
    data() {
        return {
            form: {
                id: "",
                nombre: "",
                empresa_id: "",
                departamento_id: "",
                ciudad_id: "",
                direccion: "",
            },
            nombre_empresa: "",
            required: "Este campo es requerido",
            options_departamento: [],
            options_ciudad: [],

            empresa_sede: new EmpresaSede({
                id: "",
                nombre: "",
                empresa_id: "",
                departamento_id: "",
                ciudad_id: "",
                direccion: "",
            }),
        };
    },
    props: ["datos"],
    validations: {
        form: {
            nombre: {
                required,
            },
            departamento_id: {
                required,
            },
            ciudad_id: {
                required,
            },
            direccion: {
                required,
            },
        },
    },
    mounted() {
        this.getOptionsParametros(1, "options_departamento");
        this.getOptionsParametros(2, "options_ciudad");
        if (this.datos.accion == "Crear") {
            this.getEmpresaById();
        } else {
            this.getSedeById();
        }
    },
    methods: {
        async getOptionsParametros(tipo_parametro_id, variable) {
            //1 departamento
            //4 ciudad
            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },

        async getOptionsCiudad() {
            this.options_ciudad = [];
            if (
                this.form.departamento_id != "" &&
                this.form.departamento_id != null
            ) {
                this.form.ciudad_id = "";

                this.options_ciudad = await Parametro.where(
                    "parametro_id",
                    this.form.departamento_id
                ).get();
            }
        },

        async getSedeById() {
            let sede = await EmpresaSede.include("empresa")
                .find(this.datos.id_sede)
                .catch((error) => {
                    this.$root.mostrarMensaje(
                        "error",
                        "No existe la sede",
                        "error"
                    );
                    this.$root.redirectIndex("/sedes");
                });

            this.form.id = sede.id;
            this.form.nombre = sede.nombre;
            this.form.empresa_id = sede.empresa_id;
            this.form.departamento_id = sede.departamento_id;
            this.form.ciudad_id = sede.ciudad_id;
            this.form.direccion = sede.direccion;
            this.nombre_empresa = sede.empresa.nombre;
        },

        async getEmpresaById() {
            let empresa = await Empresa.find(this.datos.empresa_id).catch(
                (error) => {
                    this.$root.mostrarMensaje(
                        "error",
                        "No existe la empresa",
                        "error"
                    );
                    this.$root.redirectIndex("/sedes");
                }
            );
            this.nombre_empresa = empresa.nombre;
            this.form.empresa_id = empresa.id;
        },

        async submit() {
            this.$v.$touch();
            if (!this.$v.form.$invalid) {
                this.$root.mostrarCargando("Guardando");
                if (this.datos.accion == "Actualizar") {
                    this.empresa_sede.id = this.form.id;
                }
                this.empresa_sede.nombre = this.form.nombre;
                this.empresa_sede.empresa_id = this.form.empresa_id;
                this.empresa_sede.departamento_id = this.form.departamento_id;
                this.empresa_sede.ciudad_id = this.form.ciudad_id;
                this.empresa_sede.direccion = this.form.direccion;
                await this.empresa_sede.save();

                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Guardado exitosamente",
                    "success"
                );

                this.$root.redirectIndex("/sedes");
            }
        },
    },
};
</script>
