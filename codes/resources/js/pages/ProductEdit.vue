<template>
  <div>
    <Wait :show="loading"/>
    <div class="container mx-auto my-2 px-4">
      <div class="flex gap-2 items-center text-3xl text-primary-600 font-semibold">
        <i class="fi fi-rr-folder-tree"></i>
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
                  <input type="text" v-model="name" id="title" class="form-input" placeholder="Western Wear" required>
                </div>
                <div class="w-full my-2">
                  <label for="slug" class="block mb-2 text-sm font-bold text-gray-900"
                         title="The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.">
                    URL / Slug <span class="text-red-600">*</span>
                  </label>
                  <input type="text" v-model="slug" id="slug" class="form-input" placeholder="western-wear" required>
                </div>
                <div class="w-full my-2">
                  <label for="code" class="block mb-2 text-sm font-bold text-gray-900"
                         title="'SKU' stands for Stock Keeping Unit, a unique code for product identification in inventory.">
                    Product Code (ERP) / SKU <span class="text-red-600">*</span>
                  </label>
                  <input type="text" v-model="sku" id="code" class="form-input" placeholder="12X-987XX" required>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="category_id" class="block mb-2 text-sm font-bold text-gray-900"
                           title="Those immediately above the category in the hierarchy">Category <span class="text-red-600">*</span></label>
                    <div class="relative">
                      <select v-model="category_id" id="category_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Category</option>
                        <option v-for="(category, index) in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="sub_category_id" class="block mb-2 text-sm font-bold text-gray-900" title="Those immediately below the main category in the hierarchy">Sub
                      Category
                      <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                      <select v-model="sub_category_id" id="sub_category_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Sub Category</option>
                        <option v-for="(sub_cat, index) in sub_categories" :key="sub_cat.id" :value="sub_cat.id">{{ sub_cat.name }}</option>
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
                      <select v-model="brand_id" id="brand_id" class="form-input appearance-none" required>
                        <option value="" selected>Choose Brand</option>
                        <option v-for="(brand, index) in brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>
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
                      <select v-model="seller_id" id="seller_id" class="form-input appearance-none" required>
                        <option value="" selected>Choose Seller</option>
                        <option v-for="(seller, index) in sellers" :key="seller.id" :value="seller.id">{{ seller.name }}</option>
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
                         v-if="main_image"
                         :src="$store.state.storageUrl + main_image"
                         @click="imageModal($store.state.storageUrl + main_image)"
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
              <textarea v-model="description" id="description" class="form-input h-36" placeholder="Describe your product here..."></textarea>
            </div>
            <div class="w-full my-1 mb-3">
              <label for="features" class="block mb-2 text-sm font-bold text-gray-900"
                     title="Distinctive attributes or characteristics of something, often highlighting its unique qualities or functions.">
                Features <span class="text-red-600">*</span>
              </label>
              <RichTextEditor :setVal="(val) => features = val" :initail_value="features" height="350"/>
            </div>
            <div class="flex flex-col md:flex-row gap-8 mx-2 mb-3">
              <div class="flex flex-col md:w-3/5 w-full">
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="gender_id" class="block mb-2 text-sm font-bold text-gray-900">Gender <span class="text-red-600">*</span></label>
                    <div class="relative">
                      <select v-model="gender_id" id="gender_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Gender</option>
                        <option v-for="(gender, index) in genders" :key="gender.id" :value="gender.id">{{ gender.name }}</option>
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
                      <select v-model="style_id" id="style_id" class="form-input appearance-none" required>
                        <option value="" selected>Select Style</option>
                        <option v-for="(style, index) in styles" :key="style.id" :value="style.id">{{ style.name }}</option>
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
                    <input type="text" v-model="length" id="length" class="form-input" placeholder="20" required>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="breadth" class="block mb-2 text-sm font-bold text-gray-900" title="The breadth of the item in cms. Must be more than 0.5">
                      Breadth (cms) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" v-model="breadth" id="breadth" class="form-input" placeholder="20" required>
                  </div>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="md:w-1/2 w-full">
                    <label for="height" class="block mb-2 text-sm font-bold text-gray-900" title="The height of the item in cms. Must be more than 0.5">
                      Height (cms) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" v-model="height" id="height" class="form-input" placeholder="20" required>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="weight" class="block mb-2 text-sm font-bold text-gray-900" title="The weight of the item in cms. Must be more than 0.5">
                      Weight (cms) <span class="text-red-600">*</span>
                    </label>
                    <input type="text" v-model="weight" id="weight" class="form-input" placeholder="20" required>
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
                    <input type="number" step="0.01" v-model="mrp" id="mrp" class="form-input" placeholder="1999" required>
                  </div>
                  <div class="md:w-1/2 w-full">
                    <label for="offer_price" class="block mb-2 text-sm font-bold text-gray-900">Selling Price <span class="text-red-600">*</span></label>
                    <input type="number" step="0.01" v-model="offer_price" id="offer_price" class="form-input" placeholder="1499" required>
                  </div>
                </div>
                <div class="w-full mb-2">
                  <div class="text-green-500 text-sm">
                    <span class="text-gray-800">Discount :</span>
                    ₹500.00 (25%)
                  </div>
                </div>
                <div class="w-full my-2">
                  <label for="product_tags" class="block mb-2 text-sm font-bold text-gray-900"
                         title="Product keywords are specific terms used to optimize search and enhance discoverability online.">
                    Product Keywords / Tags (Comma [,] Seperated)
                  </label>
                  <textarea v-model="product_tags" id="product_tags" class="form-input h-32"
                            placeholder="Western, Western-style clothing, Dress, Denim, Bolo tie, Western belt">
                  </textarea>
                </div>
                <div class="w-full my-2" v-if="editId">
                  <label for="admin_comments" class="block mb-2 text-sm font-bold text-gray-900">Admin Comments </label>
                  <RichTextEditor :setVal="(val) => admin_comments = val" :initail_value="admin_comments"/>
                </div>
                <div class="flex gap-4 w-full my-2">
                  <div class="w-1/2">
                    <label for="admin_status" class="block mb-2 text-sm font-bold text-gray-900">QC Status</label>
                    <div class="relative">
                      <select v-model="admin_status" id="admin_status" class="form-input appearance-none" required>
                        <option v-for="(status, index) in admin_statuses" :key="status.id" :value="status.name">{{ status.name }}</option>
                      </select>
                      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fi fi-ss-angle-small-down text-xl w-5 h-6 ml-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="w-1/2">
                    <label for="flash_sale" class="block mb-2 text-sm font-bold text-gray-900">Flash Sale </label>
                    <label class="relative inline-flex items-center cursor-pointer">
                      <input type="checkbox" id="flash_sale" value="1" :checked="parseInt(flash_sale) === 1" class="sr-only peer">
                      <div
                          class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                    </label>
                  </div>
                </div>
              </div>
              <div class="block md:w-2/5 w-full">
                <label class="block mb-2 text-sm font-bold text-gray-900">More Images</label>
                <div class="grid gap-2 grid-cols-2">
                  <template v-if="true">
                    <div class="relative bg-white border border-gray-200 rounded-lg shadow h-[18rem]" v-for="(image, index) in more_images" :key="image">
                      <div class="h-full w-full">
                        <img class="h-full w-full cursor-zoom-in border rounded-md object-fill"
                             v-if="image"
                             :src="$store.state.storageUrl + image"
                             @click="imageModal($store.state.storageUrl + image)"
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
      loading: false,
      dataLoading: false,
      showModal: false,
      imgModal: '',
      editId: '1',
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
      //basic-text-fields
      name: '',
      sku: '',
      slug: '',
      //dropdown-list-ids
      category_id: '',
      sub_category_id: '',
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
      offer_price: '',
      mrp: '',
      //image
      main_image: "products/August2023/aWihGA0zmgQYhSj0zVN0.jpg",
      more_images: [
        'products/August2023/Kbr8Rm11cqfhMOdWHgwE.jpg',
        'products/August2023/9FLqytOXvCMv2KkDGNm9.jpg',
        'products/August2023/fXhXTu7VGm9LI8blJdS0.jpg',
        'products/August2023/aWihGA0zmgQYhSj0zVN0.jpg',
      ],
      //textarea-fields
      description: "",
      features: "<p>Describe your product's features here...</p>",
      product_tags: "",
      admin_comments: "",
      //status
      flash_sale: false,
      admin_status: 'Accepted',
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

    }
  },
  created() {

  },
}
</script>