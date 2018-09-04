<? include("config.php");

	try { $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname",  $login_mysql,  $password_mysql); }
	catch(PDOException $e)
	{
		echo "You have an error: ".$e->getMessage()."<br>";
		echo "On line: ".$e->getLine();
	}

	// Сначала проверяем может ли данный пользователь по cookie выполнять данный запрос

	$moo_link = $_POST['moo_link'];

	if ($DEBUG)
	{
	    echo "moo_link: ".$moo_link;
		echo "moo_text: ".$_POST['moo_text'];
	}

	if($moo_link != NULL)
	{

		//$page_by_link = $db->getRow("SELECT id FROM pages WHERE link = s:", $moo_link);
		//return $page_by_link;

		//$login  = $db->quote($_POST["login"]);
		//$result = $db->query("SELECT * FROM users WHERE login = $login");

		$page_by_link = $db->prepare("SELECT id FROM pages WHERE link = :moo_link");
		$page_by_link->bindValue(':moo_link', $moo_link, PDO::PARAM_STR);
		$page_by_link->execute();
		$page_by_link = $page_by_link->FETCH(PDO::FETCH_ASSOC);

		if ($DEBUG)
		{
			var_dump($page_by_link);
	    	echo "rowCount: ".$page_by_link->rowCount();
			echo "id: ".$page_by_link['id'];
		}

		$page_sql = mysql_query("SELECT id FROM pages WHERE link = '".$moo_link."';");


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