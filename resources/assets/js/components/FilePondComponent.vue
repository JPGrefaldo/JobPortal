<template>
    <div>  
        <file-pond class="w-2/5" name="photo" ref="photo" label-idle="Drop files here or <span class='filepond--label-action'>Browse</span>"
            allow-multiple="true" accepted-file-types="image/jpeg, image/png" v-bind:files="myFiles"/>
        <button @click="createPhoto" class="btn-blue">UPDATE PHOTO</button>
    </div>
</template>

<script>

// Import FilePond styles
import 'filepond/dist/filepond.min.css'

// Import image preview plugin styles
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'

import { vueFilePond, FilePondPluginFileValidateType, FilePondPluginImagePreview } from '../filepond.js' 

import { setOptions } from 'vue-filepond'

setOptions({
    server: {
        url: 'http://localhost:8000',
        process: {
            url: '/crew/photos',
            method: 'POST',
            withCredentials: false,
            headers: {},
            onload: null,
            onerror: null,
            ondata: null
        }
    }
})

// Create component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
)
export default {
    name: 'FilePondDemo',
    data: function() {
        return { myFiles: [] }
    },
    components: {
        FilePond,
        vueFilePond,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    }
  }
</script>
