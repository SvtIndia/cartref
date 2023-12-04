<template>
  <div>
    <Wait :show="loading"/>
    <div class="container mx-auto my-2 px-4">
      <h1 class="text-center text-2xl underline uppercase">{{ product.name }}</h1>
      <div class="flex flex-wrap justify-between items-center">
        <div class="flex gap-2 items-center text-3xl text-green-600 font-semibold">
          <i class="fi fi-rr-palette"></i>
          <h3 class="text-start my-8">{{ color.color }} Sizes</h3>
        </div>
      </div>

      <div class="block">

      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "ProductSizes",
  data() {
    return {
      loading: true,
      dataLoading: true,
      product_id: this.$route.params.product_id,
      color_id: this.$route.params.color_id,
      product: {},
      color: {},
      sizes: [],
    }
  },
  methods: {
    fetchProductAndColor(){
      axios
          .get(`/admin/product/${this.product_id}`)
          .then(res=>{
            this.product = res.data.data;
          })

      axios
          .get(`/admin/product/color/${this.color_id}`)
          .then(res=>{
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