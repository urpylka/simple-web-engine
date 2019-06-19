window.addEvent('domready', function() {

    // Раскоментируйте, чтобы включить MooEditable
    // document.getElementById('textarea1').mooEditable({
    // 	actions: 'bold italic underline strikethrough | formatBlock justifyleft justifycenter justifyright justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo removeformat | createlink unlink | urlimage | toggleview'
    // });

    document.getElementById("editor_area").setAttribute("style", "display:none;");
    document.getElementById("save_button").setAttribute('disabled', '');

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

    var st = false;

    function updateStatus() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText;
                if (response.startsWith("The")) { st = true; };
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

    link = document.getElementById('page_link_field').value;

    var url = "redactor?act=update";
    var data = "link=<?=$page_link?>&new_link="+encodeURIComponent(link);
    request.open('POST', url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onreadystatechange = updateStatus;
    request.send(data);

    // redirect to new address
    setTimeout(function(){if(st){location=link;}}, 100);

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


function delete_page() {
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

    var st = false;

    function updateStatus() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText;
                if (response.startsWith("The")) { st = true; };
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

    var url = "redactor?act=drop";
    var data = "link=<?=$page_link?>";
    request.open('POST', url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    request.onreadystatechange = updateStatus;
    request.send(data);


    // redirect to new address
    setTimeout(function(){if(st){location="editor";}}, 1000);
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
