<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-3 pt-2">
                <router-link to="/" class="row">Главная</router-link>
                    <div class="row">
                    <h4 class="mt-2 mb-0">Категории </h4>
                    <span class="badge badge-default pt-3 mt-1 mb-2">
                    <router-link to="/category"> ред.</router-link>
                    </span>
                </div>

                <router-link class="row flex" v-for="category in categories" :key="category.id" :to="createLinkTo(category.id)">
                    {{ category.name }}
                </router-link>
            </div>
            <div class="col-9">
                <h4>{{pageTitle}}</h4>
                <router-view :key="$route.fullPath"></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                categories: this.$root.categories
            }
        },
        computed:{
            pageTitle: function () {
                let path = this.$route.fullPath;
                switch(path){
                    case '/': return 'Главная';
                    case '/category': return 'Управление категориями';
                    default:
                        if (this.categories.length > 0){
                            let id = this.$route.params.category;
                            return this.categories.find(category => parseInt(category.id) === parseInt(id)).name;
                        }
                }
                return '...'
            }
        },
        methods: {
            createLinkTo(categoryId) {
                return '/category/' + categoryId + '/products';
            },
        },
        created(){
            this.$root.$on('fetchCompleted',()=>{
                this.categories = this.$root.categories;
            });
        }
    }
</script>

<style scoped>

</style>
