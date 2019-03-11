<template>
    <div class="container bg-white shadow-md rounded p-4">

        <label class="block text-grey-darker font-bold mb-6">
            Tutorial Videos/How it Works
        </label>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                Project Title
            </label>
            <input v-model="project.title" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" type="text">
        </div>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                Production company name (or your name if individual)
            </label>
            <input v-model="project.production_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" type="text">
        </div>

        <div class="mb-6">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-state">
                Project type
            </label>
            <div class="relative">
                <select v-model="project.type_id" class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey">
                    <option v-for="projectType in projectTypes" :key="projectType.id" v-bind:value="projectType.id">{{ projectType.name }}</option>
                </select>
                
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                Project information
            </label>
            <textarea v-model="project.description" row=4 class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        
        <div class="mb-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                City/Area
            </label>
            <input v-model="project.location" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" type="text">
        </div>

        <div class="flex flex-col mb-4">
            <h3 class="block uppercase tracking-wide">Positions needed</h3>

            <cca-department></cca-department>

            <cca-position></cca-position>
        </div>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">Show my production company name publicly?</label>
            <div>
                <input v-model="project.production_name_public" type="radio" value="1" checked> Yes
                <input v-model="project.production_name_public" type="radio" value="0"> No
                <!-- TODO: need to defer to producer uri instead of admin -->
                <a href="/">See site list</a>
            </div>
        </div>

        <p class="mb-4">Only roles that accept video auditions and are paid, or audio auditions can be posted on ther sites.</p>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                Sites to post on
            </label>
            <div v-if="sites">
                <input v-model="project.sites_to_post" type="checkbox"> Check All
                <input v-model="project.sites_to_post" type="checkbox"> Yourcasting Test Site
                <div v-for="site in sites" :key="site.id" >
                    <input type="checkbox" v-model="project.sites"> {{ site.name }}
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2">
                Will travel/lodging expenses be paid for out-of-area talent?
            </label>

            <input v-model="project.paid_travel" type="radio" value="1"> Yes
            <input v-model="project.paid_travel" type="radio" value="0"> No
        </div>

        <div class="mb-4">
            <button class="bg-blue hover:bg-blue-dark text-white font-bold w-24 py-2 px-4 rounded-full float-right w-64" @click.stop="submit">Save</button>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import Department from './forms/Department.vue'
    import Position from './forms/Position.vue'

    export default {
        components: {
            'cca-department': Department,
            'cca-position': Position
        },

        mounted() {
            this.$store.dispatch('project/fetchTypes');
            this.$store.dispatch('crew/fetchSites')
        },

        computed: {
            ...mapGetters({
                position: 'crew/position',
                sites: 'crew/sites',
                project: 'project/project',
                projectTypes: 'project/types'
            })
        },

        methods: {
            submit()
            {
                console.log(this.form);
            }
        }
    }
</script>