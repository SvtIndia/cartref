import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';
Vue.use(Vuex);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = window.location.origin + "/api";
window.axios = axios;

//init store
const store = new Vuex.Store({
    state: {
        url: window.location.origin,
        baseUrl: window.location.origin + "/api",
        assetUrl: 'https://cartrefs.com',
        storageUrl: 'https://cartrefs.com/storage/',
        user: {
            authenticated: true,
        }
    },
    mutations: {},
    actions: {},
})
export default store;
