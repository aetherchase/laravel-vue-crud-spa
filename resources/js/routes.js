import Products from "./components/Products";
import Categories from "./components/Categories";
import App from "./components/App";


export default{
    mode: 'history',
    history: true,

    routes: [
        {
            path:'/',
            component: App,
            children:[
                {
                    path: '/',
                    component: Products,
                },
                {
                    path:'/category',
                    component: Categories,
                },
                {
                    path: '/category/:category/products',
                    component: Products,
                    props: (route) => {
                        return {
                            'categoryId': parseInt(route.params.category, 10)
                        }
                    }
                }
            ]
        },
    ]
}
