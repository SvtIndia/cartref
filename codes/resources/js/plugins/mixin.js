import Vue from 'vue';
import formatDate from "./formatDate";
import toast from "./toast";
import strFunctions from "./strFunctions";
import imageLoad from "./imageLoad";

Vue.mixin({
    methods: {
        ...formatDate,
        ...toast,
        ...strFunctions,
        ...imageLoad,
    }
});