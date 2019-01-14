import axios from 'axios'
import jsonpAdapter from 'axios-jsonp';

window.jsonpCallback = (params) => {}

axios.interceptors.request.use(request => {
    if (! /^\/?api/.test(request.url)) {
        return
    }

    let url = request.url
    let method = request.method
    let adapter = new jsonpAdapter({
        method,
        url,
        callbackParamName: 'jsonpCallback'
    })




    Object.assign(request, {
        method: 'options',
        adapter,
        headers: {
            common: {
                'X-Requested-With': 'XMLHttpRequest',
                'Access-Control-Allow-Origin': 'http://champ-crewcalls.test',
                'Access-Control-Request-Method': method.toUpperCase(),
                'Content-Type': 'application/json'
            }
        }
    })

    console.log(request)

    return request
});
