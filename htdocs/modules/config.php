<?
    $host='localhost';        #Хост 
    $login_mysql="root";      #Логин 
    $password_mysql="PASSWD";       #Пароль 
    $baza_name="my_war";   #Имя базы 
    $db = @mysql_connect("$host", "$login_mysql", "$password_mysql"); 
    if (!$db) exit("<center><p class=\"error\">К сожалению, не доступен сервер MySQL</p></center>"); 
    if (!@mysql_select_db($baza_name,$db)) exit("<center><p class=\"error\">К сожалению, не доступна база данных</p></center>");
    mysql_set_charset('utf8',$db); 
    
    #идентификаторы сайта
    $site_url = "http://war.ssau.ru";
    $adm_title = "Панель администрирования сайта";
    
    #идентификаторы CMS
    $cms_version = "v1.00";
    
?>
