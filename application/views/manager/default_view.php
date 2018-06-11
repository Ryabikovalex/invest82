<div style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <?php
    //Проверка успешного завершенного действия
    if (isset($success))
    {
        if (is_object($success) == true)
        {
            ?><<div class="alert alert-success alert-dismissible fade show" role="alert">
            Успешно выполнено
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div><?php
        }else{
            ?><div class="alert alert-warning alert-dismissible fade show" role="alert">
                Что-то пошло не так.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><?php
        }
    }
    ?>
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm btn-outline-secondary">Share</button>
            <button class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
    </div>
</div>

<canvas class="my-4chartjs-render-monitor" id="myChart" width="1486" height="627" style="display: block; width: 1486px; height: 627px;"></canvas>

<h2>
    Новые бизнесы на продажу
    <button type="button" class="btn btn-info">
        Всего <span class="badge badge-light"><?=$stat['submit_products_count']?></span>
    </button>
</h2>
<ul class="pagination justify-content-center">
    <?php $dp = (isset($from)and$from>0) ? '' : 'disabled';
    $dn = (isset($to) and $to>1) ? '' : 'disabled'?>
    <li class="page-item <?=$dp?>"><a class="page-link" href="<?=Route::$url?>/?page=<?= $from?>"> ← Назад</a></li>
    <li class="page-item <?=$dn?>"><a class="page-link" href="<?=Route::$url?>/?page=<?= $to?>">Вперед →</a></li>
</ul>


<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th></th>
            <th>Название</th>
            <th>Метка</th>
            <th>Стоимость</th>
            <th>Доход</th>
            <th>Город</th>
            <th>Добавлен</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($table as $k => $arr)
            {
                list( $id, $name, $cost, $earn, $regionName, $cityName, $address, $about, $added, $conf, $customer, $customer_tel) = $arr;
                echo '<tr><td>'.$id.'</td><td><a class=" btn-link" href="/manager/submit_product/?id='.$id.'">Одобрить</a></td><td>'.$name.'<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_cat_'.$id.'" aria-expanded="false" aria-controls="#collapse_cat_'.$id.'">
            Подробнее
        </button>
        <div id="collapse_cat_'.$id.'" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
        <table class="table-borderless col-xs-6 col-md-6 col-lg-6 col-xl-6">
            <tr>
            <td class=" col-md-6 col-lg-6 col-xl-6 "><b class="d-inline">Клиент</b> : </td><td>'.$customer.'</td>
        </tr>
        <tr>
            <td class=" col-md-6 col-lg-6 col-xl-6 "><b class="d-inline">Номер моб. телефона</b> : </td><td>'.$customer_tel.'</td>
        </tr>
        <tr>
            <td><b class="d-inline">Адресс</b> : </td><td>'.$cityName.' / '.$address.'</td>
        </tr>
    </table>
           '.$about.'
    </div></td><td>'.$conf.'</td><td>'.$cost.'</td><td>'.$earn.'</td><td>'.$regionName.'</td><td>'.$added.'</td></tr>';
            }?>
        </tbody>
    </table>
</div>
<script>
var config = {
    type: 'doughnut',
    data: {
        datasets: [
            {
                data:  JSON.parse(document.querySelector('noscrupt#prod_cat').innerText),
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.orange,
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                ],
                label: 'Dataset 1'
            },
        ],
        labels: [
        ]
    },
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Кол-во продуктов в категориях
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
};
    window.onload = function() {
            var ctx = document.getElementById('chart-area').getContext('2d');
        window.myDoughnut = new Chart(ctx, config);
    };
</script>
