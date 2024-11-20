
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// Vue.directive('model-inject', {
//     bind: function(el, binding, vnode) {
//         el.value = vnode.context[binding.expression];

//         // Create inject event and add it to Vue instance (available by this.injectEvent)
//         vnode.context.injectEvent = new CustomEvent("inject");
//         // Attach custom event to el
//         el.addEventListener('inject', function() {
//             vnode.context[binding.expression] = el.value;
//         });

//         // Also bind input
//         el.addEventListener('input', function() {
//             vnode.context[binding.expression] = el.value;
//         });
//     },
//     update: function(el, binding, vnode) {
//         el.value = vnode.context[binding.expression];
//     }
// });
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.mixin(require('./trans'));
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const moduleVueFiles = require.context('../../modules', true, /\.vue$/i);
moduleVueFiles.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], moduleVueFiles(key).default));

const app = new Vue({
    el: '#app'
});
