import { createRouter, createWebHistory } from 'vue-router'
const Home = () => import('@/components/views/Home.vue')
const Categories = () => import('@/components/views/Categories/Index.vue')
const CategoriesAdd = () => import('@/components/views/Categories/Add.vue')
const CategoriesEdit = () => import('@/components/views/Categories/Edit.vue')
const Products = () => import('@/components/views/Products/Index.vue')
const ProductsAdd = () => import('@/components/views/Products/Add.vue')
const ProductsEdit = () => import('@/components/views/Products/Edit.vue')
const Shop = () => import('@/components/views/Shop/Index.vue')

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: { title: 'Mishkat Nour | Home' }
    },
    {
        path: '/categories',
        name: 'Categories',
        component: Categories,
        meta: { title: 'Mishkat Nour | Categories' }
    },
    {
        path: '/categories/add',
        name: 'CategoriesAdd',
        component: CategoriesAdd,
        meta: { title: 'Mishkat Nour | Add Category' }
    },
    {
        path: '/categories/edit/:id',
        name: 'EditCategory',
        component: CategoriesEdit,
        props: true,
        meta: { title: 'Mishkat Nour | Add Category' }
    },
    {
        path: '/products',
        name: 'Products',
        component: Products,
        meta: { title: 'Mishkat Nour | Products' }
    },
    {
        path: '/products/add',
        name: 'ProductsAdd',
        component: ProductsAdd,
        meta: { title: 'Mishkat Nour | Add Product' }
    },
    {
        path: '/products/edit/:id',
        name: 'EditProduct',
        component: ProductsEdit,
        props: true,
        meta: { title: 'Mishkat Nour | Add Product' }
    },
    {
        path: '/shop',
        name: 'Shop',
        component: Shop,
        meta: { title: 'Mishkat Nour | Shop Products' }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import('@/components/views/NotFound.vue')
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { top: 0 }
        }
    }
})


export default router
