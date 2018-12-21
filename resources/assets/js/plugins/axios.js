import axios from 'axios'
import Cookies from 'js-cookie'
import store from './../store'

/*axios.interceptors.request.use(request => {
    const token = store.getters['auth/token']

    console.log(console.log(request.headers))

    /!*if (token) {
        request.headers.common['Content-Type'] = 'application/json'
        request.headers.common['Authorization'] = `Bearer ${token}`
    }*!/

    return request
})*/
