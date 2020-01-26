<template>
    <div v-if="product" class="product-edit">
        <a @click.prevent ="showModal()" href="#" class="text-primary h-6">ред.</a>
        <modal-window name="product-edit-modal" ref="modal">
            <div class="card">
                <p class="card-title h6 font-weight-bold p-3 pt-4">Редактировать</p>
                <form class="form py-0 px-3 mb-0" @submit.prevent>
                    <div class="form-group row py-0 px-3">
                        <label for="product-name" class="form-label pb-0">Наименование</label>
                        <input v-model="title" id="product-name" class="form-control" placeholder="" >
                    </div>
                    <div class="form-group row py-0 px-3">
                        <label for="product-article" class="form-label pb-0">Артикул (нельзя изменить!)</label>
                        <input v-model="article" id="product-article" class="form-control" placeholder="" disabled>
                    </div>
                    <div class="form-group row py-0 px-3">
                        <label for="product-description" class="form-label pb-0">Описание</label>
                        <textarea v-model="description" id="product-description" class="md-textarea form-control" placeholder=""></textarea>
                    </div>
                    <h6>Категории</h6>
                    <div v-if="categories" class="d-flex align-content-start flex-wrap pl-1">
                        <div class="custom-control d-flex inline col-auto" v-for="category in categories" :key="category.id">
                            <input type="checkbox"
                                   :id="category.id"
                                   v-model="checkedCategories"
                                   :value="category.id"
                                   class="custom-control-input pr-1">
                            <label :for="category.id"
                                   class="custom-control-label pr-4 mt-2">{{category.name}}
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3 mb-2" @click.prevent="editProduct(product)">
                </form>
            </div>
        </modal-window>
    </div>
</template>
<style scoped>
    .card{
        max-width: 380px;
        padding-bottom: 0;
    }
    .btn{
        width: 100%;
    }
</style>
<script>
    import ModalWindow from "./ModalWindow";

    export default {
        name: "ProductEdit",
        props:{
            editingProduct: Object
        },
        components:{
            'modal-window': ModalWindow
        },
        data(){
            return{
                errors: false,
                isShow: false,
                title: '',
                article: '',
                description:'',
                checkedCategories:[],
                categories: this.$root.categories
            }
        },
        computed:{
            product: function () {
                return{
                    'id': this.editingProduct.id,
                    'title': this.title,
                    'description': this.description,
                    'categories': this.checkedCategories
                }
            }
        },
        methods: {
            showModal() {
                this.title = this.editingProduct.title;
                this.article = this.editingProduct.article;
                this.description = this.editingProduct.description;
                this.checkedCategories = this.editingProduct.categories.map((el)=>{
                    return el.id;
                });
                this.$refs.modal.show();
            },
            editProduct(product){
                this.$root.$emit('editProduct', product);
            },
            confirmProductEdit(){
                this.$refs.modal.close();
            }
        },
        created(){
            self = this;
            this.$root.$on('fetchCompleted',()=>{
                this.categories = this.$root.categories;
            });
            this.$root.$on('confirmProductEdit', ()=>{
                this.confirmProductEdit();
            })
        }
    }
</script>


