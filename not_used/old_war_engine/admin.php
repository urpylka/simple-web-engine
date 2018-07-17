<?
    session_start(); // стартуем сессию
    include("config.php"); // подключаем файл с настройками
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
  <head>
    <title>Панель администрирования</title>
    <link rel="stylesheet"  type="text/css" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/css/admin.css" media="screen" />
    <link rel="stylesheet"  type="text/css" href="http://<? echo $_SERVER['HTTP_HOST']; ?>/css/selects.css" media="screen" />
    <script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jquery.selects.js"></script>
    <script type="text/javascript" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/js/jsScroll.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  </head>
  <body>
            <?
                ### Блок обработки данных, пришедших из формы авторизации ###
                // если в форму авторизации были занесены логин и пароль
                // И если сессионные переменные НЕзарегистрированы
                if(isset($_POST['login']) && isset($_POST['password'])
                && !isset($_SESSION['login']) && !isset($_SESSION['password']))
                    {
                    // Ищем в бд строку, сравнивая имеющиеся данные с полученными из формы
                    $admins = mysql_query("
                    SELECT * FROM admin
                    WHERE login = '". $_POST['login']."'
                    AND password = '".md5($_POST['password'])."'");
                    // если найдена хоть одна строка
                        if(mysql_numrows($admins))
						{
							// регистрируем сессионные переменные
							$_SESSION["login"] = $_POST['login'];
							$_SESSION["password"] = $_POST['password'];
							//убрал urpylka 1.04.2016 тк эти функции больше не поддерживаются http://www.adodo.ru/blog/web_code/41.html
							//if (!session_register("login")) die("Session var login not registered");
							//if (!session_register("password")) die("Session var login not registered");
							if (!$_SESSION["login"]) die("Session var login not registered");
							if (!$_SESSION["password"]) die("Session var passsword not registered");
							//echo $_SESSION['login']."@".$_SESSION['password'];
						}
                        // Иначе выводим предупреждение и форму авторизации
                        else{
                              include("tpl/login_form.php");
                              echo "<center><p class=\"error\">Вы ввели неправильный логин или пароль!</p></center>";}
                    }
                  // Иначе выводим форму авторизации
                  else if(!isset($_SESSION['login']) && !isset($_SESSION['password'])) include("tpl/login_form.php");

                  ### Блок управления сайтом ###
                  // Если есть сессионные переменные
                  if(isset($_SESSION['login']) && isset($_SESSION['password']))
                  {
				  // Ищем в бд строку, сравнивая имеющиеся данные, с сессионными переменными
                          $admins = mysql_query ("
                          SELECT * FROM admin
                          WHERE login = '".$_SESSION['login']."'
                          AND password = '".md5($_SESSION['password'])."'
                          ");
						 // echo "mysql_numrows: ".mysql_numrows($admins);
                      if(mysql_numrows($admins)) // если найдена хоть одна строка
                      {
                  ?>
        <div id="wrap">
              <div id="menu">
                  <ul>
                      <li><a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/admin/menu/">Меню</a></li><li><a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/admin/news/">Новости</a></li><li><a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/admin/change_pass/">Сменить пароль</a></li><li><a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/upldr/index.php" target="blank">Загрузчик</a></li><li><a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/admin/logout/">Выйти</a></li><li><a>Техподдержка: cap.ssau@gmail.com</a></li>
                  </ul>
                  <div class="corner bl"></div>
                  <div class="corner br"></div>
				</div>
<?
        if(isset($_GET['action']))
        {
            if($_GET['action'] == "pages") include("modules/pages.php");
            if($_GET['action'] == "menu") include("modules/menu.php");
            if($_GET['action'] == "news") include("modules/news.php");
            if($_GET['action'] == "change_pass") include("modules/change_pass.php");
            if($_GET['action'] == "logout") {
                    if(isset($_SESSION['login']) && isset($_SESSION['password'])) // если существуют сессионные переменные login и password
                      {
                          session_unregister("login"); // удаляем
                          session_unregister("password"); // удаляем
                          unset ($_SESSION['login'],$_SESSION['password']);// удаляем
                          session_destroy();// убиваем сессию
                          echo "<center><p style=\"color:green;\">Выход из системы произведен успешно!<br />Чтобы войти в систему заново, Вам нужно <a href=\"http://".$_SERVER['HTTP_HOST']."/admin/\">ввести логин и пароль</a>.</p></center>";
                      }
            }
        }
    }
    // Иначе выводим предупреждение и форму авторизации
    else{
    echo "<center><p class=\"error\">Вы ввели неправильный логин или пароль!</p><br /></center>";
    include("tpl/login_form.php");}
}
### Конец блока управления каталогом ###
?>
      </div>
  </body>
</html>