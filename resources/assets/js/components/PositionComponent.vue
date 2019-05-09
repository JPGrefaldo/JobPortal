<template>
    <div>
        <div class="py-2">
            <label class="checkbox-control">
                <h3 class="text-md" v-text="position.name"></h3>
                <input type="checkbox" v-model="selected" />
                <div class="control-indicator"></div>
            </label>
        </div>
        <div v-if="selected">
            <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                <div class="py-2">
                    <div class="mb-2">
                        <textarea
                            class="form-control w-full h-64"
                            placeholder="Position Biography"
                            v-model="form.bio"
                        >
                        </textarea>
                    </div>
                </div>
                <div class="py-2">
                    <div class="mb-2">
                        <input
                            type="text"
                            class="form-control w-full"
                            placeholder="Union Description"
                            v-model="form.union_description"
                        />
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mb-2 md:mb-0">Resume</h3>
                        </div>
                        <div class="md:w-2/3">
                            <button for="resume" class="btn-outline text-green inline-block" @click="uploadResume()">
                                Upload file
                            </button>
                            <input id="crewResume" class="hidden" type="file" name="resume" ref="resume" @change="onResumeChange" />
                        </div>
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Reel</h3>
                        </div>
                        <div class="md:w-2/3">
                            <input
                                type="text"
                                class="form-control bg-light w-64 mr-2 mb-2 md:mb-0"
                                placeholder="Add link"
                                v-model="form.reel_link"
                            />
                            or
                            <label for="reel" class="btn-outline text-green inline-block"
                                >Upload file</label
                            >
                            <input id="reel" type="file" name="reel" class="hidden" />
                        </div>
                    </div>
                </div>
                <div class="border-t-2 border-grey-lighter py-4">
                    <div class="md:flex">
                        <div class="md:w-1/3 pr-8">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Gear</h3>
                        </div>
                        <div class="md:w-2/3">
                            <div class="display">
                                <label class="label toggle">
                                    <input
                                        type="checkbox"
                                        class="hidden"
                                        v-model="has_gear"
                                    />
                                    <span
                                            class="border rounded-full border-grey flex items-center cursor-pointer my-4 w-12"
                                            v-bind:class="[has_gear ? 'switch-on' : 'switch-off']"
                                    >
                                    <span class="rounded-full border w-6 h-6 border-grey shadow-inner bg-white shadow"></span>
                                    </span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="md:flex" v-if="has_gear">
                        <div class="md:w-1/3 pr-8"></div>
                        <div class="md:w-2/3">
                            <h3 class="text-md font-header mt-2 mb-2 md:mb-0">
                                What gear do you have for this position?
                            </h3>
                            <br />
                            <div class="mb-2">
                                <textarea
                                    class="form-control w-full h-64"
                                    placeholder="Your gear"
                                    v-model="form.gear"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                <button class="text-grey bold mr-4 hover:text-green" @click="selected = false">Cancel</button>
                <button class="btn-green" v-if="position_exists" @click="onClickSave">UPDATE CHANGES</button>
                <button class="btn-green" v-else @click="onClickSave">SAVE CHANGES</button>
            </div>
        </div>
    </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform';
import { mapGetters } from 'vuex';

export default {
    name: 'PositionComponent',
    props: {
        position: Object,
    },
    data() {
        return {
            position_exists: false,
            has_gear       : false,
            selected       : false,
            form: new Form({
                bio              : '',
                union_description: '',
                resume           : null,
                reel_link        : '',
                reel_file        : null,
                gear             : '',
                position         : this.position.id,
            }),
        };
    },
    computed: {
        ...mapGetters({
            existingCrewPositions: 'crew/existingCrewPositions',
            crewPositionInfo     : 'crew/crewPositionInfo',
        })
    },
    methods: {
        onClickSave: function() {
            this.saveCrewPosition();
        },

        uploadResume: function() {
            document.getElementById("crewResume").click();
        },

        onResumeChange: function(e) {
            let vm = this;
            vm.form.resume = e.target.files[0];
        },

        saveCrewPosition: function() {
            if (this.position_exists)
                this.$store.dispatch('crew/updateCrewPositionInfo', this.form);
            else
                this.$store.dispatch('crew/addCrewPositionInfo', this.form);
        },

        checkExistingCrewPosition: function() {
            if (this.existingCrewPositions.includes(this.position.id)) {
                this.selected        = true;
                this.position_exists = true;

                this.$store.dispatch('crew/fetchCrewPositionInfo', this.position.id);

                setTimeout(() => this.fetchCrewPosition(), 2000);
            }
            else
                this.selected = false;
        },

        fetchCrewPosition: function() {
            this.form.bio               = this.crewPositionInfo.crewPosition.details;
            this.form.union_description = this.crewPositionInfo.crewPosition.union_description;

            if (this.crewPositionInfo.reel != null) {
                this.form.reel_link = this.crewPositionInfo.reel.path;
            }

            if (this.crewPositionInfo.gear != null) {
                this.has_gear = true;
                this.form.gear = this.crewPositionInfo.gear.description;
            }
        },
    },
    mounted() {
        this.$store.dispatch('crew/checkExistingCrewPosition');
        setTimeout(() => this.checkExistingCrewPosition(), 2000);
    },
};
</script>
