<template>
  <div class="card">
    <div class="card-body">
      <v-app>
        <v-stepper v-model="paso">
          <v-stepper-header>
            <v-stepper-step :complete="paso > 1" step="1">
              Correo
            </v-stepper-step>
            <v-divider></v-divider>

            <v-stepper-step :complete="paso > 2" step="2">
              Datos generales
            </v-stepper-step>
            <v-divider></v-divider>

            <v-stepper-step step="3"> Datos empresa </v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">
              <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-envelope"></i
                  ></span>
                  <input
                    v-model.trim="$v.correo.$model"
                    type="email"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.correo.$error,
                      'is-valid': !$v.correo.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.correo.required">{{ required }}</span>
                    <span v-if="!$v.correo.email"
                      >Debe ingresar un correo valido</span
                    >
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Confirmar correo electrónico</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-envelope"></i
                  ></span>
                  <input
                    v-model.trim="$v.confirmar_correo.$model"
                    type="email"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.confirmar_correo.$error,
                      'is-valid':
                        correo != '' ? !$v.confirmar_correo.$invalid : '',
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.confirmar_correo.sameAsCorreo">
                      El correo electrónico no coincide</span
                    >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <v-btn color="error" @click="cancelar()"> Cancelar </v-btn>
                </div>
                <div class="col-lg-6 text-right">
                  <v-btn color="primary" @click="submit()"> Siguiente </v-btn>
                </div>
              </div>
            </v-stepper-content>

            <v-stepper-content step="2">
              <div class="mb-3">
                <label class="form-label">Nombres</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-n"></i
                  ></span>
                  <input
                    v-model.trim="$v.form.nombres.$model"
                    type="text"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.form.nombres.$error,
                      'is-valid': !$v.form.nombres.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.form.nombres.required">{{ required }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Apellidos</label>

                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-a"></i
                  ></span>
                  <input
                    v-model.trim="$v.form.apellidos.$model"
                    type="text"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.form.apellidos.$error,
                      'is-valid': !$v.form.apellidos.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.form.apellidos.required">{{
                      required
                    }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Celular</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-mobile"></i
                  ></span>
                  <input
                    v-model.trim="$v.form.celular.$model"
                    type="text"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.form.celular.$error,
                      'is-valid': !$v.form.celular.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.form.celular.required">{{ required }}</span>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-envelope"></i
                  ></span>
                  <input
                    v-model.trim="$v.form.correo.$model"
                    type="email"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.form.correo.$error,
                      'is-valid': !$v.form.correo.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.form.correo.required">{{ required }}</span>
                    <span v-if="!$v.form.correo.email"
                      >Debe ingresar un correo valido</span
                    >
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Confirmar correo electrónico</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-envelope"></i
                  ></span>
                  <input
                    v-model.trim="$v.form.confirmar_correo.$model"
                    type="email"
                    class="form-control"
                    autocomplete="new-text"
                    :class="{
                      'is-invalid': $v.form.confirmar_correo.$error,
                      'is-valid':
                        form.correo != ''
                          ? !$v.form.confirmar_correo.$invalid
                          : '',
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.form.confirmar_correo.sameAsCorreo">
                      El correo electrónico no coincide</span
                    >
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Contraseña</label>

                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-lock"></i
                  ></span>
                  <input
                    v-model.trim="$v.form.contrasena.$model"
                    type="password"
                    id="contrasena"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.form.contrasena.$error,
                      'is-valid': !$v.form.contrasena.$invalid,
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.form.contrasena.required">{{
                      required
                    }}</span>
                    <span v-if="!$v.form.contrasena.minLength"
                      >Mínimo 8 caracteres</span
                    >
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <div class="input-group">
                  <span class="input-group-text"
                    ><i class="fa-solid fa-lock"></i
                  ></span>
                  <input
                    v-model.trim="$v.form.confirmar_contrasena.$model"
                    type="password"
                    id="confirmar_contrasena"
                    class="form-control"
                    :class="{
                      'is-invalid': $v.form.confirmar_contrasena.$error,
                      'is-valid':
                        form.contrasena != ''
                          ? !$v.form.confirmar_contrasena.$invalid
                          : '',
                    }"
                  />
                  <div class="invalid-feedback">
                    <span v-if="!$v.form.confirmar_contrasena.sameAsContrasena">
                      La contraseña no coincide</span
                    >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <v-btn color="error" @click="cancelar()">Cancelar</v-btn>
                </div>
                <div class="col-lg-6 text-right">
                  <v-btn text @click="paso = 1">Atrás</v-btn>
                  <v-btn color="primary" @click="submit()">Siguiente</v-btn>
                </div>
              </div>
            </v-stepper-content>

            <v-stepper-content step="3">
              <div class="row">
                <div class="col-lg-6">
                  <v-btn color="error" @click="cancelar()">Cancelar</v-btn>
                </div>
                <div class="col-lg-6 text-right">
                  <v-btn text @click="paso = 2">Atrás</v-btn>
                  <v-btn color="primary" @click="submit()">Siguiente</v-btn>
                </div>
              </div>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-app>
    </div>
  </div>
</template>
<script>
import { required, email, sameAs, minLength } from "vuelidate/lib/validators";
import User from "../../models/User";

export default {
  data() {
    return {
      form: {
        nombres: "",
        apellidos: "",
        celular: "",
        correo: "",
        confirmar_correo: "",
        contrasena: "",
        confirmar_contrasena: "",
      },
      user: new User({
        name: "",
        password: "",
        email: "",
      }),
      correo: "",
      confirmar_correo: "",
      paso: 1,
      required: "Este campo es requerido",
    };
  },
  validations: {
    form: {
      nombres: {
        required,
      },
      apellidos: {
        required,
      },
      celular: {
        required,
      },
      correo: {
        required,
        email,
      },
      confirmar_correo: {
        required,
        sameAsCorreo: sameAs("correo"),
      },
      contrasena: {
        required,
        minLength: minLength(8),
      },
      confirmar_contrasena: {
        sameAsContrasena: sameAs("contrasena"),
      },
    },
    correo: {
      required,
      email,
    },
    confirmar_correo: {
      required,
      sameAsCorreo: sameAs("correo"),
    },
  },
  mounted() {
    //this.getUsers();
    /*
    this.user.name = "nombres";
    this.user.password = "contrasena";
    this.user.email = "javdo2@gmail.com";
    this.user.save();*/
  },
  methods: {
    async getUsers() {

      /* listas where users
      let usuarios = User.where("email", "javdo2@gmail.com");
      usuarios.orderBy("-id");
      //usuarios.include("carriers");
      //usuarios.append("quantity_origin_deliveries");
      let usuariosData = await usuarios.get();
      console.log(usuariosData);*/

        // find user
      let usuariosData = await User.append('last_name').find(2);
            console.log(usuariosData);
    },
    async submit() {
      this.$v.$touch();
      if (this.paso == 1) {
        if (!(this.$v.correo.$invalid || this.$v.confirmar_correo.$invalid)) {
          this.paso = 2;
          this.$v.$reset();
          alert("validar correo");
          this.form.correo = this.correo;
        }
      }
      if (this.paso == 2) {
        if (!this.$v.$invalid) {
          this.paso = 3;
        }
      }
      if (this.paso == 3) {
        if (!this.$v.$invalid) {
          this.user.name = this.form.nombres;
          this.user.password = this.form.contrasena;
          this.user.email = this.form.correo;
          await this.user.save();
          /**
           * llamar todos 
           * 
            this.usuarios = await User.get();
            this.usuario = await User.include("role")
            .append("quantity_invoiced")
            .find(id);
           */
        }
      }
    },
    // cancelar() {
    //     window.location.href = "login";
    // },
  },
};
</script>
