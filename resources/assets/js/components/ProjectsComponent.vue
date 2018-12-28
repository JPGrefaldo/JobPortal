<template>
    <div class="bg-grey-dark overflow-auto p-1 w-12">
        <!-- project -->
        <button class="flex justify-center items-center h-10 w-full mb-1 rounded uppercase text-white font-bold"
            v-for="project in projects" :key="project.id"
            :class="getColorByRole(role)"
            @click="$emit('onClickSetProject', project)"
        >
            {{ getAcronymAttribute(project.title) }}
        </button>
    </div>
</template>

<script type="text/javascript">
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

        data() {
            return {
            }
        },

        methods: {
            getAcronymAttribute(text) {
                text = text.replace('-', ' ');

                const words = text.split(' ');

                if (words.length === 1) {
                    return text[0];
                }

                let acronym = '';

                for (let index = 0; index < 2; index++) {
                    const word = words[index];
                    acronym += word[0];
                }

                return acronym;
            },

            getColorByRole: function (role) {
                const colorDictionary = {
                    Producer: [
                        'bg-blue',
                        'hover:bg-blue-dark',
                    ],
                    Crew: [
                        'bg-green',
                        'hover:bg-green-dark',
                    ]
                };

                return colorDictionary[role];
            },

            onClickSetProject: function (project) {
                this.$emit('setProject', project);
            }
        }
    }
</script>
