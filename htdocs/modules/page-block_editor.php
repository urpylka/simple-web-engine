<? include_once 'modules/block_site_map.php'; ?>
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
	?>
	</section>
</article>
