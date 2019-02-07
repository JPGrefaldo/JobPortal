<template>
    <div>
        <div class="py-2">
            <label class="checkbox-control">
                <h3 class="text-md" v-text="position.name"></h3>
                <input type="checkbox" v-model="selected">
                <div class="control-indicator"></div>
            </label>
        </div>
        <div v-if="selected">
            <div class="p-2 md:p-4 border-t-2 border-grey-lighter bg-white">
                    <div class="py-2">
                        <div class="mb-2">
                            <textarea class="form-control w-full h-64"
                                      placeholder="Biography"
                                      v-model="form.bio">
                            </textarea>
                        </div>
                    </div>
                    <div class="py-2">
                        <div class="mb-2">
                                <textarea class="form-control w-full h-64"
                                          placeholder="Union Description"
                                          v-model="form.description">
                                </textarea>
                        </div>
                    </div>
                    <div class="border-t-2 border-grey-lighter py-4">
                        <div class="md:flex">
                            <div class="md:w-1/3 pr-8">
                                <h3 class="text-md font-header mb-2 md:mb-0">Resume</h3>
                            </div>
                            <div class="md:w-2/3">
                                <label for="resume"
                                       class="btn-outline text-green inline-block" >Upload file</label>
                                <input type="file"
                                       name="resume"
                                       class="invisible">
                            </div>
                        </div>
                    </div>
                    <div class="border-t-2 border-grey-lighter py-4">
                        <div class="md:flex">
                            <div class="md:w-1/3 pr-8">
                                <h3 class="text-md font-header mt-2 mb-2 md:mb-0">Reel</h3>
                            </div>
                            <div class="md:w-2/3">
                                <input type="text"
                                       class="form-control bg-light w-64 mr-2 mb-2 md:mb-0"
                                       placeholder="Add link"
                                       v-model="form.reel_link"> or
                                <label for="resume" class="btn-outline text-green inline-block" >Upload file</label>
                                <input type="file"
                                       name="resume"
                                       class="invisible">
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
                                        <input type="checkbox" class="toggle_input" v-model="has_gear"/>
                                        <div class="toggle-control"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="md:flex" v-if="has_gear">
                            <div class="md:w-1/3 pr-8">
                            </div>
                            <div class="md:w-2/3">
                                <h3 class="text-md font-header mt-2 mb-2 md:mb-0">What gear do you have for this position?</h3>
                                <br>
                                <div class="mb-2">
                                    <textarea class="form-control w-full h-64"
                                              placeholder="Your gear"
                                              v-model="form.gear"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                    <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                    <a href="#" class="btn-green" @click="onClickSave">SAVE CHANGES</a>
                </div>
            </div>

        </div>
</template>

<script>
    import { Form, HasError, AlertError } from 'vform';

    export default {
        name: "PositionComponent",
        props : {
            position: Object,
        },
        data () {
            return{
                has_gear: false,
                selected: false,
                form: new Form({
                    bio: "",
                    reel_link: "",
                    gear: "",
                    description: "",
                    position: this.position.id,
                })
            }
        },
        methods: {
            onClickSave: function() {
                this.saveCrewPosition();
            },

            saveCrewPosition: function() {
                this.form.post('/crew/positions/' + this.position.id);
            },

        }

    }
</script>

