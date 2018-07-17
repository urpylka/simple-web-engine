<?
if(@$_GET['action'] == "logout") // если в адресной строке переменная action равна "logout" 
{                                             
    if(isset($_SESSION['login']) && isset($_SESSION['password'])) // если существуют сессионные переменные login и password 
    { 
        session_unregister("login"); // удаляем 
        session_unregister("password"); // удаляем 
        unset ($_SESSION['login'],$_SESSION['password']);// удаляем 
        session_destroy();// убиваем сессию
        
    } 
} 
?>