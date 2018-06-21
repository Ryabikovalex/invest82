document.addEventListener('DOMContentLoaded', function() {
    let subcatSelect = document.querySelector('select#subcat');

    $('select#cat').onchange = function (e) {
        let val = e.target.selectedOptions[0].getAttribute('data-payload');
        let obj = [];
        getSubParams( subcatSelect, e.target.name, val);
    };

}, false);