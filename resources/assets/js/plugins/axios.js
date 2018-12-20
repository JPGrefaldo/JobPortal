import axios from 'axios'
import store from './../store'

axios.interceptors.request.use(request => {
    const token = store.getters['auth/token']

    if (token) {
        request.headers.common['Authorization'] = `Bearer ${token}`
    }

    return request
})
