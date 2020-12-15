require('./bootstrap');

window.Vue = require('vue');

//register form
import Form from './core/Form';
window.axios = axios;
window.Form = Form;

import Vue from 'vue'
//import vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
    //Routes
import { routes } from './router';
//Register Routes
const router = new VueRouter({
    routes,
})
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
    Form
});