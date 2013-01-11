<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
echo "
<link rel='stylesheet' href='datepicker/datepicker.css' type='text/css' /> 
<script type='text/javascript' src='datepicker/jquery.js'></script>
<script type='text/javascript' src='datepicker/date_new.js'></script>
<script type='text/javascript' src='datepicker/jquery.datePicker-2.1.2_new.js'></script>
 
<script type='text/javascript'>
$(function()
{
$('#inputDate4').datePicker({
createButton:false,
clickInput:true,
endDate: (new Date()).addDays(365).asString()
});
$('#inputDate3').datePicker({
createButton:false,
clickInput:true,
endDate: (new Date()).addDays(365).asString()
});
});
</script>";
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='new_special.php'>Редагування лікарів</a></Font>";
include "admin_menu.php";
if ($_SESSION['role']>1)
	{
echo " <b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
<center><FONT size=8>Редагування лікаря </FONT><br><br><table width=100% ><tr><td>";




if (!$_GET['doctor'])
	{
echo "<table width=100% id='old' cellspacing=1><tr>
<td width=3% style='border-bottom: 1px solid #666'><center><FONT size=5 color=blue><b>Фото</td>
<td width=30% style='border-bottom: 1px solid #666'><center><FONT size=5 color=blue><b>Прізвище імя по-батькові</td>
<td  width=20% style='border-bottom: 1px solid #666'><FONT size=5 color=blue><b><center>Спеціальність</td>
<td  width=35%  style='border-bottom: 1px solid #666'><FONT size=5 color=blue>  &nbsp</td>
<td  width=15%  style='border-bottom: 1px solid #666'><FONT size=5 color=blue>  &nbsp</td></tr>";


$misjac=date('m');
if ($_SESSION['role']==3)
	{
	   
			if ($_POST['lik']=='0')
			{
$sql="SELECT zv.id, doctor.family, doctor.name,doctor.photo, doctor.third_name,doctor.affibiation,zv.id_speciality,special.spec_name,zv.id_physician
FROM  mis_guide_physician AS doctor, mis_guide_speciality AS special, mis_physican_in_hospital AS zv WHERE zv.id_physician = doctor.id AND zv.id_speciality = special.id 
AND special.role = '1' AND zv.tul='1' ORDER BY zv.id_speciality,doctor.family ASC";
$mas_doctor=$base->get_doctor_select($sql);
			}
			else if ($_POST['lik']>0)	
				{
					$mas_doctor=$base->Get_doctor($_POST['lik']);
				}
		
		
	echo "<form action='new_doctor.php' method='post'>";
	$i=0;
		$mas_spec = array(array());
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_hospital` WHERE 1;";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$mas_spec[$i]['id_title'] = $Mas['id'];
			$mas_spec[$i]['title'] = $Mas['title'];
			$i++;
			}
		echo "<center><b>Виберіль лікувальний заклад <select class='text' name='lik'>	";
		echo "<option value='0'>Тернопільський державний медичний університет(ТДМУ)</option>";
		for ($i=0;$i<count($mas_spec);$i++)
		{
			if ($mas_spec[$i]['id_title']==$_POST['lik']){echo "<option value='".$mas_spec[$i]['id_title']."' selected=selected>".$mas_spec[$i]['title']."</option>";}else{
		echo "<option value='".$mas_spec[$i]['id_title']."'>".$mas_spec[$i]['title']."</option>";}
		}
		echo "<input type='submit' value='Вибрати'> </form><br><br><br>";
	
	}
	else {
	if ($_POST['lik']=='0')
			{

	$mas_doctor=$base->get_doctor_select($sql);
			}
			else 
				{
					$mas_doctor=$base->Get_doctor($_SESSION['likarnja']);
				}
		}
        
		/*echo "<tr><td class='TD_b' width=30%><Font size=5><a class='text' href='' >".$mas_spec[$i]['name']."</a><br></td><td class='TD_b' width=70% align=right>";*/
			for ($j=0;$j<count($mas_doctor);$j++)
			{
			     $special=$mas_doctor[$j]['id_spec'];
                 
			     if (($mas_doctor[$j]['id_spec']==$special)&&($id_special_povtor!=$mas_doctor[$j]['spec_name']))
                 {
			         echo "<tr><td colspan=4><center><FONT size=5 color=blue><b>".$mas_doctor[$j]['spec_name']."</td></tr>";
                     $id_special_povtor=$mas_doctor[$j]['spec_name'];
                 }
                 if($mas_doctor[$j+1]['id_spec']!=$special)
                     {
                        $special=$mas_doctor[$j+1]['id_spec'];
                     }
			         
				if($mas_doctor[$j])
				{
				if ($mas_doctor[$j]['photo']){
				echo "<tr><td width=3% style='border: 1px solid #666'><img width=25px  style='float:left;margin-right:26px;margin-left:26px;' src='script_img/image_doctor.php?num=".$mas_doctor[$j]['id']."'></td>";
				}else echo "<td width=3% style='border: 1px solid #666'><img width=25px  style='float:left;margin-right:26px;margin-left:26px;' src='images/spec/nophoto.png'></td>";
				
					echo "<td width=30% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['family']." ".$mas_doctor[$j]['name']." ".$mas_doctor[$j]['third_name']." </td>
					<td width=20% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['spec_name']."</td>
					<td width=35% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['affibiation']."</td>
					<td width=15% style='border: 1px solid #666'><Font size=3><a href='new_doctor.php?doctor=".$mas_doctor[$j]['id']."&m=".$misjac."' class='text'><center>Змінити</a></td>
					
					</tr>		
					";
				}
			}
		echo "";
	}
else 
	{
	
	$base->sql_connect();
    if ($_SESSION['role']==3)
	   {
	   $base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_physican_in_hospital.date_otpusk,mis_physican_in_hospital.start_date_otpusk,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,
    	mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_physican_in_hospital.id_speciality,mis_physican_in_hospital.otpusk,mis_physican_in_hospital.tul,mis_physican_in_hospital.id_hospital,mis_physican_in_hospital.id_physician,mis_physican_in_hospital.active 
    	FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
    	WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
    	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
    	AND mis_physican_in_hospital.id='".$_GET['doctor']."'";
       }
       else 
	$base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_physican_in_hospital.date_otpusk,mis_physican_in_hospital.start_date_otpusk,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,
	mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_physican_in_hospital.id_speciality,mis_physican_in_hospital.otpusk,mis_physican_in_hospital.tul,mis_physican_in_hospital.id_hospital,mis_physican_in_hospital.id_physician,mis_physican_in_hospital.active 
	FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
	WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
	AND mis_physican_in_hospital.id='".$_GET['doctor']."' AND mis_physican_in_hospital.id_hospital=".$_SESSION['likarnja']."";
	$base->sql_execute();
	while($Mas = mysql_fetch_array($base->sql_result))
	{	
		$id_doctor = $Mas['id_physician'];
		$name = $Mas['name'];
		$family = $Mas['family'];
		$third_name = $Mas['third_name'];
		$name_spec = $Mas['spec_name'];
		$id_spec = $Mas['id'];
		$affibiation = $Mas['affibiation'];
		$id_spec = $Mas['id_speciality'];
		$id_hosp = $Mas['id_hospital'];
		$photo=$Mas['photo'];
        $active=$Mas['active'];
		$tul=$Mas['tul'];
		$otpusk=$Mas['otpusk'];
		$date_otpusk=$Mas['date_otpusk'];
		$start_date_otpusk=$Mas['start_date_otpusk'];
	}
  if ($_POST['put']=='Змінити')
{$base->logs("Змінений користувач".$_POST['family']." ".$_POST['name']." ".$_POST['third_name']."");
	$base->sql_connect();
	$sql="UPDATE `mis`.`mis_guide_physician` SET 
	`family` = '".$_POST['family']."',
	`name` = '".$_POST['name']."',
	`third_name` = '".$_POST['third_name']."',
	`affibiation` = '".$_POST['affibiation']."'	
	WHERE `mis_guide_physician`.`id` =".$id_doctor.";";
	$base->sql_query=$sql;
	$base->sql_execute();
	
	if($_POST['tul']=="on"){
	$tul_cheked="1";}else{$tul_cheked="0";}
	if($_POST['otpusk']=="on"){$otpusk_cheked=1;}else{$otpusk_cheked=0;}
	if ($otpusk_cheked==1)
	{
	$sql="UPDATE `mis`.`mis_physican_in_hospital` SET `id_speciality` = '".$_POST['spec']."',`active` = '".$_POST['active']."' ,`tul` = '".$tul_cheked."',`otpusk` = '".$otpusk_cheked."',`date_otpusk` = '".$_POST['date']."',`start_date_otpusk` = '".$_POST['start_date']."' 	WHERE `mis_physican_in_hospital`.`id` =".$_GET['doctor'].";";	
	}
	else if ($otpusk_cheked==0)
	{
	$sql="UPDATE `mis`.`mis_physican_in_hospital` SET `id_speciality` = '".$_POST['spec']."',`active` = '".$_POST['active']."' ,`tul` = '".$tul_cheked."',`otpusk` = '".$otpusk_cheked."' 	WHERE `mis_physican_in_hospital`.`id` =".$_GET['doctor'].";";
	}
	$base->sql_query=$sql;
	$base->sql_execute();	

        if ($_SESSION['role']==3)
	   {
	   $base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,
    	mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_physican_in_hospital.id_speciality,mis_physican_in_hospital.date_otpusk,mis_physican_in_hospital.start_date_otpusk,mis_physican_in_hospital.id_hospital,mis_physican_in_hospital.tul,mis_physican_in_hospital.otpusk,mis_physican_in_hospital.id_physician,mis_physican_in_hospital.active 
    	FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
    	WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
    	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
    	AND mis_physican_in_hospital.id='".$_GET['doctor']."'";
       }
       else
	$base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,
	mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_physican_in_hospital.id_speciality,mis_physican_in_hospital.date_otpusk,mis_physican_in_hospital.start_date_otpusk,mis_physican_in_hospital.id_hospital,mis_physican_in_hospital.otpusk,mis_physican_in_hospital.tul,mis_physican_in_hospital.id_physician,mis_physican_in_hospital.active 
	FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
	WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
	AND mis_physican_in_hospital.id='".$_GET['doctor']."'AND mis_physican_in_hospital.id_hospital=".$_SESSION['likarnja']."";
	$base->sql_execute();
	while($Mas = mysql_fetch_array($base->sql_result))
	{	
		$id_doctor = $Mas['id_physician'];
		$name = $Mas['name'];
		$family = $Mas['family'];
		$third_name = $Mas['third_name'];
		$name_spec = $Mas['spec_name'];
		$id_spec = $Mas['id'];
		$affibiation = $Mas['affibiation'];
		$id_spec = $Mas['id_speciality'];
		$id_hosp = $Mas['id_hospital'];
		$photo=$Mas['photo'];
        $active=$Mas['active'];
		$tul=$Mas['tul'];
		$otpusk=$Mas['otpusk'];
		$date_otpusk=$Mas['date_otpusk'];
		$start_date_otpusk=$Mas['start_date_otpusk'];
	}
    	
}

    
    
if ($id_doctor)	{
	if ($photo){
  echo "<img width=150px  style='float:left;margin-right:26px;margin-left:26px;' src='script_img/image_doctor.php?num=".$_GET['doctor']."'>";
  }else echo "<img width=150px  style='float:left;margin-right:26px;margin-left:26px;' src='images/spec/nophoto.png'>";
  echo "<div class='auth-form-min' style='margin-left:186px;'>Завантажити фото <br><form method='post' action='new_doctor.php?doctor=".$_GET['doctor']."&m=".$_GET['m']."' enctype='multipart/form-data' >
  
  <input type='file' name='form_data' size='40' >
  
  <input type='submit' name='file' value='Завантажити фото' >
  </form></div>
  ";

  echo"
			<form action='new_doctor.php?doctor=".$_GET['doctor']."&m=".$_GET['m']."' method='post' enctype='multipart/form-data'>
		<table align=left cellspacing=0><tr><td>
        Видимість лікаря </td><td><select class='text' name='active'>";
        
        if ($active=='0')
		{
		echo "<option value='0' selected>Aктивний</option>";}
		else {
		echo "<option value='0'>Aктивний</option>";}
        
        	if ($active=='1')
		{
		echo "<option value='1' selected>Деактивний</option>";}
		else {
		echo "<option value='1'>Деактивний</option>";}
		
        
        echo"</select></td></tr>
		<tr><td>Прізвище </td><td><input name='family' maxlength='50' size='41' class='input-text' type='text' value='".$family."'></tr>
		<tr><td>Ім'я</td><td><input name='name' maxlength='50' size='41' class='input-text' type='text' value='".$name."'></tr>
		<tr><td>По батькові</td><td><input name='third_name' maxlength='50' size='41' class='input-text' type='text' value='".$third_name."'></tr>
		<tr><td>
		Спеціальність </td><td><select class='text' name='spec'>";
		//$mas_spec=$base->Get_spec($id_hosp);
		$mas_spec=$base->Get_spec_tul("SELECT * FROM  mis_guide_speciality WHERE  spec_code!='111' ;");
		
		for ($i=0;$i<count($mas_spec);$i++)
		{
		if ($mas_spec[$i]['id_spec']==$id_spec)
		{
		echo "<option value='".$mas_spec[$i]['id_spec']."' selected>".$mas_spec[$i]['name']."</option>";
		}else
		echo "<option value='".$mas_spec[$i]['id_spec']."'>".$mas_spec[$i]['name']."</option>";
		}

  echo"		
		</td>
		</tr>
		<tr><td>Опис лікаря </td><td><input name='affibiation' maxlength='80' size='60' class='input-text' type='text' value='".$affibiation."'></tr>
			<tr><td bgcolor='yellow'><center>
			";
		
		if ($otpusk==0){echo "<input name='otpusk' type='checkbox' >";}else{	echo "<input name='otpusk' type='checkbox' checked='checked'>";}	
		echo"</td><td bgcolor='yellow' >Відмітити якщо лікар в отпуску від <input  id='inputDate3' name='start_date' value='".$start_date_otpusk."' /> до <input  id='inputDate4' name='date' value='".$date_otpusk."' /></td></tr>";

	//-------------------------------------------------Університетська лікарня---------------------------------------------------------------
				if ($_SESSION['role']==3)
	   {	
				echo "<tr><td height='20'></td></tr><tr><td bgcolor='yellow'><center>";
				if ($tul==0){echo "<input name='tul' type='checkbox' >";}else{	echo "<input name='tul' type='checkbox' checked='checked'>";}
				echo"</td><td bgcolor='yellow' >Відмітити для Тернопільської університетської лікарні</td></tr>";
	   }		else 
	   {
				echo "<tr><td height='20'></td></tr><tr><td bgcolor='yellow'><center>";
				if ($tul==0){echo "<input name='tul' type='checkbox' DISABLED>";}else{	echo "<input name='tul' type='checkbox' checked='checked'>";}
				echo"</td><td bgcolor='yellow' >Відмітити для Тернопільської університетської лікарні (<font color='red'>права глобального адміністратора</font>)</td></tr>";
	   
	   }
   //-------------------------------------------------Університетська лікарня---------------------------------------------------------------

		echo"<tr><td></td><td><input type='submit' name='put' value='Змінити'><br><br></form></td></tr>
		
		<tr><td colspan='2' ><center><div class='auth-form-min' style='margin-left:0px;width:450px;'>
				
				<center><FONT color='blue'><b>Отримати шаблон для заповнення графіка</b></FONT></center>";
				$_SESSION['likarnja']=$id_hosp;
		
		$num_mis = array('Січень','Лютий','Березень','Квітень','Травень','Червень','Липень','Серпень','Вересень','Жовтень','Листопад','Грудень');
		$date_m = date("m");
		
		echo "<form action='1.php' method='post' enctype='multipart/form-data'>
		
		<select class='text' name='year'>";
		for ($mis=2012;$mis<2026;$mis++)
		{
		if ($mis==$year) {echo "<option value='".($mis)."' SELECTED>".$mis."</option>";}
        else {
		echo "<option value='".($mis)."'>".$mis."</option>";}
		}
		echo "</select>";
		
		echo"<select class='text' name='mis'>";
		for ($mis=0;$mis<12;$mis++)
		{
		if ($mis+1==$date_m) {echo "<option value='".($mis+1)."' SELECTED>".$num_mis[$mis]."</option>";}
        else {
		echo "<option value='".($mis+1)."'>".$num_mis[$mis]."</option>";}
		}
		echo "</select>	<select class='text' name='likarnya'>";
		echo "<option value='".$_GET['doctor']."'>".$family." ".$name." ".$third_name."</option>";
		echo "</select>";
		echo "<input type='submit' name='puti' value='Отримати'>
		</form></div></td><tr><td colspan='2' ><center>
	<div class='auth-form-min' style='margin-left:0px;width:450px;'>  
	<center><FONT color='blue'><b>Завантаження таблиці роботи лікаря</b></FONT></center>
	  <form action='Get_exel.php?active=true' method='post' enctype='multipart/form-data'>
      <input type='file' name='filename'  value='Огляд'>
      <input type='submit'  name='zav' value='Завантажити'>
	</form></div></td></tr><tr><td colspan='2'>
		<br><br>
		";
	include "reg_calendar.php";
	}}

echo "</table>";	
	
	//-------------------------------------------------------------------Foto----------------------------------
	if ($file)
 {
   // echo $form_data;
   // echo $id_doctor;
   if (filesize($form_data)<=64000){
    $data = fread(fopen($form_data,  "rb"), filesize($form_data)); 
    $data = mysql_escape_string ($data);

	$sql="UPDATE `mis`.`mis_guide_physician` SET 	`photo` = '".$data."'	WHERE `mis_guide_physician`.`id` ='".$id_doctor."';";
	
	$base->ins($sql);
	}	else echo "<script type='text/javascript'> alert('Завеликий розмір фото!!!'); </script>";
	
    
 }  
 //--------------------------------------------------------------------END foto--------------------------------------


//-----------------------------------------------якщо незалогінений---------------------------------------
}
	else 
	{
	header("Location: my_admin.php");
	}
echo "</td></tr></table>";



 
?>








