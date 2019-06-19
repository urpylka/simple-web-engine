<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$site_name?></title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<header>
			<? include_once 'blocks/block-navbar.php'; ?>
			<? include_once 'blocks/block-promo.php'; ?>
			<? include_once 'blocks/block-quick_menu.php'; ?>
			<? include_once 'blocks/block-site_map.php'; ?>
		</header>
		<main>
			<?//=$page_content?>
			<? try { include_once($page_content); } catch (Exception $e) { throw $e; }?>
		</main>
		<footer>
			<? include_once 'blocks/block-footer.php'; ?>
			<? include_once 'blocks/block-copyrights.php'; ?>
		</footer>
	</body>
</html>
