<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$site_name?></title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<header>
			<? include_once 'blocks/block-search.php'; ?>
			<? /* include_once 'blocks/block-navbar.php'; ?>
			<? include_once 'blocks/block-promo.php'; ?>
			<? include_once 'blocks/block-search.php'; ?>
			<? include_once 'blocks/block-quickmenu.php'; ?>
			<? include_once 'blocks/block-sitemap.php'; */ ?>
		</header>
		<main>
			<? include_once 'blocks/block-news.php'; ?>
			<?//=$page_content?>
			<? // try { include_once($page_content); } catch (Exception $e) { throw $e; }?>
		</main>
		<footer>
			<? include_once 'blocks/block-footer.php'; ?>
			<? include_once 'blocks/block-copyrights.php'; ?>
		</footer>
	</body>
</html>
