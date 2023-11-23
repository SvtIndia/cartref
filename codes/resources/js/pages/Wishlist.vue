<template>
  <div>
    <div class="container mx-auto my-2 px-4">
      <div class="flex gap-2 items-center text-3xl text-green-600 font-semibold">
        <i class="fi fi-rr-heart"></i>
        <h3 class="text-start my-8">Wishlists</h3>
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
              <label for="table-search" class="sr-only">Search</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                  <i class="fi fi-rr-search mr-1"></i>
                </div>
                <input type="text"
                       class="block focus-visible:outline focus-visible:outline-1 focus-visible:outline-green-500 focus-visible:border-green-500 p-2 pl-10 text-sm text-gray-900 border border-gray-400 rounded-lg w-40 bg-white"
                       placeholder="Search">
              </div>
              <div class="flex border border-gray-600 rounded-lg bg-white">
                <button class="px-2 py-1 m-[2px] hover:bg-gray-100 border-r border-solid cursor-pointer">
                  <i class="ffi fi-rr-refresh mr-1"></i>
                </button>
                <select class="w-12 block px-1 m-[2px] text-sm text-gray-900 bg-white hover:bg-gray-100 cursor-pointer">
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
                    <input type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                  </div>
                </div>
                <div class="table-cell border-l border-gray-500 text-center font-semibold uppercase w-10 p-1">S.No.
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">Customer</div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">Wishlist
                  Items
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">Date</div>
              </div>
              <template v-if="wishlists && wishlists.length > 0">
                <div class="table-row table-body hover:bg-green-100 bg-white" v-for="(wishlist, index) in wishlists"
                     v-bind:key="index">
                  <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                    <div class="flex items-center">
                      <input type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                    </div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">{{
                      index + 1
                    }}
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                    <template v-if="wishlist.user">
                      <div class="mx-2">{{ wishlist.user.name }}</div>
                      <div class="whitespace-nowrap">
                        <i class="fi fi-sr-envelope"></i> {{ wishlist.user.email }}
                      </div>
                      <div class="whitespace-nowrap" v-if="wishlist.user.mobile">
                        <i class="fi fi-sr-phone-flip"></i> +91 {{ wishlist.user.mobile }}
                      </div>
                    </template>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-left py-1">
                    <template v-if="wishlist.wishlist_data">
                      <div class="flex gap-2" v-for="(wishlist, index) in wishlist.wishlist_data" v-bind:key="index">
                        <div class="flex gap-1 items-center text-start text-gray-900 whitespace-nowrap dark:text-white">
                          <img
                              @click="imageModal($store.state.storageUrl + wishlist.product.image)"
                              class="w-14 h-14 border rounded-[50%]"
                              :src="$store.state.storageUrl + wishlist.product.image"
                              alt="Shoes image">
                          <div class="pl-2">
                            <div class="text-base font-medium overflow-hidden w-[80%] hover:underline">
                              <a :href="'/product/'+wishlist.product.slug" target="_blank">
                                {{ wishlist.product ? wishlist.product.name : '-' }}
                              </a>
                            </div>
                            <div class="font-normal text-gray-500">
                              {{ wishlist.product ? wishlist.product.brand_id : '-' }}
                            </div>
                          </div>
                        </div>
                      </div>
                    </template>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 !align-middle">
                    <div class="font-normal text-gray-900">{{ formatSimpleDate(wishlist.created_at) }}</div>
                  </div>
                </div>
              </template>
            </div>
            <pagination/>
          </div>
        </div>
      </div>
    </div>
    <image-modal :show="showModal" :hide="closeImageModal" :img="imgModal"></image-modal>
  </div>
</template>

<script>
export default {
  name: "Wishlist",
  data() {
    return {
      wishlists: [],
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
    },
    fetchWishlist() {
      axios.get('/admin/wishlist')
          .then(res => {
            this.wishlists = res.data.data;
          })
    }
  },
  created() {
    this.fetchWishlist();
  },
}
</script>

<style lang="scss" scoped>

</style>