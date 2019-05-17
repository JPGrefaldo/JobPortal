<template>
    <div>
        <div class="w-full pb-8 border-b-2 mb-8 border-grey-light md:flex justify-between items-center">
            <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold mb-3 md:mb-0">My projects</h1>
            <a class="btn-green-outline" href="/producer/projects/create">Add new project</a>
        </div>

        <div class="md:hidden w-full md:w-1/4 float-left md:mb-3">
            <div class="has-menu relative">
                <div class="flex justify-between justify-center items-center rounded-lg w-full float-left mb-4 py-3 px-3 border border-grey-light bg-white cursor-pointer text-sm">
                    All projects
                    <span class="btn-toggle float-right"></span>
                </div>
                <div class="menu w-full shadow-md bg-white absolute py-3 font-body border text-sm border-grey-light">
                    <ul class="text-left">
                        <li class="py-2 px-4">
                            <a class="block text-blue-dark hover:text-green" href="#">View profile</a>
                        </li>
                        <li class="py-2 px-4">
                            <a class="block text-blue-dark hover:text-green" href="#">Subscription</a>
                        </li>
                        <li class="py-2 px-4">
                            <a class="block text-blue-dark hover:text-green" href="#">Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="hidden md:block font-header text-right px-md py-6">
                <li class="block py-4">
                    <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Active projects</a>
                </li>
                <li class="block py-4">
                    <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Inactive projects</a>
                </li>
                <li class="block py-4">
                    <a class="text-blue-dark font-semibold py-2 border-b-2 border-red hover:text-green" href="#">Add
                        manager</a>
                </li>
                <li class="block py-4">
                    <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Pending projects</a>
                </li>
                <li class="block py-4">
                    <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Close account</a>
                </li>
            </ul>
        </div>

        <aside class="hidden md:block w-1/4 float-left pr-4">
            <ul class="font-header text-left py-6">
                <li class="block py-4">
                    <a :class="{'border-b-2 border-red ': activeTab == 'all'}" class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('all')">
                        All projects
                        <div class="badge bg-white ml-2">{{ projects.length }}</div>
                    </a>
                </li>
                <li class="block py-4">
                    <a :class="{'border-b-2 border-red ': activeTab == 'active'}" class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('active')">
                        Active projects
                        <div class="badge bg-white ml-2">{{ projectApprovedCount }}</div>
                    </a>
                </li>
                <li class="block py-4">
                    <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('inactive')">
                        Inactive projects
                        <div class="badge bg-white ml-2">1000</div>
                    </a>
                </li>
                <li :class="{'border-b-2 border-red ': activeTab == 'pending'}" class="block py-4">
                    <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('pending')">
                        Pending projects
                        <div class="badge bg-white ml-2">{{ projectPendingCount }}</div>
                    </a>
                </li>
            </ul>
            <div class="py-6 pr-8">
                <h4 class="text-grey mb-4">HOW IT WORKS VIDEO</h4>
                <a class="pb-66 h-none rounded relative block" href="#"
                    style="background: url(/images/th2.jpg); background-size:cover;">
                    <span class="btn-play w-10 h-10"></span>
                </a>
            </div>
            <div>
                <h4 class="text-grey leading-loose">Need help?
                    <br>
                    <a class="text-green" href="#">Contact support</a>
                </h4>
            </div>
        </aside>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        props: ['projects'],

        data() {
            return {
                activeTab: 'all'
            }
        },

        computed: {
            ...mapGetters({
                projectApprovedCount: 'project/approvedCount',
                projectPendingCount: 'project/pendingCount'
            })
        },

        methods: {
            loadProjects: function (type) {
                this.activeTab = type

                if(type === 'all') {
                    this.$store.dispatch('project/fetch')
                }

                if(type === 'active') {
                    this.$store.dispatch('project/fetchAllApproved')
                }

                if(type === 'pending') {
                    this.$store.dispatch('project/fetchAllPending')
                }
            },
        }
    }
</script>
