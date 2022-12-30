<template>
    <li class="nav-item">
        <a
            class="nav-link"
            :class="
                dataUrl == itemSelected
                    ? 'router-link-exact-active bg-gradient-tertiary'
                    : ''
            "
            style="border-radius: 10px 10px 10px 10px"
            :href="url"
            @click="itemClicked"
        >
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
    data() {
        return {
            itemSelected: "",
            dataUrl: this.url.replace("/", ""),
        };
    },
    mounted() {
        this.itemSelected = localStorage.getItem("itemSelected");
        if (this.dataUrl == this.itemSelected) {
            console.log(
                this.$el.parentElement.parentElement.previousElementSibling.click()
            );
            this.$el.parentElement.parentElement.previousElementSibling;
        }
    },
    methods: {
        itemClicked() {
            localStorage.setItem("itemSelected", this.url.replace("/", ""));
        },
    },
};
</script>
