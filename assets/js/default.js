const $ = function (selector)
{
    return document.querySelector(selector);
};
const $$ = function (selector, element)
{
    return element.querySelector(selector);
};
function getSubParams( container, folder, val) {
    let req = new XMLHttpRequest();
    req.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            obj = JSON.parse(this.responseText);
            if ( obj instanceof Array && obj.length > 0 )
            {
                container.innerHTML = '';
                for ( let i=0; i < obj.length; i++)
                {
                    let el = document.createElement('option');
                    el.value = obj[i].id;
                    el.innerHTML = obj[i].name;
                    container.appendChild(el    );
                }
            }
        }
    };
    console.log('invest82.loc/assets/json/all/'+folder+'/'+val+'.json');
    req.open("GET", '/assets/json/all/'+folder+'/'+val+'.json', true);
    req.send();
}