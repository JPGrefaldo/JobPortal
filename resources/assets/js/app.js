
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import store from './store'
import './plugins'

//https://akryum.github.io/v-tooltip/#/
// @todo transfer in ./plugins/index.js
Vue.component('tooltip', require('v-tooltip'));

//https://github.com/avil13/vue-sweetalert2
//https://sweetalert2.github.io
// @todo transfer in ./plugins/index.js
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

if (window.JWT_TOKEN) {
    store.dispatch('auth/saveToken', {
        token: window.JWT_TOKEN,
        remember: true
    })
}

if (! store.getters['auth/check'] && store.getters['auth/token']) {
    (async function (store) {
        await store.dispatch('auth/fetchUser')
    })(store)
}

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
Vue.component('messages-dashboard', require('./components/MessagesDashboardComponent'));
Vue.component('projects', require('./components/ProjectsComponent'));
Vue.component('app-logout-link', require('./components/AppLogoutLink'));

new Vue({
    el: '#nav-container',
    store
})

const content = new Vue({
    el: '#content',
    store
});


