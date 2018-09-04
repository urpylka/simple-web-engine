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
		$count_pages = $page_by_link->rowCount();
		if ($DEBUG)
		{
			var_dump($page_by_link);
	    	echo "count_pages: ".$count_pages;
		}

		switch(count_pages){
			case '0': throw new Exception('No pages were found in the database for this query.');
			case '1':
				echo $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'];
				//$id = $view_page_info['id'];
				//$page_sql = mysql_query("UPDATE `pages` SET `text` = '".$_POST['moo_text']."' WHERE `id` = ".$id.";");
				echo "<p style='margin-left:30px;'>The page was saved!</p>";
				break;
			default: throw new Exception('$count pages have been returned for this request, but there must be one.');
		}
	}
?>