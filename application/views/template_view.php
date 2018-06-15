<!DOCTYPE html>
<html>
<head>
    <meta lang="ru">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title><?=$header?></title>

    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap-grid.min.css">
</head>
<body>
	<header class="container-fluid">
        <h1>
            <?=$header?>
        </h1>
        <nav>
            <ul>
                <li>
                    <a href="/shop/list">Каталог</a>
                </li>
                <li>
                    <a href="/form/sell_biznes">Продать бизнес</a>
                </li>
                <li>
                    <a href="/form/buy_biznes">Купить бизнес</a>
                </li>
                <li>
                    <a href="/about">О нас</a>
                </li>
            </ul>
        </nav>
	</header>
	<main>
        <div>
            <?=$filters ?? ''?>
        </div>
		<?php include $content_view ?>
	</main>
	<footer>
		@Copyright
	</footer>
</body>
</html>