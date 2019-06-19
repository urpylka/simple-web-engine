## blank_*

модули вызываемые самостоятельно, либо через шаблон template_blank.php

- blank_phpinfo.php - выводит результат функции phpinfo()
- blank_redactor.php - API построенное на AJAX для редактирования страниц

## block_*

модули встраиваемые в шаблон сайта, встраивается между другими такими блоками в любом порядке

- block_promo.php - блок с бендером
- block_quick_menu.php - три кнопки (быстрый доступ)
- block_site_map.php - используется в editor для отображения структуры сайта второго уровня
- block_yandex_map.php - используется в contacts

## page-block_*

модуль встраивается только в шаблон в блок <main> обычно это template_block или template_main

- page-block_editor.ideas.php
- page-block_editor.php
- page-block_login_form.php
- page-block_main.php
- page-block_news.ideas.php
- page-block_news.php

## module_*

более мелкий модуль используемый для выполнения логики, выполняющий определенную функцию

- module_navbar.php
- module_qr.php
- module_redactor.php

## site_*

основные составляющие дизайна сайта

- site_footer.php
- site_gototop.php
- site_header.php

## template_*

шаблон, имеет ряд переменных определяющих его

- template_blank.php
- template_block.php
- template_contacts.php
- template_main.php
- template_standart.php
