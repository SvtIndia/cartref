import Dashboard from '../pages/Dashboard.vue'
import Orders from '../pages/Orders.vue'
import Showcases from '../pages/Showcases.vue'
import Wishlist from "../pages/Wishlist.vue";
import Cart from "../pages/Cart.vue";
import Category from "../pages/Category.vue";
import SubCategory from "../pages/SubCategory.vue";

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
        name: 'category',
        path: '/admin/product/category',
        component: Category,
    },
    {
        name: 'sub-category',
        path: '/admin/product/sub-category',
        component: SubCategory,
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
