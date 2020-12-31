<?
# форма добавления страниц
if($_GET['op'] == 'addform') { ?>
  <div id="workzone">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div id="form">
      <h1>Добавить новую страницу</h1>
      <form method="post" action="http://<?=$_SERVER['HTTP_HOST']?>/admin/menu/addpage/">
        <div class="field"><input type="text" name="name" id="title" />&larr; Название страницы</div>
        <div class="field"><input type="text" name="entitle" id="en-title" />&larr; URL страницы</div>
        <div class="lineForm">
          <select name="type" id="type">
            <option value="" selected="selected">Выберите тип страницы</option>
            <option value="section">--Раздел--</option>
            <option value="text">--Текстовая страница--</option>
            <option value="news">--Новости--</option>
          </select>
        </div>
        <div class="lineForm">
          <select name="parent" id="include">
            <option value="/" selected="selected">--Вложить в...--</option>
            <?
                #выводим основные разделы
                $types = mysql_query("SELECT * FROM menu WHERE type = 'section' ORDER BY id ASC");
                while($list_types = mysql_fetch_array($types))
                  {
                      echo "<option value=\"".$list_types['link']."\">".$list_types['name']."</option>";
                      #выводим второй уровень меню
                      $factory = mysql_query("SELECT * FROM menu WHERE parent = '".$list_types['link']."' ORDER BY id ASC");
                      while($list_factory = mysql_fetch_array($factory))
                        {
                          echo "<option value=\"".$list_factory['link']."\">&nbsp;&nbsp;&rarr;&nbsp;".$list_factory['name']."</option>";
                          #выводим третий уровень меню
                          $types_of_print = mysql_query("SELECT * FROM menu WHERE parent = '".$list_factory['link']."' ORDER BY id ASC");
                          while($list_types_of_print = mysql_fetch_array($types_of_print))
                            {
                              echo "<option value=\"".$list_types_of_print['link']."\">&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;".$list_types_of_print['name']."</option>";
                            }
                        }
                  }
            ?>
          </select>
        </div>
        <div class="text">
          <textarea class="ckeditor" cols="80" id="editor1" name="text" rows="10"></textarea>
        </div>
        <div class="field"><input type="submit" value="Добавить страницу" /></div>
      </form>
    </div>
    <div class="corner bl"></div>
    <div class="corner br"></div>
  </div>
<?
}

# форма редактирования страницы
elseif($_GET['op'] == 'editform') {
$edit_page = mysql_query("SELECT * FROM menu WHERE id = '".$_GET['id']."' ORDER BY id ASC");
$edit_page_data = mysql_fetch_array($edit_page);
?>
  <div id="workzone">
    <div class="corner tl"></div>
    <div class="corner tr"></div>
    <div id="form">
      <h1>Редактирование страницы</h1>
      <form method="post" action="http://<?=$_SERVER['HTTP_HOST']?>/admin/menu/editpage/<? echo $_GET['id']; ?>">
        <div class="field"><input type="text" name="name" id="title" value="<? echo $edit_page_data['name']; ?>" />&larr; Название страницы</div>
        <div class="field"><input type="text" name="entitle" id="en-title" value="<? echo $edit_page_data['link']; ?>" />&larr; URL страницы</div>
        <div class="lineForm">
          <select name="type" id="type">
            <option value="">Выберите тип страницы</option>
            <option value="section" <? if($edit_page_data['type'] == 'section') echo "selected=\"selected\""; ?>>--Раздел--</option>
            <option value="text" <? if($edit_page_data['type'] == 'text') echo "selected=\"selected\""; ?>>--Текстовая страница--</option>
            <option value="news" <? if($edit_page_data['type'] == 'news') echo "selected=\"selected\""; ?>>--Новости--</option>
          </select>
        </div>
        <div class="lineForm">
          <select name="parent" id="include">
            <option value="section" <? if($edit_page_data['type'] == 'section') echo "selected=\"selected\""; ?>>--Вложить в...--</option>
                <?
                    #выводим типы устройств
                    $types = mysql_query("SELECT * FROM menu WHERE type = 'section' ORDER BY id ASC");
                    while($list_types = mysql_fetch_array($types))
                      {
                          if($edit_page_data['parent'] == $list_types['link']){
                            echo "<option value=\"".$list_types['link']."\" selected=\"selected\">".$list_types['name']."</option>";
                          } else {
                            echo "<option value=\"".$list_types['link']."\">".$list_types['name']."</option>";
                          }
                          #выводим производителей для каждого типа устройств
                          $factory = mysql_query("SELECT * FROM menu WHERE parent = '".$list_types['link']."' ORDER BY id ASC");
                          while($list_factory = mysql_fetch_array($factory))
                            {
                              if($edit_page_data['parent'] == $list_factory['link']){
                                echo "<option value=\"".$list_factory['link']."\" selected=\"selected\">&nbsp;&nbsp;&rarr;&nbsp;".$list_factory['name']."</option>";
                              } else {
                                echo "<option value=\"".$list_factory['link']."\">&nbsp;&nbsp;&rarr;&nbsp;".$list_factory['name']."</option>";
                              }
                              #выводим возможные типы печати для производителей
                              $types_of_print = mysql_query("SELECT * FROM menu WHERE parent = '".$list_factory['link']."' ORDER BY id ASC");
                              while($list_types_of_print = mysql_fetch_array($types_of_print))
                                {
                                  if($edit_page_data['parent'] == $list_types_of_print['link']){
                                    echo "<option value=\"".$list_types_of_print['link']."\" selected=\"selected\">&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;".$list_types_of_print['name']."</option>";
                                  } else {
                                    echo "<option value=\"".$list_types_of_print['link']."\">&nbsp;&nbsp;&nbsp;&nbsp;&rarr;&nbsp;".$list_types_of_print['name']."</option>";
                                  }
                                }
                            }
                      }
                ?>
              </select>
        </div>
        <div class="text">
          <textarea class="ckeditor" cols="80" id="editor1" name="text" rows="10"><? echo $edit_page_data['text']; ?></textarea>
        </div>
        <div class="field"><input type="submit" value="Редактировать страницу" /></div>
      </form>
    </div>
    <div class="corner bl"></div>
    <div class="corner br"></div>
  </div>

<?
}
#обработка добавления страницы
elseif($_GET['op'] == 'addpage') {
  if(isset($_POST['name']) && isset($_POST['type'])) {
      $entitle = strtolower($_POST['entitle']);
      $add_page = mysql_query("INSERT menu SET
        type = '".$_POST['type']."',
        name = '".$_POST['name']."',
        parent = '".$_POST['parent']."',
        link = '".$entitle."',
        text = '".$_POST['text']."'
      ") or die(mysql_error());
      if($add_page) {
        echo "<center><p style=\"color:green; border:1px solid #fff;\">Раздел успешно добавлен</p></center>";
        }
      else {
        echo "<center><p style=\"color:red; border:1px solid #fff;\">Ошибка при добавлении раздела</p></center>";
      }
  } else {
      echo "Вы заполнили не все поля. <a href=\"http://war.ssau.ru/admin/pages/add/\">Попробуйте снова</a>";
  }
}

#обработка редактирования страницы
elseif($_GET['op'] == 'editpage') {
  if(isset($_POST['name']) && isset($_POST['type'])) {
      $entitle = strtolower($_POST['entitle']);
      $edit_page = mysql_query("UPDATE menu SET
        type = '".$_POST['type']."',
        name = '".$_POST['name']."',
        parent = '".$_POST['parent']."',
        link = '".$entitle."',
        text = '".$_POST['text']."'
        WHERE id = '".$_GET['id']."'
      ") or die(mysql_error());
      if($edit_page) {
        echo "<center><p style=\"color:green; border:1px solid #fff;\">Страница успешно отредактирована</p></center>";
        }
      else {
        echo "<center><p style=\"color:red; border:1px solid #fff;\">Ошибка при редактировании раздела</p></center>";
      }
  } else {
      echo "Не все поля заполнены. <a href=\"http://war.ssau.ru/admin/pages/editform/".$GET['id']."/\">Попробуйте снова</a>";
  }
}

#обработка удаления страницы
elseif($_GET['op'] == 'del') {
      $delete = mysql_query("DELETE FROM menu WHERE id = '".$_GET['id']."' OR parent = '".$_GET['id']."'");
      if($delete) {
        echo "<center><p style=\"color:green; border:1px solid #fff;\">Страница успешно удалена</p></center>";
      }
      else {
        echo "<center><p style=\"color:red; border:1px solid #fff;\">Ошибка при удалении раздела</p></center>";
      }
}
?>