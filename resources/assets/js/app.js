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

if (window.IS_AUTHORIZED) {
    (async function (store) {
        await store.dispatch('auth/fetchUser')
    })(store)
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('signup-type', require('./components/SignupTypeComponent').default);
Vue.component('bubble-slidder', require('./components/BubbleSiliderComponent').default);
Vue.component('mobile-menu', require('./components/MobileMenuComponent').default);
Vue.component('create-crew-position-form', require('./components/CreateCrewPositionFormComponent').default);
Vue.component('edit-crew-position-form', require('./components/EditCrewPositionFormComponent').default);
Vue.component('create-endorsement-request-form', require('./components/CreateEndorsementRequestFormComponent').default);
Vue.component('endorsers-component', require('./components/EndorsementControlComponent').default);
Vue.component('cca-messages-dashboard', require('./components/messenger/index').default);
Vue.component('cca-logout-link', require('./components/LogoutLink').default);
<<<<<<< HEAD
Vue.component('cca-work-position-component', require('./components/WorkPositionComponent'));
Vue.component('cca-position-component', require('./components/PositionComponent'));
Vue.component('cca-department-component', require('./components/DepartmentsComponent'));
=======
>>>>>>> master
Vue.component('cca-work-position-component', require('./components/WorkPositionComponent').default);
Vue.component('cca-position-component', require('./components/PositionComponent').default);
Vue.component('cca-department-component', require('./components/DepartmentsComponent').default);

new Vue({
    el: '#nav-container',
    store
})

const content = new Vue({
    el: '#content',
    store
});
