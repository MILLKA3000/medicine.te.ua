<div id="printe">
<?php
include ("auth.php");
include "header.php";
require_once "Class/mysql-class.php";
require_once "Class/func-date.php";
$base = new class_mysql_base();
if ($_POST['back']=='Вихід')
{
header("Location: auth.php?action=logout");
}
if ($_POST['back']=='Відміна')
{
header("Location: calendar.php?num=".$_GET['num']."&m=".$_GET['m']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."");
}

//------------------------------------------------------------------------------------------------------------------------------------
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".$_GET['id_type']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$i = $Mas['id'];
	}
if($_GET['id_type']==6)
						{
							
$base->sql_query="SELECT mis_hospital.id,mis_hospital.title,mis_hospital.contacts FROM mis_hospital,mis_physican_in_hospital WHERE mis_physican_in_hospital.id='".$_GET['num']."' AND mis_physican_in_hospital.id_hospital=mis_hospital.id;";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$hosp = $Mas['title'];
		$contacts = $Mas['contacts'];
		$id_hosp = $Mas['id'];
	}						
						}else{	
$base->sql_query="SELECT * FROM mis_hospital WHERE `id` ='".$_GET['id_hosp']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$hosp = $Mas['title'];
		$contacts = $Mas['contacts'];
		$id_hosp = $Mas['id'];
	}	
	}
$base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_guide_speciality.metod 
FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
AND mis_physican_in_hospital.id='".$_GET['num']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$name = $Mas['name'];
		$family = $Mas['family'];
		$third_name = $Mas['third_name'];
		$name_spec = $Mas['spec_name'];
		$id_spec = $Mas['id'];
		$metod_spec = $Mas['metod'];
		$affibiation = $Mas['affibiation'];
		$photo=$Mas['photo'];
		
	}	

echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='hospital.php?id_type=".$_GET['id_type']."'>".$s."</a>
 -> <a href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>".$hosp."</a>
 -> <a href='physician.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."&id_spec=".$id_spec."'>".$name_spec."</a>
  -> <a href='calendar.php?num=".$_GET['num']."&m=".$_GET['m']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."' >".$family." ".$name[0].".".$third_name[0].".</a></Font>";
$base->sql_close();
echo "</div>";
//------------------------------------------------------------------------------------------------------------------------------------
include "menu.php";
include "form_new_patient.php";
	if (!$_SESSION['name_sesion'])
	{
$er=0;$err=0;$t1=0;$t2=0;$t3=0;

if ($_POST['tel1']!='')
{	if ($_GET['id_hosp']==3){
	if ( strlen($_POST['tel1'])<6){$t1=1;}
     if((preg_match('/^[0-9]+$/i', $_POST['tel1'])==false))	
	 {
	 $er=1;
	 }
}else{
	if ( strlen($_POST['tel1'])<8){$t1=1;}
     if((preg_match('/^[0-9]+$/i', $_POST['tel1'])==false))	
	 {
	 $er=1;
	 }}
}

if (($_POST['tel2']!='')||($_POST['tel_cut2']!=''))
{
	if ( strlen($_POST['tel2'])<7){$t3=1;}
	if ( strlen($_POST['tel_cut2'])<3){$t2=1;}
	if((preg_match('/^[0-9]+$/i', $_POST['tel2'])==false)||(preg_match('/^[0-9]+$/i', $_POST['tel_cut2'])==false))
	{
	
	$er=1;
	}
}

if (($_POST['tel1'])||($_POST['tel_cut2'])||($_POST['tel2'])||($_POST['family'])||($_POST['name'])||($_POST['first_name'])||($_POST['adress'])) 
{
if (($_POST['tel1']=='')&&($_POST['tel2']=='')&& ($_POST['tel_cut2']==''))
	{
	$er=2;
	}

if (($_POST['family']=='')||($_POST['name']=='')||($_POST['first_name']=='')||($_POST['adress']==''))
{	
	$err=1;
}
}
	if (($er>0)||($err>0)||($t1>0)||($t2>0)||($t3>0))
	{
		echo "<center ><div class='lifted'><p> <FONT size=8>Крок №5: Запис на прийом </FONT><br><br>";		
		if ($er==1){form_er();}
		if ($er==2){form_er2();}
		if ($err==1){form_old();}
		if ($t1==1){echo " <FONT color=red size=4 style='border: 1px solid #666;padding: 5px'>Мала кількість цифр у телефоні 1 </FONT><br><br> ";}
		if ($t2==1){echo " <FONT color=red size=4 style='border: 1px solid #666;padding: 5px'>Мала кількість цифр у коді оператора </FONT><br><br> ";}
		if ($t3==1){echo " <FONT color=red size=4 style='border: 1px solid #666;padding: 5px'>Мала кількість цифр у телефоні 2 </FONT><br><br> ";}
		form();
		form_end();
	}
	else

if ((((!$_POST['tel1'])||((!$_POST['tel_cut2'])&&(!$_POST['tel2'])))&&(!$_POST['family'])&&(!$_POST['name'])&&(!$_POST['first_name'])&&(!$_POST['adress'])&&($er==0)&&($err==0)&&($t1==0)&&($t2==0)&&($t3==0))) 
	{
	if ($metod_spec=='0'){	echo "<center ><div class='lifted'><p> <FONT size=8>Крок №6: Запис на прийом </FONT><br><br>";}
	if ($metod_spec=='1'){	echo "<center ><div class='lifted'><p> <FONT size=8>Крок №6: Запис на обстеження </FONT><br><br>";}
	
	form();
	form_end();
	}
	
else
{
			$time=$base->Get_time($_GET['time']);
			$phone2=$_POST['tel_cut2'].$_POST['tel2'];
			$date_b=$_POST['year']."-".$_POST['mis']."-".$_POST['date'];
	//----------------------------------------перевірка в базі чи є паціент----------------------
	$base->sql_connect();
	$base->sql_query="SELECT * FROM `mis_patient` WHERE (`phone1` ='".$_POST['tel1']."'  AND `phone1` !='' )OR (`phone2` ='".$phone2."' AND `phone2` !=''); ";
    
	$base->sql_execute();
	while($Mas = mysql_fetch_array($base->sql_result))
	{
		$id_patient = $Mas['id'];
		
	}
	//----------------------------------------перевірка чи є паціент----------------------
	
    if ($id_patient==1){$id_patient='';}; 
	if (!$id_patient)
		{
$id_patient=$base->Put_patient(htmlentities($_GET['time'], ENT_QUOTES | ENT_IGNORE, "windows-1251"),htmlentities($_POST['family'], ENT_QUOTES | ENT_IGNORE, "windows-1251"),htmlentities($_POST['name'], ENT_QUOTES | ENT_IGNORE, "windows-1251"),htmlentities($_POST['first_name'], ENT_QUOTES | ENT_IGNORE, "windows-1251"),htmlentities($_POST['adress'], ENT_QUOTES | ENT_IGNORE, "windows-1251"),$_POST['tel1'],$phone2,$date_b,$_POST['email']);
            session_start();
            $_SESSION['name_sesion'] = $id_patient;
           	$_SESSION['family_p'] = $_POST['family'];
        	$_SESSION['name_p'] = $_POST['name'];
        	$_SESSION['first_name_p'] = $_POST['first_name'];
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['date'] = $date_b;
            $_SESSION['adress'] = $_POST['adress'];
			//echo "new- ".$id_patient;
		}
	else 
		{
			$base->upd_scedule($_GET['time'],$id_patient);
			session_start();
			$_SESSION['name_sesion'] = $id_patient;
			 $_SESSION['family_p'] = $_POST['family'];
        	$_SESSION['name_p'] = $_POST['name'];
        	$_SESSION['first_name_p'] = $_POST['first_name'];
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['date'] = $date_b;
            $_SESSION['adress'] = $_POST['adress'];
			//echo "upd- ".$id_patient;
		}
	//----------------------------------------початок сесії---------------------------------------
	
	
	echo "<center ><div class='lifted'><div id='printe'><p> <FONT size=8>Крок №6: Ваші дані введено </FONT><br>";
	if($_GET['id_hosp']==3)
    {
   echo "<FONT size=8 color=red>Візьміть із собою посвідчення особи та талон амбулаторного пацієнта </FONT><br></div>";
	}else{
   echo "<FONT size=8 color=red>Візьміть із собою посвідчення особи та талон амбулаторного пацієнта</FONT><br></div>";}
	echo "<table><tr><td><b>
	<form class='lifted'  action='new_patient.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'  method='post'>
	Шановний ".$_SESSION['family_p']." ".$_SESSION['name_p']." ".$_SESSION['first_name_p'].".";
	if ($metod_spec=='0'){	echo "<br>Ви записані на прийом в лікувальний заклад : ".$hosp.",";}
	if ($metod_spec=='1'){	echo "<br>Ви записані на обстеження в лікувальний заклад : ".$hosp.",";}
	echo" за адресою: ".$contacts."<br>Кабінет: ".$time[0]['room']."
	<br> до лікаря ".$name_spec."  ".$family." ".$name." ".$third_name."<br>
	Дата прийому: ".date_parse_vupuska($time[0]['date'])."
	<br>Час прийому: ".$time[0]['timebegin']." - ".$time[0]['timeend']." <br><br>
<div id='printe'>	
";
if($_GET['id_hosp']==3)
    {	
	
			//echo "<a class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>	<input type='submit' value='Роздрукувати запрошення' onclick='javascript:window.print();'></a><br>";
	/*echo"<a style='border: 4px double green;' class='text' href='talon/print.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'><FONT color=green>	Роздрукувати запрошення</FONT></a><br><br>";*/
     echo"<a style='border: 4px double green;' class='text' href='talon/tml2.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'><FONT color=green>	Роздрукувати талон амбулаторного пацієнта</FONT></a>

	 <a class='text' href='auth.php?action=logout'><input type='submit' name='back' value='Вихід' style='float:right'></div>";

	/*echo "<a class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>	<input type='submit' value='Роздрукувати запрошення' onclick='javascript:window.print();'></a><br>";
     echo"<a class='text' href='talon/tml2.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'>	<input type='submit' value='Роздрукувати талон амбулаторного хворого' ></a><a class='text' href='auth.php?action=logout'><input type='submit' name='back' value='Вихід' style='float:right'></div>";*/
	}else
    {
echo "<a class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>	<input type='submit' value='Роздрукувати' onclick='javascript:window.print();'></a><a class='text' href='auth.php?action=logout'><input type='submit' name='back' value='Вихід' style='float:right'></div>";
}
echo"	</form>
		
	</td></tr></table></div>";
}
	}
	else
	{
			$time=$base->Get_time($_GET['time']);
			$phone2=$_POST['tel_cut2'].$_POST['tel2'];
			$date_b=$_POST['year']."-".$_POST['mis']."-".$_POST['date'];
	$base->upd_scedule($_GET['time'],$_SESSION['name_sesion']);
	echo "<center ><div class='lifted'  ><div id='printe'><p> <FONT size=8>Крок №6: Ваші дані введено </FONT><br>
    <FONT size=8 color=red>Візьміть із собою посвідчення особи та талон амбулаторного пацієнта</FONT><br></div>
	<table><tr><td><b>
	<form class='lifted' action='new_patient.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'  method='post'>
    Шановний ".$_SESSION['family_p']." ".$_SESSION['name_p']." ".$_SESSION['first_name_p'].".";
	
	if ($metod_spec=='0'){	echo "<br>Ви записані на прийом в лікувальний заклад : ".$hosp.",";}
	if ($metod_spec=='1'){	echo "<br>Ви записані на обстеження в лікувальний заклад : ".$hosp.",";}
	
	echo" за адресою: ".$contacts."
	<br> до лікаря ".$name_spec."  ".$family." ".$name." ".$third_name."<br>Кабінет: ".$time[0]['room']."<br>
	Дата прийому: ".date_parse_vupuska($time[0]['date'])."
	<br>Час прийому: ".$time[0]['timebegin']." - ".$time[0]['timeend']." <br><br></div>
<div id='printe'>	
";
if($_GET['id_hosp']==3)
    {
			//	echo "<a class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>	<input type='submit' value='Роздрукувати запрошення' onclick='javascript:window.print();'></a><br>";
	/* echo"<a style='border: 4px double green;' class='text' href='talon/print.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'><FONT color=green>	Роздрукувати запрошення</FONT></a><br><br>";*/
     echo"<a style='border: 4px double green;' class='text' href='talon/tml2.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'><FONT color=green>	Роздрукувати талон амбулаторного пацієнта</FONT></a>
	 

	 <a class='text' href='auth.php?action=logout'><input type='submit' name='back' value='Вихід' style='float:right'></div>";

/*echo "<a class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>	<input type='submit' value='Роздрукувати запрошення' onclick='javascript:window.print();'></a><br>";
     echo"<a class='text' href='talon/tml2.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'>	<input type='submit' value='Роздрукувати талон амбулаторного хворого' ></a><a class='text' href='auth.php?action=logout'><input type='submit' name='back' value='Вихід' style='float:right'></div>";*/

	}
    else
    {
echo "<a class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>	<input type='submit' value='Роздрукувати запрошення' onclick='javascript:window.print();'></a><a class='text' href='auth.php?action=logout'><input type='submit' name='back' value='Вихід' style='float:right'></div>";
}
echo"	</form>
		
	</td></tr></table></div>";
	}
    
echo "</p></div>";		
?>
