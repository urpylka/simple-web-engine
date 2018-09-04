<article>
	<section class="text-content" id="fullpage">
		<h1><?=$name?></h1>
		<?
		// ВЫХОД
		if($_GET['action'] == "logout" && isset($_SESSION['login']))
		{
			session_unset();
			session_destroy();
		}
		// АВТОРИЗАЦИЯ
		if(isset($_POST['login']) && isset($_POST['password']) && !isset($_SESSION['login']))
		{
			$users = mysql_query("
			SELECT * FROM users
			WHERE login = '". $_POST['login']."'
			AND password = '".md5($_POST['password'])."';");
			// если найдена хоть одна строка (admins - group_id='1')
			if(mysql_numrows($users)=="1")
			{
				// регистрируем сессионные переменные
				$_SESSION["login"] = $_POST['login'];
				$_SESSION["password"] = $_POST['password'];
				$_SESSION["group_id"] = mysql_fetch_assoc($users)['group_id'];
				//if (!$_SESSION["password"]) die("Session var passsword not registered");
				echo("<div>Вы успешно авторизованы! ".$_SESSION['login'].":".$_SESSION['group_id']."</div>");
				echo ("<div>".session_name().' = '.session_id()."</div>");
				//print_r($_GET);
				echo(isset($_GET['refer'])?"<div>Нажмите <a href='".$_GET['refer']."'>сюда</a>, чтобы вернуться на предущую страницу.</div>":"");
				?>
					<div><a href="login?action=logout">Выйти</div>
				<?
				/*
				здесь надо проверку с какого адреса пришел и если это этот сайт то (ссылку на переход на предыдущую страницу)
				*/
			}
			// Иначе выводим предупреждение и форму авторизации
			else{
				?>
				<div>Вы ввели неправильный логин или пароль!</div>
				<form method="post" action="login">
					<input type="text" name="login" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
					<input type="password" name="password" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
					<input type="submit" value="Войти" />
				</form>
				<?
			}
		}
		// Иначе выводим форму авторизации
		else if(!isset($_SESSION['login']))
		{
			?>
			<div>Введите учетные данные</div>
			<form method="post" action="login<?echo(isset($_GET['refer'])?"?refer=".$_GET['refer']:"");?>">
				<input type="text" name="login" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
				<input type="password" name="password" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" />
				<input type="submit" value="Войти" />
			</form>
		<?}
		else
		{
			//важным является то что сюда мы попадаем при повторной отправке данных
			echo("<div>Вы успешно авторизованы! ".$_SESSION['login'].":".$_SESSION['group_id']."</div>");
			echo ("<div>".session_name().' = '.session_id()."</div>");
			?>
				<div><a href="login?action=logout">Выйти</a></div>
			<?
		}
		?>
	</section>
</article>
