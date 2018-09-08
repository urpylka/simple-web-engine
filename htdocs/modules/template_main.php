<? include_once 'modules/site_header.php'; ?>
	<header>
		<? include_once 'modules/module_navbar.php'; ?>
		<? include_once 'modules/block_promo.php'; ?>
		<? include_once 'modules/block_quick-menu.php'; ?>
		<? include_once 'modules/block_main_menu.php'; ?>
		<hr/>
	</header>
	<main>
		<article>
			<?=$page_content?>
		</article>
		<?
			if ($admin_flag && ! $error_output)
			{
				$moo_text = $page_content;
				$moo_link = $page_link;
				include_once 'modules/module_redactor.php';
			}
		?>
	</main>
<? include_once 'modules/site_footer.php'; ?>