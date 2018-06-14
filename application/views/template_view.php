<!DOCTYPE html>
<html>
<head>
    <meta lang="ru">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title><?=$header ?? 'Купить бизнес в России'?></title>

    <!--<link rel="stylesheet" href="/assets/css/index.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap-grid.min.css">
</head>
<body>
	<header>
        <h1>
            <?=$header ?? 'Купить бизнес в России'?>
        </h1>
	</header>
	<main>
        <nav>

        </nav>
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