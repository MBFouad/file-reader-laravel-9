file = {
    formSubmit: function () {
        var form = document.getElementById('file-reader-form');
        var responseDivId = 'reader-div';

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            if (!form.checkValidity()) {
                event.stopPropagation();
            } else {
                const parameters = new FormData(form)
                // const url = new URL(form.action);
                const url = file.generateFormURL(form.action, form.method, parameters);
                const requestParameters = file.generateFormParameters(form.method, parameters);
                const response = fetch(url, requestParameters)
                    .then(response => {//Response from server
                        return response.json();
                    })
                    .then(data => {
                        if (data.error == true) {
                            file.showError(responseDivId, data.message)
                        } else {
                            document.getElementById(responseDivId).innerHTML = data.html;
                        }
                    }).catch(err => {
                        file.showError(responseDivId, err)
                    })


            }
            return false;
        });
    },

    generateFormParameters: function (method, parameters) {
        const formParameters = {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        if (method == 'post' || method == 'put') {
            formParameters.body = JSON.stringify(parameters)
        }

        return formParameters;
    },

    generateFormURL: function (action, method, parameters) {
        if (method == 'get') {
            const url = new URL(action)
            url.search = new URLSearchParams(parameters).toString();
            return url;
        }
        return action;
    },

    showError: function (parentDiv, message) {
        const errorDiv = document.createElement("div");
        const newContent = document.createTextNode(message);
        errorDiv.appendChild(newContent);
        errorDiv.className = "alert alert-danger";
        errorDiv.setAttribute('role', 'alert');
        const currentDiv = document.getElementById(parentDiv);
        currentDiv.innerHTML = errorDiv.outerHTML;
    },
    ajaxPaginationLinks: function () {
        var responseDivId = 'reader-div'
        var readerDiv = document.getElementById(responseDivId);
        readerDiv.onclick = function (event) {
            let target = event.target;
            if (target.tagName == 'A' && target.classList.contains('ajax-pagination-link')) {
                event.preventDefault();
                const url = target.getAttribute("href");
                const requestParameters = file.generateFormParameters('get', {});
                const response = fetch(url, requestParameters)
                    .then(response => {//Response from server
                        return response.json();
                    })
                    .then(data => {
                        if (data.error == true) {
                            file.showError(responseDivId, data.message)
                        } else {
                            document.getElementById(responseDivId).innerHTML = data.html;
                        }
                    }).catch(err => {
                        file.showError(responseDivId, err)
                    })
                return false
            }
        };
    },

    init: function () {
        file.formSubmit();
        file.ajaxPaginationLinks();
    }
}
file.init();