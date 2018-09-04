<?
if(!isset($_GET['op'])) { ?>
  <div id="workzone">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <form method="post" action="http://<?=$_SERVER['HTTP_HOST']?>/admin/change_pass/new/">
        <div class="field"><input type="text" name="login" />&larr; Логин</div>
        <div class="field"><input type="text" name="old_pass" />&larr; Старый пароль</div>
        <div class="field"><input type="text" name="new_pass" />&larr; Новый пароль</div>
        <div class="field"><input type="submit" value="Изменить пароль" /></div>
      </form>
    <div class="corner bl"></div>
    <div class="corner br"></div>
  </div>
<?
}

#обработка изменения пароля
if($_GET['op'] == 'new'){
        // если введены логин и пароль и они совпадают
    if($_POST['old_pass'] == $_SESSION['password'])  
    {      
        //  обновляем БД  
        $query = mysql_query("  
        UPDATE admin
        SET login = '".$_POST['login']."',   
        password = '".md5($_POST['new_pass'])."'
        ");  
        // если успешно, то...  
        if ($query) {echo "<center><strong> 
        Обновление данных успешно завершено</strong></center>";}
        else { echo "<center><strong> 
        Не удалось обновить данные</strong></center>";}
        unset ($_SESSION['login'],$_SESSION['password']);// удаляем 
        $login = $_POST['login']; 
        $password = $_POST['new_pass']; 
        session_register("login"); 
        session_register("password"); 
  
    }
    else {echo "<center><strong>Старый пароль введен неверно</strong></center>";}
}
?>