<?php list( $name, $date, $cost, $earn, $oborot, $rashod, $region, $city, $address, $about, $shtat, $status, $images, $is_conf, , $brName, $brTel) = $product;
$images = json_decode($images, true, 512, JSON_OBJECT_AS_ARRAY);
?>
<div class="container-fluid row" itemscope itemtype="http://schema.org/Product">
    <div class="col-xs-12 col-sm-12 col-md-6 h-auto" style="">
        <div id="carouselimages" class="carousel slide h-100" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php for ( $i=0; $i < count($images); $i++)
                {
                    $a = ($i==0)?'class="active"':'';
                    echo '<li data-target="#carouselimages" data-slide-to="'.$i.'" '.$a.'></li>';
                }
                ?>
            </ol>
            <div class="carousel-inner d-flex">
                <?php foreach ($images as $k => $data)
                {
                    $a = ($k==0)?'active':'';
                    $i = ($k==0)?'itemprop="image"':'';
                    echo ' <div class="carousel-item '.$a.'">
                <img class="d-block w-100" '.$i.' src="'.PATH['images_biznes'].$data['name'].'" alt="'.$data['alt'].'">
            </div>';
                }
                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselimages" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselimages" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <p class="h5 d-flex justify-content-center">
            <?php echo ($status == 0) ? '<span class="badge badge-success " style="font-size: 85%; margin-right: 15px">Новинка</span>' : ''?>
            <?php echo ($is_conf == 1) ? '<span class="badge badge-danger" style="font-size: 85%;">Конфидециально</span>' : ''?>
        </p>
        <p>
            Добавлен : <?=format_date($date)?>
        </p>
        <div class="container-fluid">
            <?=$about?>
        </div>
        <span itemprop="name" class="d-none"><?=$name?></span>
        <span itemprop="name" class="d-none"><?=$description?></span>
        <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <span itemprop="price" class="d-none"><?=$cost?></span>
            <span itemprop="priceCurrency" content="RUB"></span>
        </span>
        <p class="h5 text-primary">Стоимость : <?=format_cost($cost)?> руб.</p>

    </div>
</div>
<script>
    $('#carouselimages').carousel({
        interval: 3000
    })
</script>
<div class="container-fluid" style="padding-top: 10px">
    <p class="h5">
        Дополнительная информация
    </p>
    <p> Адресс  : <?=$city?> / <?=$address?></p>
    <p>
        Ежемесячная прибыль : <?=format_cost($earn)?> руб. / месяц <br/>
        Обороты в месяц :	<?=format_cost($oborot)?> руб. <br/>
        Средний расход в месяц : <?=format_cost($rashod)?> руб.
    </p>
    <p>
        Штат сотрудников : <?=$shtat?>
    </p>
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Брокер объекта: <?=$brName?></h4>
        <p>Свяжитесь со мной <b><?=format_tel($brTel)?></b> и я проконсультирую вас по любым вопросам относительно покупки этого бизнеса. </p>
    </div>
</div>