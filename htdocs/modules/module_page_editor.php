<?
	$page_link=$_POST['moo_link'];//принимаем переменную
	//echo $page_link;
	//echo $_POST['moo_text'];
	if($page_link!=NULL)
	{
		$page_sql=mysql_query("SELECT id FROM pages WHERE link='".$page_link."';");
		$count=mysql_num_rows($page_sql);
		switch($count){
			case '0':
				throw new Exception('По данному запросу не найдено страниц в базе данных.');
			case '1':
				$view_page_info = mysql_fetch_assoc($page_sql);
				$id = $view_page_info['id'];
				//изменяем контент страницы
				$page_sql=mysql_query("UPDATE `pages` SET `text` = '".$_POST['moo_text']."' WHERE `id` = ".$id.";");
				echo "<p style='margin-left:30px;'>Страница сохранена!</p>";
				break;
			default:
				throw new Exception('По данному запросу возвращено $count страниц, а должна быть одна.');
		}
	}
?>