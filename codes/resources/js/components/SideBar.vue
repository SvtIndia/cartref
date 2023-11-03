<template>
    <div class="max-h-[90vh] bg-gray-100 z-10 fixed" >
        <div class="sidebar group hidden md:block max-h-[90vh] w-[3.35rem] hover:w-64 overflow-hidden border-r hover:bg-white hover:shadow-lg" id="sidenav">
            <!-- <div class="sidebar fixed max-h-screen w-[3.35rem] z-10 bg-gray-100 overflow-hidden border-r hover:w-56 hover:bg-white hover:shadow-lg"> -->
            <div class="flex h-[90vh] overflow-y-scroll flex-col justify-between pb-6">
                <div>
                    <ul class="space-y-1 tracking-wide">
                        <li class="min-w-max">
                            <a href="#" class="relative flex items-center space-x-4 bg-green-600  pl-4 py-3 text-white">
                                <i class="fi fi-rr-dashboard text-xl h-5 w-5"></i>
                                <span class="-mr-1 font-medium">Dashboard</span>
                            </a>
                        </li>
                        <li class="min-w-max">
                            <a href="#" class="flex items-center space-x-4 pl-4 py-3 text-gray-600 hover:bg-green-200">
                                <i class="fi fi-rr-boxes text-xl h-5 w-5"></i>
                                <span class="">Orders</span>
                            </a>
                        </li>
                        <li class="min-w-max">
                            <a href="javascript:void(0)" @click="showcase = !showcase;"
                                class="group flex items-center space-x-4 rounded-md pl-4 py-3 text-gray-600">
                                <i class="fi fi-rr-house-chimney text-xl h-5 w-5"></i>

                                <span class="group-hover:text-gray-700 flex justify-between w-full">
                                    <span>Showcase At Home</span>
                                    <i class="fi fi-ss-angle-small-up w-6 h-6 mr-2 text-xl" v-if="showcase"></i>
                                    <i class="fi fi-ss-angle-small-down w-6 h-6 mr-2 text-xl" v-if="!showcase"></i>
                                </span>
                            </a>
                            <ul v-if="showcase" class="hidden max-md:block group-hover:block py-2 space-y-2">
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Showcases
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Delivert Servicable Areas
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="min-w-max">
                            <a href="javascript:void(0)" @click="product = !product;"
                                class="group flex items-center space-x-4 rounded-md pl-4 py-3 text-gray-600">
                                <i class="fi fi-rr-folder-open text-xl h-5 w-5" v-if="product"></i>
                                <i class="fi fi-rr-folder text-xl h-5 w-5" v-if="!product"></i>

                                <span class="group-hover:text-gray-700 flex justify-between w-full">
                                    <span>Product Management</span>
                                    <i class="fi fi-ss-angle-small-up w-6 h-6 mr-2 text-xl" v-if="product"></i>
                                    <i class="fi fi-ss-angle-small-down w-6 h-6 mr-2 text-xl" v-if="!product"></i>
                                </span>
                            </a>
                            <ul v-if="product" class="hidden max-md:block group-hover:block py-2 space-y-2">
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Products
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Categories
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        SubCategories
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        SKU Report
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="min-w-max">
                            <a href="#" class="flex items-center space-x-4 pl-4 py-3 text-gray-600 hover:bg-green-200">
                                <i class="fi fi-rr-lightbulb-on text-xl h-5 w-5"></i>
                                <span class="">Services</span>
                            </a>
                        </li>
                        <li class="min-w-max">
                            <a href="javascript:void(0)" @click="vendor = !vendor;"
                                class="group flex items-center space-x-4 rounded-md pl-4 py-3 text-gray-600">
                                <i class="fi fi-rr-users-alt text-xl h-5 w-5"></i>

                                <span class="group-hover:text-gray-700 flex justify-between w-full">
                                    <span>Vendor Management</span>
                                    <i class="fi fi-ss-angle-small-up w-6 h-6 mr-2 text-xl" v-if="vendor"></i>
                                    <i class="fi fi-ss-angle-small-down w-6 h-6 mr-2 text-xl" v-if="!vendor"></i>
                                </span>
                            </a>
                            <ul v-if="vendor" class="hidden max-md:block group-hover:block py-2 space-y-2">
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Vendors
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Vendor Payments
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="min-w-max">
                            <a href="javascript:void(0)" @click="lead = !lead;"
                                class="group flex items-center space-x-4 rounded-md pl-4 py-3 text-gray-600">
                                <i class="fi fi-tr-phone-call text-xl h-5 w-5"></i>

                                <span class="group-hover:text-gray-700 flex justify-between w-full">
                                    <span>Leads</span>
                                    <i class="fi fi-ss-angle-small-up w-6 h-6 mr-2 text-xl" v-if="lead"></i>
                                    <i class="fi fi-ss-angle-small-down w-6 h-6 mr-2 text-xl" v-if="!lead"></i>
                                </span>
                            </a>
                            <ul v-if="lead" class="hidden max-md:block group-hover:block py-2 space-y-2">
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Contacts
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Newsletters
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="min-w-max">
                            <a href="javascript:void(0)" @click="collection = !collection;"
                                class="group flex items-center space-x-4 rounded-md pl-4 py-3 text-gray-600">
                                <i class="fi fi-rr-gallery text-xl h-5 w-5"></i>

                                <span class="group-hover:text-gray-700 flex justify-between w-full">
                                    <span>Collections</span>
                                    <i class="fi fi-ss-angle-small-up w-6 h-6 mr-2 text-xl" v-if="collection"></i>
                                    <i class="fi fi-ss-angle-small-down w-6 h-6 mr-2 text-xl" v-if="!collection"></i>
                                </span>
                            </a>
                            <ul v-if="collection" class="hidden max-md:block group-hover:block py-2 space-y-2">
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Groups
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center w-full p-2 text-base font-normal text-gray-700 transition duration-75 hover:bg-green-200  pl-11">
                                        Collection Images
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="w-max -mb-3">
                    <a href="#" class="group flex items-center space-x-4 rounded-md px-4 py-3 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:fill-cyan-600"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="group-hover:text-gray-700">Settings</span>
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
            show: false,
            showcase:false,
            product:false,
            vendor:false,
            lead:false,
            collection:false,
            config:false,
        }
    },
}
</script>
