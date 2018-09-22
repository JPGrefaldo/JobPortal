
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

//https://akryum.github.io/v-tooltip/#/
Vue.component('tooltip', require('v-tooltip'));

Vue.component('signup-type', require('./components/SignupTypeComponent'));

const content = new Vue({
    el: '#content',
});

//
// $(function() {
//
//     if ($(".js-switch").length) {
//         $(".js-switch").click(function (event) {
//             if ($(this).hasClass("switch-on")) {
//                 $(this).removeClass("switch-on");
//                 $(this).addClass("switch-off");
//                 $('[name="' + $(this).attr('id') + '"]').val(0);
//
//             } else {
//                 $(this).removeClass("switch-off");
//                 $(this).addClass("switch-on");
//                 $('[name="' + $(this).attr('id') + '"]').val(1);
//             }
//         });
//     }
//
//     if ($(".js-switch").length) {
//         $(".js-switch").click(function (event) {
//             if ($(this).hasClass("switch-on")) {
//                 $(this).removeClass("switch-on");
//                 $(this).addClass("switch-off");
//                 $('[name="' + $(this).attr('id') + '"]').val(0);
//
//             } else {
//                 $(this).removeClass("switch-off");
//                 $(this).addClass("switch-on");
//                 $('[name="' + $(this).attr('id') + '"]').val(1);
//             }
//         });
//     }
//     $(".url-menu").each(function() {
//         $(this).click(function () {
//             window.location = $(this).attr("href");
//         });
//     });
//
// });


