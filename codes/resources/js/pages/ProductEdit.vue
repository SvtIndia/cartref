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
            <div class="md:flex mb-3">
              <div class="mb-5 w-full mx-2 my-1">
                <label for="title" class="block mb-2 text-sm font-bold text-gray-900">Product Title <span class="text-red-600">*</span></label>
                <input type="text" v-model="name" id="title" class="form-input" placeholder="Western Wear" required>
              </div>
            </div>
            <div class="md:flex mb-3">
              <div class="mb-5 md:w-1/2 w-full mx-2 my-1">
                <label for="code" class="block mb-2 text-sm font-bold text-gray-900">Product Code (ERP) / SKU <span class="text-red-600">*</span></label>
                <input type="text" v-model="sku" id="code" class="form-input" placeholder="12X-987XX" required>
              </div>
              <div class="mb-5 md:w-1/2 w-full mx-2 my-1">
                <label for="slug" class="block mb-2 text-sm font-bold text-gray-900"
                       title="The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.">
                  URL / Slug <span class="text-red-600">*</span></label>
                <input type="text" v-model="slug" id="slug" class="form-input" placeholder="western-wear" required>
              </div>
            </div>
            <div class="md:flex mb-3">
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="category_id" class="block mb-2 text-sm font-bold text-gray-900" title="Those immediately above the category in the hierarchy">Category</label>
                <select v-model="category_id" id="category_id" class="form-input" required>
                  <option value="" selected>Select Category</option>
                  <option v-for="(category, index) in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
              </div>
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="sub_category_id" class="block mb-2 text-sm font-bold text-gray-900" title="Those immediately below the main category in the hierarchy">Sub Category
                  <span class="text-red-600">*</span>
                </label>
                <select v-model="sub_category_id" id="sub_category_id" class="form-input" required>
                  <option value="" selected>Select Sub Category</option>
                  <option v-for="(sub_cat, index) in sub_categories" :key="sub_cat.id" :value="sub_cat.id">{{ sub_cat.name }}</option>
                </select>
              </div>
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="brand_id" class="block mb-2 text-sm font-bold text-gray-900">Brand <span class="text-red-600">*</span>
                </label>
                <select v-model="brand_id" id="brand_id" class="form-input" required>
                  <option value="" selected>Choose Brand</option>
                  <option v-for="(brand, index) in brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>
                </select>
              </div>
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="seller_id" class="block mb-2 text-sm font-bold text-gray-900">Seller Name <span class="text-red-600">*</span>
                </label>
                <select v-model="seller_id" id="seller_id" class="form-input" required>
                  <option value="" selected>Choose Seller</option>
                  <option v-for="(seller, index) in sellers" :key="seller.id" :value="seller.id">{{ seller.name }}</option>
                </select>
              </div>
            </div>
            <div class="md:flex mb-3">
              <div class="mb-5 md:w-1/2 w-full mx-2 my-1">
                <label for="description" class="block mb-2 text-sm font-bold text-gray-900">Description <span class="text-red-600">*</span></label>
                <textarea v-model="description" id="description" class="form-input" placeholder="Describe your product here..."></textarea>
              </div>
              <div class="mb-5 md:w-1/2 w-full mx-2 my-1">
                <label for="features" class="block mb-2 text-sm font-bold text-gray-900">Features <span class="text-red-600">*</span></label>
                <textarea v-model="features" id="features" class="form-input" placeholder="Describe your product's features here..."></textarea>
              </div>
            </div>
            <div class="md:flex mb-3">
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="gender_id" class="block mb-2 text-sm font-bold text-gray-900">Gender  <span class="text-red-600">*</span></label>
                <select v-model="gender_id" id="gender_id" class="form-input" required>
                  <option value="" selected>Select Gender</option>
                  <option v-for="(gender, index) in genders" :key="gender.id" :value="gender.id">{{ gender.name }}</option>
                </select>
              </div>
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="style_id" class="block mb-2 text-sm font-bold text-gray-900" title="Those immediately below the main category in the hierarchy">Style
                  <span class="text-red-600">*</span>
                </label>
                <select v-model="style_id" id="style_id" class="form-input" required>
                  <option value="" selected>Select Style</option>
                  <option v-for="(style, index) in styles" :key="style.id" :value="style.id">{{ style.name }}</option>
                </select>
              </div>
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="sizes" class="block mb-2 text-sm font-bold text-gray-900">
                  Available Sizes <span class="text-red-600">*</span>
                </label>
<!--                <select v-model="brand_id" id="brand_id" class="form-input" required>-->
<!--                  <option value="" selected>Choose Brand</option>-->
<!--                  <option v-for="(brand, index) in brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>-->
<!--                </select>-->
              </div>
              <div class="mb-5 md:w-1/4 w-full mx-2 my-1">
                <label for="seller_id" class="block mb-2 text-sm font-bold text-gray-900">
                  Available Colors <span class="text-red-600">*</span>
                </label>
<!--                <select v-model="seller_id" id="seller_id" class="form-input" required>-->
<!--                  <option value="" selected>Choose Seller</option>-->
<!--                  <option v-for="(seller, index) in sellers" :key="seller.id" :value="seller.id">{{ seller.name }}</option>-->
<!--                </select>-->
              </div>
            </div>
            <div class="md:flex mb-3">
              <div class="mb-5 md:w-1/5 w-full mx-2 my-1">
                <label for="length" class="block mb-2 text-sm font-bold text-gray-900" title="The length of the item in cms. Must be more than 0.5">
                  Length (cms) <span class="text-red-600">*</span>
                </label>
                <input type="text" v-model="length" id="length" class="form-input" placeholder="20" required>
              </div>
              <div class="mb-5 md:w-1/5 w-full mx-2 my-1">
                <label for="breadth" class="block mb-2 text-sm font-bold text-gray-900" title="The breadth of the item in cms. Must be more than 0.5">
                  Breadth (cms) <span class="text-red-600">*</span>
                </label>
                <input type="text" v-model="breadth" id="breadth" class="form-input" placeholder="20" required>
              </div>
              <div class="mb-5 md:w-1/5 w-full mx-2 my-1">
                <label for="height" class="block mb-2 text-sm font-bold text-gray-900" title="The height of the item in cms. Must be more than 0.5">
                  Height (cms) <span class="text-red-600">*</span>
                </label>
                <input type="text" v-model="height" id="height" class="form-input" placeholder="20" required>
              </div>
              <div class="mb-5 md:w-1/5 w-full mx-2 my-1">
                <label for="weight" class="block mb-2 text-sm font-bold text-gray-900" title="The weight of the item in cms. Must be more than 0.5">
                  Weight (cms) <span class="text-red-600">*</span>
                </label>
                <input type="text" v-model="weight" id="weight" class="form-input" placeholder="20" required>
              </div>
              <div class="mb-5 md:w-1/5 w-full mx-2 my-1">
                <label for="size_guide" class="block mb-2 text-sm font-bold text-gray-900">Size Guide </label>
                <input type="file" id="size_guide" class="form-input" accept="image/*">
              </div>
            </div>
            <div class="md:flex mb-3">
              <div class="mb-5 md:w-1/2 w-full mx-2 my-1">
                <label for="offer_price" class="block mb-2 text-sm font-bold text-gray-900">Selling Price <span class="text-red-600">*</span></label>
                <input type="number" step="0.01" v-model="offer_price" id="offer_price" class="form-input" placeholder="1499" required>
              </div>
              <div class="mb-5 md:w-1/2 w-full mx-2 my-1">
                <label for="mrp" class="block mb-2 text-sm font-bold text-gray-900">Maximum Retail Price (MRP) <span class="text-red-600">*</span></label>
                <input type="number" step="0.01" v-model="mrp" id="mrp" class="form-input" placeholder="1999" required>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="submit-btn"> {{ this.editId ? 'Update' : 'Create' }} </button>
              <button type="button" @click="clear()" class="submit-btn bg-gray-600 hover:bg-gray-700">Clear</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name:"ProductEdit",
  data() {
    return {
      loading: false,
      dataLoading: false,
      editId: '',
      //dropdown-lists
      categories: [],
      sub_categories: [],
      brands: [],
      sellers: [],
      genders: [],
      styles: [],
      //basic-text-fields
      name: '',
      sku: '',
      slug: '',
      //dropdown-list-ids
      category_id: '',
      sub_category_id: '',
      brand_id: '',
      seller_id: '',
      gender_id:'',
      style_id:'',
      //dimensions
      length:'',
      breadth:'',
      height:'',
      weight:'',
      //price fields
      offer_price:'',
      mrp:'',
      //textarea-fields
      description: '',
      features:'',
    }
  },
  methods: {
    name() {

    },
    clear(){

    }
  },
  created() {

  },
}
</script>