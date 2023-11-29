import Dashboard from '../pages/Dashboard.vue'
import Orders from '../pages/Orders.vue'
import Showcases from '../pages/Showcases.vue'
import Wishlist from "../pages/Wishlist.vue";
import Cart from "../pages/Cart.vue";
import Category from "../pages/Category.vue";
import SubCategory from "../pages/SubCategory.vue";
import Products from "../pages/Products.vue";
import ProductColors from "../pages/ProductColors.vue";

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
        name: 'products',
        path: '/admin/products',
        component: Products,
    },
    {
        name: 'product_colors',
        path: '/admin/products/:id',
        component: ProductColors,
    },
    {
        name: 'category',
        path: '/admin/products/category',
        component: Category,
    },
    {
        name: 'sub-category',
        path: '/admin/products/sub-category',
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
