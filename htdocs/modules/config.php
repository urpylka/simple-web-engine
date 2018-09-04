<?
    // Site settings
    $site_url = "http://war.ssau.ru";
    $site_name = "Военная кафедра";

    // Database settings
    $host = "localhost";
    $login_mysql = "root";
    $password_mysql = "PASSWD";
    $database = "my_war";

    $db = @mysql_connect("$host", "$login_mysql", "$password_mysql"); 
    if (!$db) exit("<center><p class=\"error\">К сожалению, не доступен сервер MySQL</p></center>"); 
    if (!@mysql_select_db($database,$db)) exit("<center><p class=\"error\">К сожалению, не доступна база данных</p></center>");
    mysql_set_charset('utf8',$db); 
?>
