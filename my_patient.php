<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
 	if ($_SESSION['name_sesion_a'] && $_GET['id_patient'])
	{
	       $base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_patient` WHERE `id` ='".$_GET['id_patient']."'";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_patient = $Mas['id'];
			$id_patient_family = $Mas['family'];
			$id_patient_name = $Mas['name'];
			$id_patient_first_name = $Mas['third_name'];
			}
            if ($id_patient!='')
		{
		
		$_SESSION['name_sesion'] = $id_patient;
		$_SESSION['family_p'] = $id_patient_family;
		$_SESSION['name_p'] = $id_patient_name;
		$_SESSION['first_name_p'] = $id_patient_first_name;
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['grant'] = "false";
		}
    }
if ($_POST['auth'])
		{
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_patient` WHERE `phone1` ='".$_POST['auth']."' OR `phone2` ='".$_POST['auth']."'";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_patient = $Mas['id'];
			$id_patient_family = $Mas['family'];
			$id_patient_name = $Mas['name'];
			$id_patient_first_name = $Mas['third_name'];
            $date = $Mas['birthday'];
            $adress = $Mas['adress'];
			}	
		if ($id_patient!='')
		{
		session_start();
		$_SESSION['name_sesion'] = $id_patient;
		$_SESSION['family_p'] = $id_patient_family;
		$_SESSION['name_p'] = $id_patient_name;
		$_SESSION['first_name_p'] = $id_patient_first_name;
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['date'] = $date;
        $_SESSION['adress'] = $adress;
		}
		
		}
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_patient.php?status=active'>Мої записи</a></Font>";
include ("menu.php");

echo "<center><div class='lifted'  ><p> <FONT size=8>Мої записи</FONT><br><br>";
//----------------------------------Перевірка авторизації----------------------------------------
if 	(($id_patient=='') && ($_POST['auth'])) echo"<FONT color=red> Неправельний ввід повторіть будь ласка </FONT>";
	
	//----------------------------------Форма авторизації----------------------------------------
	if ((!$_SESSION['name_sesion']))
	{
		echo "<div class='auth-form'> <h3><b> Авторизуйтесь <br><br><br> <table width=90%> <form action='my_patient.php?status=active' method='post'> <b>
			<tr><td  width=30%><b style='float:right;'>Введіть номер телефону<span class='jQtooltip mini' title='Вводьте тільки цифри'>!</span></td><td style='float:left;'><input name='auth' maxlength='50' size='41' class='input-text' type='text' id='all3'></td></tr>
			<tr><td></td><td style='float:center;' width=30%><input  type='submit' value='Вхід'></td></tr></table></form>";
	}
	else
	//----------------------------------Пацыент авторизувався----------------------------------------
	{
		if(($_GET['time'])&&($_SESSION['name_sesion']))
		{
				$base->sql_connect();
				$base->sql_query="UPDATE `mis`.`mis_schedule` SET `assigned_patient_id` = '1' WHERE `mis_schedule`.`id` =".$_GET['time'].";";
				$base->sql_execute();
				
		}
		
		$mas_schedule=$base->Get_to_schedule_for_patient($_SESSION['name_sesion']);
				$base->sql_connect();
				$base->sql_query="SELECT * FROM mis_patient WHERE `id` ='".$_SESSION['name_sesion']."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					echo"
		<table align=left width=90%><tr>
		<td width=10%>П.І.П</td><td width=70%><Font size=4>".$Mas['family']." ".$Mas['name']." ".$Mas['third_name']."</td>
		</tr><tr>
		<td>Адреса</td><td><Font size=4>".$Mas['adress']."</td>
		</tr><tr>
		<td>Телефон 1</td><td><Font size=4>".$Mas['phone1']."</td>
		</tr><tr>
		<td>Телефон 2</td><td><Font size=4>".$Mas['phone2']."</td>
		</tr></table>
		<br><br><br><br><br><br><br><br>
					";
					}
		//----------------------------------------------меню записів-----------------------------------------------
		echo "<table width=100% cellspacing=0><tr>
		<td width=30% style='border-bottom: 2px solid blue;'><FONT> &nbsp</FONT></td>";
		if ($_GET['status']=='deactive'){
		echo "<td width=15% style='border: 2px solid blue;'>
		<a class='text' href='my_patient.php?status=active'><center>Активні записи</a></td>";}
		else{
		echo "<td width=15% style='border-top: 2px solid blue;border-left: 2px solid blue;border-right: 2px solid blue'>
		<a class='text' href='my_patient.php?status=active'><center>Активні записи</a></td>";}
		
		echo "<td width=10% style='border-bottom: 2px solid blue;'><FONT> &nbsp</FONT></td>";
		
		if ($_GET['status']=='active'){
		echo "<td width=15% style='border: 2px solid blue;'>
		<a class='text' href='my_patient.php?status=deactive'><center>Минулі записи</a></td>";}
		else {
		echo "<td width=15% style='border-top: 2px solid blue;border-left: 2px solid blue;border-right: 2px solid blue'>
		<a class='text' href='my_patient.php?status=deactive'><center>Минулі записи</a></td>";}
		
		echo"
		<td width=30% style='border-bottom: 2px solid blue;'><FONT> &nbsp</FONT></td></tr></table>
		
		
		<br><table width=98% cellspacing=0 id='zapus'><tr><td class='TD_b' style='border-left: 1px solid #666; border-top: 1px solid #666'>Лікарня</td>
		<td  class='TD_b' style='border-top: 1px solid #666'>Спеціальність</td><td  class='TD_b' style='border-top: 1px solid #666'>Лікар</td>
		<td  class='TD_b' style='border-top: 1px solid #666'>Дата</td><td  class='TD_b' style='border-top: 1px solid #666'>Час</td><td  class='TD_b' style='border-top: 1px solid #666'><FONT>&nbsp</FONT></td></tr>";
		
		
		
		for ($i=0;$i<count($mas_schedule);$i++)
		{
				
				$base->sql_connect();
				$base->sql_query="SELECT * FROM `mis_physican_in_hospital` WHERE `id` ='".$mas_schedule[$i]['physican_id']."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$id_physican = $Mas['id_physician'];
					$id_hospital = $Mas['id_hospital'];
					$id_speciality = $Mas['id_speciality'];
					}
				$base->sql_query="SELECT * FROM mis_hospital WHERE `id` ='".$id_hospital."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$hosp_name = $Mas['title'];
					}
				$base->sql_query="SELECT * FROM mis_guide_speciality WHERE `id` ='".$id_speciality."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$spec_name = $Mas['spec_name'];
					}
				$base->sql_query="SELECT * FROM mis_guide_physician WHERE `id` ='".$id_physican."'";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$doctor_family = $Mas['family'];
					$doctor_name = $Mas['name'];
					$doctor_third_name = $Mas['third_name'];
					}
			if 	($_SESSION['grant']=="false")
            {
			if (($_GET['status']=='active')&&($mas_schedule[$i]['date']>=date("Y-m-d")))	
			{echo "<tr><td  class='TD_b' style='border-left: 1px solid #666'>".$hosp_name."</td><td  class='TD_b'>".$spec_name."</td><td  class='TD_b'>".$doctor_family." ".$doctor_name." ".$doctor_third_name."</td><td  class='TD_b'>".$mas_schedule[$i]['date']."</td><td  class='TD_b'>".$mas_schedule[$i]['timebegin']." - ".$mas_schedule[$i]['timeend']."</td><td  class='TD_b' style='border-top: 1px solid #666'></td></tr>";}
			if (($_GET['status']=='deactive')&&($mas_schedule[$i]['date']<date("Y-m-d")))
			{echo "<tr><td  class='TD_b' style='border-left: 1px solid #666'><FONT color=red>".$hosp_name."</td><td  class='TD_b'><FONT color=red>".$spec_name."</td><td  class='TD_b'><FONT color=red>".$doctor_family." ".$doctor_name." ".$doctor_third_name."</td><td  class='TD_b'><FONT color=red>".$mas_schedule[$i]['date']."</td><td  class='TD_b'><FONT color=red>".$mas_schedule[$i]['timebegin']." - ".$mas_schedule[$i]['timeend']."</td><td  class='TD_b' style='border-top: 1px solid #666'><FONT color=red></td></tr>";}
             
			}
            else
            {
			if (($_GET['status']=='active')&&($mas_schedule[$i]['date']>=date("Y-m-d")))	
			{echo "<tr><td  class='TD_b' style='border-left: 1px solid #666'>".$hosp_name."</td><td  class='TD_b'>".$spec_name."</td><td  class='TD_b'>".$doctor_family." ".$doctor_name." ".$doctor_third_name."</td><td  class='TD_b'>".$mas_schedule[$i]['date']."</td><td  class='TD_b'>".$mas_schedule[$i]['timebegin']." - ".$mas_schedule[$i]['timeend']."</td><td  class='TD_b' style='border-top: 1px solid #666'></td><td  class='TD_b' style='border-top: 1px solid #666'><a style='color:#9900CC;' href='my_patient.php?status=".$_GET['status']."&time=".$mas_schedule[$i]['id']."'>Видалити запис</a></td></tr>";}
			if (($_GET['status']=='deactive')&&($mas_schedule[$i]['date']<date("Y-m-d")))
			{echo "<tr><td  class='TD_b' style='border-left: 1px solid #666'><FONT color=red>".$hosp_name."</td><td  class='TD_b'><FONT color=red>".$spec_name."</td><td  class='TD_b'><FONT color=red>".$doctor_family." ".$doctor_name." ".$doctor_third_name."</td><td  class='TD_b'><FONT color=red>".$mas_schedule[$i]['date']."</td><td  class='TD_b'><FONT color=red>".$mas_schedule[$i]['timebegin']." - ".$mas_schedule[$i]['timeend']."</td><td  class='TD_b' style='border-top: 1px solid #666'><FONT color=red><a style='color:#9900CC;' href='my_patient.php?status=".$_GET['status']."&time=".$mas_schedule[$i]['id']."'>Видалити запис</a></td></tr>";}
            }
		}
		echo "</table>";
	}
echo "</div>";
?>