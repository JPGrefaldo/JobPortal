<template>

</template>
<script type="text/javascript">
    export default {

        data () {
            return {
                checked: false,
                showForm: 'false',
            }
        },
        methods : {
            check() {
                this.checked = !this.checked;
                if(this.checked) {
                    this.showForm = true;
                }
            }
        }

    }
</script>

<style>
    .is-displayed {display:block;}
</style>
