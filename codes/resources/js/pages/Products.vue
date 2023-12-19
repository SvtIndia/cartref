<template>
    <div>
        <Wait :show="loading" />
        <div class="container mx-auto my-2 px-4">
            <div class="flex gap-2 items-center text-3xl text-primary-600 font-semibold">
                <i class="fi fi-rr-box-open"></i>
                <h3 class="text-start my-8">Products</h3>
            </div>

            <div class="bg-white p-4 overflow-x-auto shadow-md sm:rounded-lg">
                <div class="block">
                    <div class="flex flex-wrap items-center justify-between py-4">
                        <div class="flex flex-wrap text-base text-gray-700 gap-2">
                            <div>
                                {{ pagination.from || '0' }} - {{ pagination.to || '0' }} of {{ pagination.total || '0' }}
                            </div>
                            <div>
                                <button :disabled="!pagination.prev_page_url"
                                    @click="fetchProduct(pagination.prev_page_url)" title="Previous"
                                    class="border border-transparent rounded-full hover:bg-primary-400 disabled:opacity-50">
                                    <i class="fi fi-rr-angle-small-left text-xl px-1 py-2"></i>
                                </button>
                                <button :disabled="!pagination.next_page_url"
                                    @click="fetchProduct(pagination.next_page_url)" title="Next"
                                    class="border border-transparent rounded-full hover:bg-primary-400 disabled:opacity-50">
                                    <i class="fi fi-rr-angle-small-right text-xl px-1 py-2"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="relative">
                                <select title="Status" v-model="status" @change="fetchProduct()"
                                    class="block appearance-none pl-2 pr-8 w-auto leading-tight h-full cursor-pointer text-black bg-white border border-gray-400 focus:outline-none hover:shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-none font-medium rounded-lg text-sm px-3 py-2">
                                    <option class="bg-gray-100" value="">All Status</option>
                                    <option class="bg-gray-100" value="Pending For Verification">Pending For Verification
                                    </option>
                                    <option class="bg-gray-100" value="Accepted">Accepted</option>
                                    <option class="bg-gray-100" value="Rejected">Rejected</option>
                                    <option class="bg-gray-100" value="Updated">Updated</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select title="Category" v-model="parent_category_id" @change="fetchProduct()"
                                    class="block appearance-none pl-2 pr-8 w-auto leading-tight h-full cursor-pointer text-black bg-white border border-gray-400 focus:outline-none hover:shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-none font-medium rounded-lg text-sm px-3 py-2">
                                    <option value="" selected>All Categories</option>
                                    <option v-for="(parent, index) in parent_category" :key="index" :value="parent.id">{{
                                        parent.name }}</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 cursor-pointer"
                                    @click="keyword = ''; fetchProduct();" v-if="keyword">
                                    <i class="fi fi-rr-cross-small mr-1"></i>
                                </div>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none" v-else>
                                    <i class="fi fi-rr-search mr-1"></i>
                                </div>
                                <input type="text" v-model="keyword" @change="fetchProduct()"
                                    class="block focus-visible:outline focus-visible:outline-1 focus-visible:outline-primary-500 focus-visible:border-primary-500 p-2 pl-10 text-sm text-gray-900 border border-gray-400 rounded-lg w-40 bg-white"
                                    placeholder="Search" title="Search" @keydown.enter="fetchProduct()">
                            </div>
                            <div class="flex border border-gray-600 rounded-lg bg-white">
                                <button title="Reload" class="px-2 py-1 m-[2px] hover:bg-primary-100 border-r border-solid cursor-pointer"
                                    @click="fetchProduct()">
                                    <i class="ffi fi-rr-refresh mr-1"></i>
                                </button>
                                <select title="Page Limit"
                                    class="w-14 block px-1 m-[2px] text-base text-center text-gray-900 bg-white cursor-pointer"
                                    @change="fetchProduct()" v-model="row_count">
                                    <option :value="count.toLowerCase()" v-for="(count, index) in $store.state.row_counts"
                                        :key="index" class="bg-white">
                                        {{ count }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <template v-if="dataLoading">
                        <Skeleton />
                    </template>
                    <template v-else-if="products && products.length > 0">
                        <div class="clear-right overflow-x-auto">
                            <div class="table border-solid border border-gray-500 w-full">
                                <div class="table-row table-head">
                                    <div class="table-cell border-gray-500 text-center uppercase font-semibold p-1 px-2">
                                        <div class="flex items-center">
                                            <input type="checkbox"
                                                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded">
                                        </div>
                                    </div>
                                    <div
                                        class="table-cell border-l border-gray-500 text-center font-semibold uppercase w-10 p-1">
                                        S.No.
                                    </div>
                                    <div
                                        class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                        Image
                                    </div>
                                    <div
                                        class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                        Product Information
                                    </div>
                                    <div
                                        class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                        Price
                                    </div>
                                    <div
                                        class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                        QC Status
                                    </div>
                                    <div
                                        class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                        Last Update
                                    </div>
                                    <div
                                        class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                                        Actions
                                    </div>
                                </div>
                                <div v-for="(product, index) in products" v-bind:key="index"
                                    class="table-row table-body hover:bg-primary-100">
                                    <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                                        <div class="flex items-center">
                                            <input type="checkbox"
                                                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded">
                                        </div>
                                    </div>
                                    <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">
                                        {{ pagination.from + index }}
                                    </div>
                                    <div
                                        class="table-cell border-t border-l border-gray-500 text-sm p-1 text-center !align-middle">
                                        <img class="w-20 h-20 border border-gray-400 mx-auto p-1 rounded-[50%]" v-if="product.image"
                                            @click="imageModal($store.state.storageUrl + product.image)"
                                            :src="$store.state.storageUrl + product.image" alt="product-img">
                                        <p class="text-center text-gray-800" v-else>--No Image--</p>
                                    </div>
                                    <div
                                        class="table-cell border-t border-l border-gray-500 text-sm font-semibold px-1 text-center">
                                        <div
                                            class="flex flex-col items-center text-start text-gray-900 whitespace-nowrap px-2">
                                            <div class="w-full text-base font-semibold cursor-pointer hover:underline overflow-hidden whitespace-nowrap text-ellipsis"
                                                :title="product.name">
                                                <a :href="'/product/' + product.slug" target="_blank">
                                                    {{ product.name ? product.name.substr(0, 60) : '-' }}{{
                                                        product.name.length > 60 ? '...' : '' }}
                                                </a>
                                            </div>
                                            <div class="flex gap-8 w-full">
                                                <div class="">
                                                    <div class="flex items-center gap-2">
                                                        <div class="font-medium">Category:</div>
                                                        <div class="font-normal text-gray-500">{{ product.productcategory ? product.productcategory.name : '-' }}</div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="font-medium">Sub Category:</div>
                                                        <div class="font-normal text-gray-500">{{ product.productsubcategory ? product.productsubcategory.name : '-' }}</div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="font-medium">Brand:</div>
                                                        <div class="font-normal text-gray-500">{{ product.brand_id ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="font-medium">SKU:</div>
                                                        <div class="font-normal text-gray-500">{{ product.sku ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="font-medium">HSN:</div>
                                                        <div class="font-normal text-gray-500">{{ product.productsubcategory ? product.productsubcategory.hsn : '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="table-cell border-t border-l border-gray-500 text-sm px-2 text-center !align-middle">
                                        <div class="text-base font-semibold text-black">₹{{ product.offer_price ? product.offer_price.toLocaleString("en-US") : '0.00' }}/-</div>
                                        <div class="text-sm text-gray-700" v-if="product.mrp">
                                            <del>₹{{ product.mrp.toLocaleString("en-US") }}</del>
                                        </div>
                                    </div>
                                    <div
                                        class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 !align-middle">
                                        <label :id="'wait_' + product.id"
                                            class="hidden inline-block  justify-center w-4 h-4">
                                            <Spinner />
                                        </label>
                                        <label class="relative inline-flex items-center cursor-pointer"
                                            :id="'status_' + product.id"
                                            :title="product.admin_status === 'Accepted' ? 'Click to Reject' : 'Click to Accept'">
                                            <input type="checkbox" :id="'checkbox_' + product.id" value=""
                                                :checked="product.admin_status === 'Accepted'"
                                                @change="updateStatus(product.id, $event)" class="sr-only peer">
                                            <div
                                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                                            </div>
                                        </label>
                                        <div>
                                            <label>{{ product.admin_status }}</label>
                                        </div>
                                    </div>
                                    <div
                                        class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 !align-middle">
                                        <div class="font-normal text-gray-900" v-html="formDateTime(product.updated_at)">
                                        </div>
                                    </div>
                                    <div
                                        class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                                        <div class="flex gap-4 mx-2 items-center justify-center">
                                            <a href="javascript:void(0)" type="button"
                                                class="font-medium cursor-pointer text-yellow-500">
                                                <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                                            </a>
                                            <router-link :to="{ name: 'product-colors', params: { id: product.id } }"
                                                type="button" class="font-medium cursor-pointer text-blue-500">
                                                <i class="fi fi-rr-eye w-5 h-5 text-xl"></i>
                                            </router-link>
                                            <a href="javascript:void(0)" type="button"
                                                class="font-medium cursor-pointer text-red-500">
                                                <i class="fi fi-rr-trash w-5 h-5 text-xl"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between py-4">
                                <div>
                                    <p class="text-base text-gray-700">
                                        Showing
                                        <span class="font-medium">{{ pagination.from || '0' }}</span>
                                        to
                                        <span class="font-medium">{{ pagination.to || '0' }}</span>
                                        of
                                        <span class="font-medium">{{ pagination.total || '0' }}</span>
                                        results
                                    </p>
                                </div>
                                <Pagination :pagination="pagination" :fetchNewData="fetchProduct" />
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div>
                            <p class="text-center text-2xl">No Products Found !</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <ImageModal :show="showModal" :hide="closeImageModal" :img="imgModal"></ImageModal>
    </div>
</template>

<script>
export default {
    name: "Products",
    data() {
        return {
            loading: false,
            dataLoading: true,
            toggleLoadingId: '',
            products: [{}],
            parent_category: [],
            sub_category: [],
            parent_category_id: '',
            sub_category_id: '',
            keyword: '',
            status: '',
            row_count: this.$store.state.defaultRowCount,
            showModal: false,
            imgModal: '',
            pagination: {},
        }
    },
    methods: {
        imageModal(img) {
            this.showModal = true;
            this.imgModal = img;
        },
        closeImageModal() {
            this.showModal = false;
        },
        handleImageChange(e) {
            let file = e.target?.files[0];
            if (file) {
                this.image = file;
            }
        },
        updateStatus(id, e) {
            let status = e.target.checked ? 'Accepted' : 'Rejected';
            document.getElementById('wait_' + id).classList.remove('hidden')
            document.getElementById('status_' + id).classList.add('hidden')

            axios.put('/admin/product/' + id, {
                status: status
            })
                .then(res => {
                    this.show_toast(res.data.data.status, res.data.data.msg);
                    document.getElementById('wait_' + id).classList.add('hidden')
                    document.getElementById('status_' + id).classList.remove('hidden')
                    document.getElementById('checkbox_' + id).checked = e.target.checked;
                })
                .catch(err => {
                    err.handleGlobally && err.handleGlobally();
                })

        },
        fetchParentCategory() {
            this.dataLoading = true;
            axios.get('/admin/category', {
                params: {
                    rows: 'all',
                    status: 1,
                }
            })
                .then(res => {
                    this.dataLoading = false;
                    this.parent_category = res.data.data;
                })
                .catch(err => {
                    this.dataLoading = false;
                    err.handleGlobally && err.handleGlobally();
                })
        },
        fetchProduct(url) {
            this.dataLoading = true;
            url = url || '/admin/product'
            axios.get(url, {
                params: {
                    rows: this.row_count,
                    keyword: this.keyword.trim(),
                    status: this.status,
                    parent_category: this.parent_category_id,
                    sub_category: this.sub_category_id,
                }
            })
                .then(res => {
                    this.products = res.data.data || [];
                    let { data, ...pagination } = res.data;
                    pagination.links.pop();
                    pagination.links.shift();
                    this.pagination = pagination;
                    this.dataLoading = false;
                    this.loading = false;
                })
                .catch(err => {
                    this.dataLoading = false;
                    this.loading = false;
                    err.handleGlobally && err.handleGlobally();
                })
        }
    },
    created() {
        this.fetchParentCategory();
        this.fetchProduct();
    },
}
</script>

<style lang="scss" scoped></style>
