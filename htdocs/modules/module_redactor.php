<script language="javascript" type="text/javascript">

var request;

function createRequest() {
  try {
    request = new XMLHttpRequest();
  } catch (trymicrosoft) {
    try {
      request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (othermicrosoft) {
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (failed) {
        request = false;
      }
    }
  }

  if (!request)
    alert("Error initializing XMLHttpRequest!");
}

function getCustomerInfo() {
	createRequest();
	// Сделать что-то с переменной request 
	//var phone = document.getElementById("phone").value;
	//var url = "/cgi-local/lookupCustomer.php?phone=" + escape(phone);
	//request.open("GET", url, true);
	//request.onreadystatechange = updatePage;
	//request.send(null);
	
	//var phone = document.getElementById("phone").value;
	var url = "editor";
	var data = "moo_link=<?=$moo_link?>&moo_text="+encodeURIComponent(document.getElementById('textarea-1').value);
	request.open('POST', url, true);
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	//request.setRequestHeader('Content-type: text/html; charset=utf-8');
	request.onreadystatechange = updatePage;
	request.send(data);
}

function updatePage() {
	if (request.readyState == 4) {
		if (request.status == 200) {
			var response = request.responseText;
			document.getElementById("status_urpylka").innerHTML = response;
		  //alert(response);
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
</script>

<style type="text/css">
body{
		font-family: sans-serif;
		font-size: .9em;
	}
	#textarea-1{
		position: relative;
		display: block;
		width: 930px;
		height: 200px;
		border: 0px solid #ddd;
	}
	#textarea-1-mooeditable-container
	{
		width: 990px !important; border-width: 0px 0px 1px !important;
	}
	.mooeditable-iframe
	{
		height: 204px; margin-left: 30px !important; margin-right: 30px !important; width: 930px !important; padding: 0 !important;
	}
</style>

<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.css">
<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.Extras.css">
<link rel="stylesheet" type="text/css" href="mooeditable/Assets/MooEditable/MooEditable.SilkTheme.css">

<?/*<script type="text/javascript" src="https://yastatic.net/jquery/1.7.0/jquery.min.js"></script>*/?>

<script type="text/javascript" src="mooeditable/Demos/assets/mootools.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.UI.MenuList.js"></script>
<script type="text/javascript" src="mooeditable/Source/MooEditable/MooEditable.Extras.js"></script>

<script type="text/javascript">
	window.addEvent('domready', function(){
		document.getElementById('textarea-1').mooEditable({
			actions: 'bold italic underline strikethrough | formatBlock justifyleft justifycenter justifyright justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo removeformat | createlink unlink | urlimage | toggleview'
		});

		document.getElementById("theForm").setAttribute("style", "display:none;");
		// Post submit
		$('theForm').addEvent('submit', function(event){
			/*
            // Предотвращаем обычную отправку формы
            //event.preventDefault();
			$.post('/editor', {'moo_link':'rules','moo_text':'2222'},
        	function(data) {
	//$('#fullpage').html(data);
	alert(data);
	});
	*/
			//alert($('textarea-1').value);
			getCustomerInfo();
			document.getElementById("main_cont").innerHTML = $('textarea-1').value;
			document.getElementById("theForm").setAttribute("style", "display:none;");
			document.getElementById("main_cont").setAttribute("style", "display:visible;");
			return false;
		});
		
	});
	
	function knop() {
		if(document.getElementById("main_cont").getAttribute("style")!="display:none;")
		{
			document.getElementById("main_cont").setAttribute("style", "display:none;");
			document.getElementById("theForm").setAttribute("style", "display:visible;");
		}
		else {
			document.getElementById("main_cont").setAttribute("style", "display:visible;");
			document.getElementById("theForm").setAttribute("style", "display:none;");
		}
	}
		/*
		$(document).ready(function(){
		$('').click(function () {
			$(this).next('ul').toggle();
			return false;});});
			*/
</script>

<form id="theForm" method="post" action="editor" style="padding: 0; width: 990px !important; margin: 0px;">
	<textarea id="textarea-1" name="editable1">
	<?=$moo_text;?>
	</textarea>
	<?/*<input type="hidden" value="<?=$moo_link?>" name="moo_link">*/?>
	<input style="margin-left: 30px;margin-top:15px;" type="submit">
</form>
<div id="data"></div>
<hr/>
<div id="status_urpylka" style="color:green;float:left;"></div>
<a style="margin-left: 30px;" onclick="knop();"  href="#" style="float:left;">Редактировать <img src="img/de5651dbe70eb0341d1bc6037f19adcb.jpeg" style="margin-top:-3px;height: 20px;"/></a>
<br/>