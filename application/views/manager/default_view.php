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
    <h1 class="h2">Панель</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm btn-outline-secondary">Share</button>
            <button class="btn btn-sm btn-outline-secondary">Выгрузить из Bpium</button>
        </div>
    </div>
</div>

<canvas class="my-4chartjs-render-monitor" id="myChart" width="1486" height="627" style="display: block; width: 1486px; height: 627px;"></canvas>
<?php include 'tables/submit_products_view.php' ?>
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
