<?

// $var = NULL;
// if (isset($var)) echo("set"); else echo("not");
// => not


function update_name_by_id($id, $new_name) {
    $update_name = $pdo->prepare("UPDATE `pages` SET `name` = :new_name WHERE `id` = :id;");
    $update_name->bindValue(':id', $id, PDO::PARAM_INT);
    $update_name->bindValue(':new_name', $new_name, PDO::PARAM_STR);

    if ($update_name->execute()) $response .= "The 'name' was updated!";
    else $response .= "<p>ERROR 7: Could not update the name.</p>";
    return $response;
}


function update_text_by_id($id, $new_text) {
    $update_text = $pdo->prepare("UPDATE `pages` SET `text` = :post_new_text WHERE `id` = :id;");
    $update_text->bindValue(':id', $id, PDO::PARAM_INT);
    $update_text->bindValue(':post_new_text', $new_text, PDO::PARAM_STR);

    if ($update_text->execute()) $response .= "The 'text' was updated!";
    else $response .= "<p>ERROR 8: Could not update the 'text'.</p>";
    return $response;
}


function update_tmpl_by_id($id, $new_tmpl) {
    // проверка существования шаблона
    $update_tmpl = $pdo->prepare("UPDATE `pages` SET `template` = :new_tmpl WHERE `id` = :id;");
    $update_tmpl->bindValue(':id', $id, PDO::PARAM_INT);
    $update_tmpl->bindValue(':new_tmpl', $new_tmpl, PDO::PARAM_INT);

    if ($update_tmpl->execute()) $response .= "The 'template' was updated!";
    else $response .= "<p>ERROR 9: Could not update the 'template'.</p>";
    return $response;
}


function update_prnt_by_id($id, $new_prnt) {
    // проверка существования и мб типа родителя (хотя тип может быть любым)
    $update_prnt = $pdo->prepare("UPDATE `pages` SET `parent` = :post_new_prnt WHERE `id` = :id;");
    $update_prnt->bindValue(':id', $id, PDO::PARAM_INT);
    $update_prnt->bindValue(':post_new_prnt', $new_prnt, PDO::PARAM_INT);

    if ($update_prnt->execute()) $response .= "The 'parent' was updated!";
    else $response .= "<p>ERROR 10: Could not update the 'parent'.</p>";
    return $response;
}


function update_publ_by_id($id, $new_publ) {
    $update_publ = $pdo->prepare("UPDATE `pages` SET `public_flag` = :post_new_publ WHERE `id` = :id;");
    $update_publ->bindValue(':id', $id, PDO::PARAM_INT);
    $update_publ->bindValue(':post_new_publ', $new_publ, PDO::PARAM_INT);

    if ($update_publ->execute()) $response .= "The 'public_flag' was updated!";
    else $response .= "<p>ERROR 11: Could not update the 'public_flag'.</p>";
    return $response;
}


function update_link_by_id($id, $new_link) {
    // проверка занятости адреса
    $update_link = $pdo->prepare("UPDATE `pages` SET `link` = :new_link WHERE `id` = :id;");
    $update_link->bindValue(':id', $id, PDO::PARAM_INT);
    $update_link->bindValue(':new_link', $new_link, PDO::PARAM_STR);

    if ($update_link->execute()) $response .= "The 'link' was updated!";
    else $response .= "<p>ERROR 12: Could not update the 'link'! Maybe that is busy. Field is unice.</p>";
}


function drop_page_by_id($id) {
    $page_by_id = $pdo->prepare("DELETE FROM `pages` WHERE `id` = :id;");
    $page_by_id->bindValue(':id', $id, PDO::PARAM_STR);
    $page_by_id->execute();

    if ($page_by_id->execute()) $response .= "The page was deleted.";
    else $response .= "<p>ERROR 2: Could not delete the page.</p>";
    return $response;
}


function drop_page_by_link($link) {
    $page_by_link = $pdo->prepare("DELETE FROM `pages` WHERE `link` = :link;");
    $page_by_link->bindValue(':link', $link, PDO::PARAM_STR);
    $page_by_link->execute();

    if ($page_by_link->execute()) $response .= "The page was deleted.";
    else $response .= "<p>ERROR 1: Could not delete the page.</p>";
    return $response;
}


function create_page($p_name, $p_link, $p_tmpl, $p_prnt) {
    $new_page = $pdo->prepare("INSERT INTO `pages` (parent, name, template, link) VALUES (:parent, :name, :template, :link);");
    $new_page->bindValue(':parent', $p_prnt, PDO::PARAM_INT);
    $new_page->bindValue(':name', $p_name, PDO::PARAM_STR);
    $new_page->bindValue(':template', $p_tmpl, PDO::PARAM_INT);
    $new_page->bindValue(':link', $p_link, PDO::PARAM_STR);

    if ($new_page->execute()) {
        $response .= "The page was created!";
        $response .= "<script>location=\"\/".$p_link."\";</script>";
    } else $response .= "<p>ERROR 16: Could not create page.</p>";
    return $response;
}


function get_id_by_link($link) {
    $page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :link;");
    $page_by_link->bindValue(':link', $link, PDO::PARAM_STR);
    $page_by_link->execute();
    $count_pages = $page_by_link->rowCount();

    $response = "";
    $id = -1;

    switch($count_pages) {
        default:
            $response .= "<p>ERROR 13: $count_pages pages have been returned for this request, but there must be one.</p>";
            break;
        case '0':
            $response .= "<p>ERROR 6: No pages were found in the database for this query.</p> ";
            break;
        case '1':
            $id = $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'];
            break;
    }
    echo($response);
    return $id;
}


if ( ! isset($_GET['act']) ) echo "<p>ERROR 22: Incorrect request.</p>"; 
else {

    $p_id = NULL;
    $p_link = substr(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), 1);
    $p_text = NULL;
    $p_name = NULL;
    $p_tmpl = NULL;
    $p_prnt = NULL;

    $new_p_text = NULL;
    $new_p_name = NULL;
    $new_p_tmpl = NULL;
    $new_p_prnt = NULL;

    if ( count($_POST) > 0 ) {
        // https://fortress-design.com/php-if-compact-syntax/
        // min = (а < b ? a : b);
        if ( isset($_POST['id']) ) { $p_id = $_POST['id']; }
        if ( isset($_POST['link']) ) { $p_link = $_POST['link']; }
        if ( isset($_POST['name']) ) { $p_name = $_POST['name']; }
        if ( isset($_POST['prnt']) ) { $p_prnt = $_POST['prnt']; }
        if ( isset($_POST['tmpl']) ) { $p_tmpl = $_POST['tmpl']; }
        if ( isset($_POST['priv']) ) { $p_priv = $_POST['priv']; }

        if ( isset($_POST['new_link']) ) { $new_p_link = $_POST['new_link']; }
        if ( isset($_POST['new_name']) ) { $new_p_name = $_POST['new_name']; }
        if ( isset($_POST['new_text']) ) { $new_p_text = $_POST['new_text']; }
        if ( isset($_POST['new_tmpl']) ) { $new_p_tmpl = $_POST['new_tmpl']; }
        if ( isset($_POST['new_prnt']) ) { $new_p_prnt = $_POST['new_prnt']; }
        if ( isset($_POST['new_publ']) ) { $new_p_publ = $_POST['new_publ']; }
    }

    $response = NULL;

    if ( ! $admin_flag ) { $response .= "<p>ERROR 21! Only administators can remove pages.</p>"; }
    else {
        switch ($_GET['act']) {
            case "new":
                if ( isset($p_name) && isset($p_prnt) && isset($p_tmpl) && isset($p_priv) )
                {


                    $page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :link;");
                    $page_by_link->bindValue(':link', $p_link, PDO::PARAM_STR);
                    $page_by_link->execute();
                    $count_pages = $page_by_link->rowCount();

                    switch($count_pages) {
                        default:
                            $response .= "<p>ERROR 18: $count_pages pages have been returned for this request, but there must be zero.</p>";
                            break;
                        case '1':
                            $response .= "<p>ERROR 17: The page w same link already have.</p>";
                            break;
                        case '0':
                            create_page($p_name, $p_link, $p_tmpl, $p_prnt);
                            break;
                    }


                } else $response .= "<p>ERROR 19: The post request is not correct.</p>";
                break;
            case "update":
                if ( isset($p_link) ) {
                    $id = get_id_by_link($p_link);

                    if (isset($new_p_name)) update_name_by_id($id, $new_p_name);
                    if (isset($new_p_text)) update_text_by_id($id, $new_p_text);
                    if (isset($new_p_tmpl)) update_tmpl_by_id($id, $new_p_tmpl);
                    if (isset($new_p_prnt)) update_prnt_by_id($id, $new_p_prnt);
                    if (isset($new_p_publ)) update_publ_by_id($id, $new_p_publ);
                    if (isset($new_p_link)) update_link_by_id($id, $new_p_link);            

                } else $response .= "<p>ERROR 14: The post request is not correct.</p>";
                break;
            case "drop":
                //echo "<p>Ошибка! Проверка можно ли удалить страницу.</p>";

                if (isset($p_link)) $response .= drop_page_by_link($p_link);
                else if (isset($p_id)) $response .= drop_page_by_id($p_id);
                else $response .= "<p>ERROR 3, 4: The post request is not correct.</p>";
                break;
            default:
                $response .= "<p>ERROR 20: Incorrect request.</p>";
                break;
        }
        echo($response);
    }
}
?>