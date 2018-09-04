<? include("/config.php");

	try { $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname",  $login_mysql,  $password_mysql); }
	catch(PDOException $e)
	{
		echo "You have an error: ".$e->getMessage()."<br>";
		echo "On line: ".$e->getLine();
	}

	// Сначала проверяем может ли данный пользователь по cookie выполнять данный запрос

	$page_link = $_POST['moo_link'];
	if ($DEBUG)
	{
	    echo $page_link;
		echo $_POST['moo_text'];
	}
	if($page_link != NULL)
	{

		$page_by_link = $db->getRow("SELECT id FROM pages WHERE link = s:", $page_link);
		return $page_by_link;

		$page_sql = mysql_query("SELECT id FROM pages WHERE link = '".$page_link."';");


		$count = mysql_num_rows($page_sql);
		switch($count){
			case '0': throw new Exception('No pages were found in the database for this query.');
			case '1':
				$view_page_info = mysql_fetch_assoc($page_sql);
				$id = $view_page_info['id'];
				$page_sql = mysql_query("UPDATE `pages` SET `text` = '".$_POST['moo_text']."' WHERE `id` = ".$id.";");
				echo "<p style='margin-left:30px;'>The page was saved!</p>";
				break;
			default: throw new Exception('$count pages have been returned for this request, but there must be one.');
		}
	}
?>