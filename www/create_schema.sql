# ************************************************************
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.3.11-MariaDB-1:10.3.11+maria~bionic)
#
# Schema created for the initialization of DB
# by Artem Smirnov @urpylka
#
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `parent` int(6) NOT NULL DEFAULT 0,
  `name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` int(11) NOT NULL DEFAULT 1,
  `link` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `public_flag` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `link` (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;

INSERT INTO `pages` (`id`, `parent`, `name`, `text`, `template`, `link`, `public_flag`)
VALUES
	(1,0,'Главная','blocks/block-mainpage.php',2,'/',1),
	(2,1,'Редактор','blocks/block-editor.php',3,'editor',0),
	(3,0,'Обработчик AJAX','blanks/blank-redactor.php',4,'redactor',1),
	(4,1,'Авторизация','blocks/block-loginform.php',3,'login',1),
	(5,1,'Новости','blocks/block-news.php',3,'news',1),
	(6,0,'Абитуриенту','<h2>Основное положение</h2>\r\n				<p align=\"justify\">На военную кафедру принимаются студенты Самарского университета вторых и третьих курсов очной формы обучения для подготовки по программам сержантов и офицеров запаса. С 2016 года заявки на поступление принимаются в <strong><a href=\"http://lk.ssau.ru\">личном кабинете</a></strong> студента. Если у Вас пока нет доступа к своему личному кабинету обратитесь в свой деканат.</p><p>Также после подачи заявки в личном кабинете будет отображаться необходимая информация о дальнейших действиях и сроках поступления. Если в личном кабинете отсутствует возможность подать заявку, а Вы являетесь студентом-очником второго или третьего курса обратитесь к <strong><a href=\"/contacts.php\">начальнику</a></strong> военной кафедры.</p>\r\n				<h2>Вспомогательный материал</h2>\r\n				<ul>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules\">Правила приема</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/docs\">Документы для поступления</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/actions\">Порядок действий для поступления</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rezultat\">Результат конкурсного отбора</a></li>    \r\n              	</ul>\r\n				<!--h2>Правила приема на военную кафедру Самарского университета</h2>\r\n				<p align=\"justify\">Для обучения студентов по программе подготовки офицеров запаса по ВУС-461000, 461100, 461200, 461300, 310101. Утверждены ректором СГАУ 30 октября 2001 года.</p>\r\n				<br/>\r\n				<ul>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules/part1/\">Раздел 1. Общие положения</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules/part2/\"> Раздел 2. Методика проведения профессионального отбора кандидатов</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules/part21/\"> Раздел 2.1. Условия и порядок проведения отборочного тестирования кандидатов</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules/part3/\">Раздел 3. Условия и порядок проведения проверки уровня физической подготовки кандидатов</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules/part4/\">Раздел 4. Порядок проведения апелляции</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules/part5/\">Положение по отбору студентов для обучения на военной кафедре Самарского университета</a></li>\r\n					<li><a href=\"http://war.ssau.ru/abitur/rules/sootvetstvie/\">Таблица соответствия направлений подготовки и специальностей ВУЗа военно-учетным специальностям военной кафедры</a></li>\r\n					<li><a href=\"http://war.ssau.ru/files/metod.doc\">Методика отбора</a></li>\r\n				</ul>\r\n				<h2>Основные руководящие документы по правилам и порядку приема и обучения на военных кафедрах</h2>\r\n				<ul>\r\n					<li><a href=\"http://war.ssau.ru/files/ovk.doc\">Положение &quot;О военных кафедрах&quot; утвержденное Правительством РФ 6 марта 2008 г. № 152</a></li>\r\n					<li><a href=\"http://war.ssau.ru/files/pravila.doc\">Правила поведения и обязанности студентов</a></li>\r\n					<li><a href=\"http://war.ssau.ru/files/status.htm\" target=\"_blank\">Федеральный закон &quot;О статусе военнослужащего&quot;</a></li>\r\n					<li><a href=\"http://war.ssau.ru/files/military.htm\" target=\"_blank\">Федеральный закон &quot;О воинской обязанности и военной службе</a>&quot;</li>\r\n				</ul-->',1,'for-abiturients',1),
	(7,0,'Студенту','<h2>Вспомогательный материал</h2>\n<ul>\n    <li><a href=\"http://war.ssau.ru/students/qual/\">Квалификационные требования</a></li>\n    <li><a href=\"http://war.ssau.ru/students/formavk\">Форма одежды</a></li>\n    <li><a href=\"http://war.ssau.ru/students/studabotvk\">Студенты о ВК</a></li>\n    <li><a href=\"http://war.ssau.ru/students/qlinks\">Полезные ссылки</a></li>\n    <li><a href=\"http://war.ssau.ru/students/otp\">Основный требования и положения</a></li>\n    <li><a href=\"library.php\">Библиотека</a></li>			\n</ul>',1,'for-students',0),
	(8,0,'История',NULL,5,'history',1),
	(9,7,'Библиотека','<h2>Общевоинские дисциплины (I цикл)</h2>\r\n				<ul>\r\n					<li><a href=\"http://war.ssau.ru/structure/first/gentactic\">Общая тактика</a></li>\r\n					<li><a href=\"http://war.ssau.ru/structure/first/ogp\">ОГП</a></li>\r\n					<li><a href=\"http://war.ssau.ru/structure/first/topograf\">Военная топография</a></li>\r\n					<li><a href=\"http://war.ssau.ru/structure/first/firetraning\">Огневая подготовка</a></li>\r\n					<li><a href=\"http://war.ssau.ru/structure/first/rhbzz\">РХБЗ</a></li>\r\n					<li><a href=\"http://war.ssau.ru/structure/first/charters\">Уставы</a></li>\r\n				</ul>\r\n				<h2>Эксплуатация и ремонт АО (II цикл)</h2>\r\n				<p>Информация временно отсутствует</p>\r\n				<h2>Эксплуатация и ремонт СВ и АД (III цикл)</h2>\r\n				<p>Информация временно отсутствует</p>\r\n				<h2>Эксплуатация и ремонт РЭО (IV цикл)</h2>\r\n				<p>Информация временно отсутствует</p>\r\n				<h2>Эксплуатация и ремонт АВ (V цикл)</h2>\r\n				<p>Информация временно отсутствует</p>\r\n				<br/>',1,'library',1),
	(10,1,'Структура','<style>\r\ntable.struct {width:970px; border:0; padding-bottom:10px !important;}\r\ntable.struct tr {height:50px; vertical-align:top;}\r\n.struct td {width:200px; border:0;}\r\ntable.struct td img {margin-right:10px;}\r\n</style>\r\n<table class=\"struct\">\r\n						<tbody>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/1.jpg\" style=\"float: left;\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/first/\">1&nbsp;цикл<br />«Общевоинские дисциплины»</a>\r\n								</td>\r\n								<td>\r\n									\r\n<img height=\"33\" src=\"http://war.ssau.ru/img/2.jpg\" style=\"float: left;\" width=\"47\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/second/\">2&nbsp;цикл<br />«Эксплуатация и&nbsp;ремонт авиационного оборудования и&nbsp;вертолетов»</a>\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/3.jpg\" style=\"float: left;\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/third/\">3&nbsp;цикл<br />«Эксплуатация самолетов, вертолетов и&nbsp;авиационных двигателей»</a>\r\n								</td>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/3.jpg\" style=\"float: left;\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/fourth/\">4&nbsp;цикл<br />«Эксплуатация и&nbsp;ремонт РЭО самолетов, вертолетов и&nbsp;авиационных ракет»</a><p> </p>\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/5.jpg\" style=\"float: left;\" /> <a href=\"http://war.ssau.ru/index/structure/five/\">5&nbsp;цикл<br />«Эксплуатация и&nbsp;ремонт авиационного вооружения самолетов»</a></td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n						<h2>Подразделение обеспечения учебного процесса</h2>\r\n						<p> </p>\r\n					<table class=\"struct\">\r\n						<tbody>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/5.jpg\" style=\"float: left;\" /> <a href=\"http://war.ssau.ru/index/structure/out/\">ОУТиТА<br />Отделение учебной техники и тренировочной аппаратуры</a>\r\n								</td>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/5.jpg\" style=\"float: left;\" /> <a href=\"http://war.ssau.ru/index/structure/uvp/\">УВП<br />Учебно-вспомогательный персонал</a>\r\n								</td>\r\n							</tr>\r\n						</tbody>\r\n					</table>',1,'struktura',1),
	(11,0,'Сотруднику','<h2>Вспомогательный материал</h2>\r\n				<ul>\r\n					<li><a href=\"/director\">Руководство</a></li>\r\n					<li><a href=\"/struktura\">Структура</a></li>\r\n					<li><a href=\"/contacts\">Контакты</a></li>\r\n				</ul>\r\n				<br/>',1,'for-emploeers',1),
	(12,0,'Обратная связь','<script type=\"text/javascript\" src=\"js/block-feedback.js\"></script>\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/block-feedback.css\">\n\n<p align=\"justify\">На данной странице Вы можете анонимно оставить отзыв, жалобу, благодарность или предложение</p>\n<p align=\"justify\" id=\"error2\" style=\"color:green;\">Поля отмеченные * обязательны к заполнению</p>\n<p align=\"justify\" id=\"error\" style=\"color:red;\"></p>\n<form onsubmit=\"return checkForm();\" name=\"feedback\" method=\"post\" action=\"feedback.php\" style=\"display: table !important;\">\n    <!--div class=\"notall\">Поля, выделенные красной рамкой, заполнены неправильно.</div-->\n    <div class=\"totalnames\">\n        <div>Ваше имя</div>\n        <div>Тип обращения *</div>\n        <div>Номер вашего взвода</div>\n        <div class=\"text1\">Текст обращения *</div>\n        <div>Телефон</div>\n        <div>Email</div>\n        <div class=\"text1\">Капча *</div>\n        <!--div class=\"m1\" title=\"Запоминать ее не обязательно\">Кодовая строка</div-->\n    </div>\n\n    <div class=\"totalfields\">\n        <div>\n            <input type=\"text\" placeholder=\"не обязательно\" id=\"totalfname\" />\n        </div>\n        <div>\n            <select id=\"totalvoen\" size=\"1\">\n                <option value=\'жалоба\'>жалоба</option>\n                <option value=\'отзыв\'>отзыв</option>\n                <option value=\'благодарность\'>благодарность</option>\n                <option value=\'предложение\'>предложение</option>\n            </select>\n        </div>\n        <div>\n            <input type=\"text\" placeholder=\"не обязательно\" id=\"totallname\" />\n        </div>\n        <div class=\"text1\">\n            <textarea id=\"totalltext\" name=\"text\" style=\"resize: none;\" rows=\"10\" cols=\"42\" placeholder=\"изложите суть вашего обращения\" required>',1,'feedback',1),
	(13,0,'Контакты','<style>\n.left { float:  left; width: 50%; }\n.right { float: right; width: 50%; text-align: right; }\n.clear { clear: both; }\n</style><div class=\"left\">\n<h2>Почтовый адрес</h2>\n					<p>Россия, 443086, г. Самара, ул. Врубеля 27</p>\n					<h2>Начальник военной кафедры</h2>\n					<p>Полковник <em>Хабло Иван Игоревич</em></p>\n					<p>Тел.: (846) 3345754</p>\n					<p>E-mail: <a href=\"mailto:khablo@ssau.ru?subject=%D0%9D%D0%B0%D1%87%D0%B0%D0%BB%D1%8C%D0%BD%D0%B8%D0%BA%D1%83%20%D0%92%D0%9A%20%D0%A1%D0%93%D0%90%D0%A3\">khablo@ssau.ru</a></p>\n					<h2>Заместитель начальника военной кафедры</h2>\n					<p>Полковник <em>Одобеску Виктор Трофимович</em></p>\n					<p>Тел.: (846) 2674426</p>\n					<p>E-mail: <a href=\"mailto:odobescu@ssau.ru?subject=%D0%97%D0%B0%D0%BC%D0%B5%D1%81%D1%82%D0%B8%D1%82%D0%B5%D0%BB%D1%8E%20%D0%BD%D0%B0%D1%87.%20%D0%92%D0%9A%20%D0%A1%D0%93%D0%90%D0%A3\">odobescu@ssau.ru</a></p>\n					<h2>Начальник учебной части,<br />заместитель начальника военной кафедры</h2>\n					<p>Подполковник Алексеенко Василий Павлович</p>\n					<p>Тел.: (846) 2674421</p>\n					<p>E-mail.: <a href=\"mailto:alekseenka_v@mail.ru\">alekseenko_v@ma<span style=\"display: none\">&nbsp;</span>il.ru</a></p>\n					<h2>Дежурный по кафедре</h2>\n					<p>Тел.: (846) 2674422</p>\n</div>		\n<img src=\"img/_UCeig3_IfE.jpg\" class=\"right\" style=\"margin-top:20px;\" />\n<div class=\"clear\"></div>',6,'contacts',1),
	(14,1,'Генератор QR','',4,'qr',1),
	(15,1,'Пустая 2','<p>одна строка</p>',1,'free2',1),
	(16,8,'Энциклопедия кафедры',NULL,1,'flash-history',0),
	(17,8,'О Губанове','',1,'gubanogp',0),
	(18,8,'Историческая справка',NULL,1,'historysp',0),
	(19,8,'Очерк','<p align=\"right\"><em>«Защита Отечества является долгом </em><br />\n					<em>и обязанностью гражданина Российской <em>Федерации»</em></em></p>\n<p align=\"right\"><em>Конституция РФ, ст. 59</em>.</p>\n<br/>\n<p align=\"justify\">В годы Великой Отечественной войны одной из важных проблем являлась подготовка квалифицированных офицерских кадров и технического персонала для действующей армии. Для осуществления крупных наступательных операций армия нуждалась в хорошо обученных командирах, инженерах, техниках, специалистах. 16 июля 1941 года Государственный Комитет Обороны принял постановление о подготовке резервов в системе НКО и ВМФ от 17 сентября \"О всеобщем обязательном обучении военному делу граждан СССР\".</p>',1,'ocherk',0),
	(20,7,'Квалификационные требования',NULL,1,'qual',0),
	(21,7,'Форма одежды',NULL,1,'formavk',0),
	(22,7,'Студенты о ВК',NULL,1,'studabotvk',0),
	(23,7,'Полезные ссылки',NULL,1,'qlinks',0),
	(24,7,'Основный требования и положения',NULL,1,'otp',0),
	(25,6,'Semen',NULL,7,'semen',0),
	(26,6,'Документы для поступления',NULL,1,'docs',1),
	(27,6,'Порядок действий для поступления',NULL,1,'actions',1),
	(28,6,'Результат конкурсного отбора',NULL,1,'rezultat',1),
	(29,6,'Допуск к гостайне',NULL,1,'dopusk',1),
	(30,1,'Мультимедиа',NULL,5,'multimedia',0),
	(31,30,'Фото','',1,'photo',0),
	(32,30,'Видео',NULL,1,'video',0),
	(33,30,'Программа','Тестовая страница\n<br>\nВот такая обычная страница',1,'programs',0),
	(34,30,'Сборы 2010','<p><b>dfwefqffqfqwfffffddFAFAdfDf</b></p>\n',1,'sbori2010hotilovo',1),
	(35,30,'Фотоконкурс',NULL,1,'fotokonkurs',0),
	(36,1,'Выпускникам',NULL,5,'vypusk',0),
	(37,36,'Вас ждут в войсках',NULL,1,'voysk',0),
	(38,36,'Приказы о присвоении звания','Пустая страница',1,'prik',0),
	(39,0,'Руководство кафедры','<h2><strong>Начальник военной кафедры</strong></h2>\n				<strong>полковник Хабло Иван Игоревич</strong>\n				<br/>\n				<img alt=\"\" src=\"http://war.ssau.ru/upldr/ufiles/khablo_colonel.jpg\" style=\"height: 240px; width: 160px; margin: 15px; float: left;\" />\n				<br/>\n				<p style=\"text-align: justify\">Родился 08.06.1967 г в городе Новокуйбышевске. В 1989 году окончил Тамбовское высшее военное авиационное инженерное училище имени Ф.Э. Дзержинского по специальности «радиоинженер». Проходил службу в частях Приволжско-Уральского военного округа. С 1996 года проходит службу на военной кафедре СГАУ. Занимал должности старшего инструктора, преподавателя, старшего преподавателя, начальника цикла, начальника учебной части - заместителя начальника военной кафедры. В мае 2012 года приказом ректора СГАУ назначен начальником военной кафедры.</p>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<hr/>\n				<h2><strong>Заместитель начальника военной кафедры</strong></h2>\n				<strong>полковник Одобеску Виктор Трофимович</strong>\n				<br/>\n				<img alt=\"\" src=\"http://war.ssau.ru/img/odobescu.JPG\" style=\"height: 240px; width: 160px; float: left; margin-left: 15px; margin-right: 15px; margin-top: 15px; margin-bottom: 15px\" />\n				<br/>\n				<p style=\"text-align: justify;\">Родился 28.05.1955 г. в г. Кишенев Молдавской СССР. В 1977 г. закончил Васильковское военное авиационное училище. В 1984 году закончил Киевское высшее военное авиационное инженерное училище по специальности «инженер-механик». Был делегатом Первого Всеармейского офицерского собрания в 1989г Проходил службу в частях ГСВГ (группы Советских Войск в Германии), группы Советских войск в Монгольской народной республике, Забайкальского Одесского, Прикарпатского военных округов. С 1997 года проходит службу на военной кафедре СГАУ.</p>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<hr/>\n				<h2><strong>Начальник учебной части – заместитель начальника военной кафедры</strong></h2>\n				<strong>подполковник Алексеенко Василий Павлович</strong>\n				<br/>\n				<img alt=\"\" src=\"img/assets/NZFBPugVV8Y.jpg\" style=\"height: 240px; width: 160px; float: left; margin-left: 15px; margin-right: 15px; margin-top: 15px; margin-bottom: 15px\" />\n				<br/>\n				<p style=\"text-align: justify\">Родился 17 апреля 1975 г. в городе Куйбышеве. В 1998 году закончил Военно-Воздушную Инженерную Академию имени проф. Н.Е. Жуковского, приобрел квалификацию: «инженер-механик-исследователь». В 2002 г. закончил Самарскую Государственную Экономическую Академию по специальности  «юрист». В 2002 году  защитил кандидатскую диссертацию по специальности: «Контроль испытаний летательных аппаратов. двигателей и их систем». Имеет ученое звание доцента с 2003 года. Лауреат конкурсов Совета по грантам Президента для поддержки молодых российских ученых в 2004 и 2007 гг., конкурса РАН и РАО \"ЕЭС России” среди научных работ ученых РФ в области энергетики. Проходил службу на военной кафедре на должностях старшего инструктора, преподавателя, в органах военного управления МО РФ, военных представительствах МО РФ.  С 2012 года начальник учебной части – заместитель начальника военной кафедры.</p>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>',1,'director',1),
	(40,0,'Контакты2','<style>\n.left { float:  left; width: 50%; }\n.right { float: right; width: 50%; text-align: right; }\n.clear { clear: both; }\n</style><div class=\"left\">\n<h2>Почтовый адрес</h2>\n					<p>Россия, 443086, г. Самара, ул. Врубеля 27</p>\n					<h2>Начальник военной кафедры</h2>\n					<p>Полковник <em>Хабло Иван Игоревич</em></p>\n					<p>Тел.: (846) 3345754</p>\n					<p>E-mail: <a href=\"mailto:khablo@ssau.ru?subject=%D0%9D%D0%B0%D1%87%D0%B0%D0%BB%D1%8C%D0%BD%D0%B8%D0%BA%D1%83%20%D0%92%D0%9A%20%D0%A1%D0%93%D0%90%D0%A3\">khablo@ssau.ru</a></p>\n					<h2>Заместитель начальника военной кафедры</h2>\n					<p>Полковник <em>Одобеску Виктор Трофимович</em></p>\n					<p>Тел.: (846) 2674426</p>\n					<p>E-mail: <a href=\"mailto:odobescu@ssau.ru?subject=%D0%97%D0%B0%D0%BC%D0%B5%D1%81%D1%82%D0%B8%D1%82%D0%B5%D0%BB%D1%8E%20%D0%BD%D0%B0%D1%87.%20%D0%92%D0%9A%20%D0%A1%D0%93%D0%90%D0%A3\">odobescu@ssau.ru</a></p>\n					<h2>Начальник учебной части,<br />заместитель начальника военной кафедры</h2>\n					<p>Подполковник Алексеенко Василий Павлович</p>\n					<p>Тел.: (846) 2674421</p>\n					<p>E-mail.: <a href=\"mailto:alekseenka_v@mail.ru\">alekseenko_v@ma<span style=\"display: none\">&nbsp;</span>il.ru</a></p>\n					<h2>Дежурный по кафедре</h2>\n					<p>Тел.: (846) 2674422</p>\n</div>		\n<p> </p>\n<div class=\"clear\"></div>',1,'cont2',1);

/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `phpsessid` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `login` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `phpsessid` (`phpsessid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `templates`;

CREATE TABLE `templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL DEFAULT '',
  `path` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;

INSERT INTO `templates` (`id`, `name`, `path`)
VALUES
	(1,'standart','templates/template-standart.php'),
	(2,'main','templates/template-main.php'),
	(3,'block','templates/template-block.php'),
	(4,'blank','templates/template-blank.php'),
	(5,'section','templates/template-section.php'),
	(6,'contacts','templates/template-contacts.php'),
	(7,'semen','templates/template-semen.php');

/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table top_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `top_menu`;

CREATE TABLE `top_menu` (
  `queue` int(1) NOT NULL,
  `page_id` int(6) NOT NULL,
  UNIQUE KEY `queue` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `top_menu` WRITE;
/*!40000 ALTER TABLE `top_menu` DISABLE KEYS */;

INSERT INTO `top_menu` (`queue`, `page_id`)
VALUES
	(1,1),
	(2,5),
	(3,4),
	(4,2),
	(5,13);

/*!40000 ALTER TABLE `top_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pbkdf2` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_flag` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `login`, `pbkdf2`, `admin_flag`)
VALUES
	(1,'urpylka','sha256$1000$8d9aefcf3d4d6c38$d48bc2df4ed0f46e0538',1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
