<template>
    <!-- conversation -->
    <div class="w-4/5 bg-white flex flex-col p-4">
        <div v-for="message in messages"
            :key="message.id">
            <!-- sender message template -->
            <div v-if="isSender(message)"
                class="flex mb-4">
                <div class="flex-1"></div>
                <div class="rounded-lg text-white p-3 max-w-md"
                    :class="getColorByRole(role)">
                    {{ message.body }}
                </div>
            </div>
            <!-- recipeint message template -->
            <div v-else
                class="flex items-center justify-center mb-4">
                <div class="mr-4 border h-10 w-10 rounded-full bg-white background-missing-avatar"></div>
                <div class="rounded-lg bg-grey-light p-3 max-w-md">
                    {{ message.body }}
                </div>
                <div class="flex-1"></div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {

        props: {
            user: {
                type: Object,
                required: true,
            },
            role: {
                type: String,
                required: true
            },
            messages: {
                type: Array,
                required: false
            },
        },

        data() {
            return {
            }
        },

        methods: {
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
                }

                return colorDictionary[role]
            },

            isSender: function (message) {
                return message.user_id === this.user.id
            }
        }
    }
</script>
