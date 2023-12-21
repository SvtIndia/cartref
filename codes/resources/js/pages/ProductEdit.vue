<template>
  <div>
    <Wait :show="loading"/>
    <div class="container mx-auto my-2 px-4">
      <div class="mt-6">
        <a @click="$router.go(-1)"
           class="inline-flex items-center gap-2 px-4 py-2 text-base font-bold text-center text-white align-middle transition-all rounded-lg cursor-pointer bg-gray-800 hover:bg-black hover:text-white">
          <i class="fi fi-rr-arrow-left text-base w-4 h-5"></i>
          Back
        </a>
      </div>
      <div class="flex gap-2 items-center text-3xl text-primary-600 font-semibold">
        <i class="fi fi-rr-box-open"></i>
        <h3 class="text-start my-8">Edit Product</h3>
      </div>

      <div class="bg-white p-4 overflow-x-auto shadow-md sm:rounded-lg my-4">
        <div class="block">
          <form>
            <div class="flex flex-col md:flex-row gap-8 mx-2">
              <div class="flex flex-col md:w-3/4 w-full">
                <div class="w-full my-2">
                  <label for="title" class="block mb-2 text-sm font-bold text-gray-900"
                         title="A concise name describing a product for easy identification and marketing.">
                    Product Title <span class="text-red-600">*</span>
                  </label>
                  <input type="text" v-model="product.name" id="title" class="form-input" placeholder="Western Wear" required>
                </div>
                <div class="w-full my-2">
                  <label for="slug" class="block mb-2 text-sm font-bold text-gray-900"
                         title="The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.">
                    URL / Slug <span class="text-red-600">*</span>
                  </label>
                  <input type="text" v-model="product.slug" id="slug" class="form-input" placeholder="western-wear" required>
                </div>
                <div class="w-full my-2">
                  <label for="code" class="block mb-2 text-sm font-bold text-gray-900"
                         title="'SKU' stands for Stock Keeping Unit, a unique code for product identification in inventory.">
                    Product Code (ERP) / SKU <span class="text-red-600">*</span>
                  </label>
                  <input type="text" v-model="product.sku" id="code" class="form-input" placeholder="12X-987XX" required>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="category_id" class="block mb-2 text-sm font-bold text-gray-900"
                           title="Those immediately above the category in the hierarchy">Category <span class="text-red-600">*</span></label>
                    <div class="relative">
                      <select v-model="product.category_id" id="category_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Category</option>
                        <option v-for="(category) in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="subcategory_id" class="block mb-2 text-sm font-bold text-gray-900" title="Those immediately below the main category in the hierarchy">Sub
                      Category
                      <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                      <select v-model="product.subcategory_id" id="subcategory_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Sub Category</option>
                        <option v-for="(sub_cat) in sub_categories" :key="sub_cat.id" :value="sub_cat.id">{{ sub_cat.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="mb-5 md:w-1/2 w-full">
                    <label for="brand_id" class="block mb-2 text-sm font-bold text-gray-900"
                           title="Brand is a distinct identity and perception of a product or company in the market.">
                      Brand <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                      <select v-model="product.brand_id" id="brand_id" class="form-input appearance-none" required>
                        <option value="" selected>Choose Brand</option>
                        <option v-for="(brand) in brands" :key="brand.id" :value="brand.name">{{ brand.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="mb-5 md:w-1/2 w-full">
                    <label for="seller_id" class="block mb-2 text-sm font-bold text-gray-900"
                           title="The Seller name is the individual or business selling a product or service.">
                      Seller Name <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                      <select v-model="product.seller_id" id="seller_id" class="form-input appearance-none" required>
                        <option value="" selected>Choose Seller</option>
                        <option v-for="(seller) in sellers" :key="seller.id" :value="seller.id">{{ seller.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex flex-col md:w-1/4 w-full">
                <div class="flex flex-col gap-4" title="The primary or featured image representing a subject, often used in media and content.">
                  <div>
                    <label class="block mb-2 text-sm font-bold text-gray-900">Main Image</label>
                    <img class="w-100 border h-[23rem] max:h-full w-full rounded-md shadow-md cursor-zoom-in"
                         v-if="product && product.image"
                         :src="$store.state.storageUrl + product.image"
                         @click="imageModal($store.state.storageUrl + product.image)"
                         @error="imageLoadError"
                         alt="main-img"/>
                  </div>
                  <div>
                    <input type="file" class="form-input" name="main_img" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full my-1 mb-3">
              <label for="description" class="block mb-2 text-sm font-bold text-gray-900"
                     title="A concise depiction or portrayal providing details and characteristics of a subject or object.">
                Description <span class="text-red-600">*</span>
              </label>
              <textarea v-model="product.description" id="description" class="form-input h-36" placeholder="Describe your product here..."></textarea>
            </div>
            <div class="w-full my-1 mb-3">
              <label for="features" class="block mb-2 text-sm font-bold text-gray-900"
                     title="Distinctive attributes or characteristics of something, often highlighting its unique qualities or functions.">
                Features <span class="text-red-600">*</span>
              </label>
              <RichTextEditor :setVal="(val) => product.features = val" :initial_value="product.features" height="350"/>
            </div>
            <div class="flex flex-col md:flex-row gap-8 mx-2 mb-3">
              <div class="flex flex-col md:w-3/5 w-full">
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="gender_id" class="block mb-2 text-sm font-bold text-gray-900">Gender <span class="text-red-600">*</span></label>
                    <div class="relative">
                      <select v-model="product.gender_id" id="gender_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Gender</option>
                        <option v-for="(gender) in genders" :key="gender.id" :value="gender.name">{{ gender.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="style_id" class="block mb-2 text-sm font-bold text-gray-900"
                           title="Style is a distinctive manner or characteristic expression that defines an individual, work, or era">
                      Style <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                      <select v-model="product.style_id" id="style_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Style</option>
                        <option v-for="(style) in styles" :key="style.id" :value="style.name">{{ style.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="sizes" class="block mb-2 text-sm font-bold text-gray-900">
                      Available Sizes <span class="text-red-600">*</span>
                    </label>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="seller_id" class="block mb-2 text-sm font-bold text-gray-900">
                      Available Colors <span class="text-red-600">*</span>
                    </label>
                  </div>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="length" class="block mb-2 text-sm font-bold text-gray-900" title="The length of the item in cms. Must be more than 0.5">
                      Length (cms) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" v-model="product.length" id="length" class="form-input" placeholder="20" required>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="breadth" class="block mb-2 text-sm font-bold text-gray-900" title="The breadth of the item in cms. Must be more than 0.5">
                      Breadth (cms) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" v-model="product.breadth" id="breadth" class="form-input" placeholder="20" required>
                  </div>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="height" class="block mb-2 text-sm font-bold text-gray-900" title="The height of the item in cms. Must be more than 0.5">
                      Height (cms) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" v-model="product.height" id="height" class="form-input" placeholder="20" required>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="weight" class="block mb-2 text-sm font-bold text-gray-900" title="The weight of the item in cms. Must be more than 0.5">
                      Weight (cms) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" v-model="product.weight" id="weight" class="form-input" placeholder="20" required>
                  </div>
                </div>
                <div class="w-full my-2">
                  <label for="size_guide" class="block mb-2 text-sm font-bold text-gray-900"
                         title="An image which references chart indicating measurements for selecting appropriate clothing or products.">
                    Size Guide
                  </label>
                  <input type="file" id="size_guide" class="form-input" accept="image/*">
                </div>
                <div class="flex flex-col md:flex-row gap-4 w-full mt-2 mb-1">
                  <div class="md:w-1/2 w-full">
                    <label for="mrp" class="block mb-2 text-sm font-bold text-gray-900">Maximum Retail Price (MRP) <span class="text-red-600">*</span></label>
                    <input type="number" step="0.01" v-model="product.mrp" id="mrp" class="form-input" placeholder="1999" required>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="offer_price" class="block mb-2 text-sm font-bold text-gray-900">Selling Price <span class="text-red-600">*</span></label>
                    <input type="number" step="0.01" v-model="product.offer_price" id="offer_price" class="form-input" placeholder="1499" required>
                  </div>
                </div>
                <div class="w-full mb-2">
                  <div class="text-green-500 text-sm" v-if="product.mrp > 0 && product.offer_price > 0">
                    <span class="text-gray-800">Discount :</span>
                    ₹{{ discount }} ({{ discountPercent }}%)
                  </div>
                </div>
                <div class="w-full my-2">
                  <label for="product_tags" class="block mb-2 text-sm font-bold text-gray-900"
                         title="Product keywords are specific terms used to optimize search and enhance discoverability online.">
                    Product Keywords / Tags (Comma [,] Seperated)
                  </label>
                  <textarea v-model="product.product_tags" id="product_tags" class="form-input h-32"
                            placeholder="Western, Western-style clothing, Dress, Denim, Bolo tie, Western belt">
                  </textarea>
                </div>
                <div class="w-full my-2" v-if="editId">
                  <label for="admin_comments" class="block mb-2 text-sm font-bold text-gray-900">Admin Comments </label>
                  <RichTextEditor :setVal="(val) => product.admin_comments = val" :initial_value="product.admin_comments"/>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="w-1/2">
                    <label for="admin_status" class="block mb-2 text-sm font-bold text-gray-900">QC Status</label>
                    <div class="relative">
                      <select v-model="product.admin_status" id="admin_status" class="form-input appearance-none" required>
                        <option v-for="(status) in admin_statuses" :key="status.id" :value="status.name">{{ status.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="w-1/2">
                    <label for="flash_sale" class="block mb-2 text-sm font-bold text-gray-900">Flash Sale </label>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" id="flash_sale" value="1" :checked="parseInt(product.flash_sale) === 1" class="sr-only peer">
                      <div
                          class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                    </label>
                  </div>
                </div>
              </div>
              <div class="block md:w-2/5 w-full">
                <label class="block mb-2 text-sm font-bold text-gray-900">More Images</label>
                <div class="grid gap-2 grid-cols-2">
                  <template v-if="product && product.json_images && product.json_images.length > 0">
                    <div class="relative bg-white border border-gray-200 rounded-lg shadow h-[18rem]" v-for="(image, index) in product.json_images" :key="index">
                      <div class="h-full w-full">
                        <img class="h-full w-full cursor-zoom-in border rounded-md object-fill"
                             v-if="image"
                             :src="$store.state.storageUrl + image"
                             @click="imageModal($store.state.storageUrl + image)"
                             @error="imageLoadError"
                             alt="image"
                        />
                      </div>
                      <button type="button" class="absolute top-0 right-1 text-red-500 text-xl cursor-pointer">
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
                      <input id="dropzone-file" type="file" class="absolute h-full w-full z-0 m-0 p-0 opacity-0" accept="image/*" multiple>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="submit-btn"> {{ this.editId ? 'Update' : 'Create' }}</button>
              <button type="button" @click="clear()" class="submit-btn bg-gray-600 hover:bg-gray-700">Clear</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <ImageModal :show="showModal" :hide="closeImageModal" :img="imgModal"></ImageModal>
  </div>
</template>
<script>
export default {
  name: "ProductEdit",
  data() {
    return {
      loading: true,
      dataLoading: false,
      showModal: false,
      imgModal: '',
      editId: this.$route.params.id,
      //dropdown-lists
      categories: [],
      sub_categories: [],
      brands: [],
      sellers: [],
      genders: [],
      styles: [],
      admin_statuses: [
        {id: 1, name: 'Pending For Verification'},
        {id: 2, name: 'Accepted'},
        {id: 3, name: 'Rejected'},
        {id: 4, name: 'Updated'},
      ],
      product: {
        //basic-text-fields
        name: '',
        sku: '',
        slug: '',
        //dropdown-list-ids
        category_id: '',
        subcategory_id: '',
        brand_id: '',
        seller_id: '',
        gender_id: '',
        style_id: '',
        //dimensions
        length: '',
        breadth: '',
        height: '',
        weight: '',
        //price fields
        offer_price: 0,
        mrp: 0,
        //image
        image: "",
        json_images: [],
        //textarea-fields
        description: "",
        features: "<p>Describe your product's features here...</p>",
        product_tags: "",
        admin_comments: "",
        //status
        flash_sale: false,
        admin_status: 'Accepted',
      },
    }
  },
  watch: {
    "product.category_id": function (newValue, oldValue) {
      this.fetchSubCategory();
    }
  },
  computed: {
    discount() {
      return (this.product.mrp - this.product.offer_price).toFixed(2);
    },
    discountPercent() {
      return ((this.discount / this.product.mrp) * 100).toFixed(2);
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
    clear() {

    },
    fetchProduct() {
      this.loading = true;
      axios
          .get('admin/product/' + this.editId)
          .then(res => {
            this.product = res.data.data;
            this.loading = false;
          })
          .catch(err => {
            this.loading = false;
            err.handleGlobally && err.handleGlobally();
          })
    },
    fetchParentCategory() {
      axios
          .get('/admin/category', {
            params: {
              rows: 'all',
              status: 1,
            }
          })
          .then(res => {
            this.categories = res.data.data;
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
    fetchSubCategory() {
      axios
          .get('/admin/sub-category', {
            params: {
              rows: 'all',
              status: 1,
              category_id: this.product.category_id,
            }
          })
          .then(res => {
            this.sub_categories = res.data.data;
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
    fetchBrand() {
      axios
          .get('/admin/brand', {
            params: {
              rows: 'all',
              status: 1,
            }
          })
          .then(res => {
            this.brands = res.data.data;
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
    fetchStyle() {
      axios
          .get('/admin/style', {
            params: {
              rows: 'all',
              status: 1,
            }
          })
          .then(res => {
            this.styles = res.data.data;
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
    fetchGender() {
      axios
          .get('/admin/gender', {
            params: {
              rows: 'all',
              status: 1,
            }
          })
          .then(res => {
            this.genders = res.data.data;
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
    fetchSellers() {
      axios
          .get('/admin/user', {
            params: {
              rows: 'all',
              status: 1,
              roles: JSON.stringify(["Vendor"])
            }
          })
          .then(res => {
            this.sellers = res.data.data;
          })
          .catch(err => {
            err.handleGlobally && err.handleGlobally();
          })
    },
  },
  created() {
    this.fetchParentCategory();
    this.fetchBrand();
    this.fetchStyle();
    this.fetchGender();
    this.fetchSellers();
    this.fetchProduct();
  },
}
</script>