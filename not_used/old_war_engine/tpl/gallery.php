<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
  <head>
    <title>Военная кафедра Самарского государственного аэрокосмического университета имени академика С.П. Королева</title>
    <link rel="stylesheet"  type="text/css" href="<? echo $site_url; ?>/css/main.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<? echo $site_url; ?>/css/jquery.ad-gallery.css">
    <script type="text/javascript" src="<? echo $site_url; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<? echo $site_url; ?>/js/jquery.ad-gallery.js?rand=995"></script>
    <script type="text/javascript">
  $(function() {

    $('img.image4').data('ad-desc', 'This image is wider than the wrapper, so it has been scaled down');
    $('img.image5').data('ad-desc', 'This image is higher than the wrapper, so it has been scaled down');
    var galleries = $('.ad-gallery').adGallery();
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
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
                  $menu = mysql_query("SELECT * FROM menu WHERE type = 'section' ORDER BY id ASC");
                  while($list_menu = mysql_fetch_array($menu))
                      {
                          if($parent == $list_menu['link']) {echo "<li class=\"select\">".$list_menu['name']."</li>";}
                          elseif ($list_menu['link'] == 'index') {echo "<li><a href=\"$site_url\">".$list_menu['name']."</a></li>";}
						  /*
                          elseif ($list_menu['link'] == 'abitur') {echo "<li><a href=\"$site_url/abitur/rules/\">".$list_menu['name']."</a></li>";}
                          elseif ($list_menu['link'] == 'students') {echo "<li><a href=\"$site_url/students/qual/\">".$list_menu['name']."</a></li>";}
                          elseif ($list_menu['link'] == 'multimedia') {echo "<li><a href=\"$site_url/multimedia/photo/\">".$list_menu['name']."</a></li>";}
						  elseif ($list_menu['link'] == 'history') {echo "<li><a href=\"$site_url/history/ocherk/\">".$list_menu['name']."</a></li>";}
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
          <center>
              <div id="gallery" class="ad-gallery">
      <div class="ad-image-wrapper">
      </div>
      <div class="ad-controls">
      </div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
            <li>
              <a href="<? echo $site_url; ?>/img/gallery/1.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/1.jpg" title="Студенты военной кафедры" longdesc="Лекция по дисциплине 'Тактика ВВС'" class="image0">
              </a>
            </li>
            <li>
              <a href="<? echo $site_url; ?>/img/gallery/2.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/2.jpg" title="Самолет МиГ-29" longdesc="Бортовой номер 46" class="image1">
              </a>
            </li>
            <li>
              <a href="<? echo $site_url; ?>/img/gallery/3.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/3.jpg" title="Студенты военной кафедры" longdesc="Занятия в ангаре"  class="image2">
              </a>
            </li>
            <li>
              <a href="<? echo $site_url; ?>/img/gallery/4.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/4.jpg" title="Подполковник Кодуков А.Г." longdesc="Занятия по дисциплине 'Конструкция двигателя РД-33'" class="image3">
              </a>
            </li>
            <li>
              <a href="<? echo $site_url; ?>/img/gallery/5.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/5.jpg" title="Самолет МиГ-29" longdesc="Бортовой номер 46" class="image4">
              </a>
            </li>
            <li>
              <a href="<? echo $site_url; ?>/img/gallery/6.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/6.jpg" title="Самолет МиГ-29" longdesc="Бортовой номер 46" class="image5">
              </a>
            </li>
			<li>
              <a href="<? echo $site_url; ?>/img/gallery/7.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/7.jpg" title="" longdesc="" class="image6">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/8.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/8.jpg" title="" longdesc="" class="image7">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/9.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/9.jpg" title="" longdesc="" class="image8">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/10.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/10.jpg" title="" longdesc="" class="image9">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/11.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/11.jpg" title="" longdesc="" class="image10">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/12.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/12.jpg" title="" longdesc="" class="image11">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/13.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/13.jpg" title="" longdesc="" class="image12">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/14.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/14.jpg" title="" longdesc="" class="image13">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/15.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/15.jpg" title="" longdesc="" class="image14">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/16.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/16.jpg" title="" longdesc="" class="image15">
              </a>
            </li>
						<li>
              <a href="<? echo $site_url; ?>/img/gallery/17.jpg">
                <img src="<? echo $site_url; ?>/img/gallery/thumbs/17.jpg" title="" longdesc="" class="image16">
              </a>
            </li>
          </ul>
        </div>
        </center>
          </div>
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