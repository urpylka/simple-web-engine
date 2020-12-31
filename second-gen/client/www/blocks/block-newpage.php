<?if ($admin_flag && ! $error_output){?>
<table class="toolbox marg30">
    <tr>
        <td id="page_public_flag_field_td">
            <input id="public_flag" type="checkbox" checked />
            private
        </td>
        <td>
            <input size="3" step="1" value="-1" type="number" id="page_prnt_field" />
        </td>
        <td width="90px">
            <select id="template">

            <?
            $list_tmpl = $pdo->prepare("SELECT `templates`.`id`,`templates`.`name` FROM `templates`;");
            $list_tmpl->execute();

            $standart_tmpl_id = 1;
            while ( $root_item = $list_tmpl->FETCH(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT) ) {
                if ($root_item['id'] == $standart_tmpl_id) {
                    echo("<option value=\"".$root_item['id']."\" selected>".$root_item['name']."</option>");
                } else {
                    echo("<option value=\"".$root_item['id']."\">".$root_item['name']."</option>");
                }
            }
            ?>

            </select>
        </td>
        <td style="font-size:14px;">
            <!-- нужно сделать автоматическую проверку уже занятого имени на onchange() -->
            <!-- назначение функций на кнопки их отображение можно регулироваться с помощью window.ready -->
            <input value="link" type="text" id="page_link_field" />
        </td>
        <td>
            <input id="save_button" type="submit" value="Save" onclick="new_page()" />
        </td>
        <td id="editor_status" width="350px"></td>
    </tr>
</table>
<?}?>

<article>
    <section class="text-content" id="fullpage">
        <h1 class="tape" id="page_title">Enter new title</h1>
    </section>
</article>

<?if ($admin_flag && ! $error_output){?>
    <script>window.addEvent('domready', on_dom_ready_create);</script>
    <textarea id="textarea1" class="marg30 js-elasticArea"></textarea>
<?}?>