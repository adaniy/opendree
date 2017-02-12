/**
 * JavaScript controller of the whole application
 * Also asynchronous routes using VueRouter
 */
import Vue from 'vue/dist/vue.min.js';
import VueRouter from 'vue-router/dist/vue-router.min.js';
import VTooltip from 'v-tooltip';
import Moment from 'moment';

Vue.use(VueRouter);

/** OpenDREE's modules */
import reunion from './components/reunion.vue';

const routes = [
    /** Index */
    { path: '/reunion', component: reunion },
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    data: {

    },
    components: {

    },
    router
}).$mount('#opendree');
