<?
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

include("config.php");

if (DEBUG) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
else {
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}

try { $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",  $login_mysql,  $password_mysql); }
catch(PDOException $e) {
	echo "You have an error: ".$e->getMessage()."<br>";
	echo "On line: ".$e->getLine();
}

$login = NULL;
$admin_flag = 0;

session_start();
$user_by_phpsessid = $pdo->prepare("SELECT `users`.`login`,`users`.`admin_flag` FROM `sessions` INNER JOIN `users` ON `sessions`.`user_id`=`users`.`id` WHERE `sessions`.`phpsessid` = :phpsessid;");
$user_by_phpsessid->bindValue(':phpsessid', session_id(), PDO::PARAM_STR);
$user_by_phpsessid->execute();
$count_users = $user_by_phpsessid->rowCount();

switch($count_users) {
	case '0':
		echo("<p>You is not login yet</p>");
		break;
	case '1':
		$login = $user_by_phpsessid->FETCH(PDO::FETCH_ASSOC)['login'];
		$admin_flag = $user_by_phpsessid->FETCH(PDO::FETCH_ASSOC)['admin_flag'];
		break;
	default:
		echo("<p>ERROR: $count_users users have been returned for this request, but there must be one!</p>");
		// нужно прервать завершить сессию и сообщить о проблеме
		exit(1);
}

$page_by_link = $pdo->prepare("SELECT `pages`.`name`,`pages`.`text`,`pages`.`template` FROM `pages` WHERE (`pages`.`link` = :page_link AND `pages`.`public_flag` = 1) OR (`pages`.`link` = :page_link AND :admin_flag);");
$page_by_link->bindValue(':page_link', $_GET['link'], PDO::PARAM_STR);
$page_by_link->bindValue(':admin_flag', $admin_flag, PDO::PARAM_STR);
$page_by_link->execute();
$count_pages = $page_by_link->rowCount();

switch($count_pages) {
	case '0':
		//echo("<p>ERROR: 403 Access denied</p>");
		$name = "Ошибка 403";
		$text = "<p>У вас нет прав, для просмотра этой страницы.</p><p>Пройдите <a href='login?refer=$page_link'>авторизацию</a>.</p>";
		include_once("modules/template_standart.php");
		exit(1);
	case '1':
		$name = $page_title = $page_by_link->FETCH(PDO::FETCH_ASSOC)['name'];
		$text = $page_content = $page_by_link->FETCH(PDO::FETCH_ASSOC)['text'];
		$template = $page_template = $page_by_link->FETCH(PDO::FETCH_ASSOC)['template'];
		break;
	default:
		echo("<p>ERROR: $count_pages pages have been returned for this request, but there must be one!</p>");
		exit(1);
}

if ($DEBUG) { echo "page_link: ".$page_link; }

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
?>