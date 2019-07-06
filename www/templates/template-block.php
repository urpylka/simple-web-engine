<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$site_name?></title>
		<link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript" src="js/block-article.js"></script>
		<script type="text/javascript" src="mooeditable/Demos/assets/mootools.js"></script>

	</head>
	<body>
		<header>
			<? include_once 'blocks/block-navbar.php'; ?>
		</header>
		<main>
			<? try { include_once($page_content); } catch (Exception $e) { throw $e; }?>
		</main>
		<footer>
			<? include_once 'blocks/block-footer.php'; ?>
			<? include_once 'blocks/block-copyrights.php'; ?>
		</footer>
	</body>
</html>
