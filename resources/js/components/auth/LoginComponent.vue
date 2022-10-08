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
                <label class="form-label">Correo electrónico</label>
                <div class="input-group">
                  <span class="input-group-text" id="inputGroupPrepend"
                    ><i class="fa-solid fa-envelope"></i
                  ></span>
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
            </div>
            <div class="row mb-3">
              <div class="col-md-12">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                  <span class="input-group-text" id="inputGroupPrepend"
                    ><i class="fa-solid fa-lock"></i
                  ></span>
                  <input
                    v-model="password"
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
                  @click="login"
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
import User from "../../models/User";
export default {
  data() {
    return {
      user: new User(),
      email: "",
      password: "",
    };
  },

  methods: {
    login() {
      axios
        .get(`/login`, emailData)
        .then((res) => {
          if (res.data.success) {
            Swal.fire("", res.data.message, "success");
            this.dialog = false;
          } else {
            Swal.fire("", res.data.message, "error");
          }
        })
        .catch((err) => {
          console.log("error");
          Swal.fire("", err, "error");
          //this.$message.error("Something went wrong!");
        })
        .finally((_) => {
          this.sendingEmail = false;
        });
      let userData = this.user
        .where("email", this.email)
        .where("password", this.password)
        .get();
      console.log(userData);
    },
  },
};
</script>
