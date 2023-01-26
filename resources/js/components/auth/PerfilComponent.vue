<template>
    <div class="card">
        <div class="card-body">
            <h2>Perfil de usuario</h2>
            <div class="mb-3">
                <label class="form-label required">Nombres</label>
                <div class="input-group">
                    <span class="input-group-text"
                        ><i class="fa-solid fa-n"></i
                    ></span>
                    <input
                        v-model.trim="user.first_name"
                        type="text"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.first_name.$error,
                            'is-valid': !$v.user.first_name.$invalid,
                        }"
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.first_name.required">{{
                            required
                        }}</span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label required">Apellidos</label>

                <div class="input-group">
                    <span class="input-group-text"
                        ><i class="fa-solid fa-a"></i
                    ></span>
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
            </div>
            <div class="mb-3">
                <label class="form-label required">Celular</label>
                <div class="input-group">
                    <span class="input-group-text"
                        ><i class="fa-solid fa-mobile"></i
                    ></span>
                    <input
                        v-model.trim="user.phone"
                        type="number"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.phone.$error,
                            'is-valid': !$v.user.phone.$invalid,
                        }"
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
            </div>
            <div class="mb-3">
                <label class="form-label required">Cargo</label>
                <div class="input-group">
                    <span class="input-group-text"
                        ><i class="fa fa-user"></i
                    ></span>

                    <input
                        v-model.trim="user.cargo"
                        type="text"
                        class="form-control"
                        :class="{
                            'is-invalid': $v.user.cargo.$error,
                            'is-valid': !$v.user.cargo.$invalid,
                        }"
                    />
                    <div class="invalid-feedback">
                        <span v-if="!$v.user.cargo.required">{{
                            required
                        }}</span>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-4 offset-lg-4 d-grid gap-2">
                <button type="button" class="btn btn-primary" @click="submit()">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import { required, minLength, maxLength } from "vuelidate/lib/validators";
import User from "../../models/User";

export default {
    data() {
        return {
            user: new User({
                id: "",
                first_name: "",
                last_name: "",
                phone: "",
                cargo: "",
            }),
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
            cargo: {
                required,
            },
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
                    this.user.id = response.data.id;
                    this.user.first_name = response.data.first_name;
                    this.user.last_name = response.data.last_name;
                    this.user.phone = response.data.phone;
                    this.user.cargo = response.data.cargo;
                })
                .catch((error) => {});
            this.$v.user.$reset();
        },
        async submit() {
            this.$v.$touch();
            if (!this.$v.$invalid) {
                this.$root.mostrarCargando("Guardando");
                await this.user.save();
                Swal.close();
                this.$root.mostrarMensaje(
                    "Éxito",
                    "Perfil de usuario actualizado correctamente",
                    "success"
                );
                setTimeout(() => {
                    this.$v.$reset();
                }, 1000);
            }
        },
    },
};
</script>
