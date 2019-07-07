<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$site_name?> - <?=$page_title?></title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<header>
			<? include_once 'blocks/block-navbar.php'; ?>
		</header>
		<main>
			<? include_once 'blocks/block-list.php'; ?>
		</main>
		<footer>
			<? include_once 'blocks/block-footer.php'; ?>
			<? include_once 'blocks/block-copyrights.php'; ?>
		</footer>
	</body>
</html>
