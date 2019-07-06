<?if ($admin_flag && ! $error_output){?>
<table class="toolbox marg30">
    <tr>
        <td>
            <input id="edit_button" type="submit" value="Change" onclick="open_textarea()" />
            <input id="save_button" type="submit" value="Save" onclick="update_text()" />
        </td>
        <td id="page_public_flag_field_td">
            <input id="public_flag" type="checkbox" onchange="update_public_flag()" <? if(!$page_public) {echo("checked");}?>/>
            private
        </td>
        <td style="font-size:14px;">
            <input size="3" step="1" value="<? echo($page_prnt);?>" type="number" id="page_prnt_field" onchange="update_prnt()"/>
        </td>
        <td width="90px">
            <select id="template" onchange="update_template()">

            <?
            $list_tmpl = $pdo->prepare("SELECT `templates`.`id`,`templates`.`name` FROM `templates`;");
            $list_tmpl->execute();

            while ( $root_item = $list_tmpl->FETCH(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT) ) {
                if ($root_item['id'] == $page_template) {
                    echo("<option value=\"".$root_item['id']."\" selected>".$root_item['name']."</option>");
                } else {
                    echo("<option value=\"".$root_item['id']."\">".$root_item['name']."</option>");
                }
            }
            ?>

            </select>
        </td>
        <td style="font-size:14px;">
            <input value="<? echo($page_link);?>" type="text" id="page_link_field" onchange="update_link()"/>
        </td>
        <td>
            <input width="90px" id="delete_button" type="submit" value="Delete" onclick="delete_page()" />
        </td>
        <td id="editor_status" width="350px"></td>
    </tr>
</table>
<?}?>

<article>
    <section class="text-content" id="fullpage">
        <h1 class="tape" id="page_title"><?=$page_title?></h1>
        <div id="main_cont"><?=$page_content?></div>
    </section>
</article>

<?if ($admin_flag && ! $error_output){?>
    <script>window.addEvent('domready', on_dom_ready);</script>
    <textarea id="textarea1" class="marg30 js-elasticArea"><?=$page_content;?></textarea>
<?}?>