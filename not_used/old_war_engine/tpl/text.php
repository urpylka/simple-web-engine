<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
    <script src="http://api-maps.yandex.ru/1.1/index.xml?key=AHiuxkwBAAAAusMRaAMAYlHDZC5yRQL3jZLAQnUf-XmlzIQAAAAAAAAAAAAfU4czZ05jWuxnBHQNkDtyY60U6g=="
	type="text/javascript"></script>
    <script type="text/javascript">
       YMaps.jQuery(function () {
            var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
            map.setCenter(new YMaps.GeoPoint(50.174343, 53.214137), 16);
			
			// Создание стиля для содержимого балуна
            var s = new YMaps.Style();
			
			var placemark = new YMaps.Placemark(new YMaps.GeoPoint(50.176076,53.214309), {
			 style: {       
				parentStyle : "default#greenPoint",        
				balloonContentStyle : {        
					template : new YMaps.Template( 
							'<img style="float:left; padding-right:1em" src="http://war.ssau.ru/img/gerb.jpg" width = "80px" alt="" /><div style="float:left; width: 126px; color: green;"><b>$[description]</b></div>') 
						}  
						}   
			});
			placemark.name = "Самара";
			placemark.description = "Военная кафедра СГАУ им. Героя Советского Союза генерала Губанова Г.П.";
			placemark.setIconContent('ВК СГАУ');
			map.addOverlay(placemark); 
			
			// Добавление элементов управления
            map.addControl(new YMaps.TypeControl());
            map.addControl(new YMaps.ToolBar());
            map.addControl(new YMaps.Zoom());
            map.addControl(new YMaps.MiniMap());
            map.addControl(new YMaps.ScaleLine());
			
			// Открытие балуна
            placemark.openBalloon();

        });
    </script>
  <head>
    <title>Военная кафедра Самарского государственного аэрокосмического университета имени академика С.П. Королева</title>
    <link rel="stylesheet"  type="text/css" href="<? echo $site_url; ?>/css/main.css" media="screen" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    
    <!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<? echo $site_url; ?>/css/ie.css"/>
	<![endif]-->
  <!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" media="screen, projection" href="<? echo $site_url; ?>/css/ie.css" /> <? /* urpylka 19042016: file doesnt exist and repair to ie.css */?>
    <script type="text/javascript" src="<? echo $site_url; ?>/js/DD_belated.js"></script>
    <script type="text/javascript">DD_belatedPNG.fix('.index-block .corner');</script>
	<![endif]-->

  <script type="text/javascript" src="<? echo $site_url; ?>/js/jquery.js"></script>
  <script type="text/javascript" src="<? echo $site_url; ?>/js/jquery.fancybox-1.2.1.js"></script>
  <script type="text/javascript" src="<? echo $site_url; ?>/js/jquery.lightbox-0.5.js"></script>
  <script type="text/javascript" src="<? echo $site_url; ?>/js/jquery.easing.js"></script>
  <script type="text/javascript" src="<? echo $site_url; ?>/js/swfobject.js"></script>
  <link rel="stylesheet" href="<? echo $site_url; ?>/css/jquery.fancybox.css" type="text/css" media="screen">
  <link rel="stylesheet" type="text/css" href="<? echo $site_url; ?>/css/jquery.lightbox-0.5.css" media="screen" />

  <script type="text/javascript">
    function hide_blocks ()
    {
      $('.index-block').addClass('hidden');
    }
    function show_blocks ()
    {
      $('.index-block').removeClass('hidden');
    }
    
    $(document).ready(function() {
      $("a#index-link-1").fancybox({ 'hideOnContentClick': false, 'frameWidth' : 660, 'frameHeight' : 330, callbackOnStart: hide_blocks, callbackOnClose: show_blocks });
      $("a#index-link-2").fancybox({ 'hideOnContentClick': false, 'frameWidth' : 660, 'frameHeight' : 330, callbackOnStart: hide_blocks, callbackOnClose: show_blocks });
      $("a#index-link-3").fancybox({ 'hideOnContentClick': false, 'frameWidth' : 660, 'frameHeight' : 330, callbackOnStart: hide_blocks, callbackOnClose: show_blocks });
      $("a#index-link-4").fancybox({ 'hideOnContentClick': false, 'frameWidth' : 660, 'frameHeight' : 330, callbackOnStart: hide_blocks, callbackOnClose: show_blocks });
      $("a#index-link-5").fancybox({ 'hideOnContentClick': false, 'frameWidth' : 660, 'frameHeight' : 330, callbackOnStart: hide_blocks, callbackOnClose: show_blocks });
      $("a#index-link-6").fancybox({ 'hideOnContentClick': false, 'frameWidth' : 660, 'frameHeight' : 330, callbackOnStart: hide_blocks, callbackOnClose: show_blocks });
      $("a#index-link-7").fancybox({ 'hideOnContentClick': false, 'frameWidth' : 660, 'frameHeight' : 330, callbackOnStart: hide_blocks, callbackOnClose: show_blocks });
    });
  </script>
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
          <div id="menu">
              <ul>
              <?
                  $menu = mysql_query("SELECT * FROM menu WHERE type = 'section' OR type = 'index' ORDER BY id ASC");
                  while($list_menu = mysql_fetch_array($menu))
                      {
                          if($parent == $list_menu['link']) {echo "<li class=\"select\">".$list_menu['name']."</li>";}
                          elseif ($list_menu['link'] == 'index') {echo "<li><a href=\"$site_url\">".$list_menu['name']."</a></li>";}
						  /*
                          elseif ($list_menu['link'] == 'abitur') {echo "<li><a href=\"$site_url/abitur/rules/\">".$list_menu['name']."</a></li>";}
                          elseif ($list_menu['link'] == 'students') {echo "<li><a href=\"$site_url/students/qual/\">".$list_menu['name']."</a></li>";}
                          elseif ($list_menu['link'] == 'multimedia') {echo "<li><a href=\"$site_url/multimedia/photo/\">".$list_menu['name']."</a></li>";}
						  elseif ($list_menu['link'] == 'history') {echo "<li><a href=\"$site_url/history/ocherk/\">".$list_menu['name']."</a></li>";}
						  elseif ($list_menu['link'] == 'graduate') {echo "<li><a href=\"$site_url/graduate/prik/\">".$list_menu['name']."</a></li>";}
						  */
                          else{
                                  echo "<li><a href=\"$site_url/".$list_menu['link']."\">".$list_menu['name']."</a></li>";
                              }
                      }
              ?>
              </ul>
          </div>
          <div id="submenu">
              <ul>
              <?
                  $submenu = mysql_query("SELECT * FROM menu WHERE parent = '$parent' ORDER BY id ASC");
                  while($list_submenu = mysql_fetch_array($submenu))
                      {
                          if($link == $list_submenu['link']) {echo "<li>".$list_submenu['name']."</li>";}
                          else{
                                  echo "<li><a href=\"$site_url/$parent/".$list_submenu['link']."\">".$list_submenu['name']."</a></li>";
                              }
                      }
              ?>    
              </ul>
          </div>
          <div id="content">
              <? echo $text; ?>
                  <br />
          </div>
          <script type="text/javascript">
$(function() {
 $('#107 a').lightBox();
 $('#103 a').lightBox();
 $('#205 a').lightBox();
 $('#209 a').lightBox();
 $('#210 a').lightBox();
 $('#angar a').lightBox();
 $('#105 a').lightBox();
 $('#108 a').lightBox();
 $('#um9 a').lightBox();
 $('#um10 a').lightBox();
 $('#um7 a').lightBox();
 $('#umetodbase a').lightBox();
});
</script>
          <div id="clear"></div>
          <div id="footer">
            <br />
            <div id="f-text">
                <p>&copy; Военная кафедра Самарского государственного аэрокосмического университета, 2017</p>            
            </div>
          </div>
      </div>
  </body>
</html>