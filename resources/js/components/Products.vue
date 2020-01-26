<template>
    <div class="products">
        <product-create class="mt-4"></product-create>
        <hr>
        <div v-if="isShowMessage" class="message">
            <p v-text="messageText"></p>
        </div>
        <!--todo: пагинация-->
        <div class="content">
            <div class="row">
                <product-cart v-for="product in showingProducts"
                              :key="product.id"
                              :product="product"
                class="mt-3 col-4">
                </product-cart>
            </div>
        </div>
    </div>
</template>

<script>
    import ProductCreate from "./ProductCreate";
    import ProductCard from "./ProductCard";

    export default {
        name: "Products",
        components: {
            'product-create': ProductCreate,
            'product-cart': ProductCard
        },
        props: {
            categoryId: {
                type: Number,
                default: 0,
            }
        },
        data() {
            return {
                products: [],
                isShowMessage: false,
                isShowContent: false
            }
        },
        computed: {
            showingProducts: function () {
                if (this.categoryId === 0) {
                    return this.products;
                } else {
                    return this.products.filter(product => {
                        return product.categories.map((el) => {
                            return el.id
                        }).includes(this.categoryId);
                    });
                }
            },
        },
        methods: {
            showMessage(message) {
                console.log('msg');
                this.isShowMessage = true;
                this.messageText = message;
            },
            fetchProducts() {
                axios.get('/api/product')
                    .then(response => {
                        this.products = response.data.data;
                    })
                    .catch(error => console.log(error));
            },
            createProduct(product) {
                axios.post('/api/product', product)
                    .then(()=>{
                        this.$root.$emit('confirmProductCreate');
                        this.fetchProducts();
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            editProduct(product) {
                console.log('editing product..');
                axios.put('/api/product/' + product.id, product)
                    .then(()=>{
                        this.$root.$emit('confirmProductEdit');
                        this.fetchProducts();
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            deleteProduct(product) {
                axios.delete('/api/product/' + product.id)
                    .then(()=>{
                        this.fetchProducts()
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
        },
        mounted() {
            this.fetchProducts()
        },
        created() {

            //self = this;
            this.$root.$on('createProduct',  (product)=>{
                this.createProduct(product)
            });
            this.$root.$on('editProduct',(product)=>{
                this.editProduct(product);
            });
            this.$root.$on('deleteProduct', (product)=>{
                this.deleteProduct(product)
            });
        }
    }
</script>

<style scoped>

</style>
