<? include("config.php");

	try { $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname",  $login_mysql,  $password_mysql); }
	catch(PDOException $e)
	{
		echo "You have an error: ".$e->getMessage()."<br>";
		echo "On line: ".$e->getLine();
	}

	// Сначала проверяем может ли данный пользователь по cookie выполнять данный запрос

	if ( isset($_POST['moo_link']) && isset($_POST['moo_text']) )
	{
		$page_by_link = $db->prepare("SELECT id FROM pages WHERE link = :moo_link");
		$page_by_link->bindValue(':moo_link', $_POST['moo_link'], PDO::PARAM_STR);
		$page_by_link->execute();
		$count_pages = $page_by_link->rowCount();

		switch($count_pages){
			case '0': throw new Exception('No pages were found in the database for this query.');
			case '1':
				echo "id: ".$page_by_link->FETCH(PDO::FETCH_ASSOC)['id'];
				//$id = $view_page_info['id'];
				//$page_sql = mysql_query("UPDATE `pages` SET `text` = '".$_POST['moo_text']."' WHERE `id` = ".$id.";");
				echo "<p style='margin-left:30px;'>The page was saved!</p>";
				break;
			default: throw new Exception('$count_pages pages have been returned for this request, but there must be one.');
		}
	}
	else throw new Exception('The post request is not correct!');
?>