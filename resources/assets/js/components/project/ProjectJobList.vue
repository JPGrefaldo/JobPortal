<template>
    <div>
        <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Project's Job Added</h3>
        </div>

        <div v-if="jobs">
            <div v-for="job in jobs" :key="job.id" class="flex mb-4 items-center">
                <span class="w-full mt-4 font-header text-blue-dark font-semibold mb-3">{{job.position.name}}</span>
                <button class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded bg-blue hover:bg-blue-dark text-white">Edit</button>
                <button class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-white hover:bg-red">Remove</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    
    export default {
        computed:{
            ...mapGetters({
                jobs: 'project/jobs',
            }),
        }
    }
</script>