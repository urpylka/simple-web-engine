<script type="text/javascript">

	//Функция показа
	function show(state, blockId){
			document.getElementById(blockId).style.display = state;			
			document.getElementById('wrap').style.display = state; 			
	}
</script>
<article>
	<section>
		<!-- Задний прозрачный фон-->
		<div onclick="show('none')" id="wrap"></div>
		<div class="news">
			<h1>Добро-пожаловать на новый сайт</h1>

			<div class="news-body">
				<img src="img/assets/dwfwfw.png" />
				<p>В рамках курсовой работы разработан сайт для военной кафедры Самарского университета. Сайт выполнен в статичном виде. Применено 5 javascript`ов. Автор сайта Смирнов Артем.</p>
				<a href="#" onclick="show('block','news1')">Подробнее</a>
			</div>

			<div align="justify" id="news1" class="popup_window">
				<div class="close" onclick="show('none','news1')">X</div>
				<div class="news-header">Добро-пожаловать на новый сайт</div>
				<p align="justify">В рамках курсовой работы разработан сайт для военной кафедры Самарского университета. Сайт выполнен в статичном виде. Применено 5 javascript`ов. Автор сайта Смирнов Артем.
				</p>
			</div>

		</div>
		<div style="clear:both;"></div>
		<div class="news">
			<h1>Открыт набор на кафедру</h1>
			<div class="news-body">
				<img src="img/assets/1.jpg">
				<p>Приглашаем студентов вторых и третьих курсов для обучения на военной кафедре по программам сержантов и офицеров запаса.</p>
				<a href="#" onclick="show('block','news2')">Подробнее</a>
			</div>
			<div align="justify" id="news2" class="popup_window">
				<div class="close" onclick="show('none','news2')">X</div>
				<div class="news-header">Открыт набор на кафедру</div>
				<p align="justify">Приглашаем студентов вторых и третьих курсов для обучения на военной кафедре по программам сержантов и офицеров запаса.
				</p>
			</div>
		</div>
		<div style="clear:both;"></div>
	</section>
</article>
<br/>