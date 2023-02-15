<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>{{ datos.accion }} usuario</h2>
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
                <div class="mb-3" v-if="datos.accion == 'Crear'">
                    <label class="form-label required">Contraseña</label>
                    <input
                        v-model.trim="user.password"
                        type="password"
                        id="contrasena"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.password.$error,
                            'is-valid': !$v.user.password.$invalid,
                        }"
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.password.required">{{
                            required
                        }}</span>
                        <span v-if="!$v.user.password.minLength"
                            >Mínimo 8 caracteres</span
                        >
                    </div>
                </div>
                <div class="mb-3" v-if="datos.accion == 'Crear'">
                    <label class="form-label required"
                        >Confirmar contraseña</label
                    >
                    <input
                        v-model.trim="user.verify_password"
                        type="password"
                        id="verify_password"
                        class="form-control"
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

                <div class="mb-3" v-if="datos.accion == 'Actualizar'">
                    <label class="form-label">Rol</label>
                    <input
                        class="form-control"
                        type="text"
                        :value="user.rol.nombre"
                        disabled
                    />
                </div>
                <div class="mb-3" v-else>
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
} from "vuelidate/lib/validators";
import User from "../../../models/User";

export default {
    data() {
        return {
            user: new User({}),
            options_rol: [
                { value: 1, label: "Administrador" },
                { value: 3, label: "Lider caem" },
            ],
            required: "Este campo es requerido",
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
            password: {
                required,
                minLength: minLength(8),
            },
            verify_password: {
                required,
                sameAsPassword: sameAs("password"),
            },
        },
    },
    props: ["datos"],
    mounted() {
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
        async submit() {
            this.$v.$touch();

            if (
                this.datos.accion == "Actualizar" &&
                !this.$v.user.email.$invalid &&
                !this.$v.user.first_name.$invalid &&
                !this.$v.user.last_name.$invalid &&
                !this.$v.user.phone.$invalid
            ) {
                this.$root.mostrarCargando("Guardando");
                this.user.save();
            } else {
                if (!this.$v.user.$invalid) {
                    this.$root.mostrarCargando("Guardando");
                    this.user.save();
                }
            }
            Swal.close();
            this.$root.mostrarMensaje(
                "Éxito",
                "Usuario guardado exitosamente",
                "success"
            );
            this.$root.redirectIndex("/usuarios");
        },
    },
};
</script>
