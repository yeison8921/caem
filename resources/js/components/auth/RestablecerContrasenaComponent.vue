<template>
    <div class="col-lg-6 offset-lg-3">
        <div class="row">
            <div class="form-group">
                <br />
                <h2>Restablecer contraseña</h2>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form @submit.prevent="sendNewPassword()">
                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-3">
                            <label>Correo electrónico</label>
                            <input
                                v-model="email"
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

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Enviar
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
export default {
    data() {
        return {
            email: "",
        };
    },
    methods: {
        sendNewPassword() {
            this.$root.mostrarCargando("Validando correo electrónico");
            axios
                .post("/api/sendNewPassword", {
                    email: this.email,
                })
                .then((response) => {
                    Swal.close();
                    this.$root.mostrarMensaje(
                        "Éxito",
                        "Se ha generado y enviado una nueva contraseña, por favor revise su correo electrónico",
                        "success",
                        3000
                    );
                    this.email = "";
                })
                .catch((error) => {
                    setTimeout(() => {
                        this.$root.mostrarMensaje(
                            "Error",
                            "No se encontró el correo electrónico solicitado, por favor confirme que haya quedado bien escrito y vuelva a intentarlo",
                            "error",
                            3000
                        );
                    }, 500);
                });
        },
    },
};
</script>
