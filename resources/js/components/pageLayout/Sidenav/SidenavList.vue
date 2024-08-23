<template>
    <div>
        <div
            id="sidenav-collapse-main"
            style="overflow-x: hidden"
            class="w-auto h-auto collapse navbar-collapse max-height-vh-100 h-100"
        >
            <ul class="navbar-nav">
                <li class="mt-2 nav-item">
                    <h6
                        class="mb-3 text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
                        :class="'me-4'"
                        style="margin: 0 1rem"
                    >
                        {{ userLogged.first_name }} {{ userLogged.last_name }}
                        <span v-if="empresa != ''">
                            <br />
                            Empresa: {{ empresa }}
                            <br />
                            Sede: {{ sede }}
                        </span>
                    </h6>
                </li>
                <li class="nav-item">
                    <sidenav-collapse
                        collapse-ref="generalLinks"
                        nav-text="General"
                        :class="currentRoute === 'general' ? 'active' : ''"
                    >
                        <template #icon>
                            <i
                                class="fas fa-chart-line fa-4x"
                                style="color: #21d4fd"
                            ></i>
                        </template>
                        <template #list>
                            <ul class="nav ms-4 ps-3">
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [2, 3].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Ingresar datos' }"
                                    :url="'/procesos'"
                                    mini-icon="ID"
                                    text="Ingresar datos"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 2, 3, 4].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    id="resultados"
                                    :to="{ name: 'Resultados' }"
                                    :url="'/resultados'"
                                    mini-icon="P"
                                    text="Resultados"
                                />
                            </ul>
                        </template>
                    </sidenav-collapse>
                </li>
                <li
                    class="nav-item"
                    v-if="[1, 3].includes(parseInt(userLogged.rol_id))"
                >
                    <sidenav-collapse
                        collapse-ref="AdminLinks"
                        nav-text="Administración"
                        :class="'active'"
                    >
                        <template #icon>
                            <i class="fas fa-cog" style="color: #21d4fd"></i>
                        </template>
                        <template #list>
                            <ul class="nav ms-4 ps-3">
                                <!-- nav links -->
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Parámetros' }"
                                    :url="'/parametros'"
                                    mini-icon="P"
                                    text="Parámetros"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Usuarios' }"
                                    :url="'/usuarios'"
                                    mini-icon="U"
                                    text="Usuarios"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 3].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Empresarios' }"
                                    :url="'/empresarios'"
                                    mini-icon="e"
                                    text="Empresarios"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Convenios' }"
                                    :url="'/convenios'"
                                    mini-icon="C"
                                    text="Convenios"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 3].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Empresas' }"
                                    :url="'/empresas'"
                                    mini-icon="E"
                                    text="Empresas"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 3].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Sedes' }"
                                    :url="'/sedes'"
                                    mini-icon="S"
                                    text="Sedes"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 3].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Autorización' }"
                                    :url="'/autorizaciones'"
                                    mini-icon="A"
                                    text="Autorización"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 3].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Autorizar reportes' }"
                                    :url="'/autorizaciones/huella'"
                                    mini-icon="A"
                                    text="Autorizar reportes"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Fuentes de emisión' }"
                                    :url="'/fuentes'"
                                    mini-icon="F"
                                    text="Fuentes de emisión"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Resultados globales' }"
                                    :url="'/resultados-excel'"
                                    mini-icon="R"
                                    text="Resultados globales"
                                />
                                <sidenav-item
                                    v-if="!isLoggedIn"
                                    :to="{ name: 'Login' }"
                                    :url="'/login'"
                                    mini-icon="L"
                                    text="Login"
                                />
                                <sidenav-item
                                    v-if="!isLoggedIn"
                                    :to="{ name: 'Register' }"
                                    :url="'/register'"
                                    mini-icon="R"
                                    text="Register"
                                />
                            </ul>
                        </template>
                    </sidenav-collapse>
                </li>
                <li class="nav-item">
                    <sidenav-collapse
                        collapse-ref="UserLinks"
                        nav-text="Usuario"
                        :class="'active'"
                    >
                        <template #icon>
                            <i class="fas fa-user" style="color: #21d4fd"></i>
                        </template>
                        <template #list>
                            <ul class="nav ms-4 ps-3">
                                <sidenav-item
                                    v-if="isLoggedIn"
                                    :to="{ name: 'Perfil' }"
                                    :url="'/perfil'"
                                    mini-icon="I"
                                    text="Perfil"
                                />
                                <sidenav-item
                                    v-if="isLoggedIn"
                                    :to="{ name: 'Cambiar contraseña' }"
                                    :url="'/cambiar-contrasena'"
                                    mini-icon="C"
                                    text="Cambiar contraseña"
                                />
                            </ul>
                        </template>
                    </sidenav-collapse>
                </li>
            </ul>
        </div>
        <div class="pt-5 mt-5 sidenav-footer">
            <a
                href="videotutoriales"
                target="_blank"
                class="mb-2 btn btn-sm btn-round me-1 bg-gradient-info"
                style="margin-left: 40px"
                >&nbsp&nbsp&nbsp&nbspTutoriales&nbsp&nbsp&nbsp&nbsp</a
            >
            <br />
            <a
                href="#"
                class="mb-2 btn btn-sm btn-round me-1 bg-gradient-info"
                style="margin-left: 40px"
                @click="logout()"
                >Cerrar sesión</a
            >
        </div>
    </div>
</template>
<script>
import User from "../../../models/User";
import SidenavItem from "./SidenavItem.vue";
import SidenavCollapse from "./SidenavCollapse.vue";
import SidenavCard from "./SidenavCard.vue";
import SidenavCollapseItem from "./SidenavCollapseItem.vue";
import Settings from "../../Icon/Settings.vue";
import Basket from "../../Icon/Basket.vue";
import Box3d from "../../Icon/Box3d.vue";
import Shop from "../../Icon/Shop.vue";
import Office from "../../Icon/Office.vue";
import Document from "../../Icon/Document.vue";
import Spaceship from "../../Icon/Spaceship.vue";
import CreditCard from "../../Icon/CreditCard.vue";

export default {
    name: "SidenavList",
    components: {
        SidenavItem,
        SidenavCollapse,
        SidenavCard,
        SidenavCollapseItem,
        Settings,
        Basket,
        Box3d,
        Shop,
        Office,
        Document,
        Spaceship,
        CreditCard,
    },
    props: {
        cardBg: {
            type: String,
            default: "",
        },
        routeSelected: {
            type: String,
            default: "",
        },
        isLogged: {
            type: Boolean,
            default: false,
        },
        userLogged: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            isLoggedIn: this.isLogged,
            currentRoute: this.routeSelected,
            itemSelected: "",
            empresa: "",
            sede: "",
        };
    },
    watch: {
        routeSelected: function (newVal) {
            this.currentRoute = newVal;
        },
        isLogged: function (val, oldVal) {
            this.isLoggedIn = val;
        },
        userLogged: function (val, oldVal) {
            this.userLogged = val;
        },
    },
    mounted() {
        this.getEmpresaByUser();
        this.itemSelected = localStorage.getItem("itemSelected");
    },
    methods: {
        logout() {
            this.$root.mostrarCargando();
            axios
                .post("/logout")
                .then((response) => {
                    this.$root.redirectIndex("/login");
                    this.$root.cerrarCargando();
                })
                .catch((error) => {
                    this.$root.redirectIndex("/login");
                    this.$root.cerrarCargando();
                    // this.$root.mostrarMensaje(
                    //     "error",
                    //     "ha ocurrido un error al cerrar sesión",
                    //     "error"
                    // );
                });
        },
        async getEmpresaByUser() {
            let data = await User.include("empresa", "empresaSede").find(
                this.userLogged.id
            );

            if (this.userLogged.rol_id == 2) {
                this.empresa = data.empresa.nombre;
                this.sede = data.empresa_sede.nombre;
            }
        },
    },
};
</script>
