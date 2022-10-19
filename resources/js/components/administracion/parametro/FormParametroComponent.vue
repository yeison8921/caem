<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} {{ tipo_parametro.nombre }}</h2>
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
                    <!-- <div class="mb-3">
                <label class="form-label required">Valor</label>
                <input
                    v-model.trim="form.valor"
                    type="text"
                    class="form-control"
                    :class="{
                        'is-invalid': $v.form.valor.$error,
                        'is-valid': !$v.form.valor.$invalid,
                    }"
                />
                <div class="invalid-feedback">
                    <span v-if="!$v.form.valor.required">{{ required }}</span>
                </div>
            </div> -->
                    <div class="mb-3" v-if="datos.tipo_parametro_id == 2">
                        <label class="form-label required">Departamento</label>
                        <Multiselect
                            v-model.trim="form.parametro_id"
                            :options="options_departamento"
                            :searchable="true"
                            placeholder="Seleccione una opción"
                            valueProp="id"
                            label="nombre"
                            :class="{
                                'is-invalid': $v.form.parametro_id.$error,
                                'is-valid':
                                    form.parametro_id != ''
                                        ? !$v.form.parametro_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form.parametro_id.required">
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
import { required, requiredIf } from "vuelidate/lib/validators";
import Parametro from "../../../models/Parametro";
import TipoParametro from "../../../models/TipoParametro";

export default {
    data() {
        return {
            form: {
                id: "",
                nombre: "",
                //valor: "",
                tipo_parametro_id: "",
                parametro_id: "",
            },
            parametro: new Parametro({
                id: "",
                nombre: "",
                tipo_parametro_id: "",
                parametro_id: "",
            }),
            tipo_parametro: "",
            options_departamento: [],
            required: "Este campo es requerido",
        };
    },
    props: ["datos"],
    validations: {
        form: {
            nombre: {
                required,
            },
            // valor: {
            //     required,
            // },
            tipo_parametro_id: {
                required,
            },

            parametro_id: {
                required: requiredIf(function (value, vm) {
                    return this.datos.tipo_parametro_id == 2;
                }),
            },
        },
    },
    mounted() {
        this.getNombreTipoParametro();
        this.getOptionsParametros(1, "options_departamento");
        this.form.tipo_parametro_id = this.datos.tipo_parametro_id;
        if (this.datos.accion == "Actualizar") {
            this.getParametro();
        }
    },
    methods: {
        async getNombreTipoParametro() {
            this.tipo_parametro = await TipoParametro.find(
                this.datos.tipo_parametro_id
            );
        },
        async getParametro() {
            this.form = await Parametro.find(this.datos.id_parametro);
        },
        async getOptionsParametros(tipo_parametro_id, variable) {
            //1 departamentos
            this[variable] = await Parametro.where(
                "tipo_parametro_id",
                tipo_parametro_id
            ).get();
        },
        async submit() {
            this.$v.$touch();
            if (!this.$v.form.$invalid) {
                this.parametro.nombre = this.form.nombre;
                this.parametro.tipo_parametro_id = this.form.tipo_parametro_id;

                if (this.datos.tipo_parametro_id == 2) {
                    this.parametro.parametro_id = this.form.parametro_id;
                }

                if (this.datos.accion == "Actualizar") {
                    this.parametro.id = this.form.id;
                }

                await this.parametro.save();

                setTimeout(() => {
                    window.location.href = "/parametros";
                }, 2000);
            }
        },
    },
};
</script>
