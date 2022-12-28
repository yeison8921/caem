<template>
  <nav
    id="navbarBlur"
    class="shadow-none navbar navbar-main navbar-expand-lg border-radius-xl"
    :class="[false ? 'top-1 position-sticky z-index-sticky' : '']"
    v-bind="$attrs"
    data-scroll="true"
  >
    <div class="px-3 py-1 container-fluid pt-4">
      <div
        class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none"
        :class="false ? 'me-3' : ''"
      >
        <a href="#" class="p-0 nav-link text-body" @click.prevent="navbarMinimize">
          <div class="sidenav-toggler-inner">
            <i
              class="sidenav-toggler-line"
              :class="textWhite ? 'bg-white' : ''"
            ></i>
            <i
              class="sidenav-toggler-line"
              :class="textWhite ? 'bg-white' : ''"
            ></i>
            <i
              class="sidenav-toggler-line"
              :class="textWhite ? 'bg-white' : ''"
            ></i>
          </div>
        </a>
      </div>
      <div
        id="navbar"
        class="mt-2 collapse navbar-collapse mt-sm-0 me-md-0 me-sm-4"
        :class="false ? 'px-0' : 'me-sm-4'"
      >
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a
              id="iconNavbarSidenav"
              href="#"
              class="p-0 nav-link text-body"
              @click="toggleSidebar"
            >
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>

export default {
  name: "NavbarSide",
  props: {
    textWhite: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      showMenu: false,
    };
  },
  computed: {
    currentRouteName() {
      return this.$route.name;
    },
    currentDirectory() {
      let dir = this.$route.path.split("/")[1];
      return dir.charAt(0).toUpperCase() + dir.slice(1);
    },
  },
  created() {
    this.minNav;
  },
  methods: {
    toggleSidebar() {
      this.navbarMinimize();
    },    
    navbarMinimize(state) {
      const sidenav_show = document.querySelector(".g-sidenav-show");
      if (sidenav_show.classList.contains("g-sidenav-hidden")) {
        sidenav_show.classList.remove("g-sidenav-hidden");
        sidenav_show.classList.add("g-sidenav-pinned");
      } else {
        sidenav_show.classList.add("g-sidenav-hidden");
        sidenav_show.classList.remove("g-sidenav-pinned");
      }
    }
  },
};
</script>
