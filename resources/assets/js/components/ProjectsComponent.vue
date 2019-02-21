<template>
    <div class="bg-grey-dark overflow-auto p-1 w-12">
        <!-- project -->
        <div v-if="projects.length === 0">
            <button class="flex justify-center items-center h-10 w-full mb-1 rounded uppercase text-white font-bold"
                :class="getColorByRole(role)"
                :title="getEmptyTitle"
                @click="onClickRedirect">
                +
            </button>
        </div>
        <div v-else>
            <button v-for="project in projects" :key="project.id"
                class="flex justify-center items-center h-10 w-full mb-1 rounded uppercase text-white font-bold"
                :class="getColorByRole(role)"
                :title="project.title"
                @click="$emit('onClickSetProject', project)"
            >
                {{ getAcronymAttribute(project.title) }}
            </button>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { color } from '../mixins'

    export default {
        
        props: {
            role: {
                type: String,
                required: true
            },
            projects: {
                type: Array,
                required: false
            },
        },

        mixins: [
            color
        ],

        data() {
            return {
                roleAttributes: {
                    Producer: {
                        title: 'Create a new project.',
                        redirect: '/producer/projects/create',
                    },
                    Crew: {
                        title: 'Join a project.',
                        redirect: '/projects',
                    },
                }
            }
        },

        computed: {
            getEmptyTitle() {
                return this.roleAttributes[this.role].title;
            }
        },

        methods: {
            getAcronymAttribute(text) {
                text = text.replace('-', ' ')

                const words = text.split(' ')

                if (words.length === 1) {
                    return text[0]
                }

                let acronym = ''

                for (let index = 0; index < 2; index++) {
                    const word = words[index]
                    acronym += word[0]
                }

                return acronym
            },

            onClickSetProject(project) {
                this.$emit('setProject', project)
            },

            onClickRedirect() {
                this.redirect();
            },

            redirect() {
                window.open(this.roleAttributes[this.role].redirect);
            }
        }
    }
</script>
