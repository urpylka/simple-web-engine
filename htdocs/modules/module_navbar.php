<nav>
	<div class="logo"><a href="http://ssau.ru"><img src="img/Unknown.svg" style="padding-top:15px;" height="40px;" alt="Главная"></a><a href="/"><div style="padding-left:35px;margin-top:-17px;"><b>ВОЕННАЯ</b> КАФЕДРА</div></a></div>
	<ul class="TopMenu">
		<?
			$list_menu = $pdo->query("SELECT `pages`.`name`,`pages`.`link` FROM `pages`,`top_menu` WHERE `pages`.`id` = `top_menu`.`page_id` ORDER BY `top_menu`.`queue` ASC");
			foreach (option as $list_menu) echo "<li><a href=\"".$option['link']."\">".$option['name']."</a></li>";
		?>
	</ul>
</nav>
