<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?=$site_name?></title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<header>
			<? include_once 'modules/module_navbar.php'; ?>
		</header>
		<main>
			<? try { include_once($page_content); } catch (Exception $e) { throw $e; }?>
		</main>
		<footer>
			<? include_once 'modules/block_footer.php'; ?>
			<? include_once 'modules/block_copyrights.php'; ?>
		</footer>
	</body>
</html>
