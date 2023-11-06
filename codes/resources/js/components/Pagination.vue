<template>
    <div class="my-4 px-2 flex justify-end">
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <a href="#"
                class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Previous</span>
                <i class="fi fi-ss-angle-small-left text-xl text-center h-6 w-6"></i>
            </a>
            <!-- Current: "z-10 bg-green-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
            <a href="#" aria-current="page"
                class="relative z-10 inline-flex items-center bg-green-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">1</a>
            <a href="#"
                class="relative inline-flex items-center px-4 py-2 hover:bg-green-100 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0">2</a>
            <a href="#"
                class="relative hidden items-center px-4 py-2 hover:bg-green-100 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0 md:inline-flex">3</a>
            <span
                class="relative inline-flex items-center px-4 py-2 hover:bg-green-100 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0">...</span>
            <a href="#"
                class="relative hidden items-center px-4 py-2 hover:bg-green-100 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0 md:inline-flex">8</a>
            <a href="#"
                class="relative inline-flex items-center px-4 py-2 hover:bg-green-100 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0">9</a>
            <a href="#"
                class="relative inline-flex items-center px-4 py-2 hover:bg-green-100 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 focus:z-20 focus:outline-offset-0">10</a>
            <a href="#"
                class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-green-100 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Next</span>
                <i class="fi fi-ss-angle-small-right text-xl text-center h-6 w-6"></i>
            </a>
        </nav>
    </div>
</template>
