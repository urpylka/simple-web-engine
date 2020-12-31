<style>
section.main-page h1 { width: 520px !important; }
section.main-page { display: table; }
.headnews {
	width: 320px;
	font-size: 1.5em;
	font-weight: bold;
	padding: 8px 70px 9px 20px;
	margin: -46px 100px 10px 0px !important;
	color: #fff;
	background-color: #252525;

	text-transform: uppercase;

	text-shadow: 0px 1px 2px #000;
	-webkit-box-shadow: 0px 2px 4px #888;
	-moz-box-shadow: 0px 2px 4px #888;
	box-shadow: 0px 2px 4px #888;
}

</style>

<?
// filename
// md5
// page_id
// extention
// size
// file_id
// private

// разбиение файлов по 10мб и шифрование

// max filesize

// Drag&Drop

// act=get_file&md5
// act=upload_file
?>

<article>
	<section class="main-page">
		<form action="./upload.php" method="post" enctype="multipart/form-data">
			<input type="file" name="userfile" id="file">
			<input type="submit" value="Upload file">
		</form>
	</section>
	<br/>
</article>

<?

$allowed_filetypes = array('.jpg','.gif','.bmp','.png'); // Здесь мы перечисляем допустимые типы файлов
$max_filesize = 524288; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 0.5 Мб).
$upload_path = './files/'; // Место, куда будут загружаться файлы (в данном случае это папка 'files').
$filename = $_FILES['userfile']['name']; // В переменную $filename заносим точное имя файла (включая расширение).
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // В переменную $ext заносим расширение загруженного файла.

// Сверяем полученное расширение со списком допутимых расширений,
// которые мы определили в самом начале.
// Если расширение загруженного файла не входит в список разрешенных,
// то прерываем выполнение программы и выдаем соответствующее сообщение.
if(!in_array($ext,$allowed_filetypes)) die('Данный тип файла не поддерживается.');


// Теперь проверим размер загруженного файла и если он больше максимально допустимого,
// то прерываем выполнение программы и выдаем сообщение.
if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize) die('Фаил слишком большой.');


// Проверяем, доступна ли на запись папка, определенная нами под загрузку файлов (папка files).
// Если вдруг недоступна, то выдаем сообщение, что на папку нужно поставить права доступа 777.
if(!is_writable($upload_path)) die('Невозможно загрузить фаил в папку. Установите права доступа - 777.');


// Загружаем фаил в указанную папку.
if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $filename))
	echo 'Ваш фаил успешно загружен <a href="' . $upload_path . $filename . '">смотреть</a>'; 
else echo 'При загрузке возникли ошибки. Попробуйте ещё раз.';

?>