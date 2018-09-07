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
	exit(1);
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
		if ($DEBUG) { echo("<p>You is not login yet</p>"); }
		break;
	case '1':
		$login = $user_by_phpsessid->FETCH(PDO::FETCH_ASSOC)['login'];
		$admin_flag = $user_by_phpsessid->FETCH(PDO::FETCH_ASSOC)['admin_flag'];
		break;
	default:
		echo "<p>ERROR: $count_users users have been returned for this request, but there must be one!</p>";
		// нужно прервать завершить сессию и сообщить о проблеме
		exit(1);
}

$page_link = $_GET['link'];

$page_by_link = $pdo->prepare("SELECT `pages`.`name`,`pages`.`text`,`pages`.`template` FROM `pages` WHERE (`pages`.`link` = :page_link AND `pages`.`public_flag` = 1) OR (`pages`.`link` = :page_link AND :admin_flag);");
$page_by_link->bindValue(':page_link', $page_link, PDO::PARAM_STR);
$page_by_link->bindValue(':admin_flag', $admin_flag, PDO::PARAM_STR);
$page_by_link->execute();
$count_pages = $page_by_link->rowCount();

var_dump($page_by_link);

switch($count_pages) {
	case '0':
		$error_output = 1;
		$page_title = "Ошибка 403";
		$page_content = "<p>У вас нет прав, для просмотра этой страницы.</p><p>Пройдите <a href='login?refer=$page_link'>авторизацию</a>.</p>";
		$page_template = "standart";
		break;
	case '1':
		$error_output = 0;
		$page_title = $page_by_link->FETCH(PDO::FETCH_ASSOC)['name'];
		$page_content = $page_by_link->FETCH(PDO::FETCH_ASSOC)['text'];
		$page_template = $page_by_link->FETCH(PDO::FETCH_ASSOC)['template'];
		break;
	default:
		$error_output = 1;
		$page_title = "Ошибка!";
		$page_content = "<p>ERROR: $count_pages pages have been returned for this request, but there must be one!</p>";
		$page_template = "standart";
		break;
}

if ($DEBUG) {
	echo "<p>count_pages: ".$count_pages."</p>";
	echo "<p>page_link: ".$page_link."</p>";
	echo "<p>page_title: ".$page_title."</p>";
	echo "<p>page_template: ".$page_template."</p>";
}

switch($page_template){
	case 'main': include_once("modules/template_main.php"); break;
	case 'standart': include_once("modules/template_standart.php"); break;
	case 'contacts': include_once("modules/template_contacts.php"); break;
	case 'block': include_once("modules/template_block.php"); break;
	case 'blank': include_once($page_content); break;
	case 'section2': include_once("modules/template_section.php"); break;
	default:
		$error_output = 1;
	    $page_title = "Ошибка!";
		$page_content = "Шаблон \"<b>".$page_template."</b>\" для страницы <b>".$page_link."</b> отсутствует";
		include_once("modules/template_standart.php");
		break;
}
?>