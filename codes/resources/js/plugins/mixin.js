import Vue from 'vue';
import formatDate from "./formatDate";
import toast from "./toast";

Vue.mixin({
    methods: {
        ...formatDate,
        ...toast
    }
});