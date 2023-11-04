window.Vue = require('vue');

import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import router from './router.js'
// import store from './store.js'


// Vue.use(Vuex);
Vue.use(VueRouter);

Vue.component('side-bar', require('./components/SideBar.vue').default);
Vue.component('navbar', require('./components/NavBar.vue').default);

const app = new Vue({
    el: '#app',
    router,
    // store
});
