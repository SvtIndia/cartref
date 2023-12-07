<template>
    <Transition>
        <div v-if="show"
            class="fixed right-0 left-0 top-0 bottom-0 z-50 items-center justify-center bg-gray-900 bg-opacity-60 px-4 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full">
            <div class="relative flex justify-center h-full items-center">
                <button aria-label="close" title="close" @click="hide()"
                    class="absolute top-0 right-2 text-4xl text-white bg-primary-500 py-2 px-4 rounded-sm">
                    <i class="fi fi-rr-cross-small w-4 h-6 flex items-center justify-center py-4"></i>
                </button>
                <!-- Modal content -->
                <img :src="img" class="border border-gray-500 rounded shadow-lg p-4 bg-white" />
            </div>
        </div>
    </Transition>
</template>
<script>
export default {
    name: "ImageModal",
    props: {
        show: Boolean,
        hide: Function,
        img: String,
    },
    created() {
        //hide the modal on ESC btn press
        document.addEventListener('keyup', (evt) => {
            if (evt.keyCode === 27) {
                this.hide();
            }
        });
    }
}
</script>

<style scoped>
img {
    max-height: calc(100vh - 10vh);
    max-width: 100%;
}
</style>
