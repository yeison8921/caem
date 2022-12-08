<template>
  <!-- Navbar -->
  <nav
    class="top-0 navbar navbar-expand-lg position-absolute z-index-3"
    :class="isBlur ? isBlur : 'shadow-none my-2 navbar-transparent w-100'"
  >
    <div class="container">
      <div
        class="navbar-brand font-weight-bolder ms-lg-0 ms-3"
        :class="darkMode ? 'text-black' : 'text-white'"
        to="/"
      >
        HuellaCarbono
      </div>
      <button
        class="shadow-none navbar-toggler ms-2"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navigation"
        aria-controls="navigation"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="mt-2 navbar-toggler-icon">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
      <div
        id="navigation"
        class="pt-3 pb-2 collapse navbar-collapse w-100 py-lg-0"
      >
        <ul class="mx-auto navbar-nav navbar-nav-hover">
          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="loggedIn"
              href="/home"
              class="dropdown-item border-radius-md"
              >Home</a
            >
          </li>

          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="!loggedIn"
              href="/parametros"
              class="dropdown-item border-radius-md"
              >Parámetros</a
            >
          </li>

          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="!loggedIn"
              href="/convenios"
              class="dropdown-item border-radius-md"
              >Convenios</a
            >
          </li>

          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="!loggedIn"
              href="/empresas"
              class="dropdown-item border-radius-md"
              >Empresas</a
            >
          </li>

          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="!loggedIn"
              href="/sedes"
              class="dropdown-item border-radius-md"
              >Sedes</a
            >
          </li>

          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="!loggedIn"
              href="/procesos"
              class="dropdown-item border-radius-md"
              >Procesos</a
            >
          </li>

          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="!loggedIn"
              href="/autorizaciones"
              class="dropdown-item border-radius-md"
              >Autorización</a
            >
          </li>

          <li class="mx-2 nav-item dropdown dropdown-hover">
            <a
              v-if="!loggedIn"
              href="/register"
              class="ml-4 dropdown-item border-radius-md"
              >Register</a
            >
          </li>
        </ul>
        <ul class="navbar-nav d-lg-block d-none">
          <li class="nav-item">
            <a
              href="/login"
              class="mb-0 btn btn-sm btn-round me-1"
              :class="btnBackground ? btnBackground : 'bg-white'"
              onclick="smoothToPricing('pricing-soft-ui')"
              >Login</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
</template>

<script>
/*eslint-disable*/
import downArrWhite from "../../../img/down-arrow-white.svg";
import downArrBlack from "../../../img/down-arrow-dark.svg";
import Office from "../Icon/Office.vue";
import Shop from "../Icon/Shop.vue";
import CustomerSupport from "../Icon/CustomerSupport.vue";
import Document from "../Icon/Document.vue";
import Spaceship from "../Icon/Spaceship.vue";
import GettingStarted from "../Icon/GettingStarted.vue";
import Box3d from "../Icon/Box3d.vue";
import Settings from "../Icon/Settings.vue";

export default {
  name: "Navbar",
  components: {
    Office,
    Shop,
    CustomerSupport,
    Document,
    Spaceship,
    GettingStarted,
    Box3d,
    Settings,
  },
  props: {
    btnBackground: {
      type: String,
      default: "",
    },
    isBlur: {
      type: String,
      default: "",
    },
    darkMode: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      loggedIn: false,
      downArrWhite,
      downArrBlack,
    };
  },
  computed: {
    darkModes() {
      return {
        "text-dark": this.darkMode,
      };
    },
  },
};
</script>
