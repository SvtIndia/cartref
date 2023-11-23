import Dashboard from '../pages/Dashboard.vue'
import Orders from '../pages/Orders.vue'
import Showcases from '../pages/Showcases.vue'
import Wishlist from "../pages/Wishlist.vue";

const routes = [
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
    },
    {
        name: 'wishlists',
        path: '/admin/wishlists',
        component: Wishlist,
    }
]

export default routes;