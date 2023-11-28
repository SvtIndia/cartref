<template>
  <div class="fixed inset-0 w-full h-screen flex items-center justify-center bg-white opacity-75 z-2" v-if="show">
    <div class="text-3xl block mx-auto w-12 h-12">
      <Spinner/>
    </div>
  </div>
</template>
<script>
export default {
  name: "Wait",
  props: {
    show: Boolean,
  },
  watch: {
    show: function () {
      if (this.show) {
        $('body').addClass('overflow-hidden');
      } else {
        $('body').removeClass('overflow-hidden');
      }
    }
  }
}
</script>