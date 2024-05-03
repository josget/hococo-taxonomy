import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        component: () => import('./Pages/Node.vue'),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});