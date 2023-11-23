import Vue from 'vue';
import formatDate from "./formatDate";

Vue.mixin({
    methods: {
        ...formatDate
    }
});