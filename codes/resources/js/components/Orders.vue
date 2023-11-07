<template>
    <div class="">
        <div class="container mx-auto my-2 px-4">
            <div class="flex gap-2 items-center text-3xl text-green-600 font-semibold">
                <i class="fi fi-rr-boxes"></i>
                <h3 class="text-start my-8">Orders</h3>
            </div>
            <div class="bg-green-200 p-2 md:p-4 overflow-x-auto shadow-md sm:rounded-lg my-4">
                <div
                    class="flex justify-between px-2 md:px-4 py-2 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-12 lg:px-8 lg:py-4">
                    <div class="w-[45%]">
                        <h3 class="text-sm md:text-2xl text-left text-semibold mb-2 whitespace-nowrap">
                            Order Manifestation
                            <i class="fi fi-rr-shipping-fast"></i>
                        </h3>
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        100
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">New Orders</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        200
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Ready To Dispatch</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        400
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Pending Pickup</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-[45%]">
                        <h3 class="text-sm md:text-2xl text-left text-semibold mb-2 whitespace-nowrap">
                            Order Haulage
                            <i class="fi fi-rr-person-carry-box"></i>
                        </h3>
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        100
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">In Transist</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        200
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Delivered</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        400
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Cancelled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex justify-between px-2 md:px-4 py-2 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-12 lg:px-8 lg:py-4">
                    <div class="w-[45%]">
                        <h3 class="text-sm md:text-2xl text-left text-semibold mb-2 whitespace-nowrap">
                            Returns
                            <i class="fi fi-rr-undo"></i>
                        </h3>
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        100
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">New Orders</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        200
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Ready To Dispatch</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        400
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Pending Pickup</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-[45%]">
                        <h3 class="text-sm md:text-2xl text-left text-semibold mb-2 whitespace-nowrap">
                            Journey at Cartrefs
                            <i class="fi fi-rr-route"></i>
                        </h3>
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        100
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">In Transist</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        200
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Delivered</p>
                                </div>
                            </div>
                            <div
                                class="flex flex-col justify-between overflow-hidden text-left transition-shadow duration-200 bg-white text-black shadow-xl    rounded-xl group hover:shadow-2xl hover:shadow-green-500">
                                <div class="px-2 xl:px-4 py-2">
                                    <div class="flex items-center w-10 h-10 rounded-full text-black bg-white text-lg font-semibold">
                                        400
                                    </div>
                                    <p class="mb-2 whitespace-nowrap text-sm leading-5 text-gray-900">Cancelled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 overflow-x-auto shadow-md sm:rounded-lg">
                <div class="block">
                    <div class="flex items-center justify-between py-4 ">
                        <div>
                            <p class="text-base text-gray-700">
                                Showing
                                <span class="font-medium">1</span>
                                to
                                <span class="font-medium">10</span>
                                of
                                <span class="font-medium">97</span>
                                results
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <select title="Status"
                                    class="block appearance-none w-32 leading-tight h-full cursor-pointer text-black bg-white border border-gray-400 focus:outline-none hover:shadow-sm focus:ring-2 focus:ring-green-500 focus:border-none font-medium rounded-lg text-sm px-3 py-2">
                                    <option class="bg-gray-100" value="">Select Status</option>
                                    <option class="bg-gray-100" value="1">Yet to Process!</option>
                                    <option class="bg-gray-100" value="2">Yet to Ship!</option>
                                    <option class="bg-gray-100" value="3">Yet to Deliver!</option>
                                    <option class="bg-gray-100" value="4">Delivered!</option>
                                    <option class="bg-gray-100" value="close">Close Order</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                                </div>
                            </div>
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <i class="fi fi-rr-search mr-1"></i>
                                </div>
                                <input type="text"
                                    class="block focus-visible:outline focus-visible:outline-1 focus-visible:outline-green-500 focus-visible:border-green-500 p-2 pl-10 text-sm text-gray-900 border border-gray-400 rounded-lg w-40 bg-white"
                                    placeholder="Search for users">
                            </div>
                            <div class="flex border border-gray-600 rounded-lg bg-white">
                                <button class="px-2 py-1 m-[2px] hover:bg-gray-100 border-r border-solid cursor-pointer">
                                    <i class="ffi fi-rr-refresh mr-1"></i>
                                </button>
                                <select
                                    class="w-12 block px-1 m-[2px] text-sm text-gray-900 bg-white hover:bg-gray-100 cursor-pointer"
                                    placeholder="Search for users">
                                    <option value="">25</option>
                                    <option value="">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clear-right overflow-x-auto">
                        <div class="table border-solid border border-gray-500 w-full">
                            <div class="table-row table-head">
                                <div class="table-cell border-gray-500 text-center uppercase font-semibold p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded  ">
                                    </div>
                                </div>

                                <div
                                    class="table-cell border-l border-gray-500 text-center font-semibold uppercase w-10 p-1">
                                    S.No.</div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Order No
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Date
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Products
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Qty
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Amount
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Customer
                                    Details
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Seller
                                    Information
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Logistic
                                    Details
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Pickup
                                    and Delivery
                                </div>
                                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                    Actions
                                </div>
                            </div>
                            <div class="table-row table-body hover:bg-green-100 bg-white">
                                <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">1
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 relative">
                                    169822152267</div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                                    <div class="whitespace-nowrap mx-2">25 Oct 2023 </div>
                                    <div>1:42:02 PM (Wed)</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                                    <div class="flex gap-2">
                                        <div
                                            class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                                            <img @click="imageModal('https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg')" class="w-14 h-14 border rounded-[50%]"
                                                src="https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg"
                                                alt="Shoes image">
                                            <div class="pl-2">
                                                <div
                                                    class="text-base font-medium overflow-hidden w-[80%] whitespace-nowrap text-ellipsis">
                                                    MAEVE &
                                                    SHELBY Leather Formal Shoes
                                                </div>
                                                <div class="font-normal text-gray-500">UK-8</div>
                                                <div class="font-normal text-gray-500">Black</div>
                                                <div class="font-normal text-gray-500">Maeve & Shelby</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Item Id: </div>
                                                <div class="font-normal text-gray-500">90</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">HSN: </div>
                                                <div class="font-normal text-gray-500">6405</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Type: </div>
                                                <div class="font-normal text-gray-500">Regular</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-gray-600">1</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-black">₹999</div>
                                    <div class="text-base text-gray-500">COD</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-sm text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">Bhupendra Jogi</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">bhupenda.us.jogi@gmail.com</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-left">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            302 3 floor,
                                            Prateek Center, Sanjay Place,
                                            Agra, Uttar Pradesh - 282010
                                        </p>
                                    </div>
                                </div>

                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>Other</p>
                                        <p>CANCELED</p>
                                        <p>Shiprocket</p>
                                        <p>AWB: 14326522092111</p>
                                        <p>Shipping ID: 426083992</p>
                                    </div>
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-blue-600 dark:text-blue-500">
                                            <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-yellow-600 dark:text-yellow-500">
                                            <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-red-600 dark:text-red-500">
                                            <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-row table-body hover:bg-green-100 bg-white">
                                <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">1
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 relative">
                                    169822152267</div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                                    <div class="whitespace-nowrap mx-2">25 Oct 2023 </div>
                                    <div>1:42:02 PM (Wed)</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                                    <div class="flex gap-2">
                                        <div
                                            class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="w-14 h-14 border rounded-[50%]"
                                                src="https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg"
                                                alt="Shoes image">
                                            <div class="pl-2">
                                                <div
                                                    class="text-base font-medium overflow-hidden w-[80%] whitespace-nowrap text-ellipsis">
                                                    MAEVE &
                                                    SHELBY Leather Formal Shoes
                                                </div>
                                                <div class="font-normal text-gray-500">UK-8</div>
                                                <div class="font-normal text-gray-500">Black</div>
                                                <div class="font-normal text-gray-500">Maeve & Shelby</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Item Id: </div>
                                                <div class="font-normal text-gray-500">90</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">HSN: </div>
                                                <div class="font-normal text-gray-500">6405</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Type: </div>
                                                <div class="font-normal text-gray-500">Regular</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-gray-600">1</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-black">₹999</div>
                                    <div class="text-base text-gray-500">COD</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-sm text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">Bhupendra Jogi</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">bhupenda.us.jogi@gmail.com</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-left">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            302 3 floor,
                                            Prateek Center, Sanjay Place,
                                            Agra, Uttar Pradesh - 282010
                                        </p>
                                    </div>
                                </div>

                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>Other</p>
                                        <p>CANCELED</p>
                                        <p>Shiprocket</p>
                                        <p>AWB: 14326522092111</p>
                                        <p>Shipping ID: 426083992</p>
                                    </div>
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-blue-600 dark:text-blue-500">
                                            <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-yellow-600 dark:text-yellow-500">
                                            <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-red-600 dark:text-red-500">
                                            <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-row table-body hover:bg-green-100 bg-white">
                                <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">1
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 relative">
                                    169822152267</div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                                    <div class="whitespace-nowrap mx-2">25 Oct 2023 </div>
                                    <div>1:42:02 PM (Wed)</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                                    <div class="flex gap-2">
                                        <div
                                            class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="w-14 h-14 border rounded-[50%]"
                                                src="https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg"
                                                alt="Shoes image">
                                            <div class="pl-2">
                                                <div
                                                    class="text-base font-medium overflow-hidden w-[80%] whitespace-nowrap text-ellipsis">
                                                    MAEVE &
                                                    SHELBY Leather Formal Shoes
                                                </div>
                                                <div class="font-normal text-gray-500">UK-8</div>
                                                <div class="font-normal text-gray-500">Black</div>
                                                <div class="font-normal text-gray-500">Maeve & Shelby</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Item Id: </div>
                                                <div class="font-normal text-gray-500">90</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">HSN: </div>
                                                <div class="font-normal text-gray-500">6405</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Type: </div>
                                                <div class="font-normal text-gray-500">Regular</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-gray-600">1</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-black">₹999</div>
                                    <div class="text-base text-gray-500">COD</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-sm text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">Bhupendra Jogi</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">bhupenda.us.jogi@gmail.com</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-left">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            302 3 floor,
                                            Prateek Center, Sanjay Place,
                                            Agra, Uttar Pradesh - 282010
                                        </p>
                                    </div>
                                </div>

                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>Other</p>
                                        <p>CANCELED</p>
                                        <p>Shiprocket</p>
                                        <p>AWB: 14326522092111</p>
                                        <p>Shipping ID: 426083992</p>
                                    </div>
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-blue-600 dark:text-blue-500">
                                            <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-yellow-600 dark:text-yellow-500">
                                            <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-red-600 dark:text-red-500">
                                            <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-row table-body hover:bg-green-100 bg-white">
                                <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">1
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 relative">
                                    169822152267</div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                                    <div class="whitespace-nowrap mx-2">25 Oct 2023 </div>
                                    <div>1:42:02 PM (Wed)</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                                    <div class="flex gap-2">
                                        <div
                                            class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="w-14 h-14 border rounded-[50%]"
                                                src="https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg"
                                                alt="Shoes image">
                                            <div class="pl-2">
                                                <div
                                                    class="text-base font-medium overflow-hidden w-[80%] whitespace-nowrap text-ellipsis">
                                                    MAEVE &
                                                    SHELBY Leather Formal Shoes
                                                </div>
                                                <div class="font-normal text-gray-500">UK-8</div>
                                                <div class="font-normal text-gray-500">Black</div>
                                                <div class="font-normal text-gray-500">Maeve & Shelby</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Item Id: </div>
                                                <div class="font-normal text-gray-500">90</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">HSN: </div>
                                                <div class="font-normal text-gray-500">6405</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Type: </div>
                                                <div class="font-normal text-gray-500">Regular</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-gray-600">1</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-black">₹999</div>
                                    <div class="text-base text-gray-500">COD</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-sm text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">Bhupendra Jogi</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">bhupenda.us.jogi@gmail.com</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-left">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            302 3 floor,
                                            Prateek Center, Sanjay Place,
                                            Agra, Uttar Pradesh - 282010
                                        </p>
                                    </div>
                                </div>

                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>Other</p>
                                        <p>CANCELED</p>
                                        <p>Shiprocket</p>
                                        <p>AWB: 14326522092111</p>
                                        <p>Shipping ID: 426083992</p>
                                    </div>
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-blue-600 dark:text-blue-500">
                                            <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-yellow-600 dark:text-yellow-500">
                                            <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-red-600 dark:text-red-500">
                                            <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-row table-body hover:bg-green-100 bg-white">
                                <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">1
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 relative">
                                    169822152267</div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                                    <div class="whitespace-nowrap mx-2">25 Oct 2023 </div>
                                    <div>1:42:02 PM (Wed)</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                                    <div class="flex gap-2">
                                        <div
                                            class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="w-14 h-14 border rounded-[50%]"
                                                src="https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg"
                                                alt="Shoes image">
                                            <div class="pl-2">
                                                <div
                                                    class="text-base font-medium overflow-hidden w-[80%] whitespace-nowrap text-ellipsis">
                                                    MAEVE &
                                                    SHELBY Leather Formal Shoes
                                                </div>
                                                <div class="font-normal text-gray-500">UK-8</div>
                                                <div class="font-normal text-gray-500">Black</div>
                                                <div class="font-normal text-gray-500">Maeve & Shelby</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Item Id: </div>
                                                <div class="font-normal text-gray-500">90</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">HSN: </div>
                                                <div class="font-normal text-gray-500">6405</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Type: </div>
                                                <div class="font-normal text-gray-500">Regular</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-gray-600">1</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-black">₹999</div>
                                    <div class="text-base text-gray-500">COD</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-sm text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">Bhupendra Jogi</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">bhupenda.us.jogi@gmail.com</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-left">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            302 3 floor,
                                            Prateek Center, Sanjay Place,
                                            Agra, Uttar Pradesh - 282010
                                        </p>
                                    </div>
                                </div>

                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>Other</p>
                                        <p>CANCELED</p>
                                        <p>Shiprocket</p>
                                        <p>AWB: 14326522092111</p>
                                        <p>Shipping ID: 426083992</p>
                                    </div>
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-blue-600 dark:text-blue-500">
                                            <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-yellow-600 dark:text-yellow-500">
                                            <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-red-600 dark:text-red-500">
                                            <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-row table-body hover:bg-green-100 bg-white">
                                <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">1
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 relative">
                                    169822152267</div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                                    <div class="whitespace-nowrap mx-2">25 Oct 2023 </div>
                                    <div>1:42:02 PM (Wed)</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                                    <div class="flex gap-2">
                                        <div
                                            class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="w-14 h-14 border rounded-[50%]"
                                                src="https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg"
                                                alt="Shoes image">
                                            <div class="pl-2">
                                                <div
                                                    class="text-base font-medium overflow-hidden w-[80%] whitespace-nowrap text-ellipsis">
                                                    MAEVE &
                                                    SHELBY Leather Formal Shoes
                                                </div>
                                                <div class="font-normal text-gray-500">UK-8</div>
                                                <div class="font-normal text-gray-500">Black</div>
                                                <div class="font-normal text-gray-500">Maeve & Shelby</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Item Id: </div>
                                                <div class="font-normal text-gray-500">90</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">HSN: </div>
                                                <div class="font-normal text-gray-500">6405</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Type: </div>
                                                <div class="font-normal text-gray-500">Regular</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-gray-600">1</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-black">₹999</div>
                                    <div class="text-base text-gray-500">COD</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-sm text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">Bhupendra Jogi</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">bhupenda.us.jogi@gmail.com</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-left">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            302 3 floor,
                                            Prateek Center, Sanjay Place,
                                            Agra, Uttar Pradesh - 282010
                                        </p>
                                    </div>
                                </div>

                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>Other</p>
                                        <p>CANCELED</p>
                                        <p>Shiprocket</p>
                                        <p>AWB: 14326522092111</p>
                                        <p>Shipping ID: 426083992</p>
                                    </div>
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-blue-600 dark:text-blue-500">
                                            <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-yellow-600 dark:text-yellow-500">
                                            <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-red-600 dark:text-red-500">
                                            <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-row table-body hover:bg-green-100 bg-white">
                                <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">1
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 relative">
                                    169822152267</div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                                    <div class="whitespace-nowrap mx-2">25 Oct 2023 </div>
                                    <div>1:42:02 PM (Wed)</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                                    <div class="flex gap-2">
                                        <div
                                            class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                                            <img class="w-14 h-14 border rounded-[50%]"
                                                src="https://cartrefs.com/storage/productcolors/July2022/5ZJU6TDgcYO3UUlDy6c8.jpg"
                                                alt="Shoes image">
                                            <div class="pl-2">
                                                <div
                                                    class="text-base font-medium overflow-hidden w-[80%] whitespace-nowrap text-ellipsis">
                                                    MAEVE &
                                                    SHELBY Leather Formal Shoes
                                                </div>
                                                <div class="font-normal text-gray-500">UK-8</div>
                                                <div class="font-normal text-gray-500">Black</div>
                                                <div class="font-normal text-gray-500">Maeve & Shelby</div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Item Id: </div>
                                                <div class="font-normal text-gray-500">90</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">HSN: </div>
                                                <div class="font-normal text-gray-500">6405</div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="font-medium">Type: </div>
                                                <div class="font-normal text-gray-500">Regular</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-gray-600">1</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                                    <div class="font-semibold text-black">₹999</div>
                                    <div class="text-base text-gray-500">COD</div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 p-1 text-sm text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">Bhupendra Jogi</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">bhupenda.us.jogi@gmail.com</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-left">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            302 3 floor,
                                            Prateek Center, Sanjay Place,
                                            Agra, Uttar Pradesh - 282010
                                        </p>
                                    </div>
                                </div>

                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-center">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Name: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Brand: </div>
                                        <div class="font-normal text-gray-500">S & T Shoes</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="font-semibold">Email: </div>
                                        <div class="font-normal text-gray-500">infomaeveandshelby@gmail</div>
                                    </div>
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>
                                            <span class="font-normal text-black">Address: </span>
                                            42/140 E-1 KRISHNA KUNJ
                                            MATHURA ROAD, OPP METRO & METRO Agra
                                            UTTAR PRADESH - 282002
                                        </p>
                                    </div>
                                </div>
                                <div class="table-cell border-t border-l border-gray-500 text-sm p-1 pb-4 text-left">
                                    <div class="text-gray-500 font-normal text-start">
                                        <p>Other</p>
                                        <p>CANCELED</p>
                                        <p>Shiprocket</p>
                                        <p>AWB: 14326522092111</p>
                                        <p>Shipping ID: 426083992</p>
                                    </div>
                                </div>
                                <div
                                    class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                    <div class="flex flex-col gap-2 items-center justify-center">
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-blue-600 dark:text-blue-500">
                                            <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-yellow-600 dark:text-yellow-500">
                                            <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                        </a>
                                        <a href="#" type="button"
                                            class="font-medium cursor-pointer text-red-600 dark:text-red-500">
                                            <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <pagination />
                </div>
            </div>
        </div>
        <image-modal :show="showModal" :hide="closeImageModal" :img="imgModal"></image-modal>
    </div>
</template>
<script>
export default {
    name: "Order",
    data() {
        return {
            orders: [],
            dropdownAction: false,
            showModal: false,
            imgModal: '',
        }
    },
    methods: {
        imageModal(img) {
            this.showModal = true;
            this.imgModal = img;
        },
        closeImageModal(){
            this.showModal = false;
        }
    },
}
</script>

<style>
.table-body .table-cell {
    vertical-align: top;
}

.table-head .table-cell {
    vertical-align: middle;
    color: rgb(22 163 74 / var(--tw-bg-opacity));
}
</style>
