<? include_once 'modules/site_header.php'; ?>
	<header>
		<? include_once 'modules/module_navbar.php'; ?>
		<? include_once 'modules/site_gototop.php'; ?>
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
			$moo_text = $page_content;
			$moo_link = $page_link;
			include_once 'modules/module_redactor.php';
		?>
	</main>
<? include_once 'modules/site_footer.php'; ?>