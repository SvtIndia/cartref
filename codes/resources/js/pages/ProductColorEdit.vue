<template>
  <div>
    <Wait :show="loading"/>
    <div class="container mx-auto my-2 px-4">
      <h1 class="text-center text-2xl underline uppercase">{{ product.name ?? '-' }}</h1>
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
          <h3 class="text-start my-8">{{ color.color }}</h3>
        </div>
      </div>

      <div class="block">
        <!--  Form -->
        <div class="bg-white p-4 overflow-x-auto shadow-md sm:rounded-lg my-4">
          <div class="block">
            <form>
              <div class="md:flex mb-3">
                <div class="mb-5 w-full mx-2 my-1">
                  <label for="color" class="block mb-2 text-sm font-bold text-gray-900">Color <span class="text-red-600">*</span></label>
                  <input
                      type="text"
                      id="color"
                      v-model="color_name"
                      placeholder="Color"
                      required="required"
                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus-visible:outline focus-visible:outline-1 focus-visible:outline-primary-500 focus-visible:border-primary-500"
                  />
                </div>
              </div>
              <div class="md:flex gap-4 mb-3 mx-2 my-1">
                <div class="w-full md:w-1/2 block">
                  <label class="block mb-2 text-sm font-bold text-gray-900">More Images</label>
                  <div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                    <template v-if="color.json_more_images && Array.isArray(color.json_more_images) && color.json_more_images.length > 0">
                      <div class="relative bg-white border border-gray-200 rounded-lg shadow h-52" v-for="(image, index) in color.json_more_images" :key="image">
                        <div class="h-full w-full">
                          <img class="h-full w-full cursor-zoom-in border rounded-md object-fill"
                              v-if="image"
                              :src="$store.state.storageUrl + image"
                              @click="imageModal($store.state.storageUrl + image)"
                              alt="image"
                          />
                        </div>
                        <button type="button" @click="deleteImage(image)" class="absolute top-0 right-1 text-red-500 text-xl cursor-pointer">
                          <i class="fi fi-rr-circle-xmark"></i>
                        </button>
                      </div>
                    </template>
                    <div class="flex items-center justify-center col-span-2 h-52">
                      <label for="dropzone-file"
                             class="relative flex flex-col items-center justify-center w-full h-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:rounded-xl hover:shadow-md">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                          <i class="fi fi-rr-cloud-upload-alt text-4xl h-8 mb-4 text-gray-500"></i>
                          <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                          <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF</p>
                          <p id="dropzone-file-select" class="text-base text-gray-500"></p>
                        </div>
                        <input id="dropzone-file" type="file" class="absolute h-full w-full z-0 m-0 p-0 opacity-0"  accept="image/*" @change="handleFileChange($event)" multiple>
                      </label>
                    </div>
                  </div>

                </div>
                <div class="w-full md:w-1/2 block max-sm:my-4">
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-900">Main Image</label>
                    <img class="w-100 md:h-[36rem] w-full border rounded-md" :src="$store.state.storageUrl + color?.main_image" alt="main"/>
                  </div>
                  <!-- upload -->
                  <div class="flex items-center justify-center bg-grey-lighter mt-4">
                    <label
                        class="flex flex-col items-center px-4 py-4 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-primary-500 hover:text-white">
                      <i class="fi fi-rr-file-upload text-3xl"></i>
                      <span class="mt-2 text-base leading-normal">Choose image</span>
                      <input type='file' class="hidden"/>
                    </label>
                  </div>
                </div>
              </div>
              <div class="text-left">
                <button type="submit"
                        class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-bold rounded-lg text-base mx-1 px-5 py-2.5">
                  Update
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <ImageModal :show="showModal" :hide="closeImageModal" :img="imgModal"></ImageModal>
  </div>
</template>

<script>
export default {
  name: "ProductColorEdit",
  data() {
    return {
      loading: true,
      dataLoading: true,
      showModal: false,
      imgModal: '',
      product_id: this.$route.params.product_id,
      color_id: this.$route.params.color_id,
      product: {},
      color: {},
      color_name: '',
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

    /* Operational methods */
    deleteImage(img) {
      if (!confirm("Are you sure want to delete this image ? ")) {
        return false;
      }
      this.loading = true;
      axios
          .post(`/admin/product/color/${this.color_id}/delete-image`, {
            image: img,
          })
          .then(res => {
            this.fetchColor();
            this.show_toast(res.data.status, res.data.msg);
          })
          .catch(err => {
            this.loading = false;
            err.handleGlobally && err.handleGlobally();
          })
    },
    handleFileChange(e) {
      let files = e.target.files;
      if(files.length <= 0){
        return false;
      }

      //4 files selected txt
      $('#dropzone-file-select').html(files.length+' file(s) selected')

      this.loading = true;
      //creating new object of files
      const formData = new FormData();
      for (let i = 0; i < files.length; i++) {
        let file = files[i];
        formData.append('images[' + i + ']', file);
      }

      //uploading to db
      const config = {
        headers: {'Content-Type': 'multipart/form-data'}
      }
      axios.post(`/admin/product/color/${this.color_id}/upload-images`, formData, config)
          .then((res) => {
            this.fetchColor();
            this.show_toast(res.data.status, res.data.msg);
            $('#dropzone-file-select').html('');
          })
          .catch(err => {
            $('#dropzone-file-select').html('');
            this.loading = false;
            err.handleGlobally && err.handleGlobally();
          })
    },

    /* Data fetch methods */
    fetchProduct() {
      axios
          .get(`/admin/product/${this.product_id}`)
          .then(res => {
            this.product = res.data.data;
          })
          .catch(err => {
            this.loading = false;
            err.handleGlobally && err.handleGlobally();
          })
    },
    fetchColor() {
      axios
          .get(`/admin/product/color/${this.color_id}`)
          .then(res => {
            this.color = res.data.data;
            this.loading = false;
            this.color_name = this.color.color;
          })
          .catch(err => {
            this.loading = false;
            err.handleGlobally && err.handleGlobally();
          })
    },
  },
  created() {
    this.fetchProduct();
    this.fetchColor();
  },
}
</script>

<style lang="scss" scoped>

</style>
