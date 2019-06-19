<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$site_name?></title>
		<link rel="stylesheet" href="css/style.css" />

		<link rel="stylesheet" type="text/css" href="css/template_standart.css">

		<script type="text/javascript" src="mooeditable/Demos/assets/mootools.js"></script>

		<!-- <script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.js"></script>
		<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.UI.MenuList.js"></script>
		<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.Extras.js"></script> -->

		<!-- <link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.css">
		<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.Extras.css">
		<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.SilkTheme.css"> -->
		
		<!-- <script src='http://localhost/jquery-3.3.1.min.js'></script> -->

	<script type="text/javascript" src="js/template_standart.js"></script>

	</head>
	<body>
		<header>
			<? include_once 'modules/block_yandex_map.php'; ?>
			<? include_once 'modules/module_navbar.php'; ?>
			<? include_once 'modules/block_site_map.php'; ?>		</header>
		</header>
		<main>
			<? include_once 'modules/page-block_article.php'; ?>
		</main>
		<footer>
			<? include_once 'modules/block_footer.php'; ?>
			<? include_once 'modules/block_copyrights.php'; ?>
		</footer>
	</body>
</html>