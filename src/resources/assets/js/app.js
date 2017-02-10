/**
 * JavaScript controller of the whole application
 * Also asynchronous routes using VueRouter
 */
import Vue from 'vue/dist/vue.min.js';
import VueRouter from 'vue-router/dist/vue-router.min.js';
import Moment from 'moment';
import 'bootstrap/dist/js/bootstrap.min.js';

Vue.use(VueRouter);

const reunion = require('./components/reunion.vue');

const routes = [
    /** Index */
    { path: '/', component: reunion },
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    components: {
	
    },
    router
}).$mount('#opendree');
