<template>
    <header class="header fixed w-screen z-20 top-0 bg-dark-1 shadow-md flex items-center justify-between p-2">
        <!-- logo -->
        <h1 class="w-4/12 flex gap-1 md:mx-4">
            <a class="block md:hidden" @click="toggleSideBar()" href="javascript:void(0)">
                <i class="fi fi-br-bars-sort text-white text-2xl h-8 p-1 hover:text-orange-500 duration-200"></i>
            </a>
            <a class="" href="">
                <img src="https://cartrefs.com/storage/settings/April2023/DRWK4IgZ3N2GnkZSiN2V.png"
                    class="w-52 h-8 md:w-52 md:h-8 xl:w-48 xl:h-12" alt="Cartrefs logo" width="150" height="35">
            </a>
        </h1>

        <!-- buttons --->
        <div class="w-3/12 flex justify-end mx-4">
            <a href="">
                <i class="fi fi-rr-circle-user text-white text-2xl h-3 p-1 hover:text-orange-500 duration-200"></i>
            </a>
        </div>
    </header>
</template>
<script>
export default {
    name: "NavBar",
    data() {
        return {

        }
    },
    methods: {
        toggleSideBar() {
            document.getElementById('sidenav').classList.toggle('hidden');
            document.getElementById('sidenav').classList.toggle('max-md:w-64')
        }
    },
}
</script>
