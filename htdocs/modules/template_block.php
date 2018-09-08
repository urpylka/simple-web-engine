<? include_once('modules/site_header.php'); ?>
	<header>
		<? include_once('modules/module_navbar.php'); ?>
	</header>
	<main>
		<? try { include_once($page_content); } catch (Exception $e) { throw $e; }?>
	</main>
<? require_once('modules/site_footer.php'); ?>