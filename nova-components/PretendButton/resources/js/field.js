Nova.booting((Vue, router) => {
    Vue.component('index-pretend-button', require('./components/IndexField'));
    Vue.component('detail-pretend-button', require('./components/DetailField'));
    Vue.component('form-pretend-button', require('./components/FormField'));
})
