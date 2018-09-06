<?
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

include("config.php");

if (DEBUG)
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
else
{
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}

try { $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",  $login_mysql,  $password_mysql); }
catch(PDOException $e)
{
	echo "You have an error: ".$e->getMessage()."<br>";
	echo "On line: ".$e->getLine();
}

session_start();
$user_by_phpsessid = $pdo->prepare("SELECT `user_id` FROM `sessions` WHERE phpsessid = :phpsessid;");
$user_by_phpsessid->bindValue(':phpsessid', session_id(), PDO::PARAM_STR);
$user_by_phpsessid->execute();
$count_users = $user_by_phpsessid->rowCount();

switch($count_users) {
	case '0':
		echo("<p>ERROR: No users were found in the database for this query.</p>");
		break;
	case '1':
		$update_page = $pdo->prepare("UPDATE `pages` SET `text` = :moo_text WHERE `id` = :id;");
		$update_page->bindValue(':moo_text', $_POST['moo_text'], PDO::PARAM_STR);
		$update_page->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
		if ($update_page->execute()) echo "<p style='margin-left:30px;'>The page was saved!</p>";
		else echo("<p>ERROR: Could not update the page!</p>");
		break;
	default:
		echo("<p>ERROR: $count_users pages have been returned for this request, but there must be one!</p>");
		break;
}


$_SESSION['group_id'] = isset($_SESSION['login'])?$_SESSION['group_id']:"1";



$db = @mysql_connect("$host:$port", "$login_mysql", "$password_mysql"); 
if (!$db) exit("<center><p class=\"error\">К сожалению, не доступен сервер MySQL</p></center>"); 
if (!@mysql_select_db($dbname, $db)) exit("<center><p class=\"error\">К сожалению, не доступна база данных</p></center>");
mysql_set_charset('utf8', $db);

// Сначала ищем страницу по id или link
// Затем проверяем права на ее просмотр или редактирование

/*
$page_id = $_GET['id'];
if($page_id!=NULL)
{
	//echo "page:".$page;
	$page_sql=mysql_query("SELECT name,text,template FROM pages WHERE id='".$page_id."';");
	$count=mysql_num_rows($page_sql);
	switch($count){
		case '0':
			throw new Exception('По данному запросу не найдено страниц в базе данных.');
		case '1':
			$view_page_info = mysql_fetch_assoc($page_sql);
			$name = $view_page_info['name'];
			$text = $view_page_info['text'];
			$template = $view_page_info['template'];
			break;
		default:
			throw new Exception('По данному запросу возвращено $count страниц, а должна быть одна.');
	}
}
*/
$page_link=$_GET['link'];
if ($DEBUG) { echo "page_link: ".$page_link; }
if($page_link!=NULL)
{
	$page_sql=mysql_query("SELECT name,text,template,access_id FROM pages WHERE link='".$page_link."';");
	$count=mysql_num_rows($page_sql);
	switch($count){
		case '0': throw new Exception('No pages were found in the database for this query.');
		case '1':
			$view_page_info = mysql_fetch_assoc($page_sql);
			$name = $view_page_info['name'];
			$text = $view_page_info['text'];
			$template = $view_page_info['template'];
			$access_id = $view_page_info['access_id'];
			break;
		default: throw new Exception('$count pages have been returned for this request, but there must be one.');
	}
}
if($_SESSION['group_id']>=$access_id)//на самом деле не так потому что могут быть разные логины (отдельный запрос в бд)
switch($template){
	case 'main': include_once("modules/template_main.php"); break;
	case 'standart': include_once("modules/template_standart.php"); break;
	case 'contacts': include_once("modules/template_contacts.php"); break;
	case 'block': include_once("modules/template_block.php"); break;
	case 'blank': include_once($text); break;
	case 'section2': include_once("modules/template_section.php"); break;
	default:
	    $access_id = 1000;
	    $name = "Ошибка!";
		$text = "Шаблон для этой страницы отсутствует";
		include_once("modules/template_standart.php");
		if ($DEBUG) { echo("Ошибка: Шаблон для этой страницы отсутствует"); }
		break;
}
else
	{
		$name = "Ошибка 403";
		$text = "<p>У вас нет прав, для просмотра этой страницы.</p><p>Пройдите <a href='login?refer=$page_link'>авторизацию</a>.</p>";
		include_once("modules/template_standart.php");
	}
?>