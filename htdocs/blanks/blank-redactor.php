<?
if ( ! isset($_GET['act']) ) echo "<p>Ошибка! Неккоректный запрос 1.</p>"; 
else {
    switch ($_GET['act']) {
        case "drop":
            if ( ! $admin_flag ) { echo "<p>Ошибка! Только администраторы могут удалять страницы.</p>"; }
            else {
                //echo "<p>Ошибка! Проверка можно ли удалить страницу.</p>";
                $response = NULL;

                if ( isset($_POST['link']) ) {

                    // почему-то isset($_POST['link'])
                    // вообще нормально не работает
                    // выдает непонятно какой один символ,
                    // и никак не могу его отловить
                    // при этом вообще не передаю link
                    if ( count($_POST['link']) == 1 ) {
                        $link = substr(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), 1);
                    } else {
                        $link = $_POST['link'];
                    }

                    $page_by_link = $pdo->prepare("DELETE FROM `pages` WHERE `link` = :link;");
                    $page_by_link->bindValue(':link', $link, PDO::PARAM_STR);
                    $page_by_link->execute();

                    if ($page_by_link->execute()) $response .= "The page was deleted!";
                    else $response .= "<p>ERROR: Could not delete the page!</p>";

                } else echo("<p>ERROR: The post request is not correct!</p>");

                if ( isset($_POST['id']) ) {
                    $page_by_id = $pdo->prepare("DELETE FROM `pages` WHERE `id` = :id;");
                    $page_by_id->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
                    $page_by_id->execute();

                    if ($page_by_id->execute()) $response .= "The page was deleted!";
                    else $response .= "<p>ERROR: Could not delete the page!</p>";

                } else $response .= "<p>ERROR: The post request is not correct!</p>";
            }
            echo($response);
            break;
        case "update":
            if ( ! $admin_flag ) { echo "<p>Ошибка! Только администраторы могут удалять страницы.</p>"; }
            else {
                if ( isset($_POST['link']) && count($_POST) > 1 )
                {

                    // почему-то isset($_POST['link'])
                    // вообще нормально не работает
                    // выдает непонятно какой один символ,
                    // и никак не могу его отловить
                    // при этом вообще не передаю link
                    if ( count($_POST['link']) == 1 ) {
                        $link = substr(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), 1);
                    } else {
                        $link = $_POST['link'];
                    }

                    $page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :post_link;");
                    $page_by_link->bindValue(':post_link', $link, PDO::PARAM_STR);
                    $page_by_link->execute();
                    $count_pages = $page_by_link->rowCount();

                    switch($count_pages) {
                        case '0':
                            echo("<p>ERROR: No pages were found in the database for this query.</p> ");
                            break;
                        case '1':
                            
                            $response = NULL;

                            if (isset($_POST['new_name'])) {
                                $update_name = $pdo->prepare("UPDATE `pages` SET `name` = :post_new_name WHERE `id` = :id;");
                                $update_name->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
                                $update_name->bindValue(':post_new_name', $_POST['new_name'], PDO::PARAM_STR);

                                if ($update_name->execute()) $response .= "The 'name' was updated!";
                                else $response .= "<p>ERROR: Could not update the name!</p>";
                            }
                            if (isset($_POST['new_text'])) {
                                $update_text = $pdo->prepare("UPDATE `pages` SET `text` = :post_new_text WHERE `id` = :id;");
                                $update_text->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
                                $update_text->bindValue(':post_new_text', $_POST['new_text'], PDO::PARAM_STR);

                                if ($update_text->execute()) $response .= "The 'text' was updated!";
                                else $response .= "<p>ERROR: Could not update the 'text'!</p>";
                            }
                            if (isset($_POST['new_tmpl'])) {
                                // проверка существования шаблона
                                $update_tmpl = $pdo->prepare("UPDATE `pages` SET `template` = :post_new_tmpl WHERE `id` = :id;");
                                $update_tmpl->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
                                $update_tmpl->bindValue(':post_new_tmpl', $_POST['new_tmpl'], PDO::PARAM_INT);

                                if ($update_tmpl->execute()) $response .= "The 'template' was updated!";
                                else $response .= "<p>ERROR: Could not update the 'template'!</p>";
                            }
                            if (isset($_POST['new_prnt'])) {
                                // проверка существования и мб типа родителя (хотя тип может быть любым)
                                $update_prnt = $pdo->prepare("UPDATE `pages` SET `parent` = :post_new_prnt WHERE `id` = :id;");
                                $update_prnt->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
                                $update_prnt->bindValue(':post_new_prnt', $_POST['new_prnt'], PDO::PARAM_INT);

                                if ($update_prnt->execute()) $response .= "The 'parent' was updated!";
                                else $response .= "<p>ERROR: Could not update the 'parent'!</p>";
                            }
                            if (isset($_POST['new_publ'])) {
                                $update_publ = $pdo->prepare("UPDATE `pages` SET `public_flag` = :post_new_publ WHERE `id` = :id;");
                                $update_publ->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
                                $update_publ->bindValue(':post_new_publ', $_POST['new_publ'], PDO::PARAM_INT);

                                if ($update_publ->execute()) $response .= "The 'public_flag' was updated!";
                                else $response .= "<p>ERROR: Could not update the 'public_flag'!</p>";
                            }
                            if (isset($_POST['new_link'])) {
                                // проверка занятости адреса
                                $update_link = $pdo->prepare("UPDATE `pages` SET `link` = :post_new_link WHERE `id` = :id;");
                                $update_link->bindValue(':id', $page_by_link->FETCH(PDO::FETCH_ASSOC)['id'], PDO::PARAM_INT);
                                $update_link->bindValue(':post_new_link', $_POST['new_link'], PDO::PARAM_STR);

                                if ($update_link->execute()) $response .= "The 'link' was updated!";
                                else $response .= "<p>ERROR: Could not update the 'link'! Maybe that is busy. Field is unice</p>";
                            }
                            echo($response);
                            break;
                        default:
                            echo("<p>ERROR: $count_pages pages have been returned for this request, but there must be one!</p>");
                            break;
                    }
                }
                else echo("<p>ERROR: The post request is not correct!</p>");
            }
            break;
        case "new":
            if ( ! $admin_flag ) { echo "<p>Ошибка! Только администраторы могут удалять страницы.</p>"; }
            else {
                if ( isset($_POST['link']) && isset($_POST['name']) && isset($_POST['prnt']) && isset($_POST['tmpl']) && isset($_POST['priv']) )
                {


                    // почему-то isset($_POST['link'])
                    // вообще нормально не работает
                    // выдает непонятно какой один символ,
                    // и никак не могу его отловить
                    // при этом вообще не передаю link
                    if ( count($_POST['link']) == 1 ) {
                        $link = substr(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), 1);
                    } else {
                        $link = $_POST['link'];
                    }

                    $page_by_link = $pdo->prepare("SELECT id FROM pages WHERE link = :post_link;");
                    $page_by_link->bindValue(':post_link', $link, PDO::PARAM_STR);
                    $page_by_link->execute();
                    $count_pages = $page_by_link->rowCount();

                    switch($count_pages) {
                        case '0':
                            $response = NULL;

                            $new_page = $pdo->prepare("INSERT INTO `pages` (parent, name, template, link) VALUES (:parent, :name, :template, :link);");
                            $new_page->bindValue(':parent', $_POST['prnt'], PDO::PARAM_INT);
                            $new_page->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
                            $new_page->bindValue(':template', $_POST['tmpl'], PDO::PARAM_INT);
                            $new_page->bindValue(':link', $_POST['link'], PDO::PARAM_STR);

                            if ($new_page->execute()) {
                                $response .= "The page was created!";
                                $response .= "<script>location=\"\/".$_POST['link']."\";</script>";
                                
                            }
                            else $response .= "<p>ERROR: Could not create page!</p>";

                            echo($response);
                            break;
                        case '1':
                            echo("<p>ERROR: The page w same link already have.</p>");
                            break;
                        default:
                            echo("<p>ERROR: $count_pages pages have been returned for this request, but there must be zero!</p>");
                            break;
                    }
                }
                else echo("<p>ERROR: The post request is not correct!</p>");
            }

            break;
        default:
            echo "<p>Ошибка! Неккоректный запрос 2.</p>";
            break;
    }	
}
?>