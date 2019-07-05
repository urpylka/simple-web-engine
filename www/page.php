<?
error_reporting(E_ALL);
session_start();
header('Content-Type: text/html; charset=utf-8');

// SITE CONFIGS

$site_url = $_ENV["SITE_URL"];
$site_name = $_ENV["SITE_NAME"];

// Developer settings
$DEBUG = (boolean)$_ENV["SITE_DEBUG"];

// Database settings
$host = $_ENV["DB_HOST"];
$port = $_ENV["DB_PORT"];
$login_mysql = $_ENV["DB_USER_LOGIN"];
$password_mysql = $_ENV["DB_USER_PASSWD"];
$dbname = $_ENV["DB_NAME"];
$backup = $_ENV["DB_BACKUP_FILE"];

if ($DEBUG) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
}
else {
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
}

$needs_import = FALSE;

back:
try { $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",  $login_mysql,  $password_mysql); }
catch(PDOException $e) {

	// CREATE DATABASE IF NOT EXISTS
	function startsWith($haystack, $needle)
	{
		return strpos($haystack, $needle) === 0;
	}

	if (startsWith($e->getMessage(), "SQLSTATE[42000] [1049] Unknown database")) {

		$create = new mysqli($host, $login_mysql, $password_mysql);
		if (mysqli_connect_errno()) { // проверяем подключение
			echo "Connect failed: %s\n", mysqli_connect_error();
			exit(1);
		}
		if ($create->query("CREATE DATABASE ".$dbname.";") === FALSE) {
			echo "Error creating database: ".$create->error;
			$create->close();
			exit(1);
		} else {
			echo "Database created successfully.<br/>";
			$create->close();
			$needs_import = TRUE;
			goto back;
		}

	} else {
		if ($DEBUG) {
			echo "You have an error: ".$e->getMessage()."<br/>";
			echo "On line: ".$e->getLine();
		}
		exit(1);
	}
}

// CHECK TABLES IF NOT EXISTS -> IMPORT FROM BACKUP-FILE

/**
 * Check if a table exists in the current database.
 *
 * @param PDO $pdo PDO instance connected to a database.
 * @param string $table Table to search for.
 * @return bool TRUE if table exists, FALSE if no table found.
 */
function tableExists($pdo, $table) {

    // Try a select statement against the table
    // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
    try {
        $result = $pdo->query("SELECT 1 FROM $table LIMIT 1");
    } catch (Exception $e) {
        // We got an exception == table not found
        return FALSE;
    }

    // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    return $result !== FALSE;
}

// function check_table_for_exist($pdo, $table_name) {

// 	$check_table = $pdo->query("CHECK TABLE pages;");
// 	$check_table = $check_table->fetch(PDO::FETCH_ASSOC);
// 	if (($check_table['Msg_type'] == 'error') && ($check_table['Msg_text'] == "Table '".$dbname.".".$table_name."' doesn't exist")) {
// 		return FALSE;
// 	} else {
// 		return TRUE;
// 	}
// }


$tables = array("pages", "sessions", "templates", "top_menu", "users");
foreach ($tables as $value) {
	if (! tableExists($pdo, $value)) {
		$needs_import = TRUE;
		break;
	}
}

if ($needs_import) {

	$import = new mysqli($host, $login_mysql, $password_mysql, $dbname);
	if (mysqli_connect_errno()) { /* check connection */
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit(1);
	}

	if ($import->multi_query(file_get_contents($backup))) {
		echo "Tables imported successfully. Reload the page.";
		exit(0);

	} else {
		echo "Error importing database: ".$import->error;
		exit(1);
	}
	$import->close();
}

// THE MAIN LOGIC
$login = NULL;
$admin_flag = 0;

$user_by_phpsessid = $pdo->prepare("SELECT `users`.`login`,`users`.`admin_flag` FROM `users` INNER JOIN `sessions` ON `sessions`.`login` = `users`.`login` WHERE `sessions`.`phpsessid` = :phpsessid;");
$user_by_phpsessid->bindValue(':phpsessid', session_id(), PDO::PARAM_STR);
$user_by_phpsessid->execute();
$count_users = $user_by_phpsessid->rowCount();

switch($count_users) {
	case '0':
		break;
	case '1':
		$user_by_phpsessid = $user_by_phpsessid->FETCH(PDO::FETCH_ASSOC);
		$login = $user_by_phpsessid['login'];
		$admin_flag = $user_by_phpsessid['admin_flag'];
		break;
	default:
		echo "<p>ERROR: $count_users users have been returned for this request, but there must be one!</p>";
		// нужно прервать завершить сессию и сообщить о проблеме
		exit(1);
}

$page_link = $_GET['link'];

$page_by_link = $pdo->prepare("SELECT `pages`.`name`,`pages`.`text`,`pages`.`template`,`pages`.`public_flag`,`pages`.`id` FROM `pages` WHERE `pages`.`link` = :page_link AND ( `pages`.`public_flag` = 1 OR :admin_flag );");
$page_by_link->bindValue(':page_link', $page_link, PDO::PARAM_STR);
$page_by_link->bindValue(':admin_flag', $admin_flag, PDO::PARAM_STR);
$page_by_link->execute();
$count_pages = $page_by_link->rowCount();

switch($count_pages) {
	case '0':
		$error_output = 1;
		$page_title = "Ошибка 403";
		if ( isset($login) ) $page_content = "<p>У вас нет прав, для просмотра этой страницы.</p>";
		else $page_content = "<p>У вас нет прав, для просмотра этой страницы.</p><p>Пройдите <a href='login?refer=$page_link'>авторизацию</a>.</p>";
		$page_template = "1";
		break;
	case '1':
		$error_output = 0;
		$page_by_link = $page_by_link->FETCH(PDO::FETCH_ASSOC);
		$page_title = $page_by_link['name'];
		$page_content = $page_by_link['text'];
		$page_template = $page_by_link['template'];
		$page_public = $page_by_link['public_flag'];
		$page_id = $page_by_link['id'];
		break;
	default:
		$error_output = 1;
		$page_title = "Ошибка!";
		$page_content = "<p>ERROR: $count_pages pages have been returned for this request, but there must be one!</p>";
		$page_template = "1";
		break;
}

if ($DEBUG) {
	echo "<p>login: ".$login."</p>";
	echo "<p>admin_flag: ".$admin_flag."</p>";
	echo "<p>count_pages: ".$count_pages."</p>";
	echo "<p>page_link: ".$page_link."</p>";
	echo "<p>page_title: ".$page_title."</p>";
	echo "<p>page_template: ".$page_template."</p>";
	echo "<p>page_public: ".$page_public."</p>";
	echo "<p>session_id: ".session_id()."</p>";
}

$template = $pdo->prepare("SELECT `templates`.`path`,`templates`.`name` FROM `templates` WHERE `templates`.`id` = :tmpl_id;");
$template->bindValue(':tmpl_id', $page_template, PDO::PARAM_INT);
$template->execute();
$count_templates = $template->rowCount();

switch($count_templates) {
	case '0':
		$error_output = 1;
		$page_title = "Ошибка 500";
		$page_content = "Не найден шаблон под id=\"<b>".$page_template."</b>\" для страницы <b>".$page_link."</b> отсутствует.";
		include_once("templates/template-standart.php");
		break;
	case '1':
		$tmpl = $template->FETCH(PDO::FETCH_ASSOC);
		$filename = $tmpl['path'];
		$tmpl_name = $tmpl['name'];

		if (file_exists($filename)) include_once($filename);
		else {
			$error_output = 1;
			$page_title = "Ошибка 500";
			$page_content = "Шаблон \"<b>".$tmpl_name."</b>\" для страницы <b>".$page_link."</b> отсутствует.";
			include_once("templates/template-standart.php");
		}
		break;
	default:
		$error_output = 1;
		$page_title = "Ошибка 500";
		$page_content = "<p>ERROR: Системная ошибка при попытке получить шаблон страницы.</p>";
		include_once("templates/template-standart.php");
		break;
}
?>