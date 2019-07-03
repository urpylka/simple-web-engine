//EMAIL
function checkForm()
{
    document.getElementById("error").innerHTML="";
    checkName();
    checkVzvod();
    checkText();
    checkPhone();
    checkEmail();
    checkKapcha();
    return false; //отладка
};
//NAME
function checkName()
{
    var name=document.forms["feedback"]["totalfname"].value;
    if (name.length!=0)
    {
        if((/\W/.test(name))){
            document.getElementById("error").innerHTML="Имя введено неверно: допускаются только буквы";
            document.getElementById("totalfname").style.border="1px solid red";
            return false;
        };
        if (name.length>21)
        {
            document.getElementById("error").innerHTML="Имя введено неверно: имя слишком длинное";
            document.getElementById("totalfname").style.border="1px solid red";
            return false;
        };
        document.getElementById("totalfname").value=refactorName(name);						
    }
    document.getElementById("totalfname").style.border="1px solid #ccc";
};
//VZVOD
function checkVzvod()
{
    var vzvod=document.forms["feedback"]["totallname"].value;
    if (vzvod.length!=0)
    {
        if (vzvod.length>6)
        {
            document.getElementById("error").innerHTML="Слишком большой номер взвода";
            document.getElementById("totallname").style.border="1px solid red";
            return false;
        }
        else if((/\W/.test(vzvod)))
        {
            document.getElementById("error").innerHTML="Недопустимые символы в номере взвода";
            document.getElementById("totallname").style.border="1px solid red";
            return false;
        }
    }
    document.getElementById("totallname").style.border="1px solid #ccc";					
};
//TEXT
function checkText()
{
    var text=document.forms["feedback"]["totalltext"].value;
    if (text.length==0)
    {
        document.getElementById("error").innerHTML="Не указан текст обращения";
        document.getElementById("totalltext").style.border="1px solid red";
        return false;
    }
    else if (text.length>255)
    {
        document.getElementById("error").innerHTML="Текст обращения слишком велик";
        document.getElementById("totalltext").style.border="1px solid red";
        return false;
    }
    document.getElementById("totalltext").style.border="1px solid #ccc";
};
//PHONE
function checkPhone()
{
    var phone=document.forms["feedback"]["totalphone"].value;
    if (phone.length!=0)
    {
        if (phone.length>21){
            document.getElementById("error").innerHTML="Телефон слишком длинный";
    document.getElementById("totalphone").style.border="1px solid red";
            return false;
        };								
    }
    document.getElementById("totalphone").style.border="1px solid #ccc";			
};
//EMAIL
function checkEmail()
{
    var email=document.forms["feedback"]["totalemail"].value;
    if (email.length!=0)
    {
        //проверим содержит ли значение введенное в поле email символы @ и .
        at=email.indexOf("@");
        dot=email.indexOf(".");
        //если поле не содержит эти символы значение email введено не верно
        if(at<1 || dot<1){
            document.getElementById("error").innerHTML="Email введено неверно";
            document.getElementById("totalemail").style.border="1px solid red";
            return false;
        }			
        //Проверка E-mail
        if(! (/^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i.test(email))){
            document.getElementById("error").innerHTML="Email введено неверно";
            document.getElementById("totalemail").style.border="1px solid red";
            return false;
        };	
        //Проверка E-mail
        if(! (/^[a-zA-Z0-9_\-\.]+[a-zA-Z0-9]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/.test(email))){
            document.getElementById("error").innerHTML="Email введено неверно";
            document.getElementById("totalemail").style.border="1px solid red";
            return false;
        };
        if(! (/^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i.test(email)))
        {
            document.getElementById("error").innerHTML="Email введено неверно";
            document.getElementById("totalemail").style.border="1px solid red";
            return false;
        }								
    }
    document.getElementById("totalemail").style.border="1px solid #ccc";
};
//KAPCHA
function checkKapcha()
{
    var kapcha=document.forms["feedback"]["totalkapcha"].value;
    if (kapcha!='just example')
    {
        document.getElementById("error").innerHTML="Капча введна неверно";
            document.getElementById("totalkapcha").style.border="1px solid red";
        return false;				
    }
    document.getElementById("totalkapcha").style.border="1px solid #ccc";				
};
//Имя пишется с большой буквы
function refactorName(name)
{
    name = name.charAt(0).toUpperCase() + name.substr(1);
    return name;
};