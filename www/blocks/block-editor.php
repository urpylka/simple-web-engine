<? include_once 'blocks/block-sitemap.php'; ?>
<article>
	<section>
		<h1 class="tape"><?=$page_title?></h1>
		<?

		if ( $admin_flag ) {
			$list_tmpl = $pdo->query("SELECT `templates`.`id`,`templates`.`name` FROM `templates`;")->FetchAll();
			?>
			<div>
				<p>В карте сайта отображаются только два уровня вложенность и все страницы которые помечены флагом 'public'. Пока что карта сайта фиксирована на по высоте и носит "заметочный" характер.</p>
				<li class="toggle2"><a href="#">Показать карту сайта</a></li>
			</div>

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
			<table width="930px" style="margin-top:10px;margin-bottom:-22px;" class="marg30">
				<tr>
					<td width="160px">
						Выбрано: 0
					</td>
					<td width="80px" style="font-size:14px;">
						<input type="submit" value="Private" />
					</td>
					<td width="100px">
						<input type="submit" value="Drop" />
					</td>
					<td width="240px" style="font-size:14px;">
						Parent: <input type="text" />
					</td>
					<td width="350px">
						<div id="editor_status" style="font-size:14px;"></div>
					</td>
				</tr>
			</table>	
			<br>	
			<br>
			<div>
				<b>Функционал не полностью введен в эксплуатацию!</b>
				<p>Пока что работает: создание новой страницы, отображение созданных страниц. Также при создании новой страницы она по умолчанию получается public. Для редактирования или удаления страницы, нужно перейте на неё, и если используется шаблон 'standart' -> появится интерфейс редактора.</p>
			</div>
			<br>
			<table width=100%>
				<thead>
					<tr>
						<th class="slct">S</th>
						<th class="id">ID</th>
						<th class="prnt">P</th>
						<th class="name2">Name</th>
						<th class="link">Address</th>
						<th class="tmpl">Template</th>
						<th class="publ">Pr</th>
						<th class="butt"></th>
					</tr>
				</thead>
				<form method="post" action="redactor?act=new">
					<tr>
						<td class="slct"></td>
						<td class="id"></td>
						<td><input type="text" name="prnt" value="1" style="width:20px;" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></td>
						<td><input type="text" name="name" value="Name" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></td>
						<td><input type="text" name="link" value="new" onclick="if(this.value=='')this.value='';" onblur="if(this.value=='')this.value='';" /></td>
						<td id="new_page_prnt">
							<select id="tmpl" name="tmpl" onchange="select_template_for_new_page()">
							<?
							foreach ($list_tmpl as $tmpl) {
								echo("<option value=\"".$tmpl['id']."\">".$tmpl['name']."</option>");
							}
							?>
							</select>
						</td>
						<td class="publ"><input name="priv" value="1" type="checkbox" checked/></td>
						<td class="butt"><input type="submit" value="C" /></td>
					</tr>
				</form>

			<?
			#выводим страницы каталога
			
			function view_pages($list, $level, $list_tmpl) {

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
						<select id="template" onchange="update_template()">
						<?
						
						foreach ($list_tmpl as $tmpl) {
							if ($tmpl['id'] == $list['template']) {
								echo("<option value=\"".$tmpl['id']."\" selected>".$tmpl['name']."</option>");
							} else {
								echo("<option value=\"".$tmpl['id']."\">".$tmpl['name']."</option>");
							}
						}
						?>
						</select>
					</td>
					<td class="publ">
						<input id="public_flag" type="checkbox" onchange="update_public_flag()" <? if(!$list['public_flag']) {echo("checked");}?>/>
					</td>
					<td class="butt">
						<p>
							<input type="submit" value="D" />
						</p>
					</td>
				</tr>
				<?
			}

			// $first = $pdo->prepare("SELECT * FROM `pages` WHERE `template`='section' ORDER BY id ASC");
			$first = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = 0 ORDER BY id ASC");
			$first->execute();
			while($list_first = $first->FETCH(PDO::FETCH_ASSOC)) {
				view_pages($list_first, "", $list_tmpl);

				$second = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = :list_first_link ORDER BY id ASC");
				$second->bindValue(':list_first_link', $list_first['id'], PDO::PARAM_STR);
				$second->execute();
				while($list_second = $second->fetch(PDO::FETCH_ASSOC)) {
					view_pages($list_second, "&nbsp;&nbsp;&rarr;&nbsp;", $list_tmpl);

					$third = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = :list_second_link ORDER BY id ASC");
					$third->bindValue(':list_second_link', $list_second['id'], PDO::PARAM_STR);
					$third->execute();
					while($list_third = $third->fetch(PDO::FETCH_ASSOC)) {
						view_pages($list_third, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;", $list_tmpl);

						$fourth = $pdo->prepare("SELECT * FROM `pages` WHERE `pages`.`parent` = :list_third_link ORDER BY id ASC");
						$fourth->bindValue(':list_third_link', $list_third['id'], PDO::PARAM_STR);
						$fourth->execute();
						while($list_fourth = $fourth->fetch(PDO::FETCH_ASSOC)) {
							view_pages($list_third, "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;", $list_tmpl);
						}
					}
				}

			}
			?>
			</table>
			<?
		} else {
			// такая ситуация мб, если страница будет публичной, но ты не админ
			echo "<p>У вас нет прав для просмотра этой страницы.</p>"; }
	?>
	</section>
</article>
