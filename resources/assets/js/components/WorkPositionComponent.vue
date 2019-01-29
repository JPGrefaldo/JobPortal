<template>

</template>
<script type="text/javascript">
    export default {

        data () {
            return {
                checked: false,
                showForm: true,
            }
        },
        methods : {
            check() {
                this.checked = !this.checked;
                if(this.checked) {
                    this.showForm = false;
                }
                else {
                    this.showForm = true;
                }
            }
        }

    }
</script>

<style>
    .is-displayed {display:none;}
</style>
