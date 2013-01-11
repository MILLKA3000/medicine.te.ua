<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
echo "
<link rel='stylesheet' href='datepicker/datepicker.css' type='text/css' /> 
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
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='log.php'>Перегляд логів</a></Font>";
include "admin_menu.php";
if ($_SESSION['role']>1)
	{
echo " <b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
<center><FONT size=8>Перегляд логів </FONT><br><br><table width=100% ><tr><td>
<form action='log.php' enctype='multipart/form-data' method='post'>
	Клікніть на полі для вибору дати <input  id='inputDate4' name='date' value='".$_GET['date']."' /> <input type='submit' name='ok'  value='Вибрати' ></FORM>";
if (($_POST['ok']=='Вибрати')||($_GET['date'])){
$logs=$base->Get_logs("SELECT * FROM mis_logs Where date_old = '".$_POST['date']."' OR date_old = '".$_GET['date']."' ;");
$k=ceil(count($logs)/25);
if($_GET['label']!='')
	{
		$logs=$base->Get_logs("SELECT * FROM mis_logs Where date_old = '".$_GET['date']."' LIMIT ".(($_GET['label']-1)*25)." , ".(($_GET['label']-1)*25+25).";");
	}
	else 
		{
		$logs=$base->Get_logs("SELECT * FROM mis_logs Where date_old = '".$_POST['date']."' LIMIT 0 , 25;");
		}
echo "<table border=1 id='zapus'><tr><td><b><center>Користувач</td><td><b><center>Час</td><td><b><center>Дія</td><td><b><center>Сторінка</td></tr><center>";

 for ($i=0;$i<$k;$i++)
		{
	 if($_GET['label']!='')
	{
echo " <a href='log.php?date=".$_GET['date']."&label=".($i+1)."'>".($i+1)."</a>";
	}else
	 echo " <a href='log.php?date=".$_POST['date']."&label=".($i+1)."'>".($i+1)."</a>";
				}
 for ($i=0;$i<count($logs);$i++)
		{
			$name_acount=$base->Get_physican("SELECT * FROM mis_guide_physician WHERE id='".$logs[$i]['id_acount']."'");
			echo "<tr><td>".$name_acount[0]['family']." ".$name_acount[0]['name']." ".$name_acount[0]['third_name']."</td><td>".$logs[$i]['date']."</td><td>".$logs[$i]['action']."</td><td>".$logs[$i]['adress']."</td>";
		}

}

//-----------------------------------------------якщо незалогінений---------------------------------------
}
	else 
	{
	header("Location: my_admin.php");
	}
echo "</td></tr></table>";



 
?>








