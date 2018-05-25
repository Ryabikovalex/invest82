<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta lang="ru">
	<title><?=$header?></title>
</head>
<body>
	<header class="header">
			<h1>
				Site <?=$header?>
			</h1>
	</header>
	<main>
		<?php include $content_view ?>
	</main>
	<footer>
		@Copyright
	</footer>
</body>
</html>