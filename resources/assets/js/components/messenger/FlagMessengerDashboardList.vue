<template>
    <div class="flex-1 overflow-auto bg-white">
        <button class="flex items-center justify-center p-2 hover:bg-grey-light w-full" v-for="flag in allFlags" :key="flag.id">
            <div class="h-10 w-10 rounded-full bg-white background-missing-avatar border">
            </div>
            <div class="p-2 flex-1">
                <div class="truncate w-32" style="text-align: left;">{{ flag.id }}</div>
                <p class="text-xs truncate w-32" style="text-align: left;">Date</p>
            </div>
        </button>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    name: "Flags",
    methods: {
        ...mapActions(['fetchFlags'])
    },
    computed: mapGetters(['allFlags']),
    created() {
        this.fetchFlags
    }
}
</script>

<style>

</style>
