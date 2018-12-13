
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const bootstrapVue = require('bootstrap-vue');
Vue.use(bootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 // Vue.component('example-component', require('./components/ExampleComponent.vue'));

Vue.component('item', require('./components/Item.vue'));
Vue.component('additem', require('./components/AddItem.vue'));
Vue.component('modal-confirm', require('./components/ModalConfirm.vue'));
Vue.component('modal-error', require('./components/ModalError.vue'));
Vue.component('empty', require('./components/Empty.vue'));
Vue.component('products', require('./components/Products.vue'));
Vue.component('category-card', require('./components/CategoryCard.vue'));
Vue.component('product-card', require('./components/ProductCard.vue'));
Vue.component('tag', require('./components/Tag'));


import { slider, slideritem } from 'vue-concise-slider'
Vue.component('slider', slider);
Vue.component('slideritem', slideritem);


import { Datetime } from 'vue-datetime';

Vue.component('datetime', Datetime);
import 'vue-datetime/dist/vue-datetime.css'


// Vue.component('tree-menu', require('./components/TreeMenu.vue'));
//
// const app = new Vue({
//     el: '#app'
// });

// console.log = function() {};
