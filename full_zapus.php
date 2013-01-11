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
	echo "<b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
	<form action='full_zapus.php' enctype='multipart/form-data' method='post'>
	Клікніть на полі для вибору дати <input  id='inputDate4' name='date' value='' /> <input type='submit' name='ok'  value='Вибрати' ></FORM>";

	if ($_POST['date']){
    $mas_doctor=$base->Get_doctor($_SESSION['likarnja']);
    echo "<table id='zapus'><tr><td width='2%'>№</td><td width='30%'><FONT size=4 color=blue>Лікар</FONT></td><td width='30%'><FONT size=4 color=blue>Паціент</FONT></td><td width='30%'><FONT size=4 color=blue>Дата та час</FONT></td></tr>";
	$kilkist_pat=0;
    	for ($i=0;$i<count($mas_doctor);$i++)
		{
				$assigned_patient_id='';
				$base->sql_connect();
                $base->sql_query="SELECT * FROM `mis_schedule`,`mis_physican_in_hospital` WHERE `id_physician_in_hospital` ='".$mas_doctor[$i]['id']."'
                                    AND `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` 
                                    AND `assigned_patient_id`>'1' 
                                    AND  `work_date` = '".$_POST['date']."' ";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$assigned_patient_id = $Mas['assigned_patient_id'];
					$work_date = $Mas['work_date'];
					$timebegin = $Mas['timebegin'];
                    $timeend = $Mas['timeend'];
                    $room = $Mas['room'];
                    $id_physician = $Mas['id_physician'];
                    $id_speciality = $Mas['id_speciality'];
					}
				$base->sql_query="SELECT * FROM mis_guide_speciality WHERE `id` ='".$id_speciality."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$spec_name = $Mas['spec_name'];
					}
				$base->sql_query="SELECT * FROM mis_guide_physician WHERE `id` ='".$id_physician."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$doctor_family = $Mas['family'];
					$doctor_name = $Mas['name'];
					$doctor_third_name = $Mas['third_name'];
                    
					}
                $base->sql_query="SELECT * FROM mis_patient WHERE `id` ='".$assigned_patient_id."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$p_family = $Mas['family'];
					$p_name = $Mas['name'];
					$p_third_name = $Mas['third_name'];
					}
     if ($assigned_patient_id!=''){
		 $kilkist_pat++;
         echo "<tr><td>".$kilkist_pat."</td><td>";
         
         echo "<a href='new_doctor.php?doctor=".$mas_doctor[$i]['id']."&m=".date('m')."'>".$doctor_family." ".$doctor_name." ".$doctor_third_name."(".$spec_name.")</a></td><td><a href='my_patient.php?id_patient=".$assigned_patient_id."&status=active'> ".$p_family." ".$p_name." ".$p_third_name."</td><td>".$work_date." (".$timebegin." - ".$timeend.")</td>";
         
         echo "</td></tr>";   
          }  
        }}
	}	

?>