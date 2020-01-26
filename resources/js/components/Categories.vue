<template>
    <div>
        <div class="new_category my-3">
            <form class="form-inline py-0" @submit.prevent>
                <div class="form-group py-0">
                    <input v-model="newCategory"
                           class="form-control"
                           placeholder="Новая категория">
                    <button class="btn btn-primary"
                            @keypress.enter="createCategory(category)"
                            @click="createCategory(category)">Добавить
                    </button>
                </div>
            </form>
        </div>
        <div v-if="isShowMessage" class="message">
            <p v-text="messageText"></p>
        </div>
        <div class="content">
            <table class="table table-striped ">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Наименование категории</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr v-for="category in categories" :key="category.id">
                    <th scpoe="row">{{category.id}}</th>
                    <td>{{category.name}}</td>
                    <td>
                        <category-edit :old-category="category"></category-edit>
                    </td>
                    <td><a @click.prevent="deleteCategory(category)" href="#"
                           class="text-danger">Удалить</a></td>
                </tr>
            </table>
            <p class="mt-3">Внимание, родукты, оставшиеся без привязанной категории будут удалены!</p>

        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import CategoryEdit from "./CategoryEdit";


    export default {
        data() {
            return {
                categories: [],
                newCategory: '',
                showModal: false,
                isShowContent: false,
                messageText: '',
                isShowMessage: false,
                showTooltip: ''
            }
        },
        computed: {
            category:function(){
                return{
                    'name': this.newCategory
                };
            }
        },
        components: {
            CategoryEdit
        },
        name: "Categories",
        methods: {
            //
            //category
            //
            //
            switchTooltip(){
                this.showTooltip = !this.showTooltip;
            },
            createCategory(category) {
                console.log(category);
                axios.post('/api/category', category)
                    .then(response => {
                        this.$root.fetchCategories();
                        this.newCategory = '';
                        this.showMessage = false;
                    })
                    .catch(error => {
                        this.showMessage(error)
                    })
            },
            editCategory(category) {
                axios.put('/api/category/' + category.id, category)
                    .then( ()=>{
                        this.$root.fetchCategories();
                        this.$root.$emit('confirmCategoryEdit');
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            deleteCategory(category) {
                axios.delete('/api/category/' + category.id)
                    .then(()=>{
                        this.$root.fetchCategories()
                    });
                this.$root.fetchCategories();
            },
            showMessage(message) {
                this.isShowMessage = true;
                this.messageText = message;
            },
        },
        /*beforeUpdate(){
            console.log(this.categories);
        },*/
        created() {
            this.categories = this.$root.categories;
            this.$root.$on('fetchCompleted',()=>{
                this.categories = this.$root.categories;
            });
            this.$root.$on('editCategory',(category)=>{
                //console.log('emiter cathed');
                this.editCategory(category);
            });
        }
    }
</script>

<style scoped> /*lang="css"*/

</style>
