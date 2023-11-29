<template>
  <div>
    <Wait :show="loading"/>
    <div class="container mx-auto my-2 px-4">
      <h1 class="text-center text-2xl underline">{{ product.name }}</h1>
      <div class="flex gap-2 items-center text-3xl text-green-600 font-semibold">
        <i class="fi fi-rr-palette"></i>
        <h3 class="text-start my-8">Colors</h3>
      </div>

      <div class="block">
          <div class="grid w-full grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3" v-if="product_colors && product_colors.length > 0">
            <div v-for="(color, index) in product_colors" class="relative flex flex-col mt-6 text-gray-700 bg-white shadow-lg bg-clip-border rounded-xl w-96">
              <div class="px-4 py-2">
                <img :src="$store.state.storageUrl+color.main_image" class="w-52 h-64 mx-auto">

                <h5 class="block mb-2 font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                  {{ color.color }}
                </h5>
                <p class="block font-sans text-base antialiased font-light leading-relaxed text-inherit">
                  Because it's about
                </p>
              </div>
              <div class="p-6 pt-0">
                <a href="#" class="inline-block">
                  <button
                      class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-center text-green-500 uppercase align-middle transition-all rounded-lg select-none  hover:bg-green-500 hover:text-white active:bg-gray-900/20"
                      type="button">
                    View
                    <i class="fi fi-rr-arrow-right text-sm w-4 h-4"></i>
                  </button>
                </a>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductColors",
  data() {
    return {
      loading: true,
      dataLoading: true,
      product_id: this.$route.params.id,
      product: {},
      product_colors: [],
    }
  },
  methods: {
    fetchProductColors(url) {
      axios.get('/admin/product/'+this.product_id)
          .then(res => {
            this.product_colors = res.data.data.colors;
            this.product = res.data.data.product;
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
    this.fetchProductColors();
  },
}
</script>

<style lang="scss" scoped></style>
