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
				<td class="slct">
					<input type="checkbox"/>
				</td>
				<td class="id">
					<?echo $list['id'];?>
				</td>
				<td class="prnt">
					<?echo $list['parent'];?>
				</td>
				<td class="name2">
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
				<td class="tmpl">
					<?echo $list['template'];?>
				</td>
				<td class="publ">
					<?echo $list['public_flag'];?>
					<input name="private" type="checkbox"/>
				</td>
				<td class="butt">
					<p>
						<input type="submit" value="D"/>
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
				.slct, .publ, .butt, .id, .prnt {
					text-align: center;
				}
				table {
					border-collapse: collapse;
					line-height: 1.1;

				}
				th, td {
					border: 1px solid orange;
					padding: 10px;
					text-align: left;
					font: 10px sans-serif;
				}
				th {
					background: #ffe499;

				}
				</style>
				<!-- <p align="right">Выбрано: 0 <input type="submit" value="D"/></p>
				<br> -->
				<table width=100%>
					<thead>
						<tr>
							<th class="slct"></th>
							<th class="id">ID</th>
							<th class="prnt">P</th>
							<th class="name2">Название</th>
							<th class="link">Адрес</th>
							<th class="tmpl">Шаблон</th>
							<th class="publ">Pub</th>
							<th class="butt"></th>
						</tr>
					</thead>
					<form method="post" action="redactor?act=new">
						<tr>
							<td class="slct"></td>
							<td class="id"></td>
							<td class="prnt"></td>
							<td><input type="text" name="name" value="Новая страница" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></td>
							<td><input type="text" name="link" value="Введите адрес" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></td>
							<td class="tmpl">
								<select name="template">
									<!-- <option disabled>Select template</option> -->
									<option selected value="standart">standart</option>
									<option value="block">block</option>
									<option value="main">main</option>
									<option value="contacts">contacts</option>
									<option value="blank">blank</option>
									<option value="section2">section2</option>
								</select>
							</td>
							<td class="publ"><input name="public" type="checkbox"/></td>
							<td class="butt"><input type="submit" value="C"/></td>
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
						if ( isset($_POST['link']) && count($_POST) > 1 )
						{
							$page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :post_link;");
							$page_by_link->bindValue(':post_link', $_POST['link'], PDO::PARAM_STR);
							$page_by_link->execute();
							$count_pages = $page_by_link->rowCount();

							switch($count_pages) {
								case '0':
									echo("<p>ERROR: No pages were found in the database for this query.</p>");
									break;
								case '1':
									
									$response = NULL;

									if (isset($_POST['new_name'])) {
										$update_name = $pdo->prepare("UPDATE `pages` SET `name` = :post_new_name WHERE `id` = :id;");
										$update_name->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
										$update_name->bindValue(':post_new_name', $_POST['new_name'], PDO::PARAM_STR);

										if ($update_name->execute()) $response += "<p style='margin-left:30px;'>The name was updated!</p>";
										else $response += "<p>ERROR: Could not update the name!</p>";
									}
									if (isset($_POST['new_text'])) {
										$update_text = $pdo->prepare("UPDATE `pages` SET `text` = :post_new_text WHERE `id` = :id;");
										$update_text->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
										$update_text->bindValue(':post_new_text', $_POST['new_text'], PDO::PARAM_STR);

										if ($update_text->execute()) $response += "<p style='margin-left:30px;'>The 'text' was updated!</p>";
										else $response += "<p>ERROR: Could not update the 'text'!</p>";
									}
									if (isset($_POST['new_tmpl'])) {
										// проверка существования шаблона
										$update_tmpl = $pdo->prepare("UPDATE `pages` SET `template` = :post_new_tmpl WHERE `id` = :id;");
										$update_tmpl->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
										$update_tmpl->bindValue(':post_new_tmpl', $_POST['new_tmpl'], PDO::PARAM_INT);

										if ($update_tmpl->execute()) $response += "<p style='margin-left:30px;'>The 'template' was updated!</p>";
										else $response += "<p>ERROR: Could not update the 'template'!</p>";
									}
									if (isset($_POST['new_prnt'])) {
										// проверка существования и мб типа родителя (хотя тип может быть любым)
										$update_prnt = $pdo->prepare("UPDATE `pages` SET `parent` = :post_new_prnt WHERE `id` = :id;");
										$update_prnt->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
										$update_prnt->bindValue(':post_new_prnt', $_POST['new_prnt'], PDO::PARAM_INT);

										if ($update_prnt->execute()) $response += "<p style='margin-left:30px;'>The 'parent' was updated!</p>";
										else $response += "<p>ERROR: Could not update the 'parent'!</p>";
									}
									if (isset($_POST['new_publ'])) {
										$update_publ = $pdo->prepare("UPDATE `pages` SET `public_flag` = :post_new_publ WHERE `id` = :id;");
										$update_publ->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
										$update_publ->bindValue(':post_new_publ', $_POST['new_publ'], PDO::PARAM_INT);

										if ($update_publ->execute()) $response += "<p style='margin-left:30px;'>The 'public_flag' was updated!</p>";
										else $response += "<p>ERROR: Could not update the 'public_flag'!</p>";
									}
									if (isset($_POST['new_link'])) {
										// проверка занятости адреса
										$update_link = $pdo->prepare("UPDATE `pages` SET `link` = :post_new_link WHERE `id` = :id;");
										$update_link->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
										$update_link->bindValue(':post_new_link', $_POST['new_link'], PDO::PARAM_STR);

										if ($update_link->execute()) $response += "<p style='margin-left:30px;'>The 'link' was updated!</p>";
										else $response += "<p>ERROR: Could not update the 'link'! Maybe that is busy. Field is unice</p>";
									}
									echo($response);
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
