import {createRouter, createWebHistory} from "vue-router";
import Layout from "../Layout.vue";
import Car from "../pages/Car.vue";
import Manufacturer from '../pages/Manufacturer.vue'

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
