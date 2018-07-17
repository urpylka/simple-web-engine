<style type="text/css">
#wrap{
	display: none;
	opacity: 0.8;
	position: fixed;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	padding: 16px;
	background-color: rgba(1, 1, 1, 0.725);
	z-index: 100;
	overflow: auto;
}
.popup_window{
	width: 600px;
	height: 400px;
	margin: 50px auto;
	display: none;
	background: #fff;
	z-index: 200;
	position: fixed;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	padding: 16px;
}
.close{
	margin-left: 564px;
	margin-top: 4px;
	cursor: pointer;
	float: right;
}
.popup_window .name{
	margin-left: 30px !important;
	width: 100%;
}
</style>
<script type="text/javascript">

			//Функция показа
	function show(state, blockId){
			document.getElementById(blockId).style.display = state;			
			document.getElementById('wrap').style.display = state; 			
	}
</script>
<article>
	<section class="Allnews">
		<!-- Задний прозрачный фон-->
		<div onclick="show('none')" id="wrap"></div>
		<div class="news">
			<a href="#" class="button" onclick="show('block','news1')">Подробнее</a>
			<strong class="name">Добро-пожаловать на новый сайт</strong>
			<p align="justify">В рамках курсовой работы разработан сайт для военной кафедры Самарского университета. Сайт выполнен в статичном виде. Применено 5 javascript`ов. Автор сайта Смирнов Артем.</p>
			<div align="justify" id="news1" class="popup_window">
				<div class="close" onclick="show('none','news1')">X</div>
				<div class="name">Добро-пожаловать на новый сайт</div>
				<p align="justify">В рамках курсовой работы разработан сайт для военной кафедры Самарского университета. Сайт выполнен в статичном виде. Применено 5 javascript`ов. Автор сайта Смирнов Артем.
				</p>
			</div>
			<img src="img/dwfwfw.png" class="prewiw">
		</div>
		<div class="news">
			<a href="#" class="button" onclick="show('block','news2')">Подробнее</a>
			<strong class="name">Открыт набор на кафедру</strong>
			<p align="justify">Приглашаем студентов вторых и третьих курсов для обучения на военной кафедре по программам сержантов и офицеров запаса.</p>
			<div align="justify" id="news2" class="popup_window">
				<div class="close" onclick="show('none','news2')">X</div>
				<div class="name">Открыт набор на кафедру</div>
				<p align="justify">Приглашаем студентов вторых и третьих курсов для обучения на военной кафедре по программам сержантов и офицеров запаса.
				</p>
			</div>
			<img src="img/1.jpg" class="prewiw">
		</div>
	</section>
</article>
<br/>