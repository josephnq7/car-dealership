import {createRouter, createWebHistory} from "vue-router";
import Layout from "../Layout.vue";
import Car from "../pages/car/index.vue";
import Customer from "../pages/customer/index.vue";
import Manufacturer from '../pages/manufacturer/index.vue'
import Detail from "../components/Detail.vue";

const routes = [
    {
        path: '/',
        component: Layout,
        children: [
            {
                path: '',
                component: Car
            },
            {
                path: 'car',
                component: Car
            },
            {
                path: 'customer',
                component: Customer
            },
            {
                path: '/:model/:id',
                component: Detail, props: true
            },
            {
                path: 'manufacturer',
                component: Manufacturer
            }
        ]
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
