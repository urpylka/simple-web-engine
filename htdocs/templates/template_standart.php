<? include_once 'modules/header.php'; ?>
	<header>
		<? include_once 'modules/blocks/nav-bar.php'; ?>
		<? include_once 'modules/gototop.php'; ?>
	</header>
	<main>
		<article>
			<section class="text-content" id="fullpage">
				<h1><?=$name?></h1>
				<div id="main_cont">
				<?=$text?>
				</div>
			</section>
		</article>
	<? if($_SESSION['group_id']>$access_id)
	{
		$moo_text = $text;
		$moo_link = $page_link;
		include_once 'modules/blocks/moo.php';
	} ?>
	</main>
<? include_once 'modules/footer.php'; ?>