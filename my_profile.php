<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();

include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='my_profile.php?doctor=".$_GET['doctor']."'>Мій профіль</a></Font>";
include ("menu.php");


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
	$base->sql_connect();
	$base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,
	mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_physican_in_hospital.id_speciality,mis_physican_in_hospital.id_hospital,mis_physican_in_hospital.id_physician 
	FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
	WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
	AND mis_physican_in_hospital.id='".$_GET['doctor']."'";
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
	}
	if ($photo){
  echo "<img width=150px height=150px style='float:left;margin-right:26px;margin-left:26px;' src='script_img/image_doctor.php?num=".$_GET['doctor']."'>";
  }else echo "<img width=150px height=150px style='float:left;margin-right:26px;margin-left:26px;' src='images/spec/nophoto.png'>";
  
	echo "<form action='new_doctor.php?doctor=".$_GET['doctor']."' method='post' enctype='multipart/form-data'>
		<table align=left><tr>
		<tr><td><input name='family' maxlength='50' size='41' class='input-text' type='text' value='".$family."'></tr>
		<tr><td><input name='name' maxlength='50' size='41' class='input-text' type='text' value='".$name."'></tr>
		<tr><td><input name='third_name' maxlength='50' size='41' class='input-text' type='text' value='".$third_name."'></tr>

	
		
		</tr>
		<tr><td><input name='affibiation' maxlength='80' size='60' class='input-text' type='text' value='".$affibiation."'></tr>
		</table>";
	
	
	}	
echo "";
?>