<article>
	<section class="text-content" id="fullpage">
		<h1><?=$page_title?></h1>
		<?

		function view_login_form() {
			?>
			<div>Введите учетные данные</div>
			<form method="post" action="login?act=login<?echo(isset($_GET['refer'])?"&refer=".$_GET['refer']:"");?>">
				<input type="text" name="login" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
				<input type="password" name="password" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
				<input type="submit" value="Войти" />
			</form>
			
			<div>Регистрация</div>
			<form method="post" action="login?act=register">
				<input type="text" name="login" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
				<input type="password" name="password" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
				<input type="submit" value="Зарегестрироваться" />
			</form>
			<?
		}

		function view_login() {
			?>
			<div>Вы успешно авторизованы! Под логином: <?=$GLOBALS['login']?></div>
			<?=isset($_GET['refer'])?"<div>Нажмите <a href='".$_GET['refer']."'>сюда</a>, чтобы вернуться на предущую страницу.</div>":""?>
			<div><a href="login?act=logout">Выйти</div>
			<?
		}

		if ( isset($_GET['act']) ) {
			switch ($_GET['act']) {
				case "change":
					// if(!isset($_GET['op'])) { 
					//   <div id="workzone">
					// 	<div class="corner tl"></div>
					// 	<div class="corner tr"></div>
					// 	<form method="post" action="http://=$_SERVER['HTTP_HOST']/admin/change_pass/new/">
					// 		<div class="field"><input type="text" name="login" />&larr; Логин</div>
					// 		<div class="field"><input type="text" name="old_pass" />&larr; Старый пароль</div>
					// 		<div class="field"><input type="text" name="new_pass" />&larr; Новый пароль</div>
					// 		<div class="field"><input type="submit" value="Изменить пароль" /></div>
					// 	  </form>
					// 	<div class="corner bl"></div>
					// 	<div class="corner br"></div>
					//   </div>
					//
					// }
					
					// #обработка изменения пароля
					// if($_GET['op'] == 'new'){
					// 		// если введены логин и пароль и они совпадают
					// 	if($_POST['old_pass'] == $_SESSION['password'])  
					// 	{      
					// 		//  обновляем БД  
					// 		$query = mysql_query("  
					// 		UPDATE admin
					// 		SET login = '".$_POST['login']."',   
					// 		password = '".md5($_POST['new_pass'])."'
					// 		");  
					// 		// если успешно, то...  
					// 		if ($query) {echo "<center><strong> 
					// 		Обновление данных успешно завершено</strong></center>";}
					// 		else { echo "<center><strong> 
					// 		Не удалось обновить данные</strong></center>";}
					// 		unset ($_SESSION['login'],$_SESSION['password']);// удаляем 
					// 		$login = $_POST['login']; 
					// 		$password = $_POST['new_pass']; 
					// 		session_register("login"); 
					// 		session_register("password"); 
						
					// 	}
					// 	else {echo "<center><strong>Старый пароль введен неверно</strong></center>";}
					// }
				case "logout":


					// if(@$_GET['action'] == "logout") // если в адресной строке переменная action равна "logout" 
					// {                                             
					// 	if(isset($_SESSION['login']) && isset($_SESSION['password'])) // если существуют сессионные переменные login и password 
					// 	{ 
					// 		session_unregister("login"); // удаляем 
					// 		session_unregister("password"); // удаляем 
					// 		unset ($_SESSION['login'],$_SESSION['password']);// удаляем 
					// 		session_destroy();// убиваем сессию
							
					// 	} 
					// }


					if ( ! isset($login) ) { echo "<p>Ошибка! Вы не можете выйти тк не еще залогинены.</p>"; view_login_form(); }
					else {
						$drop_session = $pdo->prepare("DELETE FROM `sessions` WHERE `sessions`.`phpsessid` = :phpsessid;");
						$drop_session->bindValue(':phpsessid', session_id(), PDO::PARAM_STR);
						if ( $drop_session->execute() )
						{
							session_unset();
							session_destroy();
							view_login_form();
						}
						else { echo "<p>Ошибка! Не удалось завершить сессию.</p>"; }
					}
					break;
				case "login":
					if ( isset($_POST['login']) && isset($_POST['password']) ) {
						if ( isset($login) ) {
							echo "<p>Ошибка! Вы не можете залогиниться, тк уже авторизованы под логином: ".$login."</p>";
							view_login();
						}
						else {
							// получить (по логину) pbkdf2 правило для проверки пароля по хешу
							// https://docs.djangoproject.com/en/2.1/topics/auth/passwords/
							// http://php.net/manual/en/function.hash-pbkdf2.php
		
							$pbkdf2_by_login = $pdo->prepare("SELECT `users`.`pbkdf2` FROM `users` WHERE `users`.`login` = :login;");
							$pbkdf2_by_login->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
							$pbkdf2_by_login->execute();
							$count_pbkdf2 = $pbkdf2_by_login->rowCount();
		
							switch($count_pbkdf2) {
								case '0':
								echo "<div>Вы ввели неправильный логин или пароль!</div>";
								view_login_form();
								break;
								case '1':
								// <algorithm>$<iterations>$<salt>$<hash>
								$pbkdf2 = explode('$', $pbkdf2_by_login->FETCH(PDO::FETCH_ASSOC)['pbkdf2']);
								if ( ! isset($pbkdf2['3']) || isset($pbkdf2['4']) ) { echo "<p>Системная ошибка! Неккоретный pbkdf2 в БД.</p>"; }
								else {
									// проверить пароль
									if ( $pbkdf2['3'] != hash_pbkdf2($pbkdf2['0'], $_POST['password'], $pbkdf2['2'], $pbkdf2['1'], 20) ) {
										echo "<div>Вы ввели неправильный логин или пароль!</div>";
										view_login_form();
									}
									else {
										// в случае успеха присвоить сессии user_id
										$pbkdf2_by_login = $pdo->prepare("INSERT INTO `sessions` (`login`,`phpsessid`) VALUES (:login, :session_id);");
										$pbkdf2_by_login->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
										$pbkdf2_by_login->bindValue(':session_id', session_id(), PDO::PARAM_STR);
										if ( $pbkdf2_by_login->execute() ) { $login = $_POST['login']; view_login(); }
										else { echo "<p>Ошибка! Не удалось привязать сессию к пользователю.</p>"; view_login_form(); }
									}
								}
								break;
								default:
								echo "<p>ERROR: Системная ошибка. По запросу логина найдено ".$count_pbkdf2." записей!</p>";
								view_login_form();
								break;
							}
						}
					}
					// else echo "Вы не ввели логин или пароль"
					break;
				case "register":
					if ( isset($login) ) { echo "<p>Ошибка! Вы не можете зарегистрироваться тк уже авторизованы под логином: ".$login.".</p>"; view_login(); }
					else {
						if ( isset($_POST['login']) && isset($_POST['password']) ) {

							// проверяем существует ли пользователь
							$user_exist = $pdo->prepare("SELECT COUNT(*) FROM `users` WHERE `users`.`login` = :login;");
							$user_exist->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
							$user_exist->execute();

							if ( $user_exist->FETCH(PDO::FETCH_NUM)['0'] != 0 )
							{ echo "<p>Ошибка! Имя пользователя <b>".$_POST['login']."</b> занято</p>"; }
							else {

								// Generate a random IV using openssl_random_pseudo_bytes()
								// random_bytes() or another suitable source of randomness
								$salt = bin2hex(openssl_random_pseudo_bytes(8));
								$password = $_POST['password'];
								$iterations = 1000;
								$hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 20);
								// <algorithm>$<iterations>$<salt>$<hash>
								$pbkdf2 = "sha256\$".$iterations."\$".$salt."\$".$hash;
								
								$user_add = $pdo->prepare("INSERT INTO `users` (`login`,`pbkdf2`) VALUES (:login, :pbkdf2);");
								$user_add->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
								$user_add->bindValue(':pbkdf2', $pbkdf2, PDO::PARAM_STR);

								if ( $user_add->execute() ) { echo "<p>Пользователь <b>".$_POST['login']."</b> успешно добавлен.</p>"; }
								else  { echo "<p>Ошибка при добавлении пользователя <b>".$_POST['login']."</b>.</p>"; }
							}
						}
						else {
							echo "<p>Вы не ввели логин или пароль. Запрос некорректен!</p>";
						}
					}
					break;
				default:
					echo "<p>Ошибка - ты чего хочешь?</p>";
					break;
			}
			
		}
		else {
			if ( isset($login) ) { view_login(); }
			else { view_login_form(); }
		}
		?>
	</section>
</article>
