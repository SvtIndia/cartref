import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios';
import toast from '../plugins/toast'
Vue.use(Vuex);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = window.location.origin + "/api";

// errorComposer will compose a handleGlobally function
const errorComposer = (err) => {
    return () => {
        let message = err?.response?.data?.message ?? "";
        let errors = err?.response?.data?.errors ?? {};

        if (errors && Object.keys(errors).length > 0) {
            //validation errors
            let errorMsg = `<ul>`
            Object.keys(errors).forEach((key, index) => {
                errorMsg += `<li>${errors[key][0]}</li>`
            })
            errorMsg += `</ul>`
            toast.show_toast('error', errorMsg);
        } else if (message) {
            //normal msg
            toast.show_toast('error', message);
        } else {
            //req. failed msg
            toast.show_toast('error', err.toString())
        }
    }
}
axios.interceptors.response.use(undefined, function (error) {
    error.handleGlobally = errorComposer(error);
    return Promise.reject(error);
})
window.axios = axios;

//init store
const store = new Vuex.Store({
    state: {
        url: window.location.origin,
        baseUrl: window.location.origin + "/api",
        assetUrl: window.location.origin,
        storageUrl: window.location.origin+'/storage/',
        defaultRowCount: '25',
        row_counts: [
            '25',
            '50',
            '100',
            '250',
            'All'
        ],
        user: {
            authenticated: true,
        }
    },
    mutations: {},
    actions: {},
})
export default store;
