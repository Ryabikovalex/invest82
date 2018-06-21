document.addEventListener('DOMContentLoaded', function() {
    let citySelect = document.querySelector('select#city');

    $('select#region').onchange = function (e) {
        let val = e.target.selectedOptions[0].getAttribute('data-payload');
        let obj = [];
        getSubParams( citySelect, e.target.name, val);
    };

}, false);