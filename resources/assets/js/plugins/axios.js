import axios from 'axios'
import jsonpAdapter from 'axios-jsonp';

axios.interceptors.request.use(request => {
    if (! /^\/?api/.test(request.url)) {
        return
    }

    let method = request.method

    Object.assign(request, {
        method: 'options',
        adapter: jsonpAdapter,
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
