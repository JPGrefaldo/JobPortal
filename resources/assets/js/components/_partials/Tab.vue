<template>
    <div v-show="isActive" class="p-8 bg-grey-light">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        active: {
            type: String
        }
    },

    data() {
        return {
            isActive: false,
            selectedTab: this.active
        };
    },

    computed: {
        href() {
            return '#' + this.name.toLowerCase().replace(/ /g, '-');
        },
    },

    mounted() {
        if (location.hash) {
            this.selectedTab = location.hash
        }
        this.isActive = this.selectedTab == this.href;
    },
};
</script>
