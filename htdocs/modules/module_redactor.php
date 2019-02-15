<?/*<script type="text/javascript" src="https://yastatic.net/jquery/1.7.0/jquery.min.js"></script>*/?>

<script type="text/javascript" src="mooeditable/Demos/assets/mootools.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.UI.MenuList.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.Extras.js"></script>

<script language="javascript" type="text/javascript">

	var request;

	function initRequest() {
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
	}

	function updatePage() {
		if (request.readyState == 4) {
			if (request.status == 200) {
				var response = request.responseText;
				document.getElementById("editor_status").innerHTML = response;
				// alert(response);
				//var response = request.responseText.split("|");
				//document.getElementById("order").value = response[0];
				//document.getElementById("address").innerHTML = response[1].replace(/\n/g, "<br />");
			} else if (request.status == 404) {
				alert ("Requested URL is not found.");
			} else if (request.status == 403) {
				alert("Access denied.");
			} else
				alert("Server return status: " + request.status);
		}
	}

	window.addEvent('domready', function() {

		document.getElementById('textarea-1').mooEditable({
			actions: 'bold italic underline strikethrough | formatBlock justifyleft justifycenter justifyright justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo removeformat | createlink unlink | urlimage | toggleview'
		});

		document.getElementById("editor_form").setAttribute("style", "display:none;");

		document.getElementById("editor_form").addEvent('submit', function(event){
			initRequest();

			var url = "redactor?act=update";
			var data = "link=<?=$page_link?>&new_text="+encodeURIComponent(document.getElementById('textarea-1').value);
			request.open('POST', url, true);
			request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			request.onreadystatechange = updatePage;
			request.send(data);

			document.getElementById("main_cont").innerHTML = document.getElementById('textarea-1').value;

			open_textarea();
			return false;
		});
	});
	
	function open_textarea() {
		if (document.getElementById("main_cont").getAttribute("style")!="display:none;")
		{
			document.getElementById('edit_button').innerHTML = "Закрыть редактирование";
			document.getElementById("main_cont").setAttribute("style", "display:none;");
			document.getElementById("editor_form").setAttribute("style", "display:visible;");
		}
		else {
			document.getElementById('edit_button').innerHTML = "Редактировать";
			document.getElementById("main_cont").setAttribute("style", "display:visible;");
			document.getElementById("editor_form").setAttribute("style", "display:none;");
		}
	}
</script>

<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.css">
<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.Extras.css">
<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.SilkTheme.css">

<style type="text/css">
	body {
		font-family: sans-serif;
		font-size: .9em;
	}
	.marg30 {
		margin-right: 30px;
		margin-left: 30px;
		width: 930px;
	}
	/* #editor_form {
		padding: 0;
		width: 990px !important;
		margin: 0px;
	} */
	#editor_status {
		color: green;
		float: left;
	}
	#editor_control {
		height: 20px;
	}
	#edit_button {
		float: right;
		clear: right;
	}
	#textarea-1 {
		position: relative;
		display: block;
		width: 930px;
		height: 200px;
		border: 0px solid #ddd;
	}
	#textarea-1-mooeditable-container {
		width: 990px !important;
		border-width: 0px 0px 1px !important;
	}
	.mooeditable-iframe {
		margin-left: 30px !important;
		margin-right: 30px !important; 
		height: 300px !important;
		width: 930px !important;
		padding: 0 !important;
	}
</style>

<form id="editor_form">
	<textarea id="textarea-1">
		<?=$page_content;?>
	</textarea>
	<!-- <input value="<?=$page_link?>">
	<input value="<?=$tmpl_name?>"> -->
	<input style="margin-left:30px;margin-top:15px;" type="submit" value="Save">
</form>
<hr/>
<div id="editor_control" class="marg30">
	<a id="edit_button" onclick="open_textarea();"  href="#">Редактировать</a>
	<div id="editor_status"></div>
</div>