<?
//http://telegra.ph/Napisanie-sobstvennoj-CMS-03-14
session_start();
$_SESSION['group_id'] = isset($_SESSION['login'])?$_SESSION['group_id']:"1";

error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

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

include("config.php");

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
if ($DEBUG) { echo $page_link; }
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
	case 'blank': include_once("modules/template_blank.php"); break;
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