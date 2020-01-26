<template>
    <div :class="position" class="modal-wrapper" v-if="modalIsDisplayed">
        <div class="modal-curtain" @click="close()"></div>
        <div class="modal-content">
            <slot></slot>
        </div>
    </div>
</template>
<style scoped>
    .modal-wrapper{
        position: fixed;
        min-height: 100%;
        min-width: 100%;
        left: 0;
        top: 0;
        z-index: 98;
    }
    .modal-curtain{
        position: fixed;
        min-height: 100%;
        min-width: 100%;
        left: 0;
        top: 0;
        background-color: rgba(0,0,0,0.28);
        z-index: 99;
    }
    .modal-content{
        position: fixed;
        left: 50%;
        top: 20%;
        transform: translate(-50%, 0);
        width: inherit;
        z-index: 100;
        box-shadow: none;
    }
</style>
<script>
    export default {
        name: "ModalWindow",
        props:{
            position:{
                type: String,
                default: 'related'
            }
        },
        data(){
            return{
                modalIsDisplayed: false,
            }
        },
        methods:{
            show(){
                this.modalIsDisplayed = true;
            },
            close(){
                this.modalIsDisplayed = false;
            }
        }
    }
</script>


