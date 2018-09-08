<? include_once 'modules/site_header.php'; ?>
	<header>
		<? include_once 'modules/block_yandex_map.php'; ?>
		<? include_once 'modules/module_navbar.php'; ?>
	</header>
	<main>
		<article>
			<section class="text-content" id="fullpage">
				<h1><?=$page_title?></h1>
				<div id="main_cont">
					<?=$page_content?>
				</div>
			</section>
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