<template>
    <div>
        <div
            id="sidenav-collapse-main"
            style="overflow-x: hidden"
            class="w-auto h-auto collapse navbar-collapse max-height-vh-100 h-100"
        >
            <ul class="navbar-nav">
                <li class="mt-3 nav-item">
                    <h6
                        class="text-xs ps-4 text-uppercase font-weight-bolder opacity-6"
                        :class="'me-4'"
                    >
                        {{ empresa }} <br />
                        {{ sede }}
                    </h6>
                </li>
                <li class="nav-item">
                    <sidenav-collapse
                        collapse-ref="generalLinks"
                        nav-text="General"
                        :class="currentRoute === 'general' ? 'active' : ''"
                    >
                        <template #icon>
                            <Document />
                        </template>
                        <template #list>
                            <ul class="nav ms-4 ps-3">
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 2, 4].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
                                    :to="{ name: 'Procesos' }"
                                    :url="'/procesos'"
                                    mini-icon="P"
                                    text="Procesos"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 2, 3, 4].includes(
                                            parseInt(userLogged.rol_id)
                                        )
                                    "
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
                    v-if="[1, 4].includes(parseInt(userLogged.rol_id))"
                >
                    <sidenav-collapse
                        collapse-ref="AdminLinks"
                        nav-text="Administración"
                        :class="'active'"
                    >
                        <template #icon>
                            <Basket />
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
                                    :to="{ name: 'Convenios' }"
                                    :url="'/convenios'"
                                    mini-icon="C"
                                    text="Convenios"
                                />
                                <sidenav-item
                                    v-if="
                                        isLoggedIn &&
                                        [1, 4].includes(
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
                                        [1, 4].includes(
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
                                        [1, 4].includes(
                                            parseInt(serLogged.rol_id)
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
                        <i class="fa fa-user me-sm-1" aria-hidden="true"></i>
                        <template #list>
                            <ul class="nav ms-4 ps-3">
                                <sidenav-item
                                    v-if="isLoggedIn"
                                    :to="{ name: 'Perfil' }"
                                    :url="'/perfil'"
                                    mini-icon="I"
                                    text="Perfil"
                                />
                            </ul>
                        </template>
                    </sidenav-collapse>
                </li>
                <li class="nav-item" v-if="isLoggedIn">
                    <a
                        href="#"
                        class="mb-0 btn btn-sm btn-round me-1 bg-gradient-info"
                        style="margin-left: 40px; bottom: 3vh; position: fixed"
                        @click="logout()"
                        >Cerrar sesión</a
                    >
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import ConvenioEmail from "../../../models/ConvenioEmail";
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
                    this.$root.mostrarMensaje(
                        "error",
                        "ha ocurrido un error al cerrar sesión",
                        "error"
                    );
                });
        },
        async getEmpresaByUser() {
            let data = await ConvenioEmail.where("email", this.userLogged.email)
                .include("sede", "sede.empresa")
                .first();

            if (Object.keys(data).length != 0) {
                this.empresa = data.sede.empresa.nombre;
                this.sede = data.sede.nombre;
            }
        },
    },
};
</script>
