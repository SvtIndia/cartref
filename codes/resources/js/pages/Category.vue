<template>
  <div>
    <div class="container mx-auto my-2 px-4">
      <div class="flex gap-2 items-center text-3xl text-green-600 font-semibold">
        <i class="fi fi-rr-chart-tree-map"></i>
        <h3 class="text-start my-8">Category</h3>
      </div>

      <div class="bg-white p-4 overflow-x-auto shadow-md sm:rounded-lg">
        <div class="block">
          <div class="flex items-center justify-between py-4">
            <div class="flex text-base text-gray-700 gap-2">
              <div>
                {{ pagination.from || '0' }} - {{ pagination.to || '0' }} of {{ pagination.total || '0' }}
              </div>
              <div>
                <button :disabled="!pagination.prev_page_url" @click="fetchCategory(pagination.prev_page_url)" title="Previous"
                        class="border border-transparent rounded-full hover:bg-green-400 disabled:opacity-50">
                  <i class="fi fi-rr-angle-small-left text-xl px-1 py-2"></i>
                </button>
                <button :disabled="!pagination.next_page_url" @click="fetchCategory(pagination.next_page_url)" title="Next"
                        class="border border-transparent rounded-full hover:bg-green-400 disabled:opacity-50">
                  <i class="fi fi-rr-angle-small-right text-xl px-1 py-2"></i>
                </button>
              </div>
            </div>
            <div class="flex items-center gap-2">
              <div class="relative">
                <select title="Status" v-model="status" @change="fetchCategory()"
                        class="block appearance-none w-32 leading-tight h-full cursor-pointer text-black bg-white border border-gray-400 focus:outline-none hover:shadow-sm focus:ring-2 focus:ring-green-500 focus:border-none font-medium rounded-lg text-sm px-3 py-2">
                  <option class="bg-gray-100" value="">All</option>
                  <option class="bg-gray-100" value="1">Published</option>
                  <option class="bg-gray-100" value="0">Un Published</option>
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
                <input type="text" v-model="keyword"
                       class="block focus-visible:outline focus-visible:outline-1 focus-visible:outline-green-500 focus-visible:border-green-500 p-2 pl-10 text-sm text-gray-900 border border-gray-400 rounded-lg w-40 bg-white"
                       placeholder="Search" @keydown.enter="fetchCategory()">
              </div>
              <div class="flex border border-gray-600 rounded-lg bg-white">
                <button class="px-2 py-1 m-[2px] hover:bg-green-100 border-r border-solid cursor-pointer" @click="fetchCategory()">
                  <i class="ffi fi-rr-refresh mr-1"></i>
                </button>
                <select
                    class="w-14 block px-1 m-[2px] text-base text-center text-gray-900 bg-white cursor-pointer"
                    @change="fetchCategory()" v-model="row_count">
                  <option :value="count.toLowerCase()" v-for="(count, index) in $store.state.row_counts" :key="index" class="bg-white">
                    {{ count }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <template v-if="loading">
            <Skeleton/>
          </template>
          <template v-else-if="category && category.length > 0">
            <div class="clear-right overflow-x-auto">
              <div class="table border-solid border border-gray-500 w-full">
                <div class="table-row table-head">
                  <div class="table-cell border-gray-500 text-center uppercase font-semibold p-1 px-2">
                    <div class="flex items-center">
                      <input type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                    </div>
                  </div>
                  <div class="table-cell border-l border-gray-500 text-center font-semibold uppercase w-10 p-1">S.No.</div>
                  <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">Name</div>
                  <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">Slug</div>
                  <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">Status</div>
                  <div class="table-cell border-l border-gray-500 text-center uppercase font-semibold p-1">Last Update</div>
                </div>
                <div v-for="(c, index) in category" v-bind:key="index" class="table-row table-body hover:bg-green-100 bg-white">
                  <div class="table-cell border-t border-gray-500 text-sm text-center w-10 p-1 px-2">
                    <div class="flex items-center">
                      <input type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded">
                    </div>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm text-center w-10 p-1">{{ index + 1 }}</div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center">{{ c.name }}</div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1">{{ c.slug }}</div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1">
                    <label :id="'wait_'+c.id" class="hidden inline-block  justify-center w-4 h-4">
                      <Spinner/>
                    </label>
                    <label class="relative inline-flex items-center cursor-pointer" :id="'status_'+c.id">
                      <input type="checkbox" :id="'checkbox_'+c.id" value="" :checked="parseInt(c.status) == 1" @change="updateStatus(c.id, $event)" class="sr-only peer">
                      <div
                          class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                    </label>
                  </div>
                  <div class="table-cell border-t border-l border-gray-500 text-sm px-1 text-center py-1 !align-middle">
                    <div class="font-normal text-gray-900">{{ formatSimpleDate(c.updated_at) }}</div>
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
                <Pagination :pagination="pagination" :fetchNewData="fetchCategory"/>
              </div>
            </div>
          </template>
          <template v-else>
            <div>
              <p class="text-center text-2xl">No Categories Found !</p>
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
  name: "Category",
  data() {
    return {
      loading: true,
      toggleLoadingId: '',
      category: [],
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
    updateStatus(id, e) {
      document.getElementById('wait_' + id).classList.remove('hidden')
      document.getElementById('status_' + id).classList.add('hidden')
      axios.put('/admin/category/' + id, {
        status: e.target.checked
      })
          .then(res => {
            if (e.target.checked) {
              this.show_toast('success', res.data.msg);
            } else {
              this.show_toast('warning', res.data.msg);
            }
            document.getElementById('wait_' + id).classList.add('hidden')
            document.getElementById('status_' + id).classList.remove('hidden')
            document.getElementById('checkbox_' + id).checked = e.target.checked;
          })

    },
    fetchCategory(url) {
      this.loading = true;
      url = url || '/admin/category'
      axios.get(url, {
        params: {
          rows: this.row_count,
          keyword: this.keyword,
          status: this.status,
        }
      })
          .then(res => {
            this.loading = false;
            this.category = res.data.data;
            let {data, ...pagination} = res.data;
            pagination.links.pop();
            pagination.links.shift();
            this.pagination = pagination;
          })
          .catch(err => {
            this.loading = false;
          })
    }
  },
  created() {
    this.fetchCategory();
  },
}
</script>

<style lang="scss" scoped>

</style>