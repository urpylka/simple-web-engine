<?php
header("Content-Type: text/html; charset=utf-8");
ini_set('display_errors','Off');

/**AUTH BLOCK */
require_once("./valid.php");
if (!passornot()) {
	echo $notauthalert;
	exit;
}
/**END OF AUTH BLOCK */



require_once("./connect.php");

$wholeyid=mysql_result(mysql_query("SELECT * FROM `settings` WHERE `property` LIKE 'current_year';"), 0, "value");

if($_GET['wid']=="") {
	$selected = " selected";
} else {
	$selected = "";
}
echo '<input type="hidden" class="linker" value="#real_all"><a class="ways'.$selected.'" href="#real_all">Все</a>';
$ft1=mysql_query("SELECT * FROM `ways` WHERE `show_status` = 1;");
for ($i=0; $i < mysql_num_rows($ft1); $i++) {
	if($_GET['wid']==mysql_result($ft1, $i, "wid")) {
		$selected = " selected";
	} else {
		$selected = "";
	}
	echo '<input type="hidden" class="linker" value="#real_all?wid='.mysql_result($ft1, $i, "wid").'"><a class="ways'.$selected.'" href="#real_all?wid='.mysql_result($ft1, $i, "wid").'">'.mysql_result($ft1, $i, "name").'</a>';
}

if(isset($_GET['wid']) && $_GET['wid']!="") {
	$ft0=mysql_query("SELECT * FROM `vus` WHERE `wid` REGEXP '".(int)$_GET['wid'].",';");
	$wid=" AND `pr_result` = ".(int)$_GET['wid']." ";
} else {
	$ft0=mysql_query("SELECT * FROM `vus`;");
	$wid="";
}

if(mysql_num_rows($ft0)>0) {
	echo '<h1>Сводная таблица кандидатов по ВУС и факультетам</h1><table class="eba">
<thead>
<tr>
	<th><p>ВУС</p><p>Факультет</p></th>';
		for($i=0;$i<mysql_num_rows($ft0);$i++) { echo'<th><input type="hidden" class="linker" value="#show_all?vus='.mysql_result($ft0, $i, "vusid").'"><a href="#show_all?vus='.mysql_result($ft0, $i, "vusid").'">'.mysql_result($ft0, $i, "vn").'</a></th>'; }
	echo'
	<th><input type="hidden" class="linker" value="#show_all?vus=0"><a href="#show_all?vus=0">Не указана ВУС</a></th>
	<th><input type="hidden" class="linker" value="#show_all?vus=all"><a href="#show_all?vus=all">Итог</a></th>
</tr>
</thead>
<tbody>
	<tr>';

$ft1=mysql_query("SELECT * FROM `facs`");

for($c=0;$c<mysql_num_rows($ft1);$c++) {
	echo'<tr>';
	echo'<td>'.mysql_result($ft1, $c, "name").'</td>';
	for($i=0;$i<mysql_num_rows($ft0);$i++) {
		$num1=mysql_num_rows(mysql_query("SELECT * FROM `candidate` WHERE `vus` = '".mysql_result($ft0, $i, "vusid")."' ".$wid."  AND `faculty` = ".mysql_result($ft1, $c, "fid")." AND `yid` = ".$wholeyid." AND `status` = 1"));
		echo'<td><input type="hidden" class="linker" value="#show_all?vus='.mysql_result($ft0, $i, "vusid").'&fac='.mysql_result($ft1, $c, "fid").'"><a class="ab1" href="#show_all?vus='.mysql_result($ft0, $i, "vusid").'&fac='.mysql_result($ft1, $c, "fid").'">'.$num1.'</a>';
		echo '</td>';
	}
	$num1=mysql_num_rows(mysql_query("SELECT * FROM `candidate` WHERE `vus` = 0  AND `faculty` = ".mysql_result($ft1, $c, "fid")." AND `yid` = ".$wholeyid." AND `status` = 1"));
	echo'<td><input type="hidden" class="linker" value="#show_all?vus=0&fac='.mysql_result($ft1, $c, "fid").'"><a class="ab1" href="#show_all?vus=0&fac='.mysql_result($ft1, $c, "fid").'">'.$num1.'</a>';
	echo '</td>';
	$num1=mysql_num_rows(mysql_query("SELECT * FROM `candidate` WHERE `faculty` = ".mysql_result($ft1, $c, "fid")." ".$wid."  AND `yid` = ".$wholeyid." AND `status` = 1"));
	echo'<td><input type="hidden" class="linker" value="#show_all?fac='.mysql_result($ft1, $c, "fid").'"><a class="ab1" href="#show_all?fac='.mysql_result($ft1, $c, "fid").'">'.$num1.'</a>';
	echo'</td></tr>';
}
echo'<tr><td>Итог</td>';
for($i=0;$i<mysql_num_rows($ft0);$i++) {
	echo'<td>
	<input type="hidden" class="linker" value="#show_all?vus='.mysql_result($ft0, $i, "vusid").'">
	<a class="ab1" href="#show_all?vus='.mysql_result($ft0, $i, "vusid").'">'.mysql_num_rows(mysql_query("SELECT * FROM `candidate` WHERE `vus` = '".mysql_result($ft0, $i, "vusid")."' ".$wid." AND `yid` = ".$wholeyid." AND `status` = 1")).'</a>';
	echo'</td>';
}
$num1=mysql_num_rows(mysql_query("SELECT * FROM `candidate` WHERE `vus` = 0 AND `yid` = ".$wholeyid." AND `status` = 1"));
echo'<td><input type="hidden" class="linker" value="#show_all?vus=0"><a class="ab1" href="#show_all?vus=0">'.$num1.'</a>';
echo '</td>';
echo'<td>
<input type="hidden" class="linker" value="#show_all?vus=all">
<a class="ab1" href="#show_all?vus=all">'.mysql_num_rows(mysql_query("SELECT * FROM `candidate` WHERE `status` = 1 ".$wid." AND `yid` = ".$wholeyid.";")).'</a>';
echo'</td></tr>';
echo'
</tbody>
</table>
<script charset="utf-8" type="text/javascript">
$(document).ready(function () {

//remove(".eba th:first-child").remove(".eba tr > td:first-child")

$(".eba td").add(".eba th").click( function () {
	location.href=$(".linker", this).val();
});

$(".eba td > a").each( function () {
	if(Number($(this).html())>0) {
		$(this).parent().addClass("hled");
	}
});
});
</script>';
} else {
	echo "<h1>Данных нет</h1>";
}
?>