<? include_once "phpqrcode/qrlib.php";
$url = $_GET['url'];
QRcode::png($url, '../tmp/test.png', 'L', 4, 2);
$im = file_get_contents('../tmp/test.png');
header('content-type: image/jpg');
echo $im;
?>