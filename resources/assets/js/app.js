
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Added
 */

//https://akryum.github.io/v-tooltip/#/
Vue.component('tooltip', require('v-tooltip'));

//https://github.com/avil13/vue-sweetalert2
//https://sweetalert2.github.io
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('signup-type', require('./components/SignupTypeComponent'));
Vue.component('bubble-slidder', require('./components/BubbleSiliderComponent'));
Vue.component('mobile-menu', require('./components/MobileMenuComponent'));
Vue.component('create-crew-position-form', require('./components/CreateCrewPositionFormComponent'));
Vue.component('edit-crew-position-form', require('./components/EditCrewPositionFormComponent'));
Vue.component('create-endorsement-request-form', require('./components/CreateEndorsementRequestFormComponent'));
Vue.component('endorsers-component', require('./components/EndorsementControlComponent'));

const content = new Vue({
    el: '#content',
});


