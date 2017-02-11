<template>
    <div class="modal-mask">
        <div class="modal-wrap">
            <div class="modal-block">
                <div class="modal-buttons">
                    <button class="btn btn-xs btn-default" v-on:click="$emit('close')"><span class="glyphicon glyphicon-remove"></span></button>
                </div>

                <div class="modal-title">
                    Modal's title
                </div>

                <div class="modal-container">
                    My own fucking modal ! Aw yiss ! My own fucking modal ! Aw yiss ! My own fucking modal ! Aw yiss ! My own fucking modal ! Aw yiss !
                </div>

                <div class="modal-validation">
		    <button class="btn btn-lg btn-default" v-on:click="$emit('close')">fermer</button>
                </div>
            </div>
        </div>
    </div>
  </template>

<script>

export default {

    data () {
        return {

        }
    },
    components: {

    }
}
                    </script>
