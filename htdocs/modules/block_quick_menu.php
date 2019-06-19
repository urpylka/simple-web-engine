<style>
/* Псевдо меню */
div#quickmenu{height: 100px;}
.col:hover{
	background-image: -moz-linear-gradient(bottom, #fdfbff 0%, #ebebeb 100%);
	background-image: -o-linear-gradient(bottom, #fdfbff 0%, #ebebeb 100%);
	background-image: -webkit-linear-gradient(bottom, #fdfbff 0%, #ebebeb 100%);
	background-image: linear-gradient(bottom, #fdfbff 0%, #ebebeb 100%);cursor: pointer;
}
.col{
	height:100px;width:100%;
	background-image: -moz-linear-gradient(bottom, #ebebeb 0%, #fdfbff 100%);
	background-image: -o-linear-gradient(bottom, #ebebeb 0%, #fdfbff 100%);
	background-image: -webkit-linear-gradient(bottom, #ebebeb 0%, #fdfbff 100%);
	background-image: linear-gradient(bottom, #ebebeb 0%, #fdfbff 100%);cursor: pointer;
	width: 330px;float:left;
	border-left: 1px solid #fff;
	box-sizing: border-box;
}
.col span{font-size:20px;font-weight:400;display:block;margin-top:25px;}
.col img{margin-left:29px;margin-top:25px;margin-right:25px;float:left;}
.col p{margin-left:107px;margin-top:2px;font-size:15px;color:#595959;}
</style>
<div id="quickmenu">
	<a href="/for-abiturients" class="col">
		<img src="img/pipl.png" alt="Что бы Валидатор неохуел"/>
		<span>Абитуриенту</span>
		<p>Правила приема,<br/>основное положение</p>
	</a>
	<a href="/for-students" class="col">
		<img src="img/plosha.png" alt="Что бы Валидатор неохуел"/>
		<span>Студенту</span>
		<p>Учебный материал,<br/>необходимые документы</p>
	</a>
	<a href="/for-emploeers" class="col">
		<img src="img/blog.png" alt="Что бы Валидатор неохуел"/>
		<span>Сотруднику</span><!-- СМИ, ниже мероприятия и контакты-->
		<p>Структура кафедры,<br/>руководство</p>
	</a>
</div>