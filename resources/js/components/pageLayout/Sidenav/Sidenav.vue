<template>
    <aside
        id="sidenav-main"
        class="my-3 overflow-auto border-0 sidenav navbar bg-white navbar-vertical navbar-expand-xs border-radius-xl"
        :class="'me-3 rotate-caret'"
        style="box-shadow: 0 20px 27px 0 rgb(0 0 0 / 40%); !important"
    >
        <div class="sidenav-header">
            <i
                id="iconSidenav"
                class="top-0 p-1 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
                aria-hidden="true"
            ></i>
            <a class="m-0 navbar-brand" href="/">
                <img
                    src="../../../../img/Carbontest - Horizontal.svg"
                    class="navbar-brand-img"
                    style="max-height: 180px !important"
                    alt="main_logo"
                />
                <!-- <span class="ms-1 font-weight-bold">Carbontest</span> -->
            </a>
        </div>
        <hr class="mt-0 horizontal dark" />
        <sidenav-list
            :card-bg="customClass"
            :route-selected="currentRoute"
            :isLogged="isLoggedIn"
            :userLogged="userLogged"
        />
    </aside>
</template>
<script>
import NavbarSide from "./NavbarSide.vue";
import SidenavList from "./SidenavList.vue";
export default {
    name: "Index",
    components: {
        SidenavList,
        NavbarSide,
    },
    props: {
        customClass: {
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
            showSidenav: true,
            isLoggedIn: this.isLogged,
            currentRoute: this.routeSelected,
            timeout: null,
            showPopup: true,
        };
    },
    watch: {
        routeSelected: function (newVal) {
            this.currentRoute = newVal;
        },
        isLogged: function (val) {
            this.isLoggedIn = val;
        },
        userLogged: function (val) {
            this.userLogged = val;
        },
    },
    mounted() {
        this.startIdleTimer();
        document.addEventListener("mousemove", this.resetIdleTimer);
        document.addEventListener("keypress", this.resetIdleTimer);
    },
    methods: {
        startIdleTimer() {
            this.timeout = setTimeout(() => {
                Swal.fire({
                    title: "Atención",
                    html: "Tu sesión está a punto de expirar, ¿Quieres seguir conectado?",
                    icon: "question",
                    confirmButtonText: "Si, seguir conectado",
                    confirmButtonColor: "rgb(48, 133, 214)",
                    timer: 59000,
                    timerProgressBar: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.stayLoggedIn();
                    } else {
                        this.logout();
                    }
                });
            }, 1000 * 60 * 13);
            //840000); // 13 minutes idle time
        },
        resetIdleTimer() {
            // clearTimeout(this.timeout);
            // if (this.showPopup) {
            //     this.stayLoggedIn();
            // } else {
            //     this.startIdleTimer();
            // }
        },
        stayLoggedIn() {
            clearTimeout(this.timeout);
            axios
                .post("/refresh-session")
                .then(() => {
                    clearTimeout(this.timeout);
                    this.startIdleTimer();
                })
                .catch((error) => {
                    console.error("Failed to refresh session", error);
                    this.$root.redirectIndex("/login");
                });
        },
        logout() {
            axios
                .post("/logout")
                .then((response) => {
                    this.$root.redirectIndex("/login");
                })
                .catch((error) => {
                    this.$root.redirectIndex("/login");
                });
        },
    },
};
</script>
