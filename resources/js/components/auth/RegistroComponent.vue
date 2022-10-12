<template>
    <div class="card">
        <div class="card-body">
            <ul
                class="nav nav-pills nav-fill mb-3"
                id="pills-tab"
                role="tablist"
            >
                <li class="nav-item" role="presentation">
                    <span
                        class="badge rounded-pill"
                        :class="
                            paso == 1 ? 'active bg-primary' : 'bg-secondary'
                        "
                        id="pills-correo-tab"
                        >1</span
                    >
                    Correo
                </li>
                <li class="nav-item" role="presentation">
                    <span
                        class="badge bg-primary rounded-pill"
                        :class="
                            paso == 2 ? 'active bg-primary' : 'bg-secondary'
                        "
                        id="pills-datos-generales-tab"
                        >2
                    </span>
                    Datos generales
                </li>
                <li class="nav-item" role="presentation">
                    <span
                        class="badge bg-primary rounded-pill"
                        :class="
                            paso == 3 ? 'active bg-primary' : 'bg-secondary'
                        "
                        id="pills-datos-empresa-tab"
                        >3
                    </span>
                    Datos empresa
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div
                    class="tab-pane fade"
                    :class="paso == 1 ? 'show active' : ''"
                    id="pills-correo"
                    role="tabpanel"
                >
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"
                                ><i class="fa-solid fa-envelope"></i
                            ></span>
                            <input
                                v-model.trim="$v.email.$model"
                                type="email"
                                class="form-control"
                                :class="{
                                    'is-invalid': $v.email.$error,
                                    'is-valid': !$v.email.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.email.required">{{
                                    required
                                }}</span>
                                <span v-if="!$v.email.email"
                                    >Debe ingresar un correo valido</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"
                            >Confirmar correo electrónico</label
                        >
                        <div class="input-group">
                            <span class="input-group-text"
                                ><i class="fa-solid fa-envelope"></i
                            ></span>
                            <input
                                v-model.trim="$v.verify_email.$model"
                                type="email"
                                class="form-control"
                                :class="{
                                    'is-invalid': $v.verify_email.$error,
                                    'is-valid':
                                        email != ''
                                            ? !$v.verify_email.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.verify_email.sameAsEmail">
                                    El correo electrónico no coincide</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <button
                                @click="cancelar()"
                                type="button"
                                class="btn btn-danger"
                            >
                                Cancelar
                            </button>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="submit()"
                            >
                                Siguiente
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    :class="paso == 2 ? 'show active' : ''"
                    id="pills-datos-generales"
                    role="tabpanel"
                >
                    <div class="mb-3">
                        <label class="form-label">Nombres</label>
                        <div class="input-group">
                            <span class="input-group-text"
                                ><i class="fa-solid fa-n"></i
                            ></span>
                            <input
                                v-model.trim="form.first_name"
                                type="text"
                                class="form-control"
                                :class="{
                                    'is-invalid': $v.form.first_name.$error,
                                    'is-valid': !$v.form.first_name.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.form.first_name.required">{{
                                    required
                                }}</span>
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
                                v-model.trim="form.last_name"
                                type="text"
                                class="form-control"
                                :class="{
                                    'is-invalid': $v.form.last_name.$error,
                                    'is-valid': !$v.form.last_name.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.form.last_name.required">{{
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
                                v-model.trim="form.phone"
                                type="text"
                                class="form-control"
                                :class="{
                                    'is-invalid': $v.form.phone.$error,
                                    'is-valid': !$v.form.phone.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.form.phone.required">{{
                                    required
                                }}</span>
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
                                v-model.trim="form.email"
                                type="email"
                                class="form-control"
                                :class="{
                                    'is-invalid': $v.form.email.$error,
                                    'is-valid': !$v.form.email.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.form.email.required">{{
                                    required
                                }}</span>
                                <span v-if="!$v.form.email.email"
                                    >Debe ingresar un correo valido</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"
                            >Confirmar correo electrónico</label
                        >
                        <div class="input-group">
                            <span class="input-group-text"
                                ><i class="fa-solid fa-envelope"></i
                            ></span>
                            <input
                                v-model.trim="form.verify_email"
                                type="email"
                                class="form-control"
                                autocomplete="new-text"
                                :class="{
                                    'is-invalid': $v.form.verify_email.$error,
                                    'is-valid':
                                        form.email != ''
                                            ? !$v.form.verify_email.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.form.verify_email.sameAsCorreo">
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
                                v-model.trim="form.password"
                                type="password"
                                id="contrasena"
                                class="form-control"
                                :class="{
                                    'is-invalid': $v.form.password.$error,
                                    'is-valid': !$v.form.password.$invalid,
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.form.password.required">{{
                                    required
                                }}</span>
                                <span v-if="!$v.form.password.minLength"
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
                                v-model.trim="form.verify_password"
                                type="password"
                                id="verify_password"
                                class="form-control"
                                :class="{
                                    'is-invalid':
                                        $v.form.verify_password.$error,
                                    'is-valid':
                                        form.password != ''
                                            ? !$v.form.verify_password.$invalid
                                            : '',
                                }"
                            />
                            <div class="invalid-feedback">
                                <span v-if="!$v.form.verify_password.required">
                                    La contraseña no coincide</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <button
                                @click="cancelar()"
                                type="button"
                                class="btn btn-danger"
                            >
                                Cancelar
                            </button>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="paso = 1"
                            >
                                Atrás
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="submit()"
                            >
                                Siguiente
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="tab-pane fade"
                    role="tabpanel"
                    :class="paso == 3 ? 'show active' : ''"
                    id="pills-datos-empresa"
                >
                    <div class="mb-3">
                        <label class="form-label required">Nit</label>
                        <input
                            v-model.trim="form_empresa.nit"
                            type="text"
                            class="form-control"
                            @change="verificarNitEmpresa()"
                            :class="{
                                'is-invalid': $v.form_empresa.nit.$error,
                                'is-valid': !$v.form_empresa.nit.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.nit.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Empresa</label>
                        <input
                            v-model.trim="form_empresa.nombre"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form_empresa.nombre.$error,
                                'is-valid': !$v.form_empresa.nombre.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.nombre.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Código CIIU</label>
                        <Multiselect
                            v-model.trim="form_empresa.codigo_ciiu_id"
                            :options="options_ciiu"
                            placeholder="Seleccione una opción"
                            required
                            :class="{
                                'is-invalid':
                                    $v.form_empresa.codigo_ciiu_id.$error,
                                'is-valid':
                                    form_empresa.codigo_ciiu_id != ''
                                        ? !$v.form_empresa.codigo_ciiu_id
                                              .$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span
                                v-if="!$v.form_empresa.codigo_ciiu_id.required"
                            >
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Sector</label>
                        <Multiselect
                            v-model.trim="form_empresa.sector_id"
                            :options="options_sector"
                            placeholder="Seleccione una opción"
                            required
                            :class="{
                                'is-invalid': $v.form_empresa.sector_id.$error,
                                'is-valid':
                                    form_empresa.sector_id != ''
                                        ? !$v.form_empresa.sector_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.sector_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Empleados</label>
                        <Multiselect
                            v-model.trim="form_empresa.empleado_id"
                            :options="options_empleado"
                            placeholder="Seleccione una opción"
                            required
                            :class="{
                                'is-invalid':
                                    $v.form_empresa.empleado_id.$error,
                                'is-valid':
                                    form_empresa.empleado_id != ''
                                        ? !$v.form_empresa.empleado_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.empleado_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Tamaño</label>
                        <Multiselect
                            v-model.trim="form_empresa.tamano_id"
                            :options="options_tamano"
                            placeholder="Seleccione una opción"
                            required
                            :class="{
                                'is-invalid': $v.form_empresa.tamano_id.$error,
                                'is-valid':
                                    form_empresa.tamano_id != ''
                                        ? !$v.form_empresa.tamano_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.tamano_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Departamento</label>
                        <Multiselect
                            v-model.trim="form_empresa.departamento_id"
                            :options="options_departamento"
                            placeholder="Seleccione una opción"
                            @input="getOptionsCiudad()"
                            required
                            :class="{
                                'is-invalid':
                                    $v.form_empresa.departamento_id.$error,
                                'is-valid':
                                    form_empresa.departamento_id != ''
                                        ? !$v.form_empresa.departamento_id
                                              .$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span
                                v-if="!$v.form_empresa.departamento_id.required"
                            >
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required"
                            >Ciudad o municipio</label
                        >
                        <Multiselect
                            v-model.trim="form_empresa.ciudad_id"
                            :options="options_ciudad"
                            placeholder="Seleccione una opción"
                            required
                            :class="{
                                'is-invalid': $v.form_empresa.ciudad_id.$error,
                                'is-valid':
                                    form_empresa.ciudad_id != ''
                                        ? !$v.form_empresa.ciudad_id.$invalid
                                        : '',
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.ciudad_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Sede</label>
                        <Multiselect
                            v-model.trim="form_empresa.sede_id"
                            :options="options_sede"
                            placeholder="Seleccione una opción"
                            required
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.sede_id.required">
                                {{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3" v-if="form_empresa.sede_id == 0">
                        <label class="form-label required">Nombre sede</label>
                        <input
                            v-model.trim="form_empresa.nombre_sede"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid':
                                    $v.form_empresa.nombre_sede.$error,
                                'is-valid':
                                    !$v.form_empresa.nombre_sede.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span
                                v-if="!$v.form_empresa.nombre_sede.required"
                                >{{ required }}</span
                            >
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Cargo</label>
                        <input
                            v-model.trim="form_empresa.cargo"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form_empresa.cargo.$error,
                                'is-valid': !$v.form_empresa.cargo.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.cargo.required">{{
                                required
                            }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Teléfono</label>
                        <input
                            v-model.trim="form_empresa.telefono"
                            type="text"
                            class="form-control"
                            :class="{
                                'is-invalid': $v.form_empresa.telefono.$error,
                                'is-valid': !$v.form_empresa.telefono.$invalid,
                            }"
                        />
                        <div class="invalid-feedback">
                            <span v-if="!$v.form_empresa.telefono.required">{{
                                required
                            }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <button
                                @click="cancelar()"
                                type="button"
                                class="btn btn-danger"
                            >
                                Cancelar
                            </button>
                        </div>
                        <div class="col-lg-6 text-end">
                            <button
                                @click="paso = 2"
                                type="button"
                                class="btn btn-secondary"
                            >
                                Atrás
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="submit()"
                            >
                                Finalizar
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
    requiredIf,
    email,
    sameAs,
    minLength,
} from "vuelidate/lib/validators";
import User from "../../models/User";
import Empresa from "../../models/Empresa";

export default {
    data() {
        return {
            form: {},
            user: new User({
                first_name: "",
                last_name: "",
                phone: "",
                email: "",
                verify_email: "",
                password: "",
                verify_password: "",
                cargo: "",
            }),
            form_empresa: {},

            email: "",
            verify_email: "",
            paso: 2,
            required: "Este campo es requerido",
            options_departamento: [],
            options_ciudad: [],
            options_sector: [],
            options_ciiu: [],
            options_tamano: [],
            options_empleado: [],
            options_sede: [{ value: 0, label: "NUEVA SEDE" }],
        };
    },
    validations: {
        form: {
            first_name: {
                required,
            },
            last_name: {
                required,
            },
            phone: {
                required,
            },
            email: {
                required,
                email,
            },
            verify_email: {
                required,
                sameAsEmail: sameAs("email"),
            },
            password: {
                required,
                minLength: minLength(8),
            },
            verify_password: {
                sameAsPassword: sameAs("password"),
            },
        },
        form_empresa: {
            nit: {
                required,
            },
            nombre: {
                required,
            },
            departamento_id: {
                required,
            },
            ciudad_id: {
                required,
            },
            tamano_id: {
                required,
            },
            empleado_id: {
                required,
            },
            sector_id: {
                required,
            },
            codigo_ciiu_id: {
                required,
            },
            sede_id: {
                required,
            },
            cargo: {
                required,
            },
            telefono: {
                required,
            },
            // nombre_sede: {
            //     required,
            // },
            nombre_sede: {
                required: requiredIf(function (value, vm) {
                    return this.form_empresa.sede_id == 0;
                }),
            },
        },
        email: {
            required,
            email,
        },
        verify_email: {
            required,
            sameAsEmail: sameAs("email"),
        },
    },
    mounted() {
        this.getOptionsParametro(1, "departamentos");
        this.getOptionsParametro(3, "sectores");
        this.getOptionsParametro(4, "CIIUs");
        this.getOptionsParametro(5, "tamaños de empresa");
        this.getOptionsParametro(6, "número de empleados");
        //this.getUsers();
        /*
    this.user.name = "nombres";
    this.user.password = "contrasena";
    this.user.email = "javdo2@gmail.com";
    this.user.save();*/
    },
    methods: {
        async getOptionsParametro(tipo_parametro_id, nombre_listado) {
            axios
                .get("api/getOptionsParametro/" + tipo_parametro_id)
                .then((response) => {
                    switch (tipo_parametro_id) {
                        case 1:
                            this.options_departamento = response.data;
                            break;
                        case 3:
                            this.options_sector = response.data;
                            break;
                        case 4:
                            this.options_ciiu = response.data;
                            break;
                        case 5:
                            this.options_tamano = response.data;
                            break;
                        case 6:
                            this.options_empleado = response.data;
                            break;
                    }
                })
                .catch((error) => {
                    this.mostrarMensaje(
                        "error",
                        "No se pudo obtener el listado de " + nombre_listado,
                        "error"
                    );
                });
            // var parametros = [{ id: 1, value: "options_sector" }];
            // parametros.forEach((e) => {
            //     axios
            //         .get("api/getOptionsParametro/" + e.id)
            //         .then((response) => {
            //             this[e.value] = response.data;
            //         })
            //         .catch((error) => {
            //             console.log(
            //                 "No se puede cargar la información de Listas"
            //             );
            //         });
            // });
        },

        async getOptionsCiudad() {
            this.options_ciudad = [];
            if (
                this.form_empresa.departamento_id != "" &&
                this.form_empresa.departamento_id != null
            ) {
                this.form_empresa.ciudad_id = "";
                axios
                    .get(
                        "api/getOptionsCiudad/" +
                            this.form_empresa.departamento_id
                    )
                    .then((response) => {
                        this.options_ciudad = response.data;
                    })
                    .catch((error) => {
                        this.mostrarMensaje(
                            "error",
                            "No se pudo obtener el listado de ciudades",
                            "error"
                        );
                    });
            }
        },

        async getUsers() {
            /* listas where users
      let usuarios = User.where("email", "javdo2@gmail.com");
      usuarios.orderBy("-id");
      //usuarios.include("carriers");
      //usuarios.append("quantity_origin_deliveries");
      let usuariosData = await usuarios.get();
      console.log(usuariosData);*/

            // let usuariosData = await User.append("last_name").find(1);

            // console.log(usuariosData);

            // find user
            let usuariosData = await User.append("last_name").find(2);
            console.log(usuariosData);
        },
        async submit() {
            this.$v.$touch();
            if (this.paso == 1) {
                if (
                    !(this.$v.email.$invalid || this.$v.verify_email.$invalid)
                ) {
                    let check_email = await User.where(
                        "email",
                        this.email
                    ).get();

                    if (check_email.length != 0) {
                        this.mostrarMensaje(
                            "Alerta",
                            "El correo electrónico ingresado ya se encuentra registrado en el sistema, por favor ingrese con el usuario y contraseña previamente creados",
                            "warning"
                        );
                        setTimeout(() => {
                            window.location.href = "login";
                        }, 2000);
                    } else {
                        this.paso = 2;
                        this.$v.$reset();
                        this.form.email = this.email;
                    }
                }
            }
            if (this.paso == 2) {
                if (!this.$v.form.$invalid) {
                    this.$v.$reset();
                    this.paso = 3;
                }
            }
            if (this.paso == 3) {
                if (!this.$v.form_empresa.$invalid) {
                    this.form_empresa.cargo = this.form.cargo;
                    this.user.first_name = this.form.first_name;
                    this.user.last_name = this.form.last_name;
                    this.user.phone = this.form.phone;
                    this.user.email = this.form.email;
                    this.user.password = this.form.password;
                    this.user.cargo = this.form.cargo;
                    this.user.estado = 0;
                    this.user.rol_id = 1;

                    //por validar estado, rol y la creación de empresa y sede
                    this.user.empresa_id = 1;
                    this.user.sede_id = 1;

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
        async verificarNitEmpresa() {
            let check_nit = await Empresa.where(
                "nit",
                this.form_empresa.nit
            ).get();

            if (check_nit.length != 0) {
                this.form_empresa.departamento_id =
                    check_nit[0]["departamento_id"];
                this.getOptionsCiudad();
                this.form_empresa = check_nit[0];
                this.getEmpresasSedes();
            } else {
                Object.keys(this.form_empresa).forEach((key) => {
                    if (key != "nit") {
                        this.form_empresa[key] = "";
                    }
                });
            }
        },
        async getEmpresasSedes() {
            await axios
                .get("api/getOptionsEmpresasSedes/" + this.form_empresa.id)
                .then((response) => {
                    response.data.forEach((e) => {
                        this.options_sede.push(e);
                    });
                })
                .catch((error) => {
                    this.mostrarMensaje(
                        "error",
                        "No se pudo obtener el listado de " + nombre_listado,
                        "error"
                    );
                });
        },
        cancelar() {
            window.location.href = "login";
        },
        mostrarMensaje(titulo, mensaje, icono) {
            Swal.fire({
                title: titulo,
                html: mensaje,
                icon: icono,
                showConfirmButton: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
            });
        },
    },
};
</script>
<style>
.required:after {
    content: " *";
    color: red;
}
.nav-link.active {
    color: #000 !important;
    background-color: white !important;
}
.nav-link:hover,
.nav-link:focus {
    color: #000;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>
