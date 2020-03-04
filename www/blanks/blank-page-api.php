<?

// $var = NULL;
// if (isset($var)) echo("set"); else echo("not");
// => not


function update_name_by_id($pdo, $id, $new_name) {
    $response = "";
    $update_name = $pdo->prepare("UPDATE `pages` SET `name` = :new_name WHERE `id` = :id;");
    $update_name->bindValue(':id', $id, PDO::PARAM_INT);
    $update_name->bindValue(':new_name', $new_name, PDO::PARAM_STR);

    if ($update_name->execute()) $response .= "The 'name' was updated!";
    else $response .= "<p>ERROR 7: Could not update the name.</p>";
    return $response;
}


function update_text_by_id($pdo, $id, $new_text) {
    $response = "";
    $update_text = $pdo->prepare("UPDATE `pages` SET `text` = :post_new_text WHERE `id` = :id;");
    $update_text->bindValue(':id', $id, PDO::PARAM_INT);
    $update_text->bindValue(':post_new_text', $new_text, PDO::PARAM_STR);

    if ($update_text->execute()) $response .= "The 'text' was updated!";
    else $response .= "<p>ERROR 8: Could not update the 'text'.</p>";
    return $response;
}


function update_tmpl_by_id($pdo, $id, $new_tmpl) {
    $response = "";
    // проверка существования шаблона
    $update_tmpl = $pdo->prepare("UPDATE `pages` SET `template` = :new_tmpl WHERE `id` = :id;");
    $update_tmpl->bindValue(':id', $id, PDO::PARAM_INT);
    $update_tmpl->bindValue(':new_tmpl', $new_tmpl, PDO::PARAM_INT);

    if ($update_tmpl->execute()) $response .= "The 'template' was updated!";
    else $response .= "<p>ERROR 9: Could not update the 'template'.</p>";
    return $response;
}


function update_prnt_by_id($pdo, $id, $new_prnt) {
    $response = "";
    // проверка существования и мб типа родителя (хотя тип может быть любым)
    $update_prnt = $pdo->prepare("UPDATE `pages` SET `parent` = :post_new_prnt WHERE `id` = :id;");
    $update_prnt->bindValue(':id', $id, PDO::PARAM_INT);
    $update_prnt->bindValue(':post_new_prnt', $new_prnt, PDO::PARAM_INT);

    if ($update_prnt->execute()) $response .= "The 'parent' was updated!";
    else $response .= "<p>ERROR 10: Could not update the 'parent'.</p>";
    return $response;
}


function update_publ_by_id($pdo, $id, $new_publ) {
    $response = "";
    $update_publ = $pdo->prepare("UPDATE `pages` SET `public_flag` = :post_new_publ WHERE `id` = :id;");
    $update_publ->bindValue(':id', $id, PDO::PARAM_INT);
    $update_publ->bindValue(':post_new_publ', $new_publ, PDO::PARAM_INT);

    if ($update_publ->execute()) $response .= "The 'public_flag' was updated!";
    else $response .= "<p>ERROR 11: Could not update the 'public_flag'.</p>";
    return $response;
}


function update_link_by_id($pdo, $id, $new_link) {
    $response = "";
    // проверка занятости адреса
    $update_link = $pdo->prepare("UPDATE `pages` SET `link` = :new_link WHERE `id` = :id;");
    $update_link->bindValue(':id', $id, PDO::PARAM_INT);
    $update_link->bindValue(':new_link', $new_link, PDO::PARAM_STR);

    if ($update_link->execute()) $response .= "The 'link' was updated!";
    else $response .= "<p>ERROR 12: Could not update the 'link'! Maybe that is busy. Field is unice.</p>";
}


function drop_page_by_id($pdo, $id) {
    $response = "";
    $page_by_id = $pdo->prepare("DELETE FROM `pages` WHERE `id` = :id;");
    $page_by_id->bindValue(':id', $id, PDO::PARAM_STR);
    $page_by_id->execute();

    if ($page_by_id->execute()) $response .= "The page was deleted.";
    else $response .= "<p>ERROR 2: Could not delete the page.</p>";
    return $response;
}


function drop_page_by_link($pdo, $link) {
    $response = "";
    $page_by_link = $pdo->prepare("DELETE FROM `pages` WHERE `link` = :link;");
    $page_by_link->bindValue(':link', $link, PDO::PARAM_STR);
    $page_by_link->execute();

    if ($page_by_link->execute()) $response .= "The page was deleted.";
    else $response .= "<p>ERROR 1: Could not delete the page.</p>";
    return $response;
}


function create_page($pdo, $p_name, $p_link, $p_tmpl, $p_prnt) {
    $response = "";
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


function get_page_id_by_link($pdo, $link) {
    $page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :link;");
    $page_by_link->bindValue(':link', $link, PDO::PARAM_STR);
    $page_by_link->execute();
    return $page_by_link;
}


if ( ! isset($_GET['act']) ) echo("<p>ERROR 22: Incorrect request.</p>");
else {

    // https://fortress-design.com/php-if-compact-syntax/
    $p_id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $p_link = isset($_POST['link']) ? $_POST['link'] : ltrim(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), '/');
    $p_name = isset($_POST['name']) ? $_POST['name'] : NULL;
    $p_prnt = isset($_POST['prnt']) ? $_POST['prnt'] : NULL;
    $p_tmpl = isset($_POST['tmpl']) ? $_POST['tmpl'] : NULL;
    $p_priv = isset($_POST['priv']) ? $_POST['priv'] : NULL;

    $new_p_name = isset($_POST['new_name']) ? $_POST['new_name'] : NULL;
    $new_p_link = isset($_POST['new_link']) ? $_POST['new_link'] : NULL;
    $new_p_text = isset($_POST['new_text']) ? $_POST['new_text'] : NULL;
    $new_p_tmpl = isset($_POST['new_tmpl']) ? $_POST['new_tmpl'] : NULL;
    $new_p_prnt = isset($_POST['new_prnt']) ? $_POST['new_prnt'] : NULL;
    $new_p_publ = isset($_POST['new_publ']) ? $_POST['new_publ'] : NULL;

    $response = NULL;
    if ($DEBUG) $response .= $p_link;
    if (count($_POST) > 0 && $DEBUG) $response .= serialize($_POST);

    if ( ! $admin_flag ) { $response .= "<p>ERROR 21: Only administators can remove pages.</p>"; }
    else {
        switch ($_GET['act']) {
            case "new":
                if ( isset($new_p_name) && isset($new_p_link) && isset($new_p_tmpl) && isset($new_p_prnt) && isset($new_p_publ) )
                {
                    $page_by_link = get_page_id_by_link($pdo, $new_p_link);
                    $count_pages = $page_by_link->rowCount();
                    switch($count_pages) {
                        default:
                            $response .= "<p>ERROR 18: $count_pages pages have been returned for this request, but there must be zero.</p>";
                            break;
                        case '1':
                            $response .= "<p>ERROR 17: The page w same link already have.</p>";
                            break;
                        case '0':
                            create_page($pdo, $new_p_name, $new_p_link, $new_p_tmpl, $new_p_publ);
                            break;
                    }
                } else $response .= "<p>ERROR 19: The post request is not correct.</p>";
                break;
            case "update":
                if ( isset($p_link) ) {
                    $page_by_link = get_page_id_by_link($pdo, $p_link);
                    $count_pages = $page_by_link->rowCount();
                    switch($count_pages) {
                        default:
                            $response .= "<p>ERROR 13: $count_pages pages have been returned for this request, but there must be one.</p>";
                            break;
                        case '0':
                            $response .= "<p>ERROR 6: No pages were found in the database for this query.</p> ";
                            break;
                        case '1':
                            $id = $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'];
                            if (isset($new_p_name)) $response .= update_name_by_id($pdo, $id, $new_p_name);
                            if (isset($new_p_text)) $response .= update_text_by_id($pdo, $id, $new_p_text);
                            if (isset($new_p_tmpl)) $response .= update_tmpl_by_id($pdo, $id, $new_p_tmpl);
                            if (isset($new_p_prnt)) $response .= update_prnt_by_id($pdo, $id, $new_p_prnt);
                            if (isset($new_p_publ)) $response .= update_publ_by_id($pdo, $id, $new_p_publ);
                            if (isset($new_p_link)) $response .= update_link_by_id($pdo, $id, $new_p_link);
                            break;
                    }

                } else $response .= "<p>ERROR 14: The post request is not correct.</p>";
                break;
            case "drop":
                //echo "<p>Ошибка! Проверка можно ли удалить страницу.</p>";

                if (isset($p_link)) $response .= drop_page_by_link($pdo, $p_link);
                else if (isset($p_id)) $response .= drop_page_by_id($pdo, $p_id);
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