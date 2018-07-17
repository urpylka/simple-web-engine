<?
if(!isset($_GET['op'])) { ?>
  <div id="workzone">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <p class="addform"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/img/add.png" width="32px" height="32px" /><a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/admin/news/addform/">Добавить новость</a></p>
    <table cellspacing="1" cellpadding="0" id="listpages">
<?
    function substring($str,$count=60){
      $str=strip_tags($str);
      if (strlen($str)>$count) {
        $substr=substr($str,0,$count-1);
        return substr($substr,0,strlen($substr)-strlen(strrchr(substr($str,0,$count-1)," "))+1)."...";
      }else{
        return $str;
      }
    }
    #выводим новости
    $news = mysql_query("SELECT * FROM news ORDER BY id DESC");
    while($list_news = mysql_fetch_array($news))
      {
          $news_header = substring($list_news['text'],60);
          echo "<tr>
                  <td class=\"link\"><p><a href=\"http://".$_SERVER['HTTP_HOST']."/admin/".$_GET['action']."/editform/".$list_news['id']."/\">".$list_news['date']." &mdash; $news_header</a></p></td>
                  <td class=\"functions\"><p><a href=\"http://".$_SERVER['HTTP_HOST']."/admin/".$_GET['action']."/del/".$list_news['id']."/\"><img src=\"http://".$_SERVER['HTTP_HOST']."/img/delete.png\" width=\"24px\" height=\"24px\" /></a></p></td>
                </tr>";
      }
?>
    </table>
    <div class="corner bl"></div>
    <div class="corner br"></div>
  </div>
<?
}

elseif($_GET['op'] == 'addform') { ?>
  <div id="workzone">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div id="form">
      <h1>Добавить новость</h1>
      <form method="post" action="http://<? echo $_SERVER['HTTP_HOST']; ?>/admin/news/addpage/">
        <div class="field"><input type="text" name="date" id="date" value="<? echo date('d.m.Y'); ?>" />&larr; Дата</div><br />
        <div class="text">
          <textarea class="ckeditor" cols="80" id="editor1" name="text" rows="10"></textarea>
        </div>
        <div class="field"><input type="submit" value="Добавить новость" /></div>
      </form>
    </div>
    <div class="corner bl"></div>
    <div class="corner br"></div>
  </div>
<?
}

#обработка добавления новости
elseif($_GET['op'] == 'addpage'){
        $add = mysql_query("  
        INSERT news  
        SET date = '".$_POST['date']."',
        text = '".$_POST['text']."'
        ");
        if($add){
            echo "<center><p style=\"color:green; border:1px solid #fff;\">Новость успешно добавлена</p></center>";
        }
        else
        {echo "<center><p style=\"color:red; border:1px solid #fff;\">Ошибка при удалении новости</p></center>";}

}

#обработка удаления новости
elseif($_GET['op'] == 'del'){
        $delete = mysql_query("DELETE FROM news WHERE id = '".$_GET['id']."'");
        if($delete){
            echo "<center><p style=\"color:green; border:1px solid #fff;\">Новость успешно удалена</p></center>";
        }
        else
        {echo "<center><p style=\"color:red; border:1px solid #fff;\">Ошибка при удалении новости</p></center>";}

}

#обработка редактирования новости
elseif($_GET['op'] == 'editpage'){
        $edit = mysql_query("  
        UPDATE news
        SET date = '".$_POST['date']."',
        text = '".$_POST['text']."'
        WHERE id = '".$_GET['id']."'
        ");
        if($edit){
            echo "<center><p style=\"color:green; border:1px solid #fff;\">Новость успешно отредактирована</p></center>";
        }
        else
        {echo "<center><p style=\"color:red; border:1px solid #fff;\">Ошибка при редактировании новости</p></center>";}

}

#редактирование новости
elseif($_GET['op'] == 'editform'){ 
$news = mysql_query("SELECT * FROM news WHERE id = '".$_GET['id']."'");
$list_news = mysql_fetch_assoc($news); ?>
  <div id="workzone">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div id="form">
      <h1>Редактировать новость</h1>
      <form method="post" action="http://<? echo $_SERVER['HTTP_HOST']; ?>/admin/news/editpage/<? echo $_GET['id']; ?>">
        <div class="field"><input type="text" name="date" id="date" value="<? echo $list_news['date'] ?>" />&larr; Дата</div><br />
        <div class="text">
          <textarea class="ckeditor" cols="80" id="editor1" name="text" rows="10"><? echo $list_news['text']; ?></textarea>
        </div>
        <div class="field"><input type="submit" value="Редактировать новость" /></div>
      </form>
    </div>
    <div class="corner bl"></div>
    <div class="corner br"></div>
  </div>
<?
}
