<? include_once 'modules/site_header.php'; ?>
	<header>
		<? include_once 'modules/module_navbar.php'; ?>
		<? include_once 'modules/block_promo.php'; ?>
		<? include_once 'modules/block_quick-menu.php'; ?>
	</header>
	<main>
		<article>
			<? include_once $page_content; ?>
		</article>
	</main>
	<hr/>
	<? include_once 'modules/block_main_menu.php'; ?>
	<hr/>
<? include_once 'modules/site_footer.php'; ?>