
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
//or window.Vue = Vue;

import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import router from './routes'

//import axios from 'axios'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(VueResource)

Vue.config.productionTip = false;

Vue.component('employee', require('./components/Employee.vue'));
Vue.component('employeetask', require('./components/EmployeeTask.vue'));
Vue.component('employeetaskadd', require('./components/EmployeeTaskAdd.vue'));
Vue.component('employeetaskedit', require('./components/EmployeeTaskEdit.vue'));
Vue.component('employeeaccount', require('./components/EmployeeAccount.vue'));
Vue.component('etoolbar', require('./components/subcomponents/EToolbar.vue'));
Vue.component('atoolbar', require('./components/subcomponents/AToolbar.vue'));
Vue.component('users', require('./components/AdminUsers.vue'));
Vue.component('schedule', require('./components/AdminSchedule.vue'));


Vue.component('stor', require('./components/AdminStor.vue'));


Vue.filter('lowercase', function (value) {
	return value.toLowerCase()
})

const app = new Vue({
    el: '#app',
    router,
   // template: '<router-view></router-view>'
});