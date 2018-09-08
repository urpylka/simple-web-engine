<article>
	<section class="text-content" id="fullpage">
		<h1><?=$page_title?></h1>
		<?
		if ( isset($_GET['act']) ) {
			switch ($_GET['act']) {
				case "logout":
				if ( ! isset($login) ) { echo "<p>Ошибка! Вы не можете выйти тк не еще залогинены.</p>"; }
				else {
					session_unset();
					session_destroy();
					// по идеи надо сделать удаление из БД
				}
				break;
				case "login":
				if ( isset($_POST['login']) && isset($_POST['password']) ) {
					if ( isset($login) ) {
						echo "<p>Ошибка! Вы не можете залогиниться, тк уже авторизованы под логином: ".$login."</p>";
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
								?>
								<div>Вы ввели неправильный логин или пароль!</div>
								<form method="post" action="login?act=login">
									<input type="text" name="login" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
									<input type="password" name="password" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
									<input type="submit" value="Войти" />
								</form>
								<?
								break;
							case '1':
								// <algorithm>$<iterations>$<salt>$<hash>
								$pbkdf2 = explode('$', $pbkdf2_by_login->FETCH(PDO::FETCH_ASSOC)['pbkdf2']);
								if ( ! isset($pbkdf2['3']) ) { echo "<p>Системная ошибка! Неккоретный pbkdf2 в бд.</p>"; }
								else {
									// проверить пароль
									if ( $pbkdf2['4'] != hash_pbkdf2($pbkdf2['1'], $_POST['password'], $pbkdf2['3'], $pbkdf2['2'], 20) ) {
										?>
										<div>Вы ввели неправильный логин или пароль!</div>
										<form method="post" action="login?act=login">
											<input type="text" name="login" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
											<input type="password" name="password" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
											<input type="submit" value="Войти" />
										</form>
										<?
									}
									else {
										// в случае успеха присвоить сессии user_id
										$pbkdf2_by_login = $pdo->prepare("INSERT INTO `sessions` (`login`,`phpsessid`) VALUES (:login, :session_id);");
										$pbkdf2_by_login->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
										$pbkdf2_by_login->bindValue(':session_id', session_id(), PDO::PARAM_STR);
										if ( $pbkdf2_by_login->execute() )
										{
											echo("<div>Вы успешно авторизованы! ".$_POST['login']."</div>");
											echo(isset($_GET['refer'])?"<div>Нажмите <a href='".$_GET['refer']."'>сюда</a>, чтобы вернуться на предущую страницу.</div>":"");
											?>
											<div><a href="login?act=logout">Выйти</div>
											<?
										}
										else { echo "<p>Ошибка! Не удалось привязать сессию к пользователю.</p>"; }
									}
								}
								break;
							default:
								echo "<p>ERROR: Системная ошибка. По запросу логина найдено ".$count_pbkdf2." записей!</p>";
								break;
						}
					}
				}
				// else echo "Вы не ввели логин или пароль"
				break;
				case "registr":
				if ( isset($login) ) { echo "<p>Ошибка! Вы не можете зарегистрироваться тк уже авторизованы под логином: ".$login.".</p>"; }
				else {
					if ( isset($_POST['login']) && isset($_POST['password']) ) {

						// проверяем существует ли пользователь
						$user_exist = $pdo->prepare("SELECT COUNT(*) FROM `users` WHERE `users`.`login` = :login;");
						$user_exist->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
						$user_exist->execute();

						if ( $user_exist->FETCH(PDO::FETCH_NUM)['0'] != 0 )
						{ echo "<p>Ошибка! Имя пользователя занято</p>"; }
						else {

							// Generate a random IV using openssl_random_pseudo_bytes()
							// random_bytes() or another suitable source of randomness
							$salt = openssl_random_pseudo_bytes(16);
							$password = $_POST['password'];
							$iterations = 1000;
							$hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 20);
							// <algorithm>$<iterations>$<salt>$<hash>
							$pbkdf2 = "sha256$".$iterations.'$'.$salt.'$'.$hash;
							$user_add = $pdo->prepare("INSERT INTO `users` (`login`,`pbkdf2`) VALUES (:login, :pbkdf2);");
							$user_add->bindValue(':login', $_POST['login'], PDO::PARAM_STR);
							$user_add->bindValue(':pbkdf2', $pbkdf2, PDO::PARAM_STR);

							try {
								$user_add->execute();
								if ( $user_add->execute() ) { echo "<p>Пользователь ".$_POST['login']." успешно добавлен.</p>"; }
								else  { echo "<p>Ошибка при добавлении пользователя ".$_POST['login'].".</p>"; }
							}
							catch (PDOException $e) {
								echo 'ERROR: ' . $e->getMessage();
							}
						}
					}
					// else echo "Вы не ввели логин или пароль"
				}
				break;
				default:
				echo "<p>Ошибка - ты чего хочешь?</p>";
				break;
			}
			
		}
		else {
			if ( isset($login) ) {
				echo("<div>Вы успешно авторизованы! ".$_SESSION['login']."</div>");
				?>
					<div><a href="login?act=logout">Выйти</a></div>
				<?
			}
			else {
				?>
				<div>Введите учетные данные</div>
				<form method="post" action="login?act=login<?echo(isset($_GET['refer'])?"&refer=".$_GET['refer']:"");?>">
					<input type="text" name="login" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
					<input type="password" name="password" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
					<input type="submit" value="Войти" />
				</form>
				<?
			}
		}
		?>
	</section>
</article>
