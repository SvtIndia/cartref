<template>
    <div class="container flex flex-col mx-auto">
        <div class="w-full px-4 md:px-2">
            <div class="container flex flex-col items-center gap-16 mx-auto my-10">
                <div class="grid w-full grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
                    <div
                        class="flex flex-col items-center gap-3 px-8 py-10 bg-white rounded-xl shadow-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fi fi-rr-box-open text-4xl w-8 h-8 text-primary-600"></i>
                        <p class="text-2xl font-extrabold text-dark-grey-900">2300</p>
                        <p class="text-3xl leading-7 text-dark-grey-600">Products</p>
                        <a class="px-8 py-2 mt-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg text-lg"
                            href="mailto: hello@loopple.com">View all</a>
                    </div>
                    <div
                        class="flex flex-col items-center gap-3 px-8 py-10 bg-white rounded-xl shadow-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fi fi-rr-boxes text-4xl w-8 h-8 text-primary-600"></i>
                        <p class="text-2xl font-extrabold text-dark-grey-900">500</p>
                        <p class="text-3xl leading-7 text-dark-grey-600">New Orders</p>
                        <a class="px-8 py-2 mt-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg text-lg"
                            href="mailto: hello@loopple.com">View all</a>
                    </div>
                    <div
                        class="flex flex-col items-center gap-3 px-8 py-10 bg-white rounded-xl shadow-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fi fi-sr-boxes text-4xl w-8 h-8 text-primary-600"></i>
                        <p class="text-2xl font-extrabold text-dark-grey-900">1000</p>
                        <p class="text-3xl leading-7 text-dark-grey-600">Orders</p>
                        <a class="px-8 py-2 mt-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg text-lg"
                            href="mailto: hello@loopple.com">View all</a>
                    </div>
                    <div
                        class="flex flex-col items-center gap-3 px-8 py-10 bg-white rounded-xl shadow-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fi fi-rr-house-chimney text-4xl w-8 h-8 text-primary-600"></i>
                        <p class="text-2xl font-extrabold text-dark-grey-900">10</p>
                        <p class="text-3xl leading-7 text-dark-grey-600">New Showcases</p>
                        <a class="px-8 py-2 mt-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg text-lg"
                            href="mailto: hello@loopple.com">View all</a>
                    </div>
                    <div
                        class="flex flex-col items-center gap-3 px-8 py-10 bg-white rounded-xl shadow-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fi fi-sr-house-chimney text-4xl w-8 h-8 text-primary-600"></i>
                        <p class="text-2xl font-extrabold text-dark-grey-900">100</p>
                        <p class="text-3xl leading-7 text-dark-grey-600">Showcases</p>
                        <a class="px-8 py-2 mt-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg text-lg"
                            href="mailto: hello@loopple.com">View all</a>
                    </div>
                    <div
                        class="flex flex-col items-center gap-3 px-8 py-10 bg-white rounded-xl shadow-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fi fi-rr-users-alt text-4xl w-8 h-8 text-primary-600"></i>
                        <p class="text-2xl font-extrabold text-dark-grey-900">150</p>
                        <p class="text-3xl leading-7 text-dark-grey-600">Users</p>
                        <a class="px-8 py-2 mt-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg text-lg"
                            href="mailto: hello@loopple.com">View all</a>
                    </div>
                    <div
                        class="flex flex-col items-center gap-3 px-8 py-10 bg-white rounded-xl shadow-lg hover:bg-gray-50 cursor-pointer">
                        <i class="fi fi-rr-paper-plane text-4xl w-8 h-8 text-primary-600"></i>
                        <p class="text-2xl font-extrabold text-dark-grey-900">15</p>
                        <p class="text-3xl leading-7 text-dark-grey-600">Posts</p>
                        <a class="px-8 py-2 mt-4 text-white bg-primary-600 hover:bg-primary-700 rounded-lg text-lg"
                            href="mailto: hello@loopple.com">View all</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
