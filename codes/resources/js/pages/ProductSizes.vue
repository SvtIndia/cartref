<template>
  <div>
    <Wait :show="loading"/>
    <div class="container mx-auto my-2 px-4">
      <h1 class="text-center text-2xl underline uppercase">{{ product.name }}</h1>
      <div class="mt-6">
        <a @click="$router.go(-1)"
           class="inline-flex items-center gap-2 px-4 py-2 text-base font-bold text-center text-white align-middle transition-all rounded-lg cursor-pointer bg-gray-800 hover:bg-black hover:text-white">
          <i class="fi fi-rr-arrow-left text-base w-4 h-5"></i>
          Back
        </a>
      </div>
      <div class="flex flex-wrap justify-between items-center">
        <div class="flex gap-2 items-center text-3xl text-green-600 font-semibold">
          <i class="fi fi-rr-palette"></i>
          <h3 class="text-start my-8">{{ color.color }} Sizes</h3>
        </div>
      </div>

      <div class="block">
        <template v-if="dataLoading">
          <Skeleton/>
        </template>
        <template v-else-if="sizes && sizes.length > 0">
          <div class="clear-right overflow-x-auto">
            <div class="table border-solid border border-gray-500 w-full">
              <div class="table-row table-head">
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  SKU
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Size
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Color
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Price
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Dimensions (L/B/H/W)
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Available Stock
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Status
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Create At
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Actions
                </div>
              </div>

              <div class="table-row table-body hover:bg-green-100 bg-white">
                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-4 relative">
                  L-Red
                </div>
                <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                  <div class="whitespace-nowrap mx-2 py-4">L</div>
                </div>
                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                  <div class="text-sm py-2.5">Red</div>
                </div>
                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                  <div class="text-sm py-2.5">-</div>
                </div>
                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                  <div class="text-sm py-2.5">20 / 18 / 16 / 0.5</div>
                </div>
                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                  <div class="font-semibold text-gray-600 py-2.5">10</div>
                </div>
                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                  <label  id="status_3014" title="Click to Reject" class="relative inline-flex items-center cursor-pointer my-2">
                    <input  type="checkbox" id="checkbox_3014" value="" class="sr-only peer">
                    <div
                         class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                  </label>
                </div>
                <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                  <div class="text-sm py-2.5">2023-04-03 15:21:58</div>
                </div>
                <div class="table-cell border-t border-l border-gray-500 text-sm align-[middle!important] text-center">
                  <div class="flex flex-col gap-2 items-center justify-center">
                    <a href="#" type="button" class="font-medium cursor-pointer text-yellow-500">
                      <i class="fi fi-rr-pencil w-5 h-5 text-xl"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </template>
        <template v-else>
          <div>
            <p class="text-center text-2xl">No Sizes Found !</p>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductSizes",
  data() {
    return {
      loading: false,
      dataLoading: false,
      product_id: this.$route.params.product_id,
      color_id: this.$route.params.color_id,
      product: {},
      color: {},
      sizes: [{}],
    }
  },
  methods: {
    fetchProductAndColor() {
      axios
          .get(`/admin/product/${this.product_id}`)
          .then(res => {
            this.product = res.data.data;
          })

      axios
          .get(`/admin/product/color/${this.color_id}`)
          .then(res => {
            this.color = res.data.data;
          })
    },
    fetchSizes() {
      axios.get(`/admin/product/${this.product_id}/color/${this.color_id}/sizes`)
          .then(res => {
            this.sizes = res.data.data;
            this.dataLoading = false;
            this.loading = false;
          })
          .catch(err => {
            this.dataLoading = false;
            this.loading = false;
            err.handleGlobally && err.handleGlobally();
          })
    },
  },
  created() {
    this.fetchProductAndColor();
    this.fetchSizes();
  },
}
</script>

<style lang="scss" scoped>

</style>