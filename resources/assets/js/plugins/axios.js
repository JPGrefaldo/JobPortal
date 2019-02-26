import axios from 'axios'

axios.interceptors.request.use(request => {
    if (!/^\/?api/.test(request.url)) {
        return request
    }

    Object.assign(request, {
        headers: {
            common: {
                'Authorization': `Bearer ${window.API_TOKEN}`,
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        }
    })

    return request
});
