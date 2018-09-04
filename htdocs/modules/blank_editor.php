<? include("config.php");

	try { $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",  $login_mysql,  $password_mysql); }
	catch(PDOException $e)
	{
		echo "You have an error: ".$e->getMessage()."<br>";
		echo "On line: ".$e->getLine();
	}

	// Сначала проверяем может ли данный пользователь по cookie выполнять данный запрос

	if ( isset($_POST['moo_link']) && isset($_POST['moo_text']) )
	{
		$page_by_link = $db->prepare("SELECT id FROM pages WHERE link = :moo_link;");
		$page_by_link->bindValue(':moo_link', $_POST['moo_link'], PDO::PARAM_STR);
		$page_by_link->execute();
		$count_pages = $page_by_link->rowCount();

		switch($count_pages) {
			case '0': echo("ERROR: No pages were found in the database for this query.");
			case '1':
				$update_page = $db->prepare("UPDATE `pages` SET `text` = :moo_text WHERE `id` = :id;");
				$update_page->bindValue(':moo_text', $_POST['moo_text'], PDO::PARAM_STR);
				$update_page->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
				if ($update_page->execute()) echo "<p style='margin-left:30px;'>The page was saved!</p>";
				else echo("ERROR: Could not save the page!");
				break;
			default: echo("ERROR: $count_pages pages have been returned for this request, but there must be one!");
		}
	}
	else echo("ERROR: The post request is not correct!");
?>