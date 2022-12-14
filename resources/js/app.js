/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import Form from 'vform'
import axios from 'axios'
import VueAxios from 'vue-axios'
//import Chart from 'chart.js';

Vue.use(VueRouter)
Vue.use(VueAxios, axios)


window.Form = Form;
Vue.config.silent = true
Vue.prototype.Routes = window.routes;

import  L  from "leaflet";
import 'leaflet/dist/leaflet.css';
Vue.use( L );
import { LMap, LTileLayer, LMarker, LPopup, LTooltip } from 'vue2-leaflet';



Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.component('l-tooltip', LTooltip);
Vue.component('l-popup', LPopup);

import Vue from "vue";
import vSelect from "vue-select";

Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";

Vue.component('pagination', require('laravel-vue-pagination'));
//Vue.component('pagination', require('laravel-vue-pagination'));
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
const Foo = {template:'<p>prueba</p>'}

let routes = [
    { path: '/guser', component: require('./view/Usuarios/ListUser.vue').default },
    { path: '/createuser', component: require('./view/Usuarios/createUser.vue').default },
    { path: '/edituser/:id', component: require('./view/Usuarios/editUser.vue').default },
    { path: '/groles', component: require('./view/Roles/ListRoles.vue').default },
    { path: '/create/groles', component: require('./view/Roles/createRoles.vue').default },
    { path: '/ginterseccion', component: require('./view/Mapa/mapa.vue').default },
    { path: '/deleteRoles/:id', component: require('./view/Roles/editRoles.vue').default },
    { path: '/permisosuser', component: require('./view/Seguridad/Lista.vue').default },
    { path: '/addpermisos/:id', component: require('./view/Seguridad/agregarPermisos.vue').default },
    { path: '/lintersecciones', component: require('./view/Intersecciones/intersecciones.vue').default },
    { path: '/mensajes', component: require('./view/Mensajes/Mensajes.vue').default },
    { path: '*', component: Foo }


  ]

//Vue.component('example-component', require('./view/Usuarios/ListUser.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 const router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
  })
window.router = router;
const app = new Vue({
    el: '#app',
    router,
    

});
