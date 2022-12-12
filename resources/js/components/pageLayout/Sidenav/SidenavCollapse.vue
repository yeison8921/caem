<template>
  <div>
    <a
      :data-bs-toggle="collapse ? 'collapse' : ''"
      :href="collapse ? `#${collapseRef}` : collapseRef"
      :aria-controls="collapseRef"
      aria-expanded="false"
      class="nav-link"
      v-bind="$attrs"
      type="button"
      @click="isExpanded = !isExpanded"
    >
      <div
        class="
          text-center
          bg-white
          shadow
          icon icon-shape icon-sm
          border-radius-md
          d-flex
          align-items-center
          justify-content-center
        "
        :class="' ms-2'"
      >
        <slot name="icon"></slot>
      </div>
      <span class="nav-link-text" :class="' ml-2 mt-2 me-1'">{{
        navText
      }}</span>
    </a>
    <div :id="collapseRef" class="collapse">
      <slot name="list"></slot>
    </div>
  </div>
</template>
<script>
export default {
  name: "SidenavCollapse",
  props: {
    collapseRef: {
      type: String,
      required: true,
    },
    navText: {
      type: String,
      required: true,
    },
    collapse: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      isExpanded: false,
    };
  },
};
</script>
