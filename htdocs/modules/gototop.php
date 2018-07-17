<style>
	#scrollup
	{
		position: fixed; /* фиксированная позиция */
		opacity: 0.8; /* прозрачность */
		padding: 10px; /* отступы */
		right: 10px; /* отступ слева */
		bottom: 10px; /* отступ снизу */
		display: none; /* спрятать блок */
		cursor: pointer;
		
		background-color: #0097D3;
		color: #FFF;
	}
	#scrollup:hover
	{
		background-color: #21ABDC;
		color: #FFF;
	}
</style>
<script>
	window.onload = function() { // после загрузки страницы
		var scrollUp = document.getElementById('scrollup'); // найти элемент
		scrollUp.onmouseover = function() { // добавить прозрачность
			scrollUp.style.opacity=1;
			scrollUp.style.filter  = 'alpha(opacity=100)';
		};
		scrollUp.onmouseout = function() { //убрать прозрачность
			scrollUp.style.opacity = 0.8;
			scrollUp.style.filter  = 'alpha(opacity=80)';
		};
		scrollUp.onclick = function() { //обработка клика
			window.scrollTo(0,0);
		};
	// show button
		window.onscroll = function () { // при скролле показывать и прятать блок
			if ( window.pageYOffset > 0 ) {
				scrollUp.style.display = 'block';
			} else {
				scrollUp.style.display = 'none';
			}
		};
	};
</script>
<div id="scrollup">Прокрутить вверх</div>