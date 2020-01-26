<template>
    <div class="category-edit">
        <a @click.prevent ="showModal()" href="#" class="text-primary">Редактировать</a>
        <modal-window name="edit-category-modal" ref="modal">
                <div class="card">
                    <p class="card-title h6 font-weight-bold p-3">Новое название</p>
                    <form class="form-inline py-0 px-3" @submit.prevent>
                        <div class="form-group py-0">
                            <input v-model="newCategoryName"
                                   class="form-control"
                                   :placeholder="oldCategory.name">
                            <button class="btn btn-primary"
                                    @keyup.enter="editCategory(category)"
                                    @click="editCategory(category)">Заменить</button>
                        </div>
                    </form>
                </div>
        </modal-window>
    </div>
</template>
<style scoped>
</style>

<script>
    import ModalWindow from "./ModalWindow";

    export default {
        name: "EditCategory",
        components: {
            'modal-window': ModalWindow
        },
        props: {
            oldCategory: Object
        },
        computed:{
            category:function () {
                return{
                    'id': this.oldCategory.id,
                    'name': this.newCategoryName
                }
            }
        },
        data(){
            return{
                errors: false,
                isShow: false,
                newCategoryName: ''
            }
        },
        methods:{
            showModal() {
                this.newCategoryName = this.oldCategory.name;
                this.$refs.modal.show();
            },
            editCategory(category){
                this.$root.$emit('editCategory', category);
            },
            confirmCategoryEdit(){
                this.$refs.modal.close();
            },
        },
        created(){
            this.$root.$on('confirmCategoryEdit',()=>{
                this.confirmCategoryEdit();
            });
        }
    }
</script>


