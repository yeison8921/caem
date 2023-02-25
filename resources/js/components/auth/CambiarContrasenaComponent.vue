<template>
    <div class="col-lg-12">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Cambiar contraseña</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <div class="col-md-4 offset-md-4">
                        <label>Contraseña actual</label>
                        <div class="input-group">
                            <input
                                v-model="contrasena_actual"
                                type="password"
                                class="form-control contrasena"
                                required
                                @change="checkContrasenaActual()"
                            />
                            <span
                                class="input-group-text"
                                @click="showPassword()"
                                ><i
                                    class="fa-solid fa-eye"
                                    id="ver-contrasena"
                                ></i
                            ></span>
                        </div>
                    </div>
                    <div class="col-md-4 offset-lg-4">
                        <label>Nueva contraseña</label>
                        <input
                            v-model="$v.password.$model"
                            type="password"
                            class="form-control contrasena"
                            required
                            :class="{
                                'is-invalid': $v.password.$error,
                                'is-valid': !$v.password.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.password.required">{{
                                required
                            }}</span>
                            <span v-if="!$v.password.minLength"
                                >Mínimo 8 caracteres</span
                            >
                            <span v-if="!$v.password.passwordValidator.test"
                                >La contraseña debe incluir como mínimo una
                                mayúscula, una minúscula, un número y carácter
                                especial</span
                            >
                        </div>
                    </div>
                    <div class="col-md-4 offset-lg-4">
                        <label>Confirmar nueva contraseña</label>
                        <input
                            v-model="$v.verify_password.$model"
                            type="password"
                            class="form-control contrasena"
                            required
                            :class="{
                                'is-invalid': $v.verify_password.$error,
                                'is-valid':
                                    password != ''
                                        ? !$v.verify_password.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.verify_password.required">
                                La contraseña no coincide</span
                            >
                        </div>
                    </div>
                </div>

                <div class="col-md-4 offset-md-4">
                    <div class="d-grid gap-2">
                        <button
                            type="button"
                            class="btn"
                            :class="
                                !check_contrasena_actual
                                    ? 'btn-danger'
                                    : 'btn-primary'
                            "
                            :disabled="!check_contrasena_actual"
                            @click="submit()"
                        >
                            Cambiar contraseña
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { required, minLength, sameAs, helpers } from "vuelidate/lib/validators";
const passwordValidator = helpers.regex(
    "passwordValidator",
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
);
export default {
    data() {
        return {
            contrasena_actual: "",
            check_contrasena_actual: false,
            password: "",
            verify_password: "",
            email: "",
            required: "Este campo es requerido",
        };
    },
    validations: {
        password: {
            required,
            minLength: minLength(8),
            passwordValidator,
        },
        verify_password: {
            required,
            sameAsPassword: sameAs("password"),
        },
    },
    mounted() {
        this.getUserLogged();
    },
    methods: {
        async getUserLogged() {
            await axios
                .get("api/user")
                .then((response) => {
                    this.email = response.data.email;
                })
                .catch((error) => {});
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
        checkContrasenaActual() {
            this.$root.mostrarCargando("Validando contraseña");
            axios
                .post("/api/checkContrasenaActual", {
                    email: this.email,
                    password: this.contrasena_actual,
                })
                .then((response) => {
                    this.check_contrasena_actual = true;
                    Swal.close();
                })
                .catch((error) => {
                    this.check_contrasena_actual = false;
                    setTimeout(() => {
                        this.$root.mostrarMensaje(
                            "Error",
                            "La contraseña actual es incorrecta",
                            "error"
                        );
                    }, 300);
                });
        },
        async submit() {
            if (this.check_contrasena_actual) {
                this.$v.$touch();
                if (!this.$v.$invalid) {
                    this.$root.mostrarCargando("Actualizando contraseña");
                    axios
                        .post("/api/actualizarContrasena", {
                            email: this.email,
                            password: this.password,
                        })
                        .then((response) => {
                            this.$root.mostrarMensaje(
                                "Éxito",
                                "Contraseña actualizada correctamente",
                                "success"
                            );
                            setTimeout(() => {
                                this.$root.redirectIndex("/cambiar-contrasena");
                            }, 300);
                        })
                        .catch((error) => {
                            setTimeout(() => {
                                this.$root.mostrarMensaje(
                                    "Error",
                                    "No se pudo actualizar la contraseña, por favor intentelo de nuevo",
                                    "error"
                                );
                            }, 300);
                        });
                }
            }
        },
    },
};
</script>
