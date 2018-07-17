<nav>
	<div class="logo"><a href="http://ssau.ru"><img src="img/Unknown.svg" style="padding-top:15px;" height="40px;" alt="Главная"></a><a href="/"><div style="padding-left:35px;margin-top:-17px;"><b>ВОЕННАЯ</b> КАФЕДРА</div></a></div>
	<ul class="TopMenu">
		<?
			$menu = mysql_query("SELECT name, link FROM pages, top_menu WHERE pages.id=top_menu.page_id ORDER BY top_menu.queue ASC");
			while($list_menu = mysql_fetch_array($menu))
			{
				echo "<li><a href=\"".$list_menu['link']."\">".$list_menu['name']."</a></li>";
				/*
				if($parent == $list_menu['link']) {echo "<li class=\"select\">".$list_menu['name']."</li>";}
				elseif ($list_menu['link'] == 'index') {echo "<li><a href=\"$site_url\">".$list_menu['name']."</a></li>";}
				*/
			}
		?>
		<?
		/*
		<li><a href="/index.php">Главная</a></li>
		<li><a href="/news.php">Новости</a></li>
		<li><a href="/struktura.php">Структура</a></li>
		<li><a href="/library.php">Библиотека</a></li>
		<li><a href="/contacts.php">Контакты</a></li>
		*/
		?>
	</ul>
</nav>
