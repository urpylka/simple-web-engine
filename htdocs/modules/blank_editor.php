<?
	// Сначала проверяем может ли данный пользователь по cookie выполнять данный запрос

	if ( isset($_POST['moo_link']) && isset($_POST['moo_text']) )
	{
		$page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :moo_link;");
		$page_by_link->bindValue(':moo_link', $_POST['moo_link'], PDO::PARAM_STR);
		$page_by_link->execute();
		$count_pages = $page_by_link->rowCount();

		switch($count_pages) {
			case '0':
				echo("<p>ERROR: No pages were found in the database for this query.</p>");
				break;
			case '1':
				$update_page = $pdo->prepare("UPDATE `pages` SET `text` = :moo_text WHERE `id` = :id;");
				$update_page->bindValue(':moo_text', $_POST['moo_text'], PDO::PARAM_STR);
				$update_page->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
				if ($update_page->execute()) echo "<p style='margin-left:30px;'>The page was saved!</p>";
				else echo("<p>ERROR: Could not update the page!</p>");
				break;
			default:
				echo("<p>ERROR: $count_pages pages have been returned for this request, but there must be one!</p>");
				break;
		}
	}
	else echo("<p>ERROR: The post request is not correct!</p>");
?>