require('./bootstrap');

window.Vue = require('vue');

//register form
// import Form from './core/Form';
// window.axios = axios;
// window.Form = Form;

//Import Sweetalert2
import Swal from 'sweetalert2'
window.Swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast


import { Form, HasError, AlertError, AlertSuccess } from 'vform'
//Import v-from
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertSuccess.name, AlertSuccess)


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