<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='new_special.php'>Редагування лікарів</a></Font>";
include "admin_menu.php";
if ($_SESSION['role']>1)
	{
echo " <b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
<center><FONT size=8>Редагування сімейного лікаря </FONT><br><br><table width=100% ><tr><td>";




if (!$_GET['doctor'])
	{
echo "<table width=100% id='old' cellspacing=1><tr>
<td width=30% style='border-bottom: 1px solid #666'><center><FONT size=5 color=blue><b>Прізвище імя по-батькові</td>
<td  width=20% style='border-bottom: 1px solid #666'><FONT size=5 color=blue><b><center>Спеціальність</td>
<td  width=35%  style='border-bottom: 1px solid #666'><FONT size=5 color=blue>  &nbsp</td>
<td  width=15%  style='border-bottom: 1px solid #666'><FONT size=5 color=blue>  &nbsp</td></tr>";


$misjac=date('m');
if ($_SESSION['role']==3)
	{
	   
     
       
	if($_POST['lik'])	
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
		for ($i=0;$i<count($mas_spec);$i++)
		{
		echo "<option value='".$mas_spec[$i]['id_title']."'>".$mas_spec[$i]['title']."</option>";
		}
		echo "<input type='submit' value='Вибрати'> </form><br><br><br>";
	
	}
	else {
		$mas_doctor=$base->Get_doctor($_SESSION['likarnja']);
		}
        
		/*echo "<tr><td class='TD_b' width=30%><Font size=5><a class='text' href='' >".$mas_spec[$i]['name']."</a><br></td><td class='TD_b' width=70% align=right>";*/
			for ($j=0;$j<count($mas_doctor);$j++)
			{
			     $special=$mas_doctor[$j]['id_spec'];
                 
			     if (($mas_doctor[$j]['id_spec']==$special)&&($id_special_povtor!=$mas_doctor[$j]['spec_name']))
                 {
			         //echo "<tr><td colspan=4><center><FONT size=5 color=blue><b>".$mas_doctor[$j]['spec_name']."</td></tr>";
                     $id_special_povtor=$mas_doctor[$j]['spec_name'];
                 }
                 if($mas_doctor[$j+1]['id_spec']!=$special)
                     {
                        $special=$mas_doctor[$j+1]['id_spec'];
                     }
			         
				if(($mas_doctor[$j]['id_spec']==18)||($mas_doctor[$j]['id_spec']==19))
				{
					echo "<tr><td width=30% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['family']." ".$mas_doctor[$j]['name']." ".$mas_doctor[$j]['third_name']." </td>
					<td width=20% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['spec_name']."</td>
					<td width=35% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['affibiation']."</td>
					<td width=15% style='border: 1px solid #666'><Font size=3><a href='simeinuy.php?doctor=".$mas_doctor[$j]['id']."&m=".$misjac."' class='text'><center>Змінити</a></td>
					
					</tr>		
					";
				}
			}
		echo "";
	}
else 
	{
	
$doc=$base->select_doctor_in_hosp("SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,
	mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_physican_in_hospital.id_speciality,mis_physican_in_hospital.id_hospital,mis_physican_in_hospital.id_physician,mis_physican_in_hospital.active 
	FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
	WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
	AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
	AND mis_physican_in_hospital.id='".$_GET['doctor']."'AND mis_physican_in_hospital.id_hospital=".$_SESSION['likarnja']."");

  if ($_POST['put']=='Додати')
{
//	$base->ins("INSERT INTO `mis`.`mis_street` (`id_ph_in_hosp` ,`name_street` ,`name_v` ,`name_d`)VALUES ('".$_GET['doctor']."', '".$_POST['street']."', '".$_POST['name_v']."', '".$_POST['name_d']."');");
$sql = "INSERT INTO `mis`.`mis_street_old` (`id_street` ,`home` ,`id_p_in_h` ,`id_type`) VALUES ('".$_POST['street']."', '".$_POST['name_v']."', '".$_GET['doctor']."', '".$_SESSION['likarnja']."');";
$base->ins($sql);
$street_name_log=$base-> select_street_name("SELECT * FROM `mis`.`mis_street` Where id='".$_POST['street']."'");	
$base->logs("Добавлений участковий ".$doc[0]['family']." ".$doc[0]['name']." ".$doc[0]['third_name']." на вулицю ".$street_name_log[0]['name_street']." буд ".$_POST['name_v']."");
//echo $sql;

}
  if ($_GET['id_street'])
{
	$base->ins("DELETE FROM `mis`.`mis_street_old` WHERE `id` = '".$_GET['id_street']."';");
}
$street=$base->select_street("SELECT * FROM `mis`.`mis_street_old` WHERE id_p_in_h='".(int)$_GET['doctor']."';");	
$street_name=$base-> select_street_name("SELECT * FROM `mis`.`mis_street` Where 1 ORDER BY name_street ASC;");	
  // print_r($street_name);
    
if ($_GET['doctor'])	{

  echo" <center><b><h2>".$doc[0]['family']." ".$doc[0]['name']." ".$doc[0]['third_name']."</h2></center>
			<form action='simeinuy.php?doctor=".$_GET['doctor']."' method='post' enctype='multipart/form-data'>
		<table align=left><tr>
        ";
        
        echo"<td>Вулиця </td><td>
		<select class='text' name='street'>";
		for ($i=0;$i<count($street_name);$i++)
		{
			echo "<option value='".$street_name[$i]['id']."'>".$street_name[$i]['name_street']."</option>";
		}
		echo "</select></tr>

		<tr><td>Будинок</td><td><input name='name_v' maxlength='50' size='41' class='input-text' type='text' ></tr>
		";
		echo "
		<tr><td><input type='submit' name='put' value='Додати'></td></tr></table>
		<br><br><br><br><br>
		";
	
	}}

echo "</table><br><br><table align=center id='zapus' width=100%>";
	for ($i=0;$i<count($street);$i++)
	{
	if ($street[0]['id_street']){
$street_name2=$base-> select_street_name("SELECT * FROM `mis`.`mis_street` Where id='".$street[$i]['id_street']."'");			
	//	echo $street[$i]['id_street'];
//echo $street_name[$street[$i]['id_street']]['name_street'];
	echo "<tr><td>Вулиця - ".$street_name2[0]['name_street']."</td><td>Будинок - ".$street[$i]['home']."</td><td> <a href='simeinuy.php?doctor=".$_GET['doctor']."&id_street=".$street[$i]['id']."'>видалити </a></td></tr>";}
	}	
echo "</table>";	


//-----------------------------------------------якщо незалогінений---------------------------------------
}
	else 
	{
	header("Location: my_admin.php");
	}
echo "</td></tr></table>";



 
?>








