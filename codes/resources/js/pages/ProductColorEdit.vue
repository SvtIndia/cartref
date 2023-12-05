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
        <div class="flex gap-2 items-center text-3xl text-orange-600 font-semibold">
          <i class="fi fi-rr-palette"></i>
          <h3 class="text-start my-8">{{ color.color }}</h3>
        </div>
      </div>

      <div class="block">
        <!--  Form -->
        <div data-v-32256d36="" class="bg-white p-4 overflow-x-auto shadow-md sm:rounded-lg my-4">
          <div data-v-32256d36="" class="block">
            <form data-v-32256d36="">
              <div data-v-32256d36="" class="md:flex mb-3">
                <div data-v-32256d36="" class="mb-5 w-full mx-2 my-1">
                  <label data-v-32256d36="" for="sub_category" title="The name is how it appears on your site." class="block mb-2 text-sm font-bold text-gray-900">Product ID <span data-v-32256d36="" class="text-red-600">*</span></label>
                  <input
                      data-v-32256d36=""
                      type="text"
                      id="sub_category"
                      placeholder="Product ID"
                      required="required"
                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-orange-500 focus-visible:border-orange-500"
                  />
                </div>
              </div>
              <div data-v-32256d36="" class="md:flex mb-3">
                <div data-v-32256d36="" class="mb-5 w-full mx-2 my-1">
                  <label data-v-32256d36="" for="sub_category" title="The name is how it appears on your site." class="block mb-2 text-sm font-bold text-gray-900">Color <span data-v-32256d36="" class="text-red-600">*</span></label>
                  <input
                      data-v-32256d36=""
                      type="text"
                      id="sub_category"
                      placeholder="Color"
                      required="required"
                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-orange-500 focus-visible:border-orange-500"
                  />
                </div>
              </div>
              <div data-v-32256d36="" class="md:flex mb-3">
                <div data-v-32256d36="" class="mb-5 md:w-1/2 w-full mx-2 my-1">
                  <label data-v-32256d36="" for="image" title="An image belonging to a specific type, often distinguished by shared characteristics or features." class="block mb-2 text-sm font-bold text-gray-900">Category Image</label>
                  <div class="w-75 mb-5">
                    <a href="#" type="button" class="font-weight-bolder cursor-pointer text-yellow-500 absolute">
                      <i class="fi fi-rr-cross-small text-red-600 !font-weight-bolder"></i>
                    </a>
                    <img src="https://cartrefs.com/storage/products/December2022/HE4IGBP8bPX5d2J2dBSK.webp" alt="" class="w-3/12" />
                  </div>
                  <input
                      data-v-32256d36=""
                      type="file"
                      id="image"
                      placeholder="western-wear"
                      accept="image/*"
                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-orange-500 focus-visible:border-orange-500"
                  />
                </div>
              </div>
              <div data-v-32256d36="" class="md:flex mb-3">
                <div data-v-32256d36="" class="mb-5 md:w-1/2 w-full mx-2 my-1">
                  <label data-v-32256d36="" for="hsn" title="A numerical code used to classify products in international trade" class="block mb-2 text-sm font-bold text-gray-900">
                    HSN (Harmonized System of Nomenclature) <span data-v-32256d36="" class="text-red-600">*</span>
                  </label>
                  <input
                      data-v-32256d36=""
                      type="text"
                      id="hsn"
                      placeholder="8471"
                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-orange-500 focus-visible:border-orange-500"
                  />
                </div>
                <div data-v-32256d36="" class="mb-5 md:w-1/2 w-full mx-2 my-1">
                  <label data-v-32256d36="" for="gst" title="GST is a mandatory financial charge imposed by the government on goods and services" class="block mb-2 text-sm font-bold text-gray-900">
                    GST (%) <span data-v-32256d36="" class="text-red-600">*</span>
                  </label>
                  <input
                      data-v-32256d36=""
                      type="number"
                      id="gst"
                      placeholder="18"
                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-orange-500 focus-visible:border-orange-500"
                  />
                </div>
              </div>
              <div data-v-32256d36="" class="text-center">
                <button data-v-32256d36="" type="submit" class="text-white bg-orange-600 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-bold rounded-lg text-base mx-1 px-5 py-2.5">
                  Create
                </button>
                <button data-v-32256d36="" type="button" class="text-white bg-gray-600 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 font-bold rounded-lg text-base mx-1 px-5 py-2.5">
                  Clear
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductColorEdit",
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
