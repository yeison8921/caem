<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h4>{{ datos.accion }} usuario</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3" v-if="datos.accion == 'Actualizar'">
                    <label class="form-label">Correo electrónico</label>
                    <input
                        :value="user.email"
                        type="text"
                        class="form-control"
                        disabled
                    />
                </div>
                <div class="mb-3" v-else>
                    <label class="form-label required"
                        >Correo electrónico</label
                    >
                    <input
                        v-model.trim="user.email"
                        type="text"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.email.$error,
                            'is-valid': !$v.user.email.$invalid,
                        }"
                        required
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.email.required">{{
                            required
                        }}</span>
                        <span v-if="!$v.user.email.email"
                            >Debe ingresar un correo valido</span
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Nombres</label>
                    <input
                        v-model.trim="user.first_name"
                        type="text"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.first_name.$error,
                            'is-valid': !$v.user.first_name.$invalid,
                        }"
                        required
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.first_name.required">{{
                            required
                        }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Apellidos</label>
                    <input
                        v-model.trim="user.last_name"
                        type="text"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.last_name.$error,
                            'is-valid': !$v.user.last_name.$invalid,
                        }"
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.last_name.required">{{
                            required
                        }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Celular</label>
                    <input
                        v-model.trim="user.phone"
                        type="number"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.phone.$error,
                            'is-valid': !$v.user.phone.$invalid,
                        }"
                        required
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.phone.required">{{
                            required
                        }}</span>
                        <span
                            v-if="
                                !$v.user.phone.minLength ||
                                !$v.user.phone.maxLength
                            "
                        >
                            El número de celular debe contener 10 dígitos</span
                        >
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <Multiselect
                        v-model.trim="user.rol_id"
                        :options="options_rol"
                        placeholder="Seleccione una opción"
                        :class="{
                            'is-invalid': $v.user.rol_id.$error,
                            'is-valid': !$v.user.rol_id.$invalid,
                        }"
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.rol_id.required">{{
                            required
                        }}</span>
                    </div>
                </div>

                <div class="mb-3" v-if="user.rol_id == 4">
                    <label class="form-label">Convenio</label>
                    <Multiselect
                        v-model.trim="user.convenio_id"
                        valueProp="id"
                        label="nombre_convenio"
                        :options="options_convenio"
                        placeholder="Seleccione una opción"
                        :class="{
                            'is-invalid': $v.user.convenio_id.$error,
                            'is-valid': !$v.user.convenio_id.$invalid,
                        }"
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.convenio_id.required">{{
                            required
                        }}</span>
                    </div>
                </div>

                <div class="mb-3" v-if="datos.accion != 'Crear'">
                    <br />
                    <div
                        class="form-check form-switch d-flex justify-content-end"
                    >
                        <input
                            class="form-check-input"
                            type="checkbox"
                            role="switch"
                            id="restablecer-contrasena"
                            v-model="restablecer_contrasena"
                        />
                        <label
                            class="form-check-label"
                            for="restablecer-contrasena"
                        >
                            Restablecer contraseña</label
                        >
                    </div>
                </div>

                <template
                    v-if="datos.accion == 'Crear' || restablecer_contrasena"
                >
                    <div class="mb-3">
                        <label class="form-label required">Contraseña</label>
                        <div class="input-group">
                            <input
                                v-model.trim="user.password"
                                type="password"
                                id="contrasena"
                                class="form-control contrasena"
                                :class="{
                                    'is-invalid': $v.user.password.$error,
                                    'is-valid': !$v.user.password.$invalid,
                                }"
                            />
                            <span
                                class="input-group-text"
                                @click="showPassword()"
                                ><i
                                    class="fa-solid fa-eye"
                                    id="ver-contrasena"
                                ></i
                            ></span>
                            <div class="invalid-feedback">
                                <span v-if="!$v.user.password.required">{{
                                    required
                                }}</span>
                                <span v-if="!$v.user.password.minLength"
                                    >Mínimo 8 caracteres</span
                                >
                                <span
                                    v-if="
                                        !$v.user.password.passwordValidator.test
                                    "
                                    >La contraseña debe incluir como mínimo una
                                    mayúscula, una minúscula, un número y
                                    carácter especial</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Confirmar contraseña</label
                        >
                        <input
                            v-model.trim="user.verify_password"
                            type="password"
                            id="verify_password"
                            class="form-control contrasena"
                            :class="{
                                'is-invalid': $v.user.verify_password.$error,
                                'is-valid':
                                    user.password != ''
                                        ? !$v.user.verify_password.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.user.verify_password.required">
                                La contraseña no coincide</span
                            >
                        </div>
                    </div>
                </template>

                <div class="mb-3">
                    <div class="col-lg-4 offset-lg-4">
                        <div class="d-grid gap-2">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="submit()"
                            >
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    required,
    email,
    sameAs,
    minLength,
    maxLength,
    requiredIf,
    helpers,
} from "vuelidate/lib/validators";
const passwordValidator = helpers.regex(
    "passwordValidator",
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&/])[A-Za-z\d@$!%*?&/]{8,}$/
);

import User from "../../../models/User";
import Convenio from "../../../models/Convenio";

export default {
    data() {
        return {
            user: new User({}),
            options_rol: [
                { value: 1, label: "Administrador" },
                { value: 3, label: "Lider caem" },
                { value: 4, label: "Lider convenio" },
            ],
            options_convenio: [],
            required: "Este campo es requerido",
            restablecer_contrasena: false,
        };
    },
    validations: {
        user: {
            first_name: {
                required,
            },
            last_name: {
                required,
            },
            phone: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(10),
            },
            email: {
                email,
                required,
            },
            rol_id: {
                required,
            },
            convenio_id: {
                required: requiredIf(function () {
                    return this.user.rol_id == 4;
                }),
            },
            password: {
                required: requiredIf(function () {
                    return (
                        this.datos.accion == "Crear" ||
                        this.restablecer_contrasena
                    );
                }),
                minLength: minLength(8),
                passwordValidator,
            },
            verify_password: {
                sameAsPassword: sameAs("password"),
            },
        },
    },
    props: ["datos"],
    mounted() {
        this.getConvenios();
        if (this.datos.accion == "Actualizar") {
            this.getUserById();
        }
    },
    methods: {
        async getUserById() {
            this.user = await User.include(
                "rol",
                "empresa",
                "empresaSede"
            ).find(this.datos.id_usuario);
        },
        async getConvenios() {
            this.options_convenio = await Convenio.get();
        },
        async submit() {
            this.$v.$touch();

            if (!this.$v.$invalid) {
                this.$root.mostrarCargando("Guardando");
                if (this.datos.accion == "Crear") {
                    this.user.estado = 1;
                }
                this.user.save();
                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Usuario guardado exitosamente",
                    "success"
                );
                this.$root.redirectIndex("/usuarios");
            }
        },
        showPassword() {
            var fields = document.getElementsByClassName("contrasena");
            for (var i = 0; i < fields.length; i++) {
                const type =
                    fields.item(i).type === "password" ? "text" : "password";
                fields.item(i).setAttribute("type", type);
            }
            var icon = document.getElementById("ver-contrasena");

            if (icon.classList.contains("fa-eye")) {
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        },
    },
};
</script>
