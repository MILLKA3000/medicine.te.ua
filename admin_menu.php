<center>
<div class='lifted'><p>

<table width=95%>
	<tr>
		

<? 

echo "		<Td width=25% valign='top'>
			<b><center><FONT size=4 color=blue>Меню</FONT></center>";
			
if ($_SESSION['role']==1){		


	$kil=0;
	$mas = array(array());
	$base->sql_connect();
	$sql="SELECT distinct id_speciality, spec_name,mis_physican_in_hospital.id FROM `mis_physican_in_hospital`, mis_guide_speciality WHERE `id_physician` = '".$_SESSION['name_sesion_a']."' AND `id_hospital` = '".$_SESSION['likarnja']."' AND `id_speciality`=  mis_guide_speciality.id";
	$base->sql_query=$sql;
	$base->sql_execute();
		while($Masuv = mysql_fetch_array($base->sql_result))
	{
	$mas[$kil]['id_spec'] = $Masuv['id_speciality'];
	$mas[$kil]['name'] = $Masuv['spec_name'];
	$mas[$kil]['id'] = $Masuv['id'];
	$kil++;
	}
echo "<a class='menu' href='my_profile.php?doctor=".$mas[0]['id']."'>Мій профіль</a><br>
<a class='menu' href='mark_patient.php'>Мої пацієнти</a><br>
<a class='menu' href='zapus.php'>Записати пацієнта на обстеження</a><br><br><br>
<FONT size=4 color=blue><center>Мої графіки</center></FONT>";
for ($i=0;$i<count($mas);$i++)
		{
		
		echo "<a class='menu' href='one_calendar.php?doctor=".$mas[$i]['id']."&m=".date('m')."'> ".$mas[$i]['name']."</a><br>";
		}

	

			}
if ($_SESSION['role']==2){
//----------------------------меню адміна лікарні -------------------------------
//echo"	 Завести нового пацієнта </a><br>";
echo"	<a class='menu' href='Get_exel.php'> Завантаження графіків </a><br>";
echo"	<a class='menu' href='reg_graf.php'> Редагування графіка </a><br>";
echo"	<a class='menu' href='new_doctor.php'> Редагування лікарів </a><br>";
echo"	<a class='menu' href='new_physician.php'> Створити нового користувача</a><br>";
echo"	<a class='menu' href='full_zapus.php'> Перегляд всіх записаних пацієнтів</a><br>";
echo"	<a class='menu' href='simeinuy.php'> Сімейний лікар </a><br>";
echo"<br><br><br><br><br><b><center><FONT size=4 color=blue>Ір входу</FONT></center></b><br> Локальна : ";
print_r($_SERVER['REMOTE_ADDR']);
echo"<br>Зовнішня : ";
print_r($_SERVER['SERVER_ADDR']);

}
//----------------------------меню повного адміна-------------------------------
if ($_SESSION['role']==3){
//echo"	 Редагування лікарень </a><br>";
echo"	<a class='menu' href='new_special.php'> Редагування спеціальностей </a><br>";
echo"	<a class='menu' href='new_doctor.php'> Редагування лікарів </a><br>";
echo"	<a class='menu' href='new_physician.php'> Створити нового користувача</a><br>";
echo"	<a class='menu' href='new_street.php'> Редагування вулиць</a><br>";
echo"	<a class='menu' href='log.php'> Переглянути логи</a><br>";
echo"	<a class='menu' href='user_upload.php'> Завантажити список користувачів</a><br>";
echo"	<a class='menu' href='new_login.php'>Змінити логін користувача</a><br>";
echo"	<a class='menu' href='zwit.php'>Недоліки по лікарях</a><br>";
echo"	<a class='menu' href='stat.php'>Збір статистики</a><br>";    
echo"<br><br><br><br><br><b><center><FONT size=4 color=blue>Ір входу</FONT></center></b><br> Локальна : ";
print_r($_SERVER['REMOTE_ADDR']);
echo"<br>Зовнішня : ";
print_r($_SERVER['SERVER_ADDR']);
echo"<br> Передані дані:<br>";
print_r($_SERVER['argv']);
//echo"	<a class='menu' href='reg_graf.php'> Редагування графіка </a><br>";
//echo"	 Перевірка записів паціентів</a><br>";

}		
if ($_SESSION['role']==4){
//----------------------------меню Реєстратури-------------------------------
echo"	<a class='menu' href='full_zapus.php'> Перегляд всіх записаних пацієнтів</a><br>";
echo"	<a class='menu' href='simeinuy.php'> Сімейний лікар </a><br>";
}			
if ($_SESSION['role']==5){
//----------------------------меню Реєстратури-------------------------------
echo"	<a class='menu' href='zwit.php'> Звіт лікарів</a><br>";
echo"	<a class='menu' href='stat.php'>Збір статистики</a><br>";  

}					
		echo "
		
		</td>
<td width=80% valign='top'>";

?>	
