require('./bootstrap');
import Vue from 'vue';
import routes from './routes';
import VueRouter from "vue-router";

Vue.use(VueRouter);


const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    data: {
        isLoaded: false,
        categories: []
    },
    methods:{
        fetchCategories(){
            axios.get('/api/category')
                .then(response => {
                    this.categories = response.data.data;
                    this.$emit('fetchCompleted')
                })//срабатывает раньше строки выше о_О
                .catch(error => {
                    console.log(error)
                });
        }
    },
    beforeRouteEnter: {
        '$route': 'fetchCategories'
    },
    created(){
        this.fetchCategories();
    }
});
