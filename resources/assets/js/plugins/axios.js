import axios from 'axios'
import JsonpAdapter from './../lib/axios/JsonpAdapter'

window.jsonpCallback = (params) => {
    ocnsole.log(params)
}

axios.interceptors.request.use(request => {
    if (! /^\/?api/.test(request.url)) {
        return
    }

    let url = request.url
    let method = request.method
    let adapter = new JsonpAdapter({
        method,
        url,
        callbackParamName: 'jsonpCallback'
    })

    Object.assign(request, {
        adapter
    });
    /*Object.assign(request, {
        method: 'options',
        adapter,
        headers: {
            common: {
                'X-Requested-With': 'XMLHttpRequest',
                'Access-Control-Allow-Origin': 'http://champ-crewcalls.test',
                'Access-Control-Request-Method': method.toUpperCase(),
             /!*   'Content-Type': 'application/json'*!/
            }
        }
    })*/

    return request
});
