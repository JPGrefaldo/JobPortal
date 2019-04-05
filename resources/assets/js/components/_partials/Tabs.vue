<template>
    <div>
        <nav class="bg-white px-8 pt-2 shadow-md">
            <div class="-mb-px flex">
                <a
                    v-for="tab in tabs"
                    :key="tab.name"
                    :href="tab.href"
                    @click="selectTab(tab)"
                    class="no-underline border-b-2 border-transparent uppercase tracking-wide font-bold text-xs py-3 mr-8"
                    :class="{
                        'text-teal-dark': tab.isActive,
                        'text-grey-dark': tab.isActive == false,
                    }"
                    >{{ tab.name }}</a
                >
            </div>
        </nav>

        <div class="tabs-details">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return { tabs: [] };
    },

    created() {
        this.tabs = this.$children;
    },

    methods: {
        selectTab(selectedTab) {
            this.tabs.forEach(tab => {
                tab.isActive = tab.href == selectedTab.href;
            });
        },
    },
};
</script>
