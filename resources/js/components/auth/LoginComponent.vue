<template>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <h4>PLATAFORMA DE CÁLCULO DE HUELLA DE CARBONO</h4>
                    </div>
                    <form action="">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label"
                                    >Correo electrónico</label
                                >
                                <div class="input-group">
                                    <span
                                        class="input-group-text"
                                        id="inputGroupPrepend"
                                        ><i class="fa-solid fa-envelope"></i
                                    ></span>
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        required
                                        autocomplete="email"
                                        autofocus
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span
                                        class="input-group-text"
                                        id="inputGroupPrepend"
                                        ><i class="fa-solid fa-lock"></i
                                    ></span>
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button
                                    type="submit"
                                    class="btn btn-block btn-primary"
                                >
                                    Ingresar
                                </button>
                            </div>

                            <a class="btn btn-link" href="password/reset">
                                Olvidé mi contraseña
                            </a>
                        </div>

                        <div class="row mt-3 text-center">
                            <h5>¿No se ha registrado?</h5>

                            <a
                                href="register"
                                class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                                >Registrese aquí</a
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            correo: "",
            contrasena: "",
        };
    },

    methods: {
        submit() {},
    },
};
</script>
