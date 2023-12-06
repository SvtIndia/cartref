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
          <h3 class="text-start my-8">Colors</h3>
        </div>
        <div>
          <a class="flex items-center gap-2 px-4 py-2 text-base font-bold text-center text-white align-middle transition-all rounded-lg cursor-pointer bg-orange-500 hover:bg-orange-600">
            Edit Product
            <i class="fi fi-rr-arrow-up-right-from-square text-base w-6 h-6"></i>
          </a>
        </div>
      </div>

      <div class="block">
        <div class="grid w-full grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" v-if="product_colors && product_colors.length > 0">
          <div v-for="(color, index) in product_colors" :key="color.id"
               class="relative flex flex-col mt-6 mx-2 text-gray-700 bg-white shadow-lg bg-clip-border rounded-xl w-100">
            <div class="p-4">
              <img :src="$store.state.storageUrl + color.main_image" class="w-full h-64 mx-auto mb-2 rounded">
              <h5 class="block mb-2 font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                {{ color.color }}
              </h5>
              <div class="flex items-center justify-between">
                <router-link :to="{name:'product-sizes', params: { product_id: product.id, color_id: color.id }}" class="inline-block">
                  <button
                      class="flex items-center gap-2 px-4 py-2 text-xs font-bold text-center text-white bg-orange-500 uppercase align-middle transition-all rounded-lg select-none  hover:bg-orange-600"
                      type="button">
                    Sizes
                    <i class="fi fi-rr-arrow-right text-sm w-4 h-4"></i>
                  </button>
                </router-link>
                <label :id="'wait_' + color.id" class="hidden inline-block  justify-center w-6 h-6">
                  <Spinner/>
                </label>
                <label class="relative inline-flex items-center cursor-pointer" :id="'status_' + color.id"
                       :title="parseInt(color.status) == 1 ? 'Click to UnPublish' : 'Click to Publish'">
                  <input type="checkbox" :id="'checkbox_' + color.id" value=""
                         :checked="parseInt(color.status) == 1" @change="updateStatus(color.id, $event)"
                         class="sr-only peer">
                  <div
                      class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-600">
                  </div>
                </label>
              </div>
            </div>
            <div class="absolute top-1 right-0">
              <router-link :to="{name:'product-color-edit', params: { product_id: product.id, color_id: color.id }}" class="bg-white text-orange-500 hover:bg-orange-500 hover:text-white cursor-pointer px-2 py-1 rounded-md">
                <i class="fi fi-rr-pencil text-sm w-4 h-4"></i>
              </router-link>
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
      axios.get(`/admin/product/${this.product_id}/colors`)
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
    },
    updateStatus(id, e) {
      let status = e.target.checked;
      document.getElementById('wait_' + id).classList.remove('hidden')
      document.getElementById('status_' + id).classList.add('hidden')

      axios.put('/admin/product/color/' + id, {
        status: status
      })
          .then(res => {
            this.show_toast(res.data.status, res.data.msg);
            document.getElementById('wait_' + id).classList.add('hidden')
            document.getElementById('status_' + id).classList.remove('hidden')
            document.getElementById('checkbox_' + id).checked = e.target.checked;
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })

    },
  },
  created() {
    this.fetchProductColors();
  },
}
</script>

<style lang="scss" scoped></style>
