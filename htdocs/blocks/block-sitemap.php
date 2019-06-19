<script src="https://yastatic.net/jquery/1.7.0/jquery.min.js"></script>
<script>
/*
$(document).ready(function(){
$('.toggle').children('a').click(function () {
	$(this).next('ul').toggle();
	return false;});});
*/
</script>
<div id="block_menu">
<br/>
<ul id="main-menu">
<?
$get_list = "SELECT `pages`.`id`,`pages`.`name`,`pages`.`link` FROM `pages` WHERE `pages`.`parent` = :root_id AND ( `pages`.`public_flag` = 1 OR :admin_flag ) ORDER BY `pages`.`id` ASC;";
$list_menu = $pdo->prepare($get_list);
$list_menu->bindValue(':root_id', 0, PDO::PARAM_INT);
$list_menu->bindValue(':admin_flag', $admin_flag, PDO::PARAM_INT);
$list_menu->execute();

while ( $root_item = $list_menu->FETCH(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT) ) {
	$inner_list_menu = $pdo->prepare($get_list);
	$inner_list_menu->bindValue(':root_id', $root_item['id'], PDO::PARAM_INT);
	$inner_list_menu->bindValue(':admin_flag', $admin_flag, PDO::PARAM_INT);
	$inner_list_menu->execute();

	if ( $inner_list_menu->rowCount() == 0 ) { echo "<li><a href=\"".$root_item['link']."\">".$root_item['name']."</a></li>"; }
	else {
		echo "<li class='toggle'>";
		echo "<a href=\"".$root_item['link']."\">".$root_item['name']."</a>";
		$root_item['id'] = ( $root_item['id'] == 1 ) ? '0' : $root_item['id'];
		echo "<ul>";
		while ( $inner_item = $inner_list_menu->FETCH(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT) )
		{ echo "<li><a href=\"".$inner_item['link']."\">".$inner_item['name']."</a></li>"; }
		echo "</ul>";
		echo "</li>";
	}
}
?>
</ul>
<!--hr-->
</div>