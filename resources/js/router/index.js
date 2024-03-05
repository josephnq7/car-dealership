import {createRouter, createWebHistory} from "vue-router";
import Layout from "../Layout.vue";
import Car from "../pages/Car.vue";

const routes = [
    {
        path: '/',
        component: Layout,
        children: [
            {
                path: '',
                component: Car
            }
        ]
    }
];


const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
