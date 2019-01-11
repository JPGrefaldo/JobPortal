import axios from 'axios'
import jsonpAdapter from 'axios-jsonp';

axios.interceptors.request.use(request => {
    if (! /^\/?api/.test(request.url)) {
        return
    }

    let method = request.method
    let adapter = new jsonpAdapter({
        params: {
            method: 'options',
            headers: {
                common: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Access-Control-Allow-Origin': 'http://champ-crewcalls.test',
                    'Access-Control-Request-Method': method.toUpperCase(),
                    'Content-Type': 'application/json'
                }
            }
        }
    })


    Object.assign(request, {
        adapter,
    })

    console.log(request)

    return request
});
