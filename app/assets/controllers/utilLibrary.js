let requestPromise = function(url, method, parameters) {
    return new Promise((resolve, reject) => {
        fetch(url, {
            method: method,
            body: JSON.stringify(parameters),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            resolve(response.json());
        }).catch(error => {
            reject(error);
        })

    })
}

let addClickEvent = function(element, callback, ...params) {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        callback.apply(this, params);
    })
}

let addChangeEvent = function(element, callback, ...params) {
    element.addEventListener('change', (event) => {
        event.preventDefault();
        callback.apply(this, params);
    })
}

let getDaysDifference = function(initDate, endDate) {
    return (new Date(endDate) - new Date(initDate))/(1000*60*60*24);
}

export {requestPromise, addClickEvent, addChangeEvent, getDaysDifference}