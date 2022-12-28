<template>
    <aside
      id="sidenav-main"
      class="my-3 overflow-auto border-0 sidenav navbar bg-white navbar-vertical navbar-expand-xs border-radius-xl"
      :class="'me-3 rotate-caret'"
    >
      <div class="sidenav-header">
        <i
          id="iconSidenav"
          class="top-0 p-3 cursor-pointer fas fa-times text-secondary opacity-5 position-absolute end-0 d-none d-xl-none"
          aria-hidden="true"
        ></i>
        <a class="m-0 navbar-brand" href="/">
          <img src="../../../../img/CAEM_mini.jpg" class="navbar-brand-img h-100" alt="main_logo" />
          <span class="ms-1 font-weight-bold">HuellaCarbono</span>
        </a>
      </div>
      <hr class="mt-0 horizontal dark" />
      <sidenav-list :card-bg="customClass" :route-selected="currentRoute" :isLogged="isLoggedIn" />
    </aside>
</template>
<script>
import NavbarSide from './NavbarSide.vue';
import SidenavList from "./SidenavList.vue";
export default {
  name: "Index",
  components: {
    SidenavList,
    NavbarSide
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
  },
  data() {
    return {
      showSidenav: true,
      isLoggedIn: this.isLogged,
      currentRoute: this.routeSelected,      
    };
  },
  watch: {
    routeSelected: function (newVal) {
      this.currentRoute = newVal;
    },
    isLogged: function (val, oldVal) {
      this.isLoggedIn = val;
    },
  },
};
</script>
