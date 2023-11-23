import Dashboard from '../pages/Dashboard.vue'
import Orders from '../pages/Orders.vue'
import Showcases from '../pages/Showcases.vue'
import Wishlist from "../pages/Wishlist.vue";
import Cart from "../pages/Cart.vue";

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
        name: 'carts',
        path: '/admin/carts',
        component: Cart,
    },
    {
        name: 'wishlists',
        path: '/admin/wishlists',
        component: Wishlist,
    }
]

export default routes;