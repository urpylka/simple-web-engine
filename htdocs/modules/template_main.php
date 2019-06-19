<? include_once 'modules/site_header.php'; ?>
	<header>
		<? include_once 'modules/module_navbar.php'; ?>
		<? include_once 'modules/block_promo.php'; ?>
		<? include_once 'modules/block_quick_menu.php'; ?>
		<? include_once 'modules/block_site_map.php'; ?>
	</header>
	<main>
		<?//=$page_content?>
		<? include_once $page_content; ?>
	</main>
<? include_once 'modules/site_footer.php'; ?>