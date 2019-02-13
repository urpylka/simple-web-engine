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

		function view_pages($list, $level) {

			// level2 = "&nbsp;&nbsp;&rarr;&nbsp;";
			// level3 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;";
			// level4 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;";

			?>
			<script>$("td.name").dblclick(function() {alert("fadasf")});</script>
			<tr>
				<td class="select">
					<input type="checkbox"/>
				</td>
				<td class="id">
					<?echo $list['id'];?>
				</td>
				<td class="name">
					<?echo $level;?>
					<?echo $list['name'];?>
				</td>
				<td class="link">
					<p>
						<a href="http://<?echo $_SERVER['HTTP_HOST'];?>/<?echo $list['link'];?>">
							<?echo $list['link'];?>
						</a>
					</p>
				</td>
				<td class="template">
					<?echo $list['template'];?>
				</td>
				<td class="public">
					<?echo $list['public_flag'];?>
					<input name="private" type="checkbox"/>
				</td>
				<td class="remove">
					<p>
						<input type="submit" value="D" />
					</p>
				</td>
			</tr>
			<?
		}

		if ( ! isset($_GET['act']) ) {
			if ( $admin_flag ) {
			
				?>
				<li class="toggle2"><a href="#">Показать карту сайта</a></li>
				<br>
				<div><b>Функционал не введен в эксплуатацию!</b></div>
				<br>
				<style>
				table {
					border-collapse: collapse;
				}
				th, td {
					border: 1px solid orange;
					padding: 10px;
					text-align: left;
				}
				</style>
				<table width=100%>
					<tr>
						<td></td>
						<td>ID</td>
						<td>Название</td>
						<td>Адрес</td>
						<td>Шаблон</td>
						<td>Приватная</td>
						<td></td>
					</tr>
					<form method="post" action="redactor?act=new">
						<tr>
							<td></td>
							<td></td>
							<td><input type="text" name="name" value="Новая страница" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></td>
							<td><input type="text" name="link" value="Введите адрес" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></td>
							<td>Шаблон</td>
							<td><input name="private" type="checkbox"/></td>
							<td><input type="submit" value="C" /></td>
						</tr>
					</form>

				<?
				#выводим страницы каталога
				
				// $first = $pdo->prepare("SELECT * FROM `pages` WHERE `template`='section' ORDER BY id ASC");
				$first = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = 0 ORDER BY id ASC");
				$first->execute();
				while($list_first = $first->FETCH(PDO::FETCH_ASSOC)) {
					view_pages($list_first, "");

					$second = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = :list_first_link ORDER BY id ASC");
					$second->bindValue(':list_first_link', $list_first['id'], PDO::PARAM_STR);
					$second->execute();
					while($list_second = $second->fetch(PDO::FETCH_ASSOC)) {
						view_pages($list_second, "&nbsp;&nbsp;&rarr;&nbsp;");

						$third = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = :list_second_link ORDER BY id ASC");
						$third->bindValue(':list_second_link', $list_second['id'], PDO::PARAM_STR);
						$third->execute();
						while($list_third = $third->fetch(PDO::FETCH_ASSOC)) {
							view_pages($list_third, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;");

							$fourth = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = :list_third_link ORDER BY id ASC");
							$fourth->bindValue(':list_third_link', $list_third['id'], PDO::PARAM_STR);
							$fourth->execute();
							while($list_fourth = $fourth->fetch(PDO::FETCH_ASSOC)) {
								view_pages($list_third, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;");
							}
						}
					}

				}
				?>
				</table>
				<?
			
			
			}
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
