<template>
    <div>
        <a
            :data-bs-toggle="collapse ? 'collapse' : ''"
            :href="collapse ? `#${collapseRef}` : collapseRef"
            :aria-controls="collapseRef"
            aria-expanded="false"
            class="nav-link"
            v-bind="$attrs"
            style="font-weight: bold"
            type="button"
            @click="isExpanded = !isExpanded"
        >
            <div
                class="text-center bg-white shadow icon icon-shape icon-sm border-radius-md d-flex align-items-center justify-content-center"
                :class="' ms-2'"
            >
                <slot name="icon"></slot>
            </div>
            <span
                style="padding-left: 10px"
                class="nav-link-text"
                :class="' ml-3 mt-2 me-1'"
                >{{ navText }}</span
            >
        </a>
        <div :id="collapseRef" class="collapse show">
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
