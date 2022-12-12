<template>
  <li class="nav-item">
    <a class="nav-link" :href="url">
      <span class="sidenav-mini-icon"> {{ miniIcon }} </span>
      <span class="sidenav-normal"> {{ text }} </span>
    </a>
  </li>
</template>
<script>
export default {
  name: "SidenavItem",
  props: {
    to: {
      type: Object,
      required: true,
    },
    miniIcon: {
      type: String,
      required: true,
    },
    text: {
      type: String,
      required: true,
    },
    url: {
      type: String,
      default: "",
    },
  },
};
</script>
