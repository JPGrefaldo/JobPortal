import axios from 'axios'

axios.interceptors.request.use(request => {
    if (!/^\/?api/.test(request.url)) {
        return
    }

    let method = request.method
    let adapter = new JsonpAdapter({
        method,
        url,
        callbackParamName: 'jsonpCallback'
    })

    Object.assign(request, {
        adapter
    });
    Object.assign(request, {
        method: 'options',
        adapter,
        headers: {
            common: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Request-Method': method.toUpperCase(),
                'Content-Type': 'application/json',
            }
        }
    })

    return request
});
