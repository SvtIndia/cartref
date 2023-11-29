<template>
  <div class="my-4 px-2 flex justify-end">
    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
      <!-- Previous btn  -->
      <button class="prev-btn" type="button" :disabled="isPrevDisabled" @click="fetchNewData(pagination.prev_page_url)">
        <i class="fi fi-ss-angle-small-left text-xl text-center h-6 w-6"></i>
      </button>

      <!-- Links 1,2,3  -->
      <template v-if="pagination.links">
        <template v-for="(link,index) in pagination.links">
          <button class="active-link" aria-current="page" v-if="link.active">
            {{ link.label || '0' }}
          </button>
          <button class="default-link" @click="link.url ? fetchNewData(link.url) : false" v-else>
            {{ link.label || '0' }}
          </button>
        </template>
      </template>

      <!-- Next btn  -->
      <button type="button" :disabled="isNextDisabled" @click="fetchNewData(pagination.next_page_url)" class="next-btn">
        <i class="fi fi-ss-angle-small-right text-xl text-center h-6 w-6"></i>
      </button>
    </nav>
  </div>
</template>
<script>
export default {
  name: "Pagination",
  props: {
    pagination: Object,
    fetchNewData: Function,
  },
  computed: {
    isPrevDisabled: function () {
      return !this.pagination.prev_page_url;
    },
    isNextDisabled: function () {
      return !this.pagination.next_page_url;
    },
  },
}
</script>
