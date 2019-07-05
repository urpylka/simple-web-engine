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

INSERT INTO `pages` (`id`, `parent`, `name`, `text`, `template`, `link`, `public_flag`) VALUES
	(1, 0, 'Главная', 'blocks/block-mainpage.php', 2, '/', 1),
	(2, 0, 'Редактор', 'blocks/block-editor.php', 3, 'editor', 0),
	(3, 0, 'Обработчик AJAX', 'blanks/blank-redactor.php', 4, 'redactor', 1),
	(4, 0, 'Авторизация', 'blocks/block-loginform.php', 3, 'login', 1),
	(5, 0, 'Добавить', NULL, 1, 'new-page', 1),
	(6, 0, 'Контакты', '<style>\n.left { float:  left; width: 50%; }\n.right { float: right; width: 50%; text-align: right; }\n.clear { clear: both; }\n</style><div class=\"left\">\n<h2>Почтовый адрес</h2>\n					<p>Россия, 443086, г. Самара, ул. Врубеля 27</p>\n					<h2>Начальник военной кафедры</h2>\n					<p>Полковник <em>Хабло Иван Игоревич</em></p>\n					<p>Тел.: (846) 3345754</p>\n					<p>E-mail: <a href=\"mailto:khablo@ssau.ru?subject=%D0%9D%D0%B0%D1%87%D0%B0%D0%BB%D1%8C%D0%BD%D0%B8%D0%BA%D1%83%20%D0%92%D0%9A%20%D0%A1%D0%93%D0%90%D0%A3\">khablo@ssau.ru</a></p>\n					<h2>Заместитель начальника военной кафедры</h2>\n					<p>Полковник <em>Одобеску Виктор Трофимович</em></p>\n					<p>Тел.: (846) 2674426</p>\n					<p>E-mail: <a href=\"mailto:odobescu@ssau.ru?subject=%D0%97%D0%B0%D0%BC%D0%B5%D1%81%D1%82%D0%B8%D1%82%D0%B5%D0%BB%D1%8E%20%D0%BD%D0%B0%D1%87.%20%D0%92%D0%9A%20%D0%A1%D0%93%D0%90%D0%A3\">odobescu@ssau.ru</a></p>\n					<h2>Начальник учебной части,<br />заместитель начальника военной кафедры</h2>\n					<p>Подполковник Алексеенко Василий Павлович</p>\n					<p>Тел.: (846) 2674421</p>\n					<p>E-mail.: <a href=\"mailto:alekseenka_v@mail.ru\">alekseenko_v@ma<span style=\"display: none\"> </span>il.ru</a></p>\n					<h2>Дежурный по кафедре</h2>\n					<p>Тел.: (846) 2674422</p>\n</div>		\n<img src=\"img/assets/_UCeig3_IfE.jpg\" class=\"right\" style=\"margin-top:20px;\" />\n<div class=\"clear\"></div>', 6, 'contacts', 1),
	(7, 0, 'Лист', 'blocks/block-list.php', 3, 'list', 1),
	(8, 0, 'Обратная связь', '<script type=\"text/javascript\" src=\"js/block-feedback.js\"></script>\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/block-feedback.css\">\n\n<p align=\"justify\">На данной странице Вы можете анонимно оставить отзыв, жалобу, благодарность или предложение</p>\n<p align=\"justify\" id=\"error2\" style=\"color:green;\">Поля отмеченные * обязательны к заполнению</p>\n<p align=\"justify\" id=\"error\" style=\"color:red;\"></p>\n<form onsubmit=\"return checkForm();\" name=\"feedback\" method=\"post\" action=\"feedback.php\" style=\"display: table !important;\">\n    <!--div class=\"notall\">Поля, выделенные красной рамкой, заполнены неправильно.</div-->\n    <div class=\"totalnames\">\n        <div>Ваше имя</div>\n        <div>Тип обращения *</div>\n        <div>Номер вашего взвода</div>\n        <div class=\"text1\">Текст обращения *</div>\n        <div>Телефон</div>\n        <div>Email</div>\n        <div class=\"text1\">Капча *</div>\n        <!--div class=\"m1\" title=\"Запоминать ее не обязательно\">Кодовая строка</div-->\n    </div>\n\n    <div class=\"totalfields\">\n        <div>\n            <input type=\"text\" placeholder=\"не обязательно\" id=\"totalfname\" />\n        </div>\n        <div>\n            <select id=\"totalvoen\" size=\"1\">\n                <option value=\'жалоба\'>жалоба</option>\n                <option value=\'отзыв\'>отзыв</option>\n                <option value=\'благодарность\'>благодарность</option>\n                <option value=\'предложение\'>предложение</option>\n            </select>\n        </div>\n        <div>\n            <input type=\"text\" placeholder=\"не обязательно\" id=\"totallname\" />\n        </div>\n        <div class=\"text1\">\n            <textarea id=\"totalltext\" name=\"text\" style=\"resize: none;\" rows=\"10\" cols=\"42\" placeholder=\"изложите суть вашего обращения\" required>', 1, 'feedback', 1),
	(9, 0, 'TEMP', 'block-news.ideas.php', 3, 'null-1', 1),
	(10, 0, NULL, NULL, 1, 'null-2', 1),
	(20, 0, 'Примитивы', NULL, 5, 'primitives', 1),
	(21, 20, 'Fonts', '<table>\n<tr style=\"font-family: Medium-Marat-Bold;\"><td>Medium-Marat-Bold</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: medium-content-sans-serif-font;font-weight: 600;\"><td>medium-content-sans-serif-font</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: Marat-Sans-Medium;\"><td>Marat-Sans-Medium</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n\n<tr style=\"font-family: Medium-Marat-Regular;\"><td>Medium-Marat-Regular</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: Marat-Sans-Regular;\"><td>Marat-Sans-Regular</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: medium-content-sans-serif-font;font-weight: 400;\"><td>medium-content-sans-serif-font</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: Marat-Sans-Light;\"><td>Marat-Sans-Light</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n\n<tr style=\"font-family: Medium;\"><td>Medium</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n\n<tr style=\"font-family: medium-content-serif-font;\"><td>medium-content-serif-font</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: medium-content-title-font;\"><td>medium-content-title-font</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: medium-content-slab-serif-font;\"><td>medium-content-slab-serif-font</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n\n<tr style=\"font-family: medium-marketing-display-font;\"><td>medium-marketing-display-font</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n\n<tr style=\"font-family: Marta-Regular;\"><td>Marta-Regular</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: Marta-Italic;\"><td>Marta-Italic</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n\n<tr style=\"font-family: Code-Pro-Bold;\"><td>Code-Pro-Bold</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: Code-Pro-Regular;\"><td>Code-Pro-Regular</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n<tr style=\"font-family: Code-Pro-Light;\"><td>Code-Pro-Light</td><td>Ωω MEDIUM Absque omni exceptione.</td><td>К невозможному никого не обязывают.</td></tr>\n\n</table>\n\n\n\n<link rel=\"stylesheet\" href=\"fonts/medium2/latin-m2.css\">\n\n<style>\n@font-face {\n	font-family: Code-Pro-Bold;\n	src: url(fonts/code-pro/сode-pro-bold.otf);\n}\n@font-face {\n	font-family: Code-Pro-Regular;\n	src: url(fonts/code-pro/сode-pro-regular-lc.otf);\n}\n@font-face {\n	font-family: Code-Pro-Light;\n	src: url(fonts/code-pro/сode-pro-light-lc.otf);\n}\n@font-face {\n	font-family: Marta-Regular;\n	src: url(fonts/marta/marta-regular.otf);\n}\n@font-face {\n	font-family: Marta-Italic;\n	src: url(fonts/marta/marta-italic.otf);\n}\n@font-face {\n	font-family: Marat-Sans-Regular;\n	src: url(fonts/marat/marat-sans-regular.otf);\n}\n@font-face {\n	font-family: Marat-Sans-Light;\n	src: url(fonts/marat/marat-sans-light.otf);\n}\n@font-face {\n	font-family: Marat-Sans-Medium;\n	src: url(fonts/marat/marat-sans-medium.otf);\n}\n\n@font-face {\n	font-family: Medium-Marat-Bold;\n	src: url(fonts/medium/marat-sans-bold-lc.otf);\n}\n\n@font-face {\n	font-family: Medium-Marat-Regular;\n	src: url(fonts/medium/marat-sans-regular-lc.otf);\n}\n@font-face {\n	font-family: Medium;\n	src: url(fonts/medium/noe-display-500-normal.otf);\n}\n</style>', 1, 'fonts', 1),
	(22, 20, 'Color palette', '<h2>Фиолетовая тема ROBOTIC</h2>\n<div class=\"square\" style=\"background-color: #47117d;\"></div>\n<div class=\"square\" style=\"background-color: #401078;\"></div>\n<div class=\"square\" style=\"background-color: #00044a;\"></div>\n<div style=\"clear: both;\"></div>\n\n<h2>blog.smirart.ru on Blogger</h2>\n<div class=\"square\" style=\"background-color: rgba(173, 58, 43, 1);\"></div>\n<div class=\"square\" style=\"background-color: rgba(246, 246, 246, 1);\"></div>\n<div class=\"square\" style=\"background-color: #adadad;\"></div>\n<div class=\"square\" style=\"background-color: #909090;\"></div>\n<div class=\"square\" style=\"background-color: #555555;\"></div>\n<div class=\"square\" style=\"background-color: #333333;\"></div>\n<div style=\"clear: both;\"></div>\n\n<h2>Meduza.io</h2>\n<div class=\"square\" style=\"background-color: #c89b63;\"></div>\n<div class=\"square\" style=\"background-color: #b88d58;\"></div>\n<div class=\"square\" style=\"background-color: #e57254;\"></div>\n<div class=\"square\" style=\"background-color: #c46349;\"></div>\n<div class=\"square\" style=\"background-color: #252525;\"></div>\n<div class=\"square\" style=\"background-color: #1a1a1a;\"></div>\n<div class=\"square\" style=\"background-color: #040404;\"></div>\n<div style=\"clear: both;\"></div>\n\n<h2>swe history</h2>\n<div class=\"square\" style=\"background-color: #0097D3;\"></div> \n<div class=\"square\" style=\"background-color: #21ABDC;\"></div>\n<div class=\"square\" style=\"background-color: #2c4e66;\"></div>\n<div class=\"square\" style=\"background-color: #254a66;\"></div>\n<div class=\"square\" style=\"background-color: #35a81a;\"></div>\n<div class=\"square\" style=\"background-color: #888;\"></div>\n<div class=\"square\" style=\"background-color: #707070;\"></div>\n<div style=\"clear: both;\"></div>\n\n<style>.square { height: 20px; width: 20px; margin: 10px; float: left; }</style>', 1, 'colors', 0),
	(23, 20, 'Пример текстовых примитивов', '<h2>Вспомогательный материал</h2>\n<ul>\n    <li><a href=\"http://war.ssau.ru/students/qual/\">Квалификационные требования</a></li>\n    <li><a href=\"http://war.ssau.ru/students/formavk\">Форма одежды</a></li>\n    <li><a href=\"http://war.ssau.ru/students/studabotvk\">Студенты о ВК</a></li>\n    <li><a href=\"http://war.ssau.ru/students/qlinks\">Полезные ссылки</a></li>\n    <li><a href=\"http://war.ssau.ru/students/otp\">Основный требования и положения</a></li>\n    <li><a href=\"library.php\">Библиотека</a></li>			\n</ul>\n\n<p align=\"right\"><em>«Защита Отечества является долгом </em><br />\n					<em>и обязанностью гражданина Российской <em>Федерации»</em></em></p>\n<p align=\"right\"><em>Конституция РФ, ст. 59</em>.</p>\n<br/>\n<p align=\"justify\">В годы Великой Отечественной войны одной из важных проблем являлась подготовка квалифицированных офицерских кадров и технического персонала для действующей армии. Для осуществления крупных наступательных операций армия нуждалась в хорошо обученных командирах, инженерах, техниках, специалистах. 16 июля 1941 года Государственный Комитет Обороны принял постановление о подготовке резервов в системе НКО и ВМФ от 17 сентября \"О всеобщем обязательном обучении военному делу граждан СССР\".</p>', 1, 'text', 1),
	(24, 20, 'Пример структуры', '<style>\r\ntable.struct {width:970px; border:0; padding-bottom:10px !important;}\r\ntable.struct tr {height:50px; vertical-align:top;}\r\n.struct td {width:200px; border:0;}\r\ntable.struct td img {margin-right:10px;}\r\n</style>\r\n<table class=\"struct\">\r\n						<tbody>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/1.jpg\" style=\"float: left;\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/first/\">1&nbsp;цикл<br />«Общевоинские дисциплины»</a>\r\n								</td>\r\n								<td>\r\n									\r\n<img height=\"33\" src=\"http://war.ssau.ru/img/2.jpg\" style=\"float: left;\" width=\"47\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/second/\">2&nbsp;цикл<br />«Эксплуатация и&nbsp;ремонт авиационного оборудования и&nbsp;вертолетов»</a>\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/3.jpg\" style=\"float: left;\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/third/\">3&nbsp;цикл<br />«Эксплуатация самолетов, вертолетов и&nbsp;авиационных двигателей»</a>\r\n								</td>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/3.jpg\" style=\"float: left;\" />\r\n									<a href=\"http://war.ssau.ru/index/structure/fourth/\">4&nbsp;цикл<br />«Эксплуатация и&nbsp;ремонт РЭО самолетов, вертолетов и&nbsp;авиационных ракет»</a><p> </p>\r\n								</td>\r\n							</tr>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/5.jpg\" style=\"float: left;\" /> <a href=\"http://war.ssau.ru/index/structure/five/\">5&nbsp;цикл<br />«Эксплуатация и&nbsp;ремонт авиационного вооружения самолетов»</a></td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n						<h2>Подразделение обеспечения учебного процесса</h2>\r\n						<p> </p>\r\n					<table class=\"struct\">\r\n						<tbody>\r\n							<tr>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/5.jpg\" style=\"float: left;\" /> <a href=\"http://war.ssau.ru/index/structure/out/\">ОУТиТА<br />Отделение учебной техники и тренировочной аппаратуры</a>\r\n								</td>\r\n								<td>\r\n									\r\n<img src=\"http://war.ssau.ru/img/5.jpg\" style=\"float: left;\" /> <a href=\"http://war.ssau.ru/index/structure/uvp/\">УВП<br />Учебно-вспомогательный персонал</a>\r\n								</td>\r\n							</tr>\r\n						</tbody>\r\n					</table>', 1, 'structure', 1),
	(25, 20, 'Пример таблицы', '		<h2>Специальности</h2>\r\n		<br/>\r\n		<table width=\"100%\">\r\n			<tr>\r\n				<td width=\"80px\" style=\"border:1px #000 solid;\">ВУС 461000</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт самолетов, вертолетов и авиационных двигателей</td>\r\n			</tr>\r\n			<tr>\r\n				<td style=\"border:1px #000 solid;\">ВУС 461100</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт авиационного вооружения</td>\r\n			</tr>\r\n			<tr>\r\n				<td style=\"border:1px #000 solid;\">ВУС 461200</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт авиационного оборудования самолетов и вертолетов</td>\r\n			</tr>\r\n			<tr>\r\n				<td style=\"border:1px #000 solid;\">ВУС 461300</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт радиоэлектронного оборудования самолетов, вертолетов и авиационных ракет</td>\r\n			</tr>\r\n			<tr>\r\n				<td style=\"border:1px #000 solid;\">ВУС 220</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт самолетов с реактивными (турбовентиляторными), турбореактивными и турбовинтовыми двигателями</td>\r\n			</tr>\r\n			<tr>\r\n				<td style=\"border:1px #000 solid;\">ВУС 233</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт ракетного вооружения, систем наведения и управления ракет</td>\r\n			</tr>\r\n			<tr>\r\n				<td style=\"border:1px #000 solid;\">ВУС 262</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт электрооборудования самолетов и вертолетов</td>\r\n			</tr>\r\n			<tr>\r\n				<td style=\"border:1px #000 solid;\">ВУС 250</td>\r\n				<td style=\"border:1px #000 solid;\">Эксплуатация и ремонт радиосвязного оборудования самолетов и вертолетов</td>\r\n			</tr>\r\n		</table>', 1, 'table', 1),
	(26, 20, 'Пример большого текста', '<h2><strong>Начальник военной кафедры</strong></h2>\n				<strong>полковник Хабло Иван Игоревич</strong>\n				<br/>\n				<img alt=\"\" src=\"http://war.ssau.ru/upldr/ufiles/khablo_colonel.jpg\" style=\"height: 240px; width: 160px; margin: 15px; float: left;\" />\n				<br/>\n				<p style=\"text-align: justify\">Родился 08.06.1967 г в городе Новокуйбышевске. В 1989 году окончил Тамбовское высшее военное авиационное инженерное училище имени Ф.Э. Дзержинского по специальности «радиоинженер». Проходил службу в частях Приволжско-Уральского военного округа. С 1996 года проходит службу на военной кафедре СГАУ. Занимал должности старшего инструктора, преподавателя, старшего преподавателя, начальника цикла, начальника учебной части - заместителя начальника военной кафедры. В мае 2012 года приказом ректора СГАУ назначен начальником военной кафедры.</p>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<hr/>\n				<h2><strong>Заместитель начальника военной кафедры</strong></h2>\n				<strong>полковник Одобеску Виктор Трофимович</strong>\n				<br/>\n				<img alt=\"\" src=\"http://war.ssau.ru/img/odobescu.JPG\" style=\"height: 240px; width: 160px; float: left; margin-left: 15px; margin-right: 15px; margin-top: 15px; margin-bottom: 15px\" />\n				<br/>\n				<p style=\"text-align: justify;\">Родился 28.05.1955 г. в г. Кишенев Молдавской СССР. В 1977 г. закончил Васильковское военное авиационное училище. В 1984 году закончил Киевское высшее военное авиационное инженерное училище по специальности «инженер-механик». Был делегатом Первого Всеармейского офицерского собрания в 1989г Проходил службу в частях ГСВГ (группы Советских Войск в Германии), группы Советских войск в Монгольской народной республике, Забайкальского Одесского, Прикарпатского военных округов. С 1997 года проходит службу на военной кафедре СГАУ.</p>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<hr/>\n				<h2><strong>Начальник учебной части – заместитель начальника военной кафедры</strong></h2>\n				<strong>подполковник Алексеенко Василий Павлович</strong>\n				<br/>\n				<img alt=\"\" src=\"img/assets/NZFBPugVV8Y.jpg\" style=\"height: 240px; width: 160px; float: left; margin-left: 15px; margin-right: 15px; margin-top: 15px; margin-bottom: 15px\" />\n				<br/>\n				<p style=\"text-align: justify\">Родился 17 апреля 1975 г. в городе Куйбышеве. В 1998 году закончил Военно-Воздушную Инженерную Академию имени проф. Н.Е. Жуковского, приобрел квалификацию: «инженер-механик-исследователь». В 2002 г. закончил Самарскую Государственную Экономическую Академию по специальности  «юрист». В 2002 году  защитил кандидатскую диссертацию по специальности: «Контроль испытаний летательных аппаратов. двигателей и их систем». Имеет ученое звание доцента с 2003 года. Лауреат конкурсов Совета по грантам Президента для поддержки молодых российских ученых в 2004 и 2007 гг., конкурса РАН и РАО \"ЕЭС России” среди научных работ ученых РФ в области энергетики. Проходил службу на военной кафедре на должностях старшего инструктора, преподавателя, в органах военного управления МО РФ, военных представительствах МО РФ.  С 2012 года начальник учебной части – заместитель начальника военной кафедры.</p>\n				<br/>\n				<br/>\n				<br/>\n				<br/>\n				<br/>', 1, 'big', 1),
	(27, 20, 'Пример Popup', '<style>\n/* POPUP WINDOW */\n\n#wrap {\n	display: none;\n	opacity: 0.8;\n	position: fixed;\n	left: 0;\n	right: 0;\n	top: 0;\n	bottom: 0;\n	padding: 16px;\n	background-color: rgba(1, 1, 1, 0.725);\n	z-index: 100;\n	overflow: auto;\n}\n\n.popup_window {\n	width: 600px;\n	height: 400px;\n	margin: 50px auto;\n	display: none;\n	background: #fff;\n	z-index: 200;\n	position: fixed;\n	left: 0;\n	right: 0;\n	top: 0;\n	bottom: 0;\n	padding: 16px;\n}\n\n.close {\n	margin-left: 564px;\n	margin-top: 4px;\n	cursor: pointer;\n	float: right;\n}\n\n.popup_window .name {\n	margin-left: 30px !important;\n	width: 100%;\n}\n</style>\n\n<script type=\"text/javascript\">\nfunction show(state, blockId) {\n	// Функция показа всплывающего окна\n	document.getElementById(blockId).style.display = state;			\n	document.getElementById(\'wrap\').style.display = state; 			\n};\n</script>\n\n<!-- Задний прозрачный фон-->\n<div onclick=\"show(\'none\')\" id=\"wrap\"></div>\n<a href=\"#\" onclick=\"show(\'block\',\'news1\')\">Подробнее</a>\n\n\n			<div align=\"justify\" id=\"news1\" class=\"popup_window\">\n				<div class=\"close\" onclick=\"show(\'none\',\'news1\')\">X</div>\n				<div class=\"news-header\">Добро-пожаловать на новый сайт</div>\n				<p align=\"justify\">В рамках курсовой работы разработан сайт для военной кафедры Самарского университета. Сайт выполнен в статичном виде. Применено 5 javascript`ов. Автор сайта Смирнов Артем.\n				</p>\n			</div>\n', 1, 'popup', 1),
	(40, 0, 'New design', NULL, 7, 'new-design', 1);

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
	(1, 1),
	(2, 5),
	(3, 4),
	(4, 2),
	(5, 9);

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
