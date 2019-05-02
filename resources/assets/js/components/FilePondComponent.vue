<template>

    <file-pond 
        class="w-2/5"
        name="photo"
        ref="pond"
        label-idle="Drop image here or <span class='filepond--label-action'>Browse</span>"
        accepted-file-types="image/jpeg, image/png"
        v-bind:files="myFiles"
    />

</template>

<script>

// Import FilePond styles
import 'filepond/dist/filepond.min.css'

// Import image preview plugin styles
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'

import { vueFilePond, FilePondPluginFileValidateType, FilePondPluginImagePreview } from '../filepond.js' 

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
