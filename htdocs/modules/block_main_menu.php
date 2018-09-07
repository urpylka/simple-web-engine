<style>
#main-menu{
	margin-left:30px;
	margin-right:30px;
	-moz-column-width: 200px;
	-webkit-column-width: 200px;
	column-width: 200px;
}
#main-menu>li{
	list-style:none;
	margin-bottom:13px;
	/*padding-top:13px;*/
}
#main-menu>li>a{
	/*background-color:rgba(255,255,0,0.48);*/
	background-color:rgba(90,159,101,0.48);
	padding:7px;
	font-weight:400;
	padding-left:10px;
	display:block;
	width:200px;
	color:#000;
	line-height:20px;
}
#main-menu>li>ul{
	padding-left:10px;
	display:none;
}
#main-menu>li>ul>li{
	list-style:none;
	padding-top:10px;
}
#main-menu>li>ul>li>a{
	line-height:20px;
}
.toggle
{
	position:relative;
}
.toggle:before
{
	top:4px;
	content:'↓';
	position:absolute;
	right:15px;
}
</style>
<br/>
<script src="https://yastatic.net/jquery/1.7.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
$('.toggle').children('a').click(function () {
	$(this).next('ul').toggle();
	return false;});});
</script>
<ul id="main-menu">
<?
$get_pages="SELECT `pages`.`id`,`pages`.`name`,`pages`.`link` FROM `pages` WHERE `pages`.`parent` = :root_id AND ( `pages`.`public_flag` = 1 OR :admin_flag ) ORDER BY `pages`.`id` ASC;";

$root_list_menu = $pdo->prepare($get_pages);
var_dump($admin_flag);
$root_list_menu->bindValue(':parent_id', 0, PDO::PARAM_INT);
$root_list_menu->bindValue(':admin_flag', $admin_flag, PDO::PARAM_INT);
$root_list_menu->execute();

foreach ( $root_list_menu as $root_item ) {
	$root_item = $root_item->FETCH(PDO::FETCH_ASSOC);
	$inner_list_menu = $pdo->prepare($get_pages);
	$inner_list_menu->bindValue(':parent_id', $root_item['id'], PDO::PARAM_INT);
	$root_list_menu->bindValue(':admin_flag', $admin_flag, PDO::PARAM_INT);
	$inner_list_menu->execute();

	if ( $inner_list_menu->rowCount() == 0 ) { echo "<li><a href=\"".$root_item['link']."\">".$root_item['name']."</a></li>"; }
	else {
		echo "<li class='toggle'>";
		echo "<a href=\"".$root_item['link']."\">".$root_item['name']."</a>";
		$root_item['id'] = ( $root_item['id'] == 1 ) ? '0' : $root_item['id'];
		echo "<ul>";

		foreach ( $inner_list_menu as $inner_item ) {
			$inner_item = $inner_item->FETCH(PDO::FETCH_ASSOC);
			echo "<li><a href=\"".$inner_item['link']."\">".$inner_item['name']."</a></li>";
		}
		echo "</ul>";
		echo "</li>";
	}
}
?>
</ul>
