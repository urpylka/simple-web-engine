function show_status(message) {
    document.getElementById("editor_status").innerHTML = message;

    function disappear() {
        document.getElementById("editor_status").style.display = 'block'; // показываем .loader
        setTimeout(function() {
            document.getElementById("editor_status").style.display = 'none'; // скрываем .loader
        }, 100000); // зарежка перед скрытием в миллисекундах
    }
    disappear();
}


// https://learn.javascript.ru/settimeout-setinterval
// https://ru.stackoverflow.com/questions/709900/Как-сделать-паузу-в-любом-месте-кода-на-js
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


var is_ready = false;
var status = false;

function send_request(url, data, func) {

    is_ready = false;
    status = false;

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
    if (!request) {
        alert("Error initializing XMLHttpRequest!");
        return false;
    }
    

    request.open('POST', url, true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    // https://habr.com/en/post/78991/
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText;
                if (response.startsWith("The")) { status = true; };
                func(response);
                // alert(response);
                //var response = request.responseText.split("|");
                //document.getElementById("order").value = response[0];
                //document.getElementById("address").innerHTML = response[1].replace(/\n/g, "<br />");
            } else if (request.status == 404) {
                func("Requested URL is not found.");
            } else if (request.status == 403) {
                func("Access denied.");
            } else {
                func("Server return status: " + request.status);
            }
        }
        is_ready = true;
    };
    request.send(data);
};


function update_name() {
    send_request("redactor?act=update", "new_name="+encodeURIComponent(document.getElementById('page_title').innerHTML), show_status);
    return false;
};


function update_template() {
    var tmpl = 1;
    var selind = document.getElementById("template").options.selectedIndex;
    var tmpl = document.getElementById("template").options[selind].value;
    send_request("redactor?act=update", "new_tmpl="+tmpl, show_status);
    return false;
};


function update_public_flag() {
    var flag = 0;
    if (document.getElementById("public_flag").hasAttribute("checked")) { flag = 1; };
    send_request("redactor?act=update", "new_publ="+flag, show_status);
    return false;
};


async function update_link() {
    link = document.getElementById('page_link_field').value;
    send_request("redactor?act=update", "new_link="+encodeURIComponent(link), show_status);
    // redirect to new address
    while (! is_ready ) { await sleep(500); };
    setTimeout(function() { if(status) { location = link; }; }, 2000);
    return false;
};


function update_prnt() {
    new_prnt = document.getElementById('page_prnt_field').value;
    send_request("redactor?act=update", "new_prnt="+encodeURIComponent(new_prnt), show_status);
    return false;
};


function update_text() {
    // https://realadmin.ru/coding/url-javascript.html
    send_request("redactor?act=update", "new_text="+encodeURIComponent(document.getElementById('textarea1').value), show_status);
    document.getElementById("main_cont").innerHTML = document.getElementById('textarea1').value;
    open_textarea();
    return false;
};


async function delete_page() {
    if (confirm("Delete this page?")) {
        send_request("redactor?act=drop", "", show_status);
        // redirect to new address

        while (! is_ready ) { await sleep(500); };
        setTimeout(function() { if(status) { location = "editor"; }; }, 2000);
        return false;
    };
};


async function new_page() {

    new_name = "new_name="+encodeURIComponent(document.getElementById('page_title').innerHTML);
    new_link = "new_link="+encodeURIComponent(document.getElementById('page_link_field').value);
    new_text = "new_text="+encodeURIComponent(document.getElementById('textarea1').value);
    new_prnt = "new_prnt="+encodeURIComponent(document.getElementById('page_prnt_field').value);

    var flag = 0;
    if (document.getElementById("public_flag").hasAttribute("checked")) { flag = 1; };
    new_publ = "new_publ="+flag;

    var tmpl = 1;
    var selind = document.getElementById("template").options.selectedIndex;
    var tmpl = document.getElementById("template").options[selind].value;
    new_tmpl = "new_tmpl="+tmpl;

    send_request("redactor?act=new", new_name+'&'+new_link+'&'+new_tmpl+'&'+new_prnt+'&'+new_publ, show_status);
    // redirect to new address

    // while (! is_ready ) { await sleep(500); };
    // setTimeout(function() { if(status) { location = new_link; }; }, 2000);
    return false;
};


function open_textarea() {
    if (document.getElementById("main_cont").getAttribute("style")!="display:none;") {
        // EDITOR
        document.getElementById('edit_button').value = "Cancel";
        document.getElementById("main_cont").setAttribute("style", "display:none;");
        document.getElementById("textarea1").setAttribute("style", "display:visible;");
        document.getElementById("textarea1").focus();
        document.getElementById("save_button").removeAttribute('disabled');
    } else {
        // RESULT
        document.getElementById('edit_button').value = "Change";
        document.getElementById("main_cont").setAttribute("style", "display:visible;");
        document.getElementById("textarea1").setAttribute("style", "display:none;");
        document.getElementById("save_button").setAttribute('disabled', '');
    }
};


// ELASTIC AREA

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


// DOMREADY

function on_dom_ready() {
    // Раскоментируйте, чтобы включить MooEditable
    // document.getElementById('textarea1').mooEditable({
    // 	actions: 'bold italic underline strikethrough | formatBlock justifyleft justifycenter justifyright justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo removeformat | createlink unlink | urlimage | toggleview'
    // });

    document.getElementById("textarea1").setAttribute("style", "display:none;");
    document.getElementById("save_button").setAttribute('disabled', '');

    // .click()
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

    elasticArea();
};


function on_dom_ready_create() {
    // Раскоментируйте, чтобы включить MooEditable
    // document.getElementById('textarea1').mooEditable({
    // 	actions: 'bold italic underline strikethrough | formatBlock justifyleft justifycenter justifyright justifyfull | insertunorderedlist insertorderedlist indent outdent | undo redo removeformat | createlink unlink | urlimage | toggleview'
    // });

    document.getElementById("textarea1").setAttribute("style", "display:visible;");
    document.getElementById("save_button").setAttribute('enable', '');

    $('#page_title').attr('contenteditable', '');
    $('#page_title').keydown(function(e) { if (e.keyCode === 13 || e.keyCode === 27) {} });
    // нужно как-то запретить переносы строк в tape

    elasticArea();
};