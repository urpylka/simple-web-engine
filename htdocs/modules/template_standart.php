<!-- <script src='http://localhost/jquery-3.3.1.min.js'></script> -->

<script type="text/javascript" src="mooeditable/Demos/assets/mootools.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.UI.MenuList.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.Extras.js"></script>

<script language="javascript" type="text/javascript">

	window.addEvent('domready', function() {

		// document.getElementById('textarea1').mooEditable({
		// 	actions: 'bold italic underline strikethrough | formatBlock justifyleft justifycenter justifyright justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo removeformat | createlink unlink | urlimage | toggleview'
		// });

		document.getElementById("editor_area").setAttribute("style", "display:none;");
		document.getElementById("save_button").setAttribute('disabled', '');

		$('#page_link_field').dblclick(function() {
			if( $('#page_link_field').attr('contenteditable') !== undefined ) {
				$('#page_link_filed').removeAttr('contenteditable');
				update_link();
			} else {
				$('#page_link_field').attr('contenteditable', '');
			};
		});

		$('#page_title').dblclick(function() {
			if( $(this).attr('contenteditable') !== undefined ) {
				$(this).removeAttr('contenteditable');
				update_name();
			} else {
				$(this).attr('contenteditable', '');
			};
		});

		// если нажать enter все равно запишется <br>
		$('#page_title').keydown(function(e) {
			if (e.keyCode === 13 || e.keyCode === 27) {
				if( $(this).attr('contenteditable') !== undefined ) {
					$(this).removeAttr('contenteditable');
					update_name();
				} else {
					// $(this).attr('contenteditable', '');
				};
			}
		});
	});

	function show_status(message) {
		document.getElementById("editor_status").innerHTML = message;

		function disappear() {
			document.getElementById("editor_status").style.display = 'block'; // показываем .loader
			setTimeout(function() {
				document.getElementById("editor_status").style.display = 'none'; // скрываем .loader
			}, 2000); // зарежка перед скрытием в миллисекундах
		}
		disappear();
	}


	function update_template() {
		var request;

		try { request = new XMLHttpRequest(); }
		catch (trymicrosoft)
		{
			try { request = new ActiveXObject("Msxml2.XMLHTTP"); }
			catch (othermicrosoft)
			{
				try { request = new ActiveXObject("Microsoft.XMLHTTP"); }
				catch (failed) { request = false; }
			}
		}
		if (!request) alert("Error initializing XMLHttpRequest!");

		function updateStatus() {
			if (request.readyState == 4) {
				if (request.status == 200) {
					var response = request.responseText;
					show_status(response);
					// alert(response);
					//var response = request.responseText.split("|");
					//document.getElementById("order").value = response[0];
					//document.getElementById("address").innerHTML = response[1].replace(/\n/g, "<br />");
				} else if (request.status == 404) {
					show_status("Requested URL is not found.");
				} else if (request.status == 403) {
					show_status("Access denied.");
				} else {
					show_status("Server return status: " + request.status);
				}
			}
		}

		var tmpl = 1;
		var selind = document.getElementById("template").options.selectedIndex;
   		var tmpl= document.getElementById("template").options[selind].value;

		var url = "redactor?act=update";
		var data = "link=<?=$page_link?>&new_tmpl="+tmpl;
		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		request.onreadystatechange = updateStatus;
		request.send(data);

		return false;
	};


	function update_public_flag() {
		var request;

		try { request = new XMLHttpRequest(); }
		catch (trymicrosoft)
		{
			try { request = new ActiveXObject("Msxml2.XMLHTTP"); }
			catch (othermicrosoft)
			{
				try { request = new ActiveXObject("Microsoft.XMLHTTP"); }
				catch (failed) { request = false; }
			}
		}
		if (!request) alert("Error initializing XMLHttpRequest!");

		function updateStatus() {
			if (request.readyState == 4) {
				if (request.status == 200) {
					var response = request.responseText;
					show_status(response);
					// alert(response);
					//var response = request.responseText.split("|");
					//document.getElementById("order").value = response[0];
					//document.getElementById("address").innerHTML = response[1].replace(/\n/g, "<br />");
				} else if (request.status == 404) {
					show_status("Requested URL is not found.");
				} else if (request.status == 403) {
					show_status("Access denied.");
				} else {
					show_status("Server return status: " + request.status);
				}
			}
		}

		var flag = 0;
		if (document.getElementById("public_flag").hasAttribute("checked")) {
			flag = 1;
		};

		var url = "redactor?act=update";
		var data = "link=<?=$page_link?>&new_publ="+flag;
		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		request.onreadystatechange = updateStatus;
		request.send(data);

		return false;
	};


	function update_link() {
		var request;

		try { request = new XMLHttpRequest(); }
		catch (trymicrosoft)
		{
			try { request = new ActiveXObject("Msxml2.XMLHTTP"); }
			catch (othermicrosoft)
			{
				try { request = new ActiveXObject("Microsoft.XMLHTTP"); }
				catch (failed) { request = false; }
			}
		}
		if (!request) alert("Error initializing XMLHttpRequest!");

		function updateStatus() {
			if (request.readyState == 4) {
				if (request.status == 200) {
					var response = request.responseText;
					show_status(response);
					// alert(response);
					//var response = request.responseText.split("|");
					//document.getElementById("order").value = response[0];
					//document.getElementById("address").innerHTML = response[1].replace(/\n/g, "<br />");
				} else if (request.status == 404) {
					show_status("Requested URL is not found.");
				} else if (request.status == 403) {
					show_status("Access denied.");
				} else
				show_status("Server return status: " + request.status);
			}
		}

		var url = "redactor?act=update";
		var data = "link=<?=$page_link?>&new_link="+encodeURIComponent(document.getElementById('page_link_field').innerHTML);
		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		request.onreadystatechange = updateStatus;
		request.send(data);

		return false;
	};


	function update_name() {
		var request;

		try { request = new XMLHttpRequest(); }
		catch (trymicrosoft)
		{
			try { request = new ActiveXObject("Msxml2.XMLHTTP"); }
			catch (othermicrosoft)
			{
				try { request = new ActiveXObject("Microsoft.XMLHTTP"); }
				catch (failed) { request = false; }
			}
		}
		if (!request) alert("Error initializing XMLHttpRequest!");

		function updateStatus() {
			if (request.readyState == 4) {
				if (request.status == 200) {
					var response = request.responseText;
					show_status(response);
					// alert(response);
					//var response = request.responseText.split("|");
					//document.getElementById("order").value = response[0];
					//document.getElementById("address").innerHTML = response[1].replace(/\n/g, "<br />");
				} else if (request.status == 404) {
					show_status("Requested URL is not found.");
				} else if (request.status == 403) {
					show_status("Access denied.");
				} else
				show_status("Server return status: " + request.status);
			}
		}

		var url = "redactor?act=update";
		var data = "link=<?=$page_link?>&new_name="+encodeURIComponent(document.getElementById('page_title').innerHTML);
		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		request.onreadystatechange = updateStatus;
		request.send(data);

		return false;
	};


	function update_text() {
		var request;

		try { request = new XMLHttpRequest(); }
		catch (trymicrosoft)
		{
			try { request = new ActiveXObject("Msxml2.XMLHTTP"); }
			catch (othermicrosoft)
			{
				try { request = new ActiveXObject("Microsoft.XMLHTTP"); }
				catch (failed) { request = false; }
			}
		}
		if (!request) alert("Error initializing XMLHttpRequest!");

		function updateStatus() {
			if (request.readyState == 4) {
				if (request.status == 200) {
					var response = request.responseText;
					show_status(response);
					// alert(response);
					//var response = request.responseText.split("|");
					//document.getElementById("order").value = response[0];
					//document.getElementById("address").innerHTML = response[1].replace(/\n/g, "<br />");
				} else if (request.status == 404) {
					show_status("Requested URL is not found.");
				} else if (request.status == 403) {
					show_status("Access denied.");
				} else
				show_status("Server return status: " + request.status);
			}
		}

		var url = "redactor?act=update";
		var data = "link=<?=$page_link?>&new_text="+encodeURIComponent(document.getElementById('textarea1').value);
		request.open('POST', url, true);
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		request.onreadystatechange = updateStatus;
		request.send(data);

		document.getElementById("main_cont").innerHTML = document.getElementById('textarea1').value;
		open_textarea();

		return false;
	};


	function open_textarea() {
		if (document.getElementById("main_cont").getAttribute("style")!="display:none;") {
			// Редактирование
			document.getElementById('edit_button').value = "Cancel";
			document.getElementById("main_cont").setAttribute("style", "display:none;");
			document.getElementById("editor_area").setAttribute("style", "display:visible;");
			document.getElementById("save_button").removeAttribute('disabled');
		} else {
			// Просмотр
			document.getElementById('edit_button').value = "Change";
			document.getElementById("main_cont").setAttribute("style", "display:visible;");
			document.getElementById("editor_area").setAttribute("style", "display:none;");
			document.getElementById("save_button").setAttribute('disabled', '');
		}
	};

</script>

<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.css">
<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.Extras.css">
<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.SilkTheme.css">

<style type="text/css">
	body {
		font-family: sans-serif;
		font-size: .9em;
	}
	#page_title[contenteditable] {background-color: orange; color: black;}
	#page_link_field[contenteditable] {background-color: orange; color: white;}
	.marg30 {
		margin-right: 30px;
		margin-left: 30px;
		width: 930px;
	}
	#editor_status {
		font-size: 12px !important;
		color: green;
		float: left;
	}
	#edit_button {
		width: 100px;
	}
	#textarea1 {
		position: relative;
		display: block;
		width: 930px;
		height: 200px;
		border: 0px solid #ddd;
	}
	#textarea1-mooeditable-container {
		width: 990px !important;
		border: 0;
		/* border-width: 0px 0px 1px !important; */
	}
	.mooeditable-iframe {
		margin-left: 30px !important;
		margin-right: 30px !important; 
		height: 300px !important;
		width: 930px !important;
		padding: 0 !important;
	}
</style>

<? include_once 'modules/site_header.php'; ?>
	<header>
		<? include_once 'modules/module_navbar.php'; ?>
		<? include_once 'modules/site_gototop.php'; ?>
		<? include_once 'modules/block_site_map.php'; ?>
	</header>
	<main>
		<?if ($admin_flag && ! $error_output){?>
			<table width="930px" style="margin-top:10px;margin-bottom:-22px;" class="marg30">
				<tr>
					<td width="160px">
						<input id="edit_button" type="submit" value="Change" onclick="open_textarea()" />
						<input id="save_button" type="submit" value="Save" onclick="update_text()" />
					</td>
					<td width="80px" style="font-size:14px;">
						<input id="public_flag" type="checkbox" onchange="update_public_flag()" <? if(!$page_public) {echo("checked");}?>/>
						Private
					</td>
					<td width="100px">
						<select id="template" onchange="update_template()">
						<?
						$list_tmpl = $pdo->prepare("SELECT `templates`.`id`,`templates`.`name` FROM `templates`;");
						$list_tmpl->execute();

						while ( $root_item = $list_tmpl->FETCH(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT) ) {
							if ($root_item['id'] == $page_template) {
								echo("<option value=\"".$root_item['id']."\" selected>".$root_item['name']."</option>");
							} else {
								echo("<option value=\"".$root_item['id']."\">".$root_item['name']."</option>");
							}
						}
						?>
						</select>
					</td>
					<td width="240px" style="font-size:14px;" id="page_link">
						http://robotic.lol/<b id="page_link_field"><? echo($page_link);?></b>
					</td>
					<td width="350px">
						<div id="editor_status" style="font-size:14px;"></div>
					</td>
				</tr>
			</table>
		<?}?>
		<article>
			<section class="text-content" id="fullpage">
				<h1 id="page_title"><?=$page_title?></h1>
				<div id="main_cont"><?=$page_content?></div>
			</section>
		</article>

		<?if ($admin_flag && ! $error_output){?>
			<div id="editor_area">
				<textarea id="textarea1" class="marg30 js-elasticArea"><?=$page_content;?></textarea>
			</div>

			<script>
			(function () {
				function elasticArea() {
					$('.js-elasticArea').each(function (index, element) {
					var elasticElement = element,
					$elasticElement = $(element),
					initialHeight = initialHeight || $elasticElement.height(),
					delta = parseInt($elasticElement.css('paddingBottom')) + parseInt($elasticElement.css('paddingTop')) || 0,
					resize = function () {
						$elasticElement.height(initialHeight);
						$elasticElement.height(elasticElement.scrollHeight - delta);
					};
					$elasticElement.on('input change keyup', resize);
					resize();
					});
				};
				//Init function in the view
				elasticArea();
			})();
			</script>
		<?}?>


	</main>
<? include_once 'modules/site_footer.php'; ?>