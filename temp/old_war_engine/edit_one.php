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

?>
<script charset="utf-8" type="text/javascript">
$(document).ready(function () {

function sel(x) {
	switch (x) {
<?php
require_once("./connect.php");

$ft2=mysql_query("SELECT * FROM `candidate` WHERE `cid` = '".(int)$_GET["cid"]."';");

$ft0=mysql_query("SELECT `fid` FROM `facs`;");
$i=0;
while($i<mysql_num_rows($ft0)) {
	$ft1=mysql_query("SELECT * FROM `specs` WHERE `fid` = ".mysql_result($ft0, $i, "fid").";");
	echo'case "'.mysql_result($ft0, $i, "fid").'":
$("#pr_spec").html("<option default=\'default\' value=\'0\'></option>';
	$c=0;
	while($c<mysql_num_rows($ft1)) {
		if(mysql_result($ft2, 0, "spec")==mysql_result($ft1, $c, "sid")) {
			$opt="selected";
		} else {
			$opt="";
		}
		echo "<option ".$opt." value='".mysql_result($ft1, $c, "sid")."'>".mysql_result($ft1, $c, "sn")." - ".mysql_result($ft1, $c, "name")."</option>";
		$c++;
	}
	echo'");
break;
';
	$i++;
}
?>
	}
}
function vuss(x) {
	switch (x) {
<?php
$ft0=mysql_query("SELECT * FROM `vus`;");
$i=0;
while($i<mysql_num_rows($ft0)) {
	$ways=explode(",", mysql_result($ft0, $i, "wid"));
	echo'case "'.mysql_result($ft0, $i, "vusid").'":
$("#pr_result").html("';
	$c=0;
	while($c<count($ways)) {
		if(mysql_result($ft2, 0, "pr_result")==$ways[$c]) {
			$opt="selected";
		} else {
			$opt="";
		}
		if($ways[$c]!="") {
			echo "<option ".$opt." value='".$ways[$c]."'>".mysql_result(mysql_query("SELECT * FROM `ways` WHERE `wid` = ".$ways[$c].";"), 0, "name")."</option>";
		}
		$c++;
	}
	echo'");
break;
';
	$i++;
}
?>
	}
}

$("#pr_faculty").bind("change", function () {
	if($("#pr_faculty").val()) {
		sel($("#pr_faculty option:selected").val());
	}
});
$("#pr_vus").bind("change", function () {
	if($("#pr_vus").val()) {
		vuss($("#pr_vus option:selected").val());
	}
});

sel($("#pr_faculty option:selected").val());
vuss($("#pr_vus option:selected").val());
$("#pr_phone").mask("(999) 999-9999");
$("#pr_bday").mask("99.99.9999");
$("#pr_date").mask("99.99.9999");

$("#pr_go").click( function () {
	$.post("./base.php", {
 cid: $("#pr_cid").val(),
 email: $("#pr_email").val(),
 fname: $("#pr_fname").val(),
 lname: $("#pr_lname").val(),
 mname: $("#pr_mname").val(),
 bday: $("#pr_bday").val(),
 voen: $("#pr_voen").val(),
 faculty: $("#pr_faculty").val(),
 spec: $("#pr_spec").val(),
 group: $("#pr_group").val(),
 vus: $("#pr_vus").val(),
 budj: $("#pr_budj").val(),
 phone: $("#pr_phone").val(),
 pr_ser: $("#pr_ser").val(),
 pr_num: $("#pr_num").val(),
 pr_date: $("#pr_date").val(),
 pr_godnogroup: $("#pr_godnogroup").val(),
 pr_ppogroup: $("#pr_ppogroup").val(),
 pr_u1: $("#pr_u1").val(),
 pr_u2: $("#pr_u2").val(),
 pr_u3: $("#pr_u3").val(),
 pr_u4: $("#pr_u4").val(),
 pr_power: $("#pr_power").val(),
 pr_speed: $("#pr_speed").val(),
 pr_endurance: $("#pr_endurance").val(),
 pr_facilities: $("#pr_facilities").is(":checked")?1:0,
 pr_result: $("#pr_result").val()
 },
	function (data) {
		var par=data.split("%");
		if(par.length>1) {
			$("#pr_cid").val(par[1]);
		}
		shown(par[0]);
		console.log(data);
	});
});

$("#pr_godnogroup").add("#pr_ppogroup").change( function () {
	$(this).siblings(".sumi").html($(":selected", this).html());
});

$("#pr_u1").add("#pr_u2").add("#pr_u3").add("#pr_u4").change( function () {
	$(this).siblings(".sumi").html((Number($("#pr_u1").val()) + Number($("#pr_u2").val()) + Number($("#pr_u3").val()) + Number($("#pr_u4").val())) / 4);
});

$("#pr_power").add("#pr_speed").add("#pr_endurance").change( function () {
	var power=0;
	var speed=0;
	var endurance=0;
	if(Number($("#pr_power").val())<7) {
		power=2;
	} else if(Number($("#pr_power").val())<10) {
		power=3;
	} else if(Number($("#pr_power").val())<12) {
		power=4;
	} else {
		power=5;
	}
	if(Number($("#pr_speed").val())>16) {
		speed=2;
	} else if(Number($("#pr_speed").val())>15) {
		speed=3;
	} else if(Number($("#pr_speed").val())>14.4) {
		speed=4;
	} else {
		speed=5;
	}
	if(Number($("#pr_endurance").val())>13.15) {
		endurance=2;
	} else if(Number($("#pr_endurance").val())>12.50) {
		endurance=3;
	} else if(Number($("#pr_endurance").val())>12.35) {
		endurance=4;
	} else {
		endurance=5;
	}
	//console.log(power + " + " + speed + " + " + endurance);
	$(this).siblings(".sumi").html((power + speed + endurance) / 3);
});

$("#pr_godnogroup").add("#pr_u1").add("#pr_power").trigger("change");

});
</script>
<?php
if(!((int)$_GET["cid"]>0)) {
	$_GET["cid"]="new";
}
echo'
<input type="hidden" id="pr_cid" name="pr_cid" value="'.$_GET["cid"].'">
<div id="preg_student" class="devdiv">
	<div class="preg_top">Личные данные</div>
		<div class="preg_utop">
			Фамилия&nbsp;<input type="text" class="binput" name="pr_lname" id="pr_lname" value="'.mysql_result($ft2, 0, "lname").'" />
			Имя&nbsp;&nbsp;<input type="text" class="binput" name="pr_fname" id="pr_fname" value="'.mysql_result($ft2, 0, "fname").'" />
		</div>
		<div class="preg_utop hrd">
			Отчество&nbsp;<input type="text" class="binput" name="pr_mname" id="pr_mname" value="'.mysql_result($ft2, 0, "mname").'" />
			Дата рождения&nbsp;<input type="text" class="ninput" name="pr_bday" id="pr_bday" value="'.mysql_result($ft2, 0, "bday").'" />
		</div>
	<div class="preg_top">Учебные данные</div>
		<div class="preg_utop">
			Военкомат&nbsp;
			<select id="pr_voen" class="" size="1">
';
$ft0=mysql_query("SELECT * FROM `voen`;");
$i=0;
echo"<option default='default' value='0'></option>";
while($i<mysql_num_rows($ft0)) {
	if(mysql_result($ft2, 0, "voen")==mysql_result($ft0, $i, "vid")) {
		$opt="selected";
	} else {
		$opt="";
	}
	echo "<option ".$opt." value='".mysql_result($ft0, $i, "vid")."'>".mysql_result($ft0, $i, "name")."</option>";
	$i++;
}
			?>
			</select>
		</div>
		<div class="preg_utop">
			Факультет&nbsp;
			<select id="pr_faculty" class="" size="1">
<?php
$ft0=mysql_query("SELECT * FROM `facs`;");
$i=0;
echo"<option default='default' value='0'></option>";
while($i<mysql_num_rows($ft0)) {
	if(mysql_result($ft2, 0, "faculty")==mysql_result($ft0, $i, "fid")) {
		$opt="selected";
	} else {
		$opt="";
	}
	echo "<option ".$opt." value='".mysql_result($ft0, $i, "fid")."'>".mysql_result($ft0, $i, "name")."</option>";
	$i++;
}
echo'
			</select>
		</div>
		<div class="preg_utop">
			Специальность&nbsp;
			<select id="pr_spec" class="rinput" size="1">
				<option value="0"></option>
			</select>
		</div>
		<div class="preg_utop hrd">
			Группа&nbsp;<input type="text" class="sinput" name="pr_group" id="pr_group" value="'.mysql_result($ft2, 0, "group").'" />
			&nbsp;&nbsp;&nbsp;<!--ВУС&nbsp;<input type="text" class="sinput" name="pr_vus" id="pr_vus_1" value="'.mysql_result($ft2, 0, "vus").'" /-->
			&nbsp;&nbsp;Форма обучения&nbsp;
			<select id="pr_budj" class="ninput" size="1">
				<option value="0"></option>';
				$opt=array_fill(0, 10, "");
				$opt[mysql_result($ft2, 0, "budj")]="selected";
					echo'<option '.$opt[1].' value="1">Бюджет</option>
					<option '.$opt[2].' value="2">Контракт</option>
			</select>
		</div>
	<div class="preg_top">Контактные данные</div>
		<div class="preg_utop">
			Телефон&nbsp;<input type="text" class="binput" name="pr_phone" id="pr_phone" value="'.mysql_result($ft2, 0, "phone").'" />
			email&nbsp;<input type="text" class="binput" name="pr_email" id="pr_email" value="'.mysql_result($ft2, 0, "email").'" />
		</div>

</div>
<div id="preg_teacher" class="devdiv">
	<div class="preg_top">Паспорт</div>
		<div class="preg_utop hrd">
			Серия&nbsp;<input type="text" class="sinput" name="pr_ser" id="pr_ser" value="'.mysql_result($ft2, 0, "pr_ser").'" />
			&nbsp;Номер&nbsp;<input type="text" class="ninput" name="pr_num" id="pr_num" value="'.mysql_result($ft2, 0, "pr_num").'" />
			&nbsp;Дата выдачи&nbsp;<input type="text" class="ninput" name="pr_date" id="pr_date" value="'.mysql_result($ft2, 0, "pr_date").'" />
		</div>
	
	<div class="preg_top">Комиссия</div>
		<div class="preg_utop">
			<div class="sumi">A</div>Группа годности
			<select id="pr_godnogroup" class="sinput" size="1">';
				$opt=array_fill(0, 10, "");
				$opt[mysql_result($ft2, 0, "pr_godnogroup")]="selected";
				echo'
				<option value="9"></option>
				<option '.$opt[1].' value="1">А</option>
				<option '.$opt[2].' value="2">Б</option>
			</select>
		</div>
		<div class="preg_utop">
			<div class="sumi">III</div>Группа ППО&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<select id="pr_ppogroup" class="sinput" size="1">';
				if(mysql_result($ft2, 0, "pr_facilities")==1) {
					$checkedd="checked";
				} else {
					$checkedd="";
				}
				$opt=array_fill(0, 10, "");
				$opt[mysql_result($ft2, 0, "pr_ppogroup")]="selected";
				echo'
				<option value="9"></option>
				<option '.$opt[1].' value="1">I</option>
				<option '.$opt[2].' value="2">II</option>
				<option '.$opt[3].' value="3">III</option>
			</select>
		</div>
		<div class="preg_utop hrd">
			<div class="sumi">4,5</div>Текущая успеваемость&nbsp;
			<input type="text" class="sinput" name="pr_u1" id="pr_u1" value="'.mysql_result($ft2, 0, "pr_u1").'" />
			<input type="text" class="sinput" name="pr_u2" id="pr_u2" value="'.mysql_result($ft2, 0, "pr_u2").'" />
			<input type="text" class="sinput" name="pr_u3" id="pr_u3" value="'.mysql_result($ft2, 0, "pr_u3").'" />
			<input type="text" class="sinput" name="pr_u4" id="pr_u4" value="'.mysql_result($ft2, 0, "pr_u4").'" />
		</div>
	
	<div class="preg_top">Физические данные</div>
		<div class="preg_utop hrd">
			<div class="sumi">4,3</div>Сила&nbsp;<input type="text" class="sinput" name="pr_power" id="pr_power" value="'.mysql_result($ft2, 0, "pr_power").'" />
			&nbsp;Скорость&nbsp;<input type="text" class="sinput" name="pr_speed" id="pr_speed" value="'.mysql_result($ft2, 0, "pr_speed").'" />
			&nbsp;Выносливость&nbsp;<input type="text" class="sinput" name="pr_endurance" id="pr_endurance" value="'.mysql_result($ft2, 0, "pr_endurance").'" />
		</div>
	
	<div class="preg_top">Результат</div>
		<div class="preg_utop">
			Льготы&nbsp;
			<input '.$checkedd.' type="checkbox" id="pr_facilities" value="1" /`>
		</div>
		<div class="preg_utop">
			ВУС&nbsp;<select id="pr_vus" class="ninput" size="1">';
$ft0=mysql_query("SELECT * FROM `vus`;");
$i=0;
echo"<option default='default' value='0'></option>";
while($i<mysql_num_rows($ft0)) {
	if(mysql_result($ft2, 0, "vus")==mysql_result($ft0, $i, "vusid")) {
		$opt="selected";
	} else {
		$opt="";
	}
	echo "<option ".$opt." value='".mysql_result($ft0, $i, "vusid")."'>".mysql_result($ft0, $i, "vn")." - ".mysql_result($ft0, $i, "name")."</option>";
	$i++;
}
echo '</select>';
//отборный кусок говнокода
$opt=array_fill(0, 10, "");
$opt[mysql_result($ft2, 0, "pr_ppogroup")]="selected";
if(mysql_result($ft2, 0, "prefer") == 0) {
	$prefer = "Предпочтений нет";
} else {
	$prefer = "Хочет получить звание <b>".mysql_result(mysql_query("SELECT * FROM `ways` WHERE `wid` = ".mysql_result($ft2, 0, "prefer")), 0, "name")."</b>";
}
		echo'
		<div class="preg_prefer">
			'.$prefer.'
		</div>
	</div>
		<div class="preg_utop">
			Решение&nbsp;&nbsp;<select id="pr_result" class="ninput" size="1"><option default="default" value="0"></option>
	</select>
		</div>
	
	<div id="pr_go" class="a1">&nbsp;&nbsp;&nbsp;Применить изменения&nbsp;&nbsp;&nbsp;</div>
</div>
';
?>
