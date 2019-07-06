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
    var tmpl= document.getElementById("template").options[selind].value;
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
    prnt = document.getElementById('page_prnt_field').value;
    send_request("redactor?act=update", "new_prnt="+encodeURIComponent(prnt), show_status);
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


function open_textarea() {
    if (document.getElementById("main_cont").getAttribute("style")!="display:none;") {
        // EDITOR
        document.getElementById('edit_button').value = "Cancel";
        document.getElementById("main_cont").setAttribute("style", "display:none;");
        document.getElementById("editor_area").setAttribute("style", "display:visible;");
        document.getElementById("textarea1").focus();
        document.getElementById("save_button").removeAttribute('disabled');
    } else {
        // RESULT
        document.getElementById('edit_button').value = "Change";
        document.getElementById("main_cont").setAttribute("style", "display:visible;");
        document.getElementById("editor_area").setAttribute("style", "display:none;");
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
