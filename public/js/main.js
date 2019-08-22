var style = document.querySelector('#style');

fetch('/artiste/{id}/sameStyle')
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        var p = document.createElement('<p>')
        style.appendChild(p);

    })