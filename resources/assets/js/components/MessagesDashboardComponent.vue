<template>
    <div class="flex flex-col h-full">
        <!-- top bar -->
        <div class="flex h-12 bg-grey-light">
            <div class="w-1/5 border-b border-r border-black flex items-center justify-center px-2">
                <button class="fa fa-search mr-2"></button>
                <input type="text" class="hidden rounded-full bg-white flex-1 px-3 mr-2" placeholder="Search">
                <div class="bg-white rounded-full h-5 flex-1 pl-3 mr-2 text-grey">
                    Search
                </div>
                <button class="fa fa-edit"></button>
            </div>
            <div class="w-4/5 text-md border-black border-b font-bold flex justify-center items-center">
                Titanic: Leonardo DiCarpio
                <!-- TODO: right chevron goes here that links to the current recipient -->
                <!-- might have to add logic depending on the role -->
            </div>
        </div>
        <!-- main -->
        <div class="flex h-full">
            <!-- left pane -->
            <div class="flex w-1/5 border-r border-black">
                <!-- projects -->
                <div class="bg-grey-dark overflow-hidden">
                    <!-- project -->
                    <button
                        class="uppercase flex items-center justify-center mb-2 m-1 text-white font-bold h-10 w-10 rounded"
                        v-for="project in projects" :key="project.id"
                        :class="{
                            'bg-blue': role == 'Producer',
                            'hover:bg-blue-dark': role == 'Producer',
                            'bg-green': role == 'Crew',
                            'hover:bg-green-dark': role == 'Crew',
                        }"
                    >
                        {{ getAcronymAttribute(project.title) }}
                    </button>
                </div>
                <!-- threads -->
                <div class="flex-1 overflow-auto bg-white">
                    <!-- thread -->
                    <div class="flex items-center justify-center p-2 bg-grey-light">
                        <div class="h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
                        <div class="p-2 flex-1">
                            <div class="mb-1">
                                Leonardo DiCarpio
                            </div>
                            <p class="text-xs">
                                You: Awesome! You ar...
                            </p>
                        </div>
                    </div>
                    <!-- thread -->
                    <div class="flex items-center justify-center p-2">
                        <div class="h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
                        <div class="p-2 flex-1">
                            <div class="mb-1">
                                Kate Winslet
                            </div>
                            <p class="text-xs">
                                I am happy.
                            </p>
                        </div>
                </div>
                </div>
            </div>
            <!-- conversation -->
            <div class="w-4/5 bg-white flex flex-col p-4">
                <!-- recipient message -->
                <div class="flex items-center justify-center mb-4">
                    <div class="mr-4 border h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
                    <div class="rounded-lg bg-grey-light p-3 max-w-md">
                        Impedit sit cumque ut voluptatem voluptatem est ea esse. Odit ipsa molestiae sint exercitationem quia tempora. Eaque non ipsum dolores reiciendis dicta. Eligendi minima quam dolorem quo voluptatem maxime qui.
                    </div>
                    <div class="flex-1"></div>
                </div>
                <!-- recipient message -->
                <div class="flex items-center justify-center mb-4">
                    <div class="mr-4 border h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
                    <div class="rounded-lg bg-grey p-3 max-w-md">
                        Eum ut quibusdam modi dolores voluptas. Assumenda possimus assumenda et voluptatum. Facere soluta rerum nostrum eaque. Maxime consequuntur velit et et perspiciatis alias iste.
                    </div>
                    <div class="flex-1"></div>
                </div>
                <!-- sender message -->
                <div class="flex mb-4">
                    <div class="flex-1"></div>
                    <div
                        class="rounded-lg text-white p-3 max-w-md"
                        :class="{
                            'bg-blue': role == 'Producer',
                            'hover:bg-blue-dark': role == 'Producer',
                            'bg-green': role == 'Crew',
                            'hover:bg-green-dark': role == 'Crew',
                        }"
                    >
                        Eveniet et neque mollitia sed. Rem rem quis dolores ea est. Tempora sit tempore asperiores necessitatibus.
                    </div>
                </div>
                <!-- sender message -->
                <div class="flex mb-4">
                    <div class="flex-1"></div>
                    <div class="rounded-lg text-white bg-blue-dark p-3 max-w-md">
                        Awesome! You are the best!
                    </div>
                </div>
            </div>
        </div>
        <!-- bottom bar -->
        <div class="flex h-12 w-screen">
            <div class="w-1/5 flex border-t border-r border-black">
                <button
                    class="flex-1 flex justify-center items-center"
                    v-for="(role, index) in roles" :key="index"
                    :class="{
                        'bg-blue': role == 'Producer',
                        'bg-green': role == 'Crew'
                    }"
                    @click="setRole(index)"
                >
                    {{ role }}
                </button>
            </div>
            <div class="w-4/5 bg-grey-light flex justify-between items-center p-3">
                <input type="text" class="w-64 rounded-full flex-1 mr-2 px-3" placeholder="Aa">
                <button class="fa fa-paper-plane mr-1"></button>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Form from '../form.js';

    export default {
        name: "MessagesDashboardComponent",

        props: {
            roles: {
                type: Array,
                required: true
            },
            projects: {
                type: Array,
                required: true
            },
        },

        data() {
            return {
                role: this.roles[0],
            }
        },

        methods: {
            // TODO: move this to projects component when it is created
            getAcronymAttribute(text) {
                const words = text.split(' ');

                let acronym = '';

                for (let index = 0; index < 2; index++) {
                    const word = words[index];
                    acronym += word[0];
                }

                return acronym;
            },

            setRole(index) {
                this.role = this.roles[index];
            }
        }
    }
</script>

