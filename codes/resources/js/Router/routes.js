import Dashboard from '../pages/Dashboard.vue'
import Orders from '../pages/Orders.vue'
import Showcases from '../pages/Showcases.vue'
import Wishlist from "../pages/Wishlist.vue";
import Cart from "../pages/Cart.vue";
import Category from "../pages/Category.vue";
import SubCategory from "../pages/SubCategory.vue";
import Products from "../pages/Products.vue";
import ProductColors from "../pages/ProductColors.vue";
import ProductSizes from "../pages/ProductSizes.vue";
import ProductColorEdit from "../pages/ProductColorEdit.vue";

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
        name: 'product-colors',
        path: '/admin/products/:id',
        component: ProductColors,
    },
    {
        name: 'product-color-edit',
        path: '/admin/products/:product_id/color/:color_id',
        component: ProductColorEdit,
    },
    {
        name: 'product-sizes',
        path: '/admin/products/:product_id/color/:color_id/sizes',
        component: ProductSizes,
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
