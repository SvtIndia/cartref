window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './Router/index'
import store from './Store/index'
import mixin from './plugins/mixin';

Vue.use(VueRouter);

//components
Vue.component('side-bar', require('./components/SideBar.vue').default);
Vue.component('navbar', require('./components/NavBar.vue').default);
Vue.component('Pagination', require('./components/Pagination.vue').default);
Vue.component('ImageModal', require('./components/ImageModal.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store
});
