<template>
    <div class="product-create">
        <a @click.prevent ="showModal()" href="#" class="text-primary">Добавить новый товар</a>
        <modal-window name="product-create-modal" ref="modal">
            <div class="card">
                <p class="card-title h6 font-weight-bold p-3 pt-4">Новый товар</p>
                <form class="form py-0 px-3 mb-0" @submit.prevent>
                    <div class="form-group row py-0 px-3">
                        <label for="product-name" class="form-label pb-0">Наименование</label>
                        <input v-model="title" id="product-name" class="form-control" placeholder="">
                    </div>
                    <div class="form-group row py-0 px-3">
                        <label for="product-article" class="form-label pb-0">Артикул (нельзя изменить!)</label>
                        <input v-model="article" id="product-article" class="form-control" placeholder="">
                    </div>
                    <div class="form-group row py-0 px-3">
                        <label for="product-description" class="form-label pb-0">Описание</label>
                        <textarea v-model="description" id="product-description" class="md-textarea form-control" placeholder=""></textarea>
                    </div>
                    <h6>Категории</h6>
                    <div class="d-flex align-content-start flex-wrap pl-1">
                        <div class="custom-control  col-10" v-for="category in categories" :key="category.id">
                            <input type="checkbox"
                                   :id="categoryId(category.id)"
                                   v-model="checkedCategories"
                                   :value="category.id"
                                   class="custom-control-input pr-1">
                            <label :for="categoryId(category.id)"
                                   class="custom-control-label pr-4 mt-2">{{category.name}}
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3 mb-2" @click.prevent="createProduct(product)">
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
        name: "ProductCreate",
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
            product:function(){
                return{
                    'title': this.title,
                    'article': this.article,
                    'description': this.description,
                    'categories': this.checkedCategories
                };
            }
        },
        methods: {
            categoryId(id){
                return 'category'+id;
            },
            showModal() {
                this.$refs.modal.show();
            },
            createProduct(product) {
                this.$root.$emit('createProduct', product);
            },
            confirmProductCreate(){
                this.$refs.modal.close();
            }
        },
        created(){
            this.$root.$on('fetchCompleted',()=>{
                this.categories = this.$root.categories;
            });
            this.$root.$on('confirmProductCreate', ()=>{
                this.confirmProductCreate();
            })
        }
    }
</script>


