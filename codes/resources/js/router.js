
import VueRouter from 'vue-router'
import Dashboard from './components/Dashboard.vue'
import Orders from './components/Orders.vue'
import Showcases from './components/Showcases.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            name: 'dashboard',
            path: '/admin/dashboard',
            component: Dashboard,
        },
        {
            name: 'orders',
            path: '/admin/orders',
            component: Orders,
        },
        {
            name: 'showcases',
            path: '/admin/showcases',
            component: Showcases,
        }
    ]
});


export default router;

