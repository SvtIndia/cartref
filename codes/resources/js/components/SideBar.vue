<template>
    <div class="max-h-screen bg-gray-100 z-10 fixed left-0 bottom-0 top-12 xl:top-16">
        <div class="sidebar group hidden md:block" id="sidenav">
            <div class="flex h-screen overflow-auto custom-scrollbar flex-col justify-between pb-6">
                <ul class="space-y-1 tracking-wide">
                    <li class="min-w-max">
                        <router-link :to="{ name: 'dashboard' }" class="single-item">
                            <i class="fi fi-rr-dashboard"></i>
                            <span class="-mr-1 font-medium">Dashboard</span>
                        </router-link>
                    </li>
                    <li class="min-w-max">
                        <router-link :to="{ name: 'orders' }" class="single-item">
                            <i class="fi fi-rr-boxes"></i>
                            <span class="">Orders</span>
                        </router-link>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': showcases }" @click="showcases = !showcases;"
                            class="group dropdown-btn">
                            <i class="fi fi-rr-house-chimney"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Showcases At Home</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="showcases"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!showcases"></i>
                            </span>
                        </a>
                        <ul v-if="showcases" class="dropdown-menu">
                            <li>
                                <router-link :to="{ name: 'showcases' }" class="dropdown-item">
                                    Showcasess
                                </router-link>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Delivert Servicable Areas
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': product }" @click="product = !product;"
                            class="group dropdown-btn">
                            <i class="fi fi-rr-folder-open" v-if="product"></i>
                            <i class="fi fi-rr-folder" v-if="!product"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Product Management</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="product"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!product"></i>
                            </span>
                        </a>
                        <ul v-if="product" class="dropdown-menu">
                            <li>
                                <router-link :to="{ name: 'products' }" class="dropdown-item">
                                    <i class="fi fi-rr-box-open mr-2"></i> Products
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'category' }" class="dropdown-item">
                                  <i class="fi fi-rr-chart-tree-map mr-2"></i> Category
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'sub-category' }" class="dropdown-item">
                                  <i class="fi fi-rr-folder-tree mr-2"></i> Sub Category
                                </router-link>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                  <i class="fi fi-rr-note-medical mr-2"></i> SKU Report
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="#" class="single-item">
                            <i class="fi fi-rr-lightbulb-on"></i>
                            <span>Services</span>
                        </a>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': vendor }" @click="vendor = !vendor;"
                            class="group dropdown-btn">
                            <i class="fi fi-rr-users-alt"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Vendor Management</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="vendor"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!vendor"></i>
                            </span>
                        </a>
                        <ul v-if="vendor" class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">
                                    Vendors
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Vendor Payments
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': lead }" @click="lead = !lead;"
                            class="group dropdown-btn">
                            <i class="fi fi-rr-phone-call"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Leads</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="lead"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!lead"></i>
                            </span>
                        </a>
                        <ul v-if="lead" class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">
                                    Contacts
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Newsletters
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': collection }"
                            @click="collection = !collection;" class="group dropdown-btn">
                            <i class="fi fi-rr-gallery"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Collections</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="collection"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!collection"></i>
                            </span>
                        </a>
                        <ul v-if="collection" class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">
                                    Groups
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Collection Images
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': config }" @click="config = !config;"
                            class="group dropdown-btn">
                            <i class="fi fi-rr-settings"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Configurations</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="config"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!config"></i>
                            </span>
                        </a>
                        <ul v-if="config" class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">
                                    Home Sliders
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Components
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Brands
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Genders
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Sizes
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Colors
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Styles
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': control }" @click="control = !control;"
                            class="group dropdown-btn">
                            <i class="fi fi-rr-broadcast-tower"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Control Panel</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="control"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!control"></i>
                            </span>
                        </a>
                        <ul v-if="control" class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">
                                    SEO
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Product Reviews
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Coupons
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': blog }" @click="blog = !blog;"
                            class="group dropdown-btn">
                            <i class="fi fi-rr-radio-alt"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>Blogs</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="blog"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!blog"></i>
                            </span>
                        </a>
                        <ul v-if="blog" class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">
                                    Categories
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Posts
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                        <a href="javascript:void(0)" :class="{ 'bg-green-100': user }" @click="user = !user;"
                            class="group dropdown-btn">
                            <i class="fi fi-br-user-gear"></i>

                            <span class="group-hover:text-gray-700 flex justify-between w-full">
                                <span>User Management</span>
                                <i class="fi fi-ss-angle-small-up mr-2" v-if="user"></i>
                                <i class="fi fi-ss-angle-small-down mr-2" v-if="!user"></i>
                            </span>
                        </a>
                        <ul v-if="user" class="dropdown-menu">
                            <li>
                                <a href="#" class="dropdown-item">
                                    Users
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item">
                                    Roles
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="min-w-max">
                      <router-link :to="{ name: 'carts' }" class="single-item">
                            <i class="fi fi-rr-shopping-cart"></i>
                            <span>Carts</span>
                        </router-link>
                    </li>
                    <li class="min-w-max">
                        <router-link :to="{ name: 'wishlists' }" class="single-item">
                            <i class="fi fi-rr-heart"></i>
                            <span>Wishlists</span>
                        </router-link>
                    </li>
                </ul>
                <div class="min-w-max mb-14">
                    <a href="#" class="group single-item">
                        <i class="fi fi-rr-gears text-xl w-5 h-5 "></i>
                        <span>Settings</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SideBar",
    data() {
        return {
            showcases: false,
            product: false,
            vendor: false,
            lead: false,
            collection: false,
            config: false,
            control: false,
            blog: false,
            user: false,
        }
    },
    watch: {
        $route: function () {
            this.updateNav();
        }
    },
    methods: {
        updateNav() {
            this.showcases = this.$route.path.startsWith('/admin/showcases');
            this.product = this.$route.path.startsWith('/admin/products');
            this.vendor = this.$route.path.startsWith('/admin/vendor');
            this.lead = this.$route.path.startsWith('/admin/lead');
            this.collection = this.$route.path.startsWith('/admin/collection');
            this.config = this.$route.path.startsWith('/admin/config');
            this.control = this.$route.path.startsWith('/admin/control');
            this.blog = this.$route.path.startsWith('/admin/blog');
            this.user = this.$route.path.startsWith('/admin/user');
        }
    },
    created() {
        this.updateNav();
    }
}
</script>
<style>
.router-link-exact-active,
.router-link-exact-active:hover {
    background-color: rgb(34 197 94 / 1) !important;
    color: white !important;
}
</style>
