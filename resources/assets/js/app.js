
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
//
// const app = new Vue({
//     el: '#app'
// });

function reverse_val(element, value) {
    if ($(element).attr('name') == "trash") {
        $(element).attr('name', "type[]");
        return true;
    }

    $(element).attr('name', "trash");
    return false;
}

function reverse_want_to_class(element, selected) {
    if (selected) {
        $(element).removeClass("want-to__default");
        $(element).addClass("want-to__selected");
    } else {
        $(element).removeClass("want-to__selected");
        $(element).addClass("want-to__default");
    }
}

(function(l){var i,s={touchend:function(){}};for(i in s)l.addEventListener(i,s)})(document);

$(function() {
    if ($("#select-want-project").length) {
        $("#select-want-project").click(function (event) {
            event.preventDefault();
            if (reverse_val("#type-project", $(this).attr('rel'))) {
                reverse_want_to_class($(this), true)
            } else {
                reverse_want_to_class($(this), false)
            }
        });
    }
    if ($("#select-want-work").length) {
        $("#select-want-work").click(function (event) {
            event.preventDefault();
            if (reverse_val("#type-work", $(this).attr('rel'))) {
                reverse_want_to_class($(this), true)
            } else {
                reverse_want_to_class($(this), false)
            }
        });
    }

    $('.tooltip').tooltip();
});
