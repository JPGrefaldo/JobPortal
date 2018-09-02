
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

function reverse_val(element) {
    if ($(element).attr('name') == "trash") {
        $(element).attr('name', "type[]");
        return true;
    }

    $(element).attr('name', "trash");
    return false;
}

function reverse_want_to_class(element) {
    if ($(element).hasClass("want-to__default")) {
        $(element).removeClass("want-to__default");
        $(element).addClass("want-to__selected");
    } else {
        $(element).removeClass("want-to__selected");
        $(element).addClass("want-to__default");
    }
}



$(function() {
    if ($("#select-want-project").length) {
        $("#select-want-project").click(function (event) {
            reverse_want_to_class($(this));
            reverse_val("#type-project");
        });
    }
    if ($("#select-want-work").length) {
        $("#select-want-work").click(function (event) {
            reverse_want_to_class($(this));
            reverse_val("#type-work");
        });
    }

    $('.tooltip').tooltipster({
        trigger: 'click',
        theme: 'tooltipster-borderless'
    });

    if ($(".js-switch").length) {
        $(".js-switch").click(function (event) {
            if ($(this).hasClass("switch-on")) {
                $(this).removeClass("switch-on");
                $(this).addClass("switch-off");
                $('[name="' + $(this).attr('id') + '"]').val(0);

            } else {
                $(this).removeClass("switch-off");
                $(this).addClass("switch-on");
                $('[name="' + $(this).attr('id') + '"]').val(1);
            }
        });
    }

    $(".url-menu").each(function() {
        $(this).click(function () {
            window.location = $(this).attr("href");
        });
    });

});


