<div>
    Отсортировать по цене: <a href="<?=Route::$url?>/?sort_by=cost&sort=1">Дороже</a> - <a href="<?=Route::$url?>/?sort_by=cost&sort=-1">Дешевле ↑</a>
</div>
<div>
    `id`, `name`, `added`, `cost`, `category_id`, `city_id`,  `status`, `images`, `is_conf`, `CY`.`cityName`, `CY`.`cityTranslit`, `CY`.`cityE`, `R`.`regTranslit`, `R`.`regE`, `SC`.`scTranslit`, `SC`.`scE`, `CT`.`ctE`, `CT`.`ctTranslit`
<?php if ( !is_array($items) or count($items) == 0){?>
    <p>Ничего ненайдено</p>
<?php }else{var_dump($items[0]);    foreach ( $items as $k => $param){
    list($id, $name, $added, $cost, ,, $status, $images, $conf,  $cityName, $cityTranslit, , $regTranslit, , $subcatTranslit, , , $catTranslit) = $param;
?>
<div class="list-item" style="display: inline-block;">
    <table border="1">
        <tr>
            <th><?=$cityName?></th>
            <th><a href="/shop/product/<?=$id?>"><?=$name?></a></th>
        </tr>
        <tr>
            <td><?=format_cost($cost)?></td>
            <td><?=format_date($added)?></td>
        </tr>
    </table>
</div>
<?php }}?>
</div>
<div>
<?php if (isset($from)  and $from>0){?>
	<a href="<?=Route::$url?>/?page=<?= $from?>"> ← Назад</a>
    <?php }
if (isset($to) and $to>1){?>
    <a href="<?=Route::$url?>/?page=<?= $to?>">Вперед →</a>
<?php }?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const { pathname } = window.location;
        let form = document.forms.filter;
        let filter_place = document.getElementById('filter-place');

        form.onclick =function (e) {
            let target = e.target;
            let span = target.closest('label > span[data-load]');
            if (!span) return;
            if (!form.contains(span)) return;
            let radio = span.parentNode.childNodes[0];

            let div = document.querySelector(`div[data-parent="${radio.value}"]`);
            filter_place.innerHTML = '';
            filter_place.innerHTML = div.innerHTML;
        };

        let filter_sbmt = document.getElementById('filter_sbmt');
        filter_sbmt.onclick = function (e) {
            e.preventDefault();

            let pl_ch_r = [].filter.call(form.querySelectorAll('input[name="region"]') , function (c) {
                if (c.checked)
                    return c;
            })[0];
            let pl_url = '';
            if (typeof pl_ch_r !== "undefined")
            {
                let doc = form.querySelectorAll('input[type="checkbox"][name="city"]');

                let checked = [].filter.call(doc, function (child) { if (child.checked) return child; } );
                if (checked.length > 0)
                {
                    pl_url='/city';
                    checked.forEach(function (c) {
                        pl_url += '/' + c.value;
                    });
                }else
                {
                    pl_url='/region/'+pl_ch_r.value;
                }
            }

            let cat_ch_r = [].filter.call(form.querySelectorAll('input[name="cat"]') , function (c) {
                if (c.checked)
                    return c;
            })[0];
            let cat_url;
            if (typeof cat_ch_r !== "undefined")
            {
                let doc = form.querySelectorAll('input[type="checkbox"][name="scat"][data-parent="'+cat_ch_r.getAttribute('data-id')+'"]');

                let checked = [].filter.call(doc, function (child) { if (child.checked) return child; } );
                if (checked.length > 0)
                {
                    cat_url='/subcat';
                    checked.forEach(function (c) {
                        cat_url += '/' + c.value;
                    });
                }else
                {
                    cat_url='/cat/'+cat_ch_r.value;
                }
            }
            form.action = pathname+pl_url+cat_url;
            form.submit();
        };
    });
</script>