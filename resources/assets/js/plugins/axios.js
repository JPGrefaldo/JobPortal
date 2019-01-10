import axios from 'axios'
import Cookies from 'js-cookie'
import store from './../store'

axios.interceptors.request.use(request => {
    if (! /^\/?api/.test(request.url)) {
        return
    }

    console.log('this is an api request')
});
