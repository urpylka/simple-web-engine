<? include_once 'modules/block_main_menu.php'; ?>
<article>
	<section class="text-content" id="fullpage">
		<h1><?=$page_title?></h1>
		<?

		function view_login() {
			?>
			<div>У вас нет доступа для промотра этой страницы! Создавать страницы могут только администраторы.</div>
			<?
		}

		function view_add_new_page() {
			?>
			<div><b>Функционал не введен в эксплуатацию!</b></div>
			<div><b>Создание новой страницы</b></div>
			<form method="post" action="redactor?act=new">
				<p>Введите адрес страницы <input type="text" name="link" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></p>
				<p>Введите название страницы <input type="text" name="name" value="" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></p>
				<p>Страница доступна только зарегистрированным пользователям <input name="private" type="checkbox"/></p>
				<input type="submit" value="Создать" />
			</form>

			<li class="toggle2"><a href="#">Показать карту сайта</a></li>
			<?
		}

		if ( ! isset($_GET['act']) ) {
			if ( $admin_flag ) { view_add_new_page(); }
			else {
				// такая ситуация мб, если страница будет публичной, но ты не админ
				echo "<p>У вас нет прав для просмотра этой страницы.</p>"; }
		} else {
			switch ($_GET['act']) {
				case "remove":
					if ( ! $admin_flag ) { echo "<p>Ошибка! Только администраторы могут удалять страницы.</p>"; }
					else {
						//echo "<p>Ошибка! Проверка можно ли удалить страницу.</p>";

						// удаляем
					}
					break;
				case "update":
					if ( ! $admin_flag ) { echo "<p>Ошибка! Только администраторы могут удалять страницы.</p>"; }
					else {
						if ( isset($_POST['moo_link']) && isset($_POST['moo_text']) )
						{
							$page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :moo_link;");
							$page_by_link->bindValue(':moo_link', $_POST['moo_link'], PDO::PARAM_STR);
							$page_by_link->execute();
							$count_pages = $page_by_link->rowCount();

							switch($count_pages) {
								case '0':
									echo("<p>ERROR: No pages were found in the database for this query.</p>");
									break;
								case '1':
									$update_page = $pdo->prepare("UPDATE `pages` SET `text` = :moo_text WHERE `id` = :id;");
									$update_page->bindValue(':moo_text', $_POST['moo_text'], PDO::PARAM_STR);
									$update_page->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
									if ($update_page->execute()) echo "<p style='margin-left:30px;'>The page was saved!</p>";
									else echo("<p>ERROR: Could not update the page!</p>");
									break;
								default:
									echo("<p>ERROR: $count_pages pages have been returned for this request, but there must be one!</p>");
									break;
							}
						}
						else echo("<p>ERROR: The post request is not correct!</p>");
					}
					break;
				case "create":
					if ( ! $admin_flag ) { echo "<p>Ошибка! Только администраторы могут удалять страницы.</p>"; }
					else {
						//fsdfgsdgsdgkodsgjiwgoi
					}

					break;
				default:
					echo "<p>Ошибка - ты чего хочешь?</p>";
					break;
			}	
		}
		?>
	</section>
</article>
