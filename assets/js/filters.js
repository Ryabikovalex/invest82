document.addEventListener('DOMContentLoaded', function () {
    const { origin } = window.location;
    let $ = function (selector, element = document)
    {
        return element.querySelector(selector);
    };
    let $$ = function (selector, element = document)
    {
        return element.querySelectorAll(selector);
    };

    let btn = $('#filter-submit');
    btn.onclick = updateUrl;
    let rmPlace = $('#remove-place');
    let contPlace = $('#place-container');
    let rmCat = $('#remove-cat');
    let contCat = $('#cat-container');

    rmCat.onclick = function ()
    {
        let items =  $$('input', contCat);
        [].forEach.call( items, function (item){
            item.checked = false;
        });
        updateUrl();
    };
    rmPlace.onclick = function ()
    {
        let items =  $$('input', contPlace);
        [].forEach.call( items, function (item){
            item.checked = false;
        });
        updateUrl();
    };

    function updateUrl ()
    {
        let URL = origin+'/shop/list';
        let cat = [], subcat = [], region = [], city = [];
        [].map.call( $$('input', contCat), function(item){
            if ( item.checked)
            {
                if (item.name === 'cat')
                {
                    cat.push(item.value);
                } else if (item.name === 'subcat')
                {
                    subcat.push(item.value);
                }
            }
        });
        [].map.call( $$('input', contPlace), function(item){
            if ( item.checked)
            {
                if (item.name === 'region')
                {
                    region.push(item.value);
                } else if (item.name === 'city')
                {
                    city.push(item.value);
                }
            }
        });

        if (cat.length > 0)
        {
            URL += '/cat/' + cat.join('/');
        }
        if (subcat.length > 0)
        {
            URL += '/subcat/' + subcat.join('/');
        }
        if (region.length > 0)
        {
            URL += '/region/' + region.join('/');
        }
        if (city.length > 0)
        {
            URL += '/city/' + city.join('/');
        }
        window.location = URL;
    }

});