<article>
	<section>
<?

function show_page_as_item($_p_name, $_p_img, $_p_desc, $_p_link) {
?> <div class="page_as_item">
	<h1 class="tape"><?=$_p_name?></h1>
	<div class="page_preview">
		<img src="<?=$_p_img?>" />
		<p><?=$_p_desc?></p>
		<a href="<?=$_p_link?>">Подробнее</a>
	</div>
</div> <?
}

$p_prnt = $page_id;
$p_tmpl = 1;

$pages_by_cond = $pdo->prepare("SELECT `pages`.`name`,`pages`.`text`,`pages`.`template`,`pages`.`public_flag`,`pages`.`link` FROM `pages` WHERE ( `pages`.`parent` = :page_prnt ) AND ( `pages`.`template` = :page_tmpl ) AND ( `pages`.`public_flag` = 1 OR :admin_flag );");
$pages_by_cond->bindValue(':page_prnt', $p_prnt, PDO::PARAM_INT);
$pages_by_cond->bindValue(':page_tmpl', $p_tmpl, PDO::PARAM_INT);
$pages_by_cond->bindValue(':admin_flag', $admin_flag, PDO::PARAM_STR);
$pages_by_cond->execute();
// echo($pages_by_cond->rowCount());

foreach($pages_by_cond as $_page) {

	// https://ruseller.com/lessons.php?id=1769
	$_string = strip_tags($_page['text']);
	$_string = substr($_string, 0, 200);
	$_string = rtrim($_string, "!,.-");
	$_string = substr($_string, 0, strrpos($_string, ' '));
	show_page_as_item($_page['name'], "img/assets/coda.png", $_string, $_page['link']);

}
?>
	</section>
</article>
<br/>