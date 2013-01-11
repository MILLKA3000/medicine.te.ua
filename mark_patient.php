<link rel="stylesheet" href="datepicker/datepicker.css" type="text/css" /> 
<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();

include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='my_profile.php?doctor=".$_GET['doctor']."'>Мій профіль</a></Font>";
include ("menu.php");
echo "
<script type='text/javascript' src='datepicker/jquery.js'></script>
<script type='text/javascript' src='datepicker/date.js'></script>
<script type='text/javascript' src='datepicker/jquery.datePicker-2.1.2.js'></script>
 
<script type='text/javascript'>
$(function()
{
$('#inputDate4').datePicker({
createButton:false,
clickInput:true,
endDate: (new Date()).addDays(365).asString()
});
});
</script>";
//----------------------------------Перевірка авторизації----------------------------------------

	//----------------------------------Форма авторизації----------------------------------------
	if (!$_SESSION['name_sesion_a'])
	{
		header("Location: my_admin.php");
	}
	else
	//----------------------------------Лікар авторизувався----------------------------------------
	{
	
	include ("admin_menu.php");
	echo "<b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";
	if ($_GET['del_id'])
		{
			$base->ins("DELETE FROM `mis`.`mis_mark` WHERE id=".$_GET['del_id'].";");
		}
	if ($_POST['vidmitka'])
		{
			$base->ins("INSERT INTO `mis`.`mis_mark` (`id_patient`, `id_schedule`, `id_num`, `mark`, `date`, `doc`) VALUES ('".$_GET['id_patient']."', '".$_GET['id_schedule']."', '".$_SESSION['num']."', '".$_POST['mark']."', '".$_GET['date']."', '');");
		}
	if($_GET['date'] & $_GET['id_patient'])
		{
	$patient = $base ->Get_patient_new("SELECT * FROM mis_patient WHERE id='".(int) $_GET['id_patient']."';");
	$patient_work = $base->Get_to_schedule_new("SELECT  * FROM mis_schedule WHERE  assigned_patient_id='".$_GET['id_patient']."' ;");
	$mark = $base ->Get_mark_new("SELECT * FROM mis_mark  WHERE id_patient='".(int) $_GET['id_patient']."' ;");
	//print_r($patient_work);
			echo "<b><h3>Пацієнт <FONT color=green>".$patient[0]['family']." ".$patient[0]['name']." ".$patient[0]['third_name']."</b></h3></FONT><hr /><br><center>Введіть відмітки для пацієнта</center>";
			echo "<form action='mark_patient.php?date=".$_GET['date']."&id_patient=".$_GET['id_patient']."&id_schedule=".$_GET['id_schedule']."' enctype='multipart/form-data' method='post'>";
			echo "<table width=100% border=1><tr><td height=200px valign=top  >
			<table width=100%><tr><td width=30%>";
	
			$doc=$base->select_doctor_in_hosp("SELECT *  FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id  AND mis_physican_in_hospital.id='".$_SESSION['num']."' AND  mis_physican_in_hospital.id_hospital='".$_SESSION['likarnja']."';");
			//print_r($doc);
			echo "<b>Лікар</b> <br>  -	".$doc[0]['family']." ".$doc[0]['name']." ".$doc[0]['third_name']."<br><b>Спеціальність</b> <br> - ".$doc[0]['name_spec']." <br><b>Огляд</b> <br> - ".$_GET['date']."<br><br><center><input type='submit' name='vidmitka'  value='Відмітити пацієнта' ></center></td>
			<td valign=top><TEXTAREA NAME='mark' WRAP='virtual' COLS='70' ROWS='10'>Відмітки ...</TEXTAREA></FORM></td><tr></table></td></tr></table>";
			echo "<b><h3><center>Відмітки які введені лікарями</center></b></h3></FONT><hr />";
	//-------------------------------------------------------------------------------------------ІНШІ------------------------------------------------------------------------------------------------
			for ($i=0;$i<count($mark);$i++)
			{
				echo "<table width=100% border=1><tr><td height=200px valign=top >
			<table width=100%><tr><td width=30%>";
			$mark = $base ->Get_mark_new("SELECT * FROM mis_mark  WHERE id_patient='".(int) $_GET['id_patient']."' ;");
			$patient_work = $base->Get_to_schedule_new("SELECT  * FROM mis_schedule WHERE  id='".$mark[$i]['id_schedule']."' ;");
			$doc=$base->select_doctor_in_hosp("SELECT *  FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id  AND mis_physican_in_hospital.id='".$mark[$i]['id_num']."'  AND  mis_physican_in_hospital.id_hospital='".$_SESSION['likarnja']."';");
			//print_r($doc);
			echo "<b>Лікар</b> <br>  -	".$doc[0]['family']." ".$doc[0]['name']." ".$doc[0]['third_name']."<br><b>Спеціальність</b> <br> - ".$doc[0]['name_spec']." <br><b>Огляд</b> <br> - ".$mark[$i]['date']." (".$patient_work[0]['timebegin']." - ".$patient_work[0]['timeend'].")<br><center></center></td>
			<td valign=top><TEXTAREA NAME='mark_old' WRAP='virtual' COLS='70' ROWS='10'>".$mark[$i]['mark']."</TEXTAREA></td>
				<td width=10%>";
			if ($mark[$i]['id_num']==$_SESSION['num']){echo "<a href='mark_patient.php?date=".$_GET['date']."&id_patient=".$_GET['id_patient']."&id_schedule=".$_GET['id_schedule']."&del_id=".$mark[$i]['id']."'>Витерти відмітку</a>";}
			echo "</td><tr></table></td></tr></table>";
			}
		}
		else
		{

	echo "<center>Веберіть дату для перегляду записаних пацієнтів. </center><br>";
	echo "<form action='mark_patient.php' enctype='multipart/form-data' method='post'>
	Клікніть на полі для вибору дати <input  id='inputDate4' name='date' value='".$_POST['date']."' /> <input type='submit' name='ok'  value='Вибрати' ></FORM>";
	if ($_POST['ok']){
	$patient_work = $base->Get_to_schedule_new("SELECT DISTINCT assigned_patient_id,id FROM mis_schedule WHERE id_physician_in_hospital='".$_SESSION['num']."' AND assigned_patient_id>'1' AND work_date='".$_POST['date']."';");

	if (count($patient_work)>0){
	echo "<table id='zapus'  width='100%'><tr><td width='50%'>ПІБ</td><td width='50%'>Відмітки про проходження консультації</td></tr>";}
	else {echo "<FONT color=red><CENTER>Жодного запису </FONT>";}
	for ($i=0;$i<count($patient_work);$i++)
		{
		$patient = $base ->Get_patient_new("SELECT * FROM mis_patient WHERE id='".(int) $patient_work[$i]['patient_id']."';");
		$mark = $base ->Get_mark_new("SELECT * FROM mis_mark  WHERE id_patient='".(int) $patient_work[$i]['patient_id']."' AND id_num ='".$_SESSION['num']."' AND  date='".$_POST['date']."' AND id_schedule=".$patient_work[$i]['id'].";");
			echo "<tr><td>".$patient[0]['family']." ".$patient[0]['name']." ".$patient[0]['third_name']."</td><td>";
			if (count($mark)==0){
			echo "<a href='mark_patient.php?date=".$_POST['date']."&id_patient=".$patient_work[$i]['patient_id']."&id_schedule=".$patient_work[$i]['id']."'>Відмітити</a>";}
			else{echo "<FONT color=green><a href='mark_patient.php?date=".$_POST['date']."&id_patient=".$patient_work[$i]['patient_id']."&id_schedule=".$patient_work[$i]['id']."'>Відмітка ".$mark[0]['date']."</FONT></a>";}
			echo "</td></tr>";
		}

	}
		}
	}	
?>