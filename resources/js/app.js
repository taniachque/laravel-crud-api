import Vue from 'vue';
import axios from 'axios';
import { BootstrapVue } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.prototype.$http = axios;

const app = new Vue({
    el: '#app',
});
