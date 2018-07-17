<?php //страница история 18.12.2016 ?>
<?php include_once 'modules/header.php'; ?>
	<header>
		<?php include_once 'modules/blocks/nav-bar.php'; ?>
		
	</header>
	<main>
		<article>
			<section class="text-content" id="fullpage">
				<h1>Обратная связь</h1>
				<script type="text/javascript">
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
			</script>
				<p align="justify">На данной странице Вы можете анонимно оставить отзыв, жалобу, благодарность или предложение</p>
						<p align="justify" id="error2" style="color:green;">Поля отмеченные * обязательны к заполнению</p>
						<p align="justify" id="error" style="color:red;"></p>
						<form onsubmit="return checkForm();" name="feedback" method="post" action="feedback.php" style="display: table !important;">
						<!--div class="notall">Поля, выделенные красной рамкой, заполнены неправильно.</div-->
						<div class="totalnames">
							<div>Ваше имя</div>
							<div>Тип обращения *</div>
							<div>Номер вашего взвода</div>
							<div class="text1">Текст обращения *</div>
							<div>Телефон</div>
							<div>Email</div>
							<div class="text1">Капча *</div>
							<!--div class="m1" title="Запоминать ее не обязательно">Кодовая строка</div-->
						</div>
						<div class="totalfields">
							<div>
								<input type="text" placeholder="не обязательно" id="totalfname" />
							</div>
							<div>
								<select id="totalvoen" size="1">
									<option value='жалоба'>жалоба</option>
									<option value='отзыв'>отзыв</option>
									<option value='благодарность'>благодарность</option>
									<option value='предложение'>предложение</option>
								</select>
							</div>
							<div>
								<input type="text" placeholder="не обязательно" id="totallname" />
							</div>
							<div class="text1">
								<textarea id="totalltext" name="text" style="resize: none;" rows="10" cols="42" placeholder="изложите суть вашего обращения" required></textarea>
							</div>
							<div>
								<input type="tel"  placeholder="не обязательно" id="totalphone" />
							</div>
							<div>
								<input type="email"  placeholder="не обязательно" id="totalemail" />
							</div>
							<!--div class="text1" style="width:320px !important;margin-bottom:-30px !important;margin-left:-2px !important;">
								<script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6LcC38gSAAAAAKuNyOQqWe87N60pvz28Ocp5tk4e"></script>
								<noscript>
							  		<iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcC38gSAAAAAKuNyOQqWe87N60pvz28Ocp5tk4e" height="300" width="500" frameborder="0"></iframe><br/>
							  		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
							  		<input type="hidden" name="recaptcha_response_field" value="manual_challenge" />
								</noscript>							
							</div-->
							<div class="text1" style="width:410px !important;margin-bottom:-30px !important;background-image: url('/img/kapcha.png');">
								<input type="kapcha"  placeholder="введите символы с картинки" id="totalkapcha" />				
							</div>
							<div>
								<input style="float:left;" type="submit" value="Отправить отзыв" />
							</div>
						</div>
					</form>
			</section>
		</article>
	</main>
<?php include_once 'modules/footer.php'; ?>