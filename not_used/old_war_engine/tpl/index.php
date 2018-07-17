<?php
//причесал код 13.12.2016 автор Смирнов Артем

//здесь загружаются названия раздела меню и различные надписи к примеру адрес кафедры
$row   = mysql_query( 'SELECT * FROM  `table` WHERE id = 1' );
$row   = mysql_fetch_array( $row );
$row2  = mysql_query( 'SELECT * FROM  `table` WHERE id = 2' );
$row2  = mysql_fetch_array( $row2 );
$row3  = mysql_query( 'SELECT * FROM  `table` WHERE id = 3' );
$row3  = mysql_fetch_array( $row3 );
$row4  = mysql_query( 'SELECT * FROM  `table` WHERE id = 4' );
$row4  = mysql_fetch_array( $row4 );
$row5  = mysql_query( 'SELECT * FROM  `table` WHERE id = 5' );
$row5  = mysql_fetch_array( $row5 );
$row6  = mysql_query( 'SELECT * FROM  `table` WHERE id = 6' );
$row6  = mysql_fetch_array( $row6 );
$row7  = mysql_query( 'SELECT * FROM  `table` WHERE id = 7' );
$row7  = mysql_fetch_array( $row7 );
$row8  = mysql_query( 'SELECT * FROM  `table` WHERE id = 8' );
$row8  = mysql_fetch_array( $row8 );
$row9  = mysql_query( 'SELECT * FROM  `table` WHERE id = 9' );
$row9  = mysql_fetch_array( $row9 );
$row10 = mysql_query( 'SELECT * FROM  `table` WHERE id = 10' );
$row10 = mysql_fetch_array( $row10 );
$row11 = mysql_query( 'SELECT * FROM  `table` WHERE id = 11' );
$row11 = mysql_fetch_array( $row11 );
$row12 = mysql_query( 'SELECT * FROM  `table` WHERE id = 12' );
$row12 = mysql_fetch_array( $row12 );
$row14 = mysql_query( 'SELECT * FROM  `table` WHERE id = 14' );
$row14 = mysql_fetch_array( $row14 );
$row15 = mysql_query( 'SELECT * FROM  `table` WHERE id = 15' );
$row15 = mysql_fetch_array( $row15 );
$row16 = mysql_query( 'SELECT * FROM  `table` WHERE id = 16' );
$row16 = mysql_fetch_array( $row16 );
$quer  = mysql_query( 'SELECT * FROM  `table` WHERE id = 13' );
$quer  = mysql_fetch_array( $quer );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
	<head>
		<title><?php echo $quer[ 'name' ];?></title>
		<link rel="stylesheet"  type="text/css" href="http://war.ssau.ru/css/main2.css" media="screen" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<a href = "http://www.ssau.ru/" title = "Перейти на сайт Самарского государственного аэрокосмического университета"><DIV id = "ssaulink">&nbsp;</DIV></a>
				<a href="http://<? echo $_SERVER['HTTP_HOST']; ?>" target = "_self"><img src="<? echo $site_url; ?>/img/flag.jpg" width="167px" height="102px" class="flag" /></a>
				<a href="http://<? echo $_SERVER['HTTP_HOST']; ?>" target = "_self"><img src="<? echo $site_url; ?>/img/header.jpg" width="680px" height="57px" /></a>
				<div id="planes">
					<OBJECT codeBase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" 
						classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 width=460 height=45><PARAM NAME="movie" VALUE="/flash/planes.swf">
						<PARAM NAME="quality" VALUE="high"><PARAM NAME="wmode" VALUE="transparent"><PARAM NAME="bgcolor" VALUE="#0000CC">
						<EMBED src="<? echo $site_url; ?>/img/planes.swf" quality=high wmode=transparent 
						bgcolor=#0000CC  WIDTH="460" HEIGHT="45" NAME="planes" ALIGN="" 
						TYPE="application/x-shockwave-flash" 
						PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
					</OBJECT>
              </div>
			</div>
			<div id="left">
				<img src="img/gerb.jpg" width="126px" height="148px" class="gerb" />
				<div class="clear"></div>
				<ul id="menu">
					<li><a href="../history/flash-history"><?php echo $row[ 'name' ];?></a></li>
					<li><a href="../index/chiffs"><?php echo $row2[ 'name' ];?></a></li>
					<li><a href="../index/structure/"><?php echo $row3[ 'name' ];?></a></li>
					<li><a href="../abitur/rules/"><?php echo $row4[ 'name' ];?></a></li>
					<li><a href="../students/qual/"><?php echo $row5[ 'name' ];?></a></li>
					<li><a href="../history/gubanogp"><?php echo $row6[ 'name' ];?></a></li>
					<li><a href="../multimedia/photo/"><?php echo $row7[ 'name' ];?></a></li>
					<li><a href="../honestydesk/index.html"><?php echo $row8[ 'name' ];?></a></li>
					<li><a href="../honestybook/index.html"><?php echo $row9[ 'name' ];?></a></li>
					<li><a href="../panorama2/virtualtour.html" target="_blank"><?php echo $row10[ 'name' ];?></a></li>
					<li><a href="../index/contacts/"><?php echo $row11[ 'name' ];?></a></li>
					<li><a href="http://sokol.ssau.ru"><?php echo $row12[ 'name' ];?></a></li>
					<li><a href="http://war.ssau.ru/students/library">Библиотека</a></li>
				</ul>
				<!-- Яндекс Поиск / Начало -->
				<div style = "margin-left: 10px; margin-top: 30px;">
					<div class="yandexform" onclick="return {type: 3, logo: 'rb', arrow: false, webopt: false, websearch: false, bg: '#FFCC00', fg: '#000000', fontsize: 12, suggest: true, site_suggest: true, encoding: ''}">
						<form action="http://yandex.ru/sitesearch" method="get">
							<input type="hidden" name="searchid" value="252762"/>
							<input name="text"/>
							<input type="submit" value="Войти"/>
						</form>
					</div>
					<script type="text/javascript" src="http://site.yandex.net/load/form/1/form.js" charset="utf-8"></script>
				</div>
				<!-- Яндекс Поиск / Конец-->
			</div>
			<div id="center"><?php echo $text;?></div>
			<div id="right">
				<h1><?php echo $row16[ 'name' ];?></h1>
				<?php
					$news = mysql_query( "SELECT * FROM news ORDER BY id DESC LIMIT 0,3" );
					while ( $list_news = mysql_fetch_array( $news ) ) {
						echo "<h3>" . $list_news[ 'date' ] . "</h3>";
						echo $list_news[ 'text' ];
					}
				?>
			</div>
			<div class="clear"></div>
			<div id="footer">
				<p><?php echo $row14[ 'name' ];?><br /><?php echo $row15[ 'name' ];?></p>
			</div>
		</div>
	</body>
</html>