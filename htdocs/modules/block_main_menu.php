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
$parent=0;
$current=1;
$menu = mysql_query("SELECT * FROM pages WHERE parent=\"0\" ORDER BY id ASC");
$list_nemu = null;
while($list_menu = mysql_fetch_array($menu))
{
	if($parent == $list_menu['id']){echo "<li class=\"select\"><a href=\"".$list_menu['link']."\">".$list_menu['name']."</a></li>";}
	else
	{
		$menu2 = mysql_query("SELECT * FROM pages WHERE parent=\"".$list_menu['id']."\" ORDER BY id ASC");
		$count=mysql_num_rows($menu2);
		if($count==0)
		{
			echo "<li>";
			echo "<a href=\"".$list_menu['link']."\">".$list_menu['name']."</a>";
			echo "</li>";
		}
		else{
			echo "<li class='toggle'>";
			echo "<a href=\"".$list_menu['link']."\">".$list_menu['name']."</a>";
			$list_nemu['id']=($list_nemu['id']==1)?'0':$list_nemu['id'];
			echo "<ul>";
			while($list_menu2 = mysql_fetch_array($menu2))
			{
				if($parent == $list_menu2['id'])
				{ echo "<li class=\"select\"><a href=\"".$list_menu2['link']."\">".$list_menu2['name']."</a></li>"; }
				else
				{ echo "<li><a href=\"".$list_menu2['link']."\">".$list_menu2['name']."</a></li>"; }
			}
			echo "</ul>";
			echo "</li>";
		}
	}
}
?>
</ul>
