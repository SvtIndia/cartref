window.Vue = require('vue');
global.jQuery = require('jquery');
import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './Router/index'
import store from './Store/index'
import mixin from './plugins/mixin';
import './plugins/directives.js';

Vue.use(VueRouter);
var $ = global.jQuery;
window.$ = $;

//components
Vue.component('side-bar', require('./components/SideBar.vue').default);
Vue.component('navbar', require('./components/NavBar.vue').default);
Vue.component('Skeleton', require('./components/Skeleton.vue').default);
Vue.component('Spinner', require('./components/Spinner.vue').default);
Vue.component('Wait', require('./components/Wait.vue').default);
Vue.component('Pagination', require('./components/Pagination.vue').default);
Vue.component('ImageModal', require('./components/ImageModal.vue').default);
Vue.component('RichTextEditor', require('./components/RichTextEditor.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store
});
