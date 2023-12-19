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
        <div class="flex gap-2 items-center text-3xl text-primary-600 font-semibold">
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
                <div class="table-cell border-gray-500 text-center uppercase font-semibold p-1">
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
                  Created On
                </div>
                <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">
                  Last Update
                </div>
              </div>

              <template v-if="sizes && sizes.length > 0">
                <div class="table-row table-body hover:bg-primary-100 bg-white" v-for="(size, index) in sizes" :key="size.id">
                  <div class="table-cell border-t border-gray-500 text-sm px-1 text-center py-4 relative">
                    {{ size.sku ?? '-' }}
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">
                    <div class="whitespace-nowrap mx-2 py-4">{{ size.size ?? '-' }}</div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                    <div class="text-sm py-2.5">{{ size.color ?? '-' }}</div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                    <div class="text-sm py-2.5" v-if="size.offer_price">₹{{ size.offer_price }}/-</div>
                    <div class="text-sm py-2.5" v-else>-</div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 p-1 text-center" @dblclick="editDimension(size)"
                       :title="size.length +' cms / ' + size.breath + ' cms / ' + size.height + ' cms / ' + size.weight + ' kgs' ">
                    <div class="flex justify-around items-center font-semibold text-gray-600 py-2.5" v-if="editDimensionId === size.id" tabindex="0"
                         v-click-outside="closeDimensionEdit">
                      <input type="number" class="rounded-md p-2 w-16 border border-primary-400 focus-visible:outline-none" v-model="editLength"
                             v-click-outside="closeStockEdit"
                             @keyup.enter="updateSize()" placeholder="10" autofocus>
                      /
                      <input type="number" class="rounded-md p-2 w-16 border border-primary-400 focus-visible:outline-none" v-model="editBreath"
                             v-click-outside="closeStockEdit"
                             @keyup.enter="updateSize()" placeholder="10" autofocus>
                      /
                      <input type="number" class="rounded-md p-2 w-16 border border-primary-400 focus-visible:outline-none" v-model="editHeight"
                             v-click-outside="closeStockEdit"
                             @keyup.enter="updateSize()" placeholder="10" autofocus>
                      /
                      <input type="number" class="rounded-md p-2 w-16 border border-primary-400 focus-visible:outline-none" v-model="editWeight"
                             v-click-outside="closeStockEdit"
                             @keyup.enter="updateSize()" placeholder="0.5" autofocus>
                    </div>
                    <div class="text-sm py-2.5" v-else>
                      {{ size.length ?? '-' }} / {{ size.breath ?? '-' }} / {{ size.height ?? '-' }} / {{ size.weight ?? '-' }}
                    </div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 p-1 text-center" @dblclick="editStockFunc(size)">
                    <div class="font-semibold text-gray-600 py-2.5" v-if="editStockId === size.id" tabindex="0">
                      <input type="number" class="rounded-md p-2 w-40 border border-primary-400 focus-visible:outline-none" v-model="editStock"
                             v-click-outside="closeStockEdit"
                             @keyup.enter="updateSize()" placeholder="qty" autofocus>
                    </div>
                    <div class="font-semibold text-gray-600 py-2.5" v-else>
                      {{ size.available_stock ?? '0' }}
                    </div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                    <label :id="'wait_'+size.id" class="hidden inline-block  justify-center w-4 h-4 mt-4  ">
                      <Spinner/>
                    </label>
                    <label class="relative inline-flex items-center cursor-pointer mt-4 " :id="'status_'+size.id">
                      <input class="sr-only peer" type="checkbox" :id="'checkbox_'+size.id" value="" :checked="parseInt(size.status) === 1"
                             @change="updateStatus(size.id, $event)">
                      <div
                          class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                    </label>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                    <div class="text-sm py-2.5" v-html="formDateTime(size.created_at)"></div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 p-1 text-center">
                    <div class="text-sm pt-2.5 pb-1" v-html="formDateTime(size.updated_at)"></div>
                    <div class="text-sm">({{ timeAgo(size.updated_at) }})</div>
                  </div>
                </div>
              </template>
              <template v-else-if="dataLoading">
                <Skeleton/>
              </template>
              <template v-else>
                <div>
                  <p class="text-center text-2xl">No Sizes Found !</p>
                </div>
              </template>
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
      loading: true,
      dataLoading: true,
      editStockId: '',
      editStock: '',
      editDimensionId: '',
      editLength: '',
      editBreath: '',
      editHeight: '',
      editWeight: '',
      product_id: this.$route.params.product_id,
      color_id: this.$route.params.color_id,
      product: {},
      color: {},
      sizes: [{}],
    }
  },
  methods: {
    closeStockEdit() {
      this.editStockId = '';
      this.editStock = '';
    },
    closeDimensionEdit() {
      this.editDimensionId = '';
      this.editLength = '';
      this.editBreath = '';
      this.editHeight = '';
      this.editWeight = '';
    },
    editStockFunc(size){
      this.editStockId = size.id;
      this.editStock = size.available_stock;
    },
    editDimension(size) {
      this.editDimensionId = size.id;
      this.editLength = size.length;
      this.editBreath = size.breath;
      this.editHeight = size.height;
      this.editWeight = size.weight;
    },
    updateSize() {
      let data = {}, id = '';
      if (this.editStockId) {
        id = this.editStockId;
        data.available_stock = this.editStock;
      }
      if (this.editDimensionId) {
        id = this.editDimensionId;
        data.length = this.editLength;
        data.breath = this.editBreath;
        data.height = this.editHeight;
        data.weight = this.editWeight;
      }
      axios.put(`/admin/product/${this.product_id}/color/${this.color_id}/sizes/${id}`, data)
          .then(({data}) => {
            this.show_toast(data.status, data.msg);
            this.closeStockEdit();
            this.closeDimensionEdit();
            this.fetchSizes();
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
    updateStatus(id, e) {
      document.getElementById('wait_' + id).classList.remove('hidden')
      document.getElementById('status_' + id).classList.add('hidden')
      axios.put(`/admin/product/${this.product_id}/color/${this.color_id}/sizes/${id}`, {
        status: e.target.checked
      })
          .then(({data}) => {
            this.show_toast(data.status, data.msg);
            document.getElementById('wait_' + id).classList.add('hidden')
            document.getElementById('status_' + id).classList.remove('hidden')
            this.fetchSizes()
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
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
