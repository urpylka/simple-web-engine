<style>
#slider { display: block; }
#quickmenu { display: block; }
#block_menu { display: none; }
</style>
<style>
/* основное меню и лого */
nav{
	height:80px;width:100%;text-transform:uppercase;
	background-image:-moz-linear-gradient(bottom, #d7d7d7 0%, #f1f1f1 100%);
	background-image:-o-linear-gradient(bottom, #d7d7d7 0%, #f1f1f1 100%);
	background-image:-webkit-linear-gradient(bottom, #d7d7d7 0%, #f1f1f1 100%);
	background-image:linear-gradient(bottom, #d7d7d7 0%, #f1f1f1 100%);
}
nav ul{
	float:right !important;
	margin-right:30px !important;
}
.logo{
	padding-top:7px;
	margin-left:30px;
	float:left;
	width:300px;
}

nav li{
	float:left;
	font-size:17px;
	margin-left:30px; /* было 35 */
	margin-top:34px;
}
</style>

<script src="https://yastatic.net/jquery/1.7.0/jquery.min.js"></script>

<script type="text/javascript">

function menu(show) {
	if (show) {
		document.getElementById('block_menu').style.display = 'block';
		document.getElementById('slider').style.display = 'none';
		document.getElementById('quickmenu').style.display = 'none';
	} else {
		document.getElementById('block_menu').style.display = 'none';
		document.getElementById('slider').style.display = 'block';
		document.getElementById('quickmenu').style.display = 'block';
	}
}

// slider https://habr.com/post/319394/

$(document).ready(function() {
	var show = false;
	$('.toggle2').children('a').click(function() {
		show = !show;
		menu(show);
	});
});
</script>

<nav>
	<div class="logo">
		<a href="http://ssau.ru"><img src="img/Unknown.svg" style="padding-top:15px;" height="40px;" alt="Главная"></a>
		<a href="/"><div style="padding-left:35px;margin-top:-17px;"><b>ВОЕННАЯ</b> КАФЕДРА</div></a>
	</div>
	<ul class="TopMenu">
		<?
			$list_menu = $pdo->query("SELECT `pages`.`name`,`pages`.`link` FROM `pages`,`top_menu` WHERE `pages`.`id` = `top_menu`.`page_id` ORDER BY `top_menu`.`queue` ASC;");
			foreach ($list_menu as $option) echo "<li><a href=\"".$option['link']."\">".$option['name']."</a></li>";
			/* ?><li class="toggle2"><a href="#">MAP</a></li><? */
		?>
	</ul>
</nav>
