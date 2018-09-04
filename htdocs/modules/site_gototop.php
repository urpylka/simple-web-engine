<style>
	#scrollup
	{
		position: fixed;
		opacity: 0.8;
		padding: 10px;
		right: 10px;
		bottom: 10px;
		display: none;
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