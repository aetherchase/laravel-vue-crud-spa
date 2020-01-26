<template>
    <div class="product-card ">
        <div class=" card col-12 px-3">
            <div class="card-body">
                <p class="h-4 cyan-text">{{product.title}}</p>
                <hr>
                <p>{{product.description}}</p>
                <hr>
                <p class="grey-text">Артикул товара: {{product.article}}</p>
                <div class="row d-flex inline px-3">
                    <product-edit :editing-product="product">
                    </product-edit>
                    <a class="ml-auto text-danger" href="#" @click.prevent="$root.$emit('deleteProduct', product)">удалить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ProductEdit from "./ProductEdit";

    export default {
        name: "ProductCard",
        components:{
            'product-edit': ProductEdit
        },
        props:{
            product: Object
        },
    }
</script>

<style scoped>

</style>
