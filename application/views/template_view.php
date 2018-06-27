<!DOCTYPE html>
<html>
<head>
    <meta lang="ru">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?=$header?></title>
    <meta name="description" content="<?php echo $description ?? 'Купить готовый и прибыльный бизнес в  Крыму. Покупайте бизнес у Инвест82.  Минимизируйте риски при покупке бизнеса.'?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="">
    <script type="application/ld+json">
    {
        "@context": "http://schema.org/",
        "@type": "Organization",
        "name": "Invest82",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "",
            "addressLocality": "Simferopol",
            "addressRegion": "Crimea",
            "postalCode": "295000"
        },
        "telephone": "+7 978 050 999 5"
    }
    </script>

    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <style>
        /*.dropdown:hover>.dropdown-menu {
            display: block;
        }*/
        main, footer {
            border-top: 1px solid #b9b9b9;
            margin-top: 5px;
        }
        main > div>  *
        {
           margin-bottom: 10px;
        }
        footer {
            padding: 15px auto;
        }
        input[type=radio]:checked + label
        {
            border-radius: 5px 5px;
            background-color: #007bff;
            color: #FEFEFE;
        }
        input[type=checkbox]:checked + label
        {
           color: #007bff;
        }
        .list-item{
            border: 1px solid #FFFFFF;
            padding: 0;
        }
        .list-item:hover{
            border: 1px solid #007bff;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="wrapper" class="container-fluid  h-auto" style="padding: 0;">
	<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="/">Invest82.ru</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="buyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Купить
                        </a>
                        <div class="dropdown-menu" aria-labelledby="buyDropdown">
                            <a class="dropdown-item" href="/catalog/list/">Готовый бизнес</a>
                            <a class="dropdown-item" href="/catalog/list/part">Долю в бизнесе</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="buyDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Продажа
                        </a>
                        <div class="dropdown-menu" aria-labelledby="buyDropdown">
                            <a class="dropdown-item" href="/form/sell_biznes">Продать готовый бизнес</a>
                            <a class="dropdown-item" href="/catalog/invest/">Найти инвестора</a>
                        </div>
                    </li>
                    <li class="nav-item disabled">
                        <a class="nav-link" href="#">Франшизы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/uslugi">Услуги</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about">О нас</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid" style="padding: 5px 0">
            <h1 class="d-flex justify-content-center h2"><?=$header?></h1>
        </div>
	</header>
	<main class="container-fluid d-flex justify-content-center">
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8" style="background-color: #FFFFFF; padding: 0; margin-top: 10px">
            <?php include $content_view ?>
        </div>
	</main>
	<footer class="text-muted d-flex justify-content-center" style="padding-top: 15px">
		<div class="col-xs-12 col-sm-5 col-lg-2">
            <ul class="list-unstyled">
                <li>
                    <a href="/catatlog/list"> Каталог бизнесов</a>
                </li>
                <li>
                    <a href="/catatlog/list/part"> Каталог долей в бизнесе</a>
                </li>
                <li>
                    <a href="/catatlog/list"> Каталог бизнесов</a>
                </li>
            </ul>
        </div>
		<div class="col-xs-12 col-sm-5 col-lg-2">
            <p class="w-100">
                8 978 050 999 5<br/>
                8 919 10 66 208
            </p>
            <p class="w-100">
                victor7broker@gmail.com
            </p><br/>
            <p class="w-100">
                © 2014-2018 Инвест82 invest82 - сайт Объявлений Симферополя купить продать готовый бизнес
            </p>
        </div>
	</footer>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="<?=PATH['js']?>bootstrap.bundle.min.js"></script>
</body>
</html>