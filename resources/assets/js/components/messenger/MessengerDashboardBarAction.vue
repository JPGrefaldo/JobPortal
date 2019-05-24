<template>
    <div class="flex h-12 w-screen">
        <div class="w-1/5 flex border-t border-r border-black">
            <button
                class="flex-1 flex justify-center items-center"
                v-for="(role, index) in roles"
                :key="index"
                :class="getColorByRole(role)"
                @click="onClickSetRole(index)"
            >
                {{ role }}
            </button>
        </div>
        <div class="w-4/5 bg-grey-light flex justify-between items-center p-3">
            <label class="checkbox-control">
                Save
                <input
                    name="Post add on these websites"
                    type="checkbox"
                    value="all"
                    v-model="saveTemplate"
                />
                <div class="control-indicator"></div>
            </label>
            <input
                v-model="message"
                type="text"
                class="w-64 rounded-full flex-1 mr-2 px-3"
                placeholder="Aa"
            />
            <button class="fa fa-paper-plane mr-1" @click.stop="sendMessage"></button>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { alert, color } from '../../mixins';

export default {
    props: ['roles', 'user'],

    mixins: [alert, color],

    data() {
        return {
            message: null,
            saveTemplate: false
        };
    },

    computed: {
        ...mapGetters({
            thread: 'thread/thread',
            participant: 'thread/participant',
        }),
    },

    methods: {
        onClickSetRole(index) {
            this.setRole(index);

            this.$store.commit('message/MESSAGES', []);
            this.$store.commit('project/PROJECT', []);
            this.$store.commit('project/PROJECTS', []);
            this.$store.commit('thread/THREADS', []);

            this.$store.dispatch('project/fetch', this.role.toLowerCase());
        },

        setRole(index) {
            this.role = this.roles[index];
        },

        sendMessage() {
            if (this.saveTemplate) {
                this.saveMessageTemplate(this.message)
            }

            let params = {
                message: this.message,
                thread: this.thread.id,
                recipient: this.participant
            };
            this.$store.dispatch('message/saveReply', params);
        },

        saveMessageTemplate(message) {
            this.$store
                .dispatch('message/saveAsTemplate', {message})
                .then(response => {
                    this.displaySuccess(response)
                })
        }
    },
};
</script>
