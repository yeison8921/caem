<template>
    <div>
        <div class="container top-0 position-sticky z-index-sticky">
            <div class="row">
                <div class="col-12">
                    <navbar-component
                        is-blur="blur blur-rounded my-3 py-2 start-0 end-0 mx-4 shadow"
                        btn-background="bg-gradient-success"
                        :dark-mode="true"
                    />
                </div>
            </div>
        </div>
        <main class="mt-0 main-content main-content-bg">
            <section>
                <div class="page-header min-vh-75">
                    <div class="container">
                        <div class="row">
                            <div
                                class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column"
                            >
                                <div class="mt-8 card card-plain">
                                    <div class="pb-0 card-header text-start">
                                        <h3
                                            class="font-weight-bolder text-success text-gradient"
                                        >
                                            Bienvenido de nuevo
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" class="text-start">
                                            <label>Correo electrónico</label>
                                            <input
                                                id="email"
                                                type="email"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid': errors.email,
                                                }"
                                                name="email"
                                                required
                                                autocomplete="email"
                                                autofocus
                                                v-model="data.email"
                                            />
                                            <label>Contraseña</label>
                                            <input
                                                id="password"
                                                type="password"
                                                class="form-control"
                                                :class="{
                                                    'is-invalid':
                                                        errors.password,
                                                }"
                                                name="password"
                                                required
                                                autocomplete="password"
                                                autofocus
                                                v-model="data.password"
                                            />
                                            <div class="text-center">
                                                <soft-button
                                                    class="my-4 mb-2"
                                                    variant="gradient"
                                                    color="success"
                                                    full-width
                                                    @clickBtn="login"
                                                    >Inicia sesión
                                                </soft-button>
                                            </div>
                                        </form>
                                    </div>
                                    <div
                                        class="px-1 pt-0 text-center card-footer px-lg-2"
                                    >
                                        <p class="mx-auto mb-4 text-sm">
                                            ¿No tienes una cuenta?
                                            <a
                                                href="/register"
                                                class="text-success text-gradient font-weight-bold"
                                                >Registro</a
                                            >
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div
                                    class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8"
                                >
                                    <div
                                        class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                        :style="{
                                            backgroundImage:
                                                'url(' +
                                                require('/images/Carbontest - bg.png') +
                                                ')',
                                        }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>

<script>
import NavbarComponent from "../pageLayout/Navbar.vue";
import SoftInput from "../SoftInput.vue";
import SoftSwitch from "../SoftSwitch.vue";
import SoftButton from "../SoftButton.vue";
const body = document.getElementsByTagName("body")[0];

export default {
    name: "SigninCover",
    components: {
        NavbarComponent,
        SoftInput,
        SoftSwitch,
        SoftButton,
    },
    data() {
        return {
            data: {
                email: "",
                password: "",
                device_name: "browser",
            },
            errors: { email: false, password: false },
            isLogged: false,
        };
    },
    methods: {
        async login() {
            this.errors.email = false;
            this.errors.password = false;
            if (this.data.email.trim() == "") {
                this.errors.email = true;
                Swal.fire({
                    icon: "error",
                    text: "El campo de correo es requerido",
                });
                return;
            }
            if (this.data.password.trim() == "") {
                this.errors.password = true;
                Swal.fire({
                    icon: "error",
                    text: "El campo de contraseña es requerido",
                });
                return;
            }
            this.$root.mostrarCargando();
            axios
                .post("/api/login", this.data)
                .then((response) => {
                    localStorage.setItem("token", response.data.token);
                    localStorage.setItem("user", response.data.user);
                    this.$root.redirectIndex("/");
                    this.$root.cerrarCargando();
                })
                .catch((error) => {
                    this.$root.mostrarMensaje(
                        "error",
                        "No se pudo iniciar sesión, por favor intentelo de nuevo",
                        "error"
                    );
                });
        },
    },
    created() {
        body.classList.remove("bg-gray-100");
    },
    beforeUnmount() {
        body.classList.add("bg-gray-100");
    },
};
</script>
