<style type="text/css">
       input[type=submit][value='Вибрати'] { font-weight:bold;  font-size: 14pt; } 
       input[type=text]{font-weight:bold;  font-size: 14pt;}
       select{font-weight:bold; height:30px; font-size: 16pt;}
       option{font-size: 16pt;}
</style>
<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");

$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".(int) $_GET['id_type']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$i = $Mas['id'];
	}
	
$base->sql_query="SELECT * FROM mis_hospital WHERE `id` ='".(int) $_GET['id_hosp']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$hosp = $Mas['title'];
		$id_hosp = $Mas['id'];
	}	
	
$base->sql_query="SELECT mis_guide_speciality.spec_name,mis_guide_speciality.id 
FROM mis_guide_speciality 
WHERE  mis_guide_speciality.id ='".(int) $_GET['id_spec']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$name_spec = $Mas['spec_name'];
		$id_spec = $Mas['id'];
	}	
if($_GET['id_type']==6)
						{
						echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> ->  <a href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."'>".$s."</a>
 -> <a href='physician.php?id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."'>".$name_spec."</a></Font>";
						
						}
			else
						{
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='hospital.php?id_type=".$i."'>".$s."</a>  -> <a href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."'>".$hosp."</a>
 -> <a href='physician.php?id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."'>".$name_spec."</a></Font>";
						}



$base->sql_close();
if(($_GET['id_type']!="")&&($_GET['id_spec']!="")){
include ("menu.php");

echo " <center><div class='lifted'>
		<p><FONT size=8>Крок №3: Виберіть лікаря</FONT><br><br><table width=100% ><tr><td>";
if (($_GET['id_spec']==18)||($_GET['id_spec']==19) && ($_GET['id_hosp']!=""))
{

//$street=$base->select_street("SELECT DISTINCT mis_street.name_street,mis_street.id FROM `mis_street`,`mis_physican_in_hospital` WHERE mis_street.id_ph_in_hosp=mis_physican_in_hospital.id;");	
//$street_name=$base-> select_street_name("SELECT * FROM `mis`.`mis_street` Where 1 ORDER BY name_street ASC;");    
$street_name=$base-> select_street_name("SELECT DISTINCT mis_street.id,mis_street.name_street FROM mis_street, mis_street_old Where mis_street_old.id_street = mis_street .id AND mis_street_old.id_type='".$_GET['id_hosp']."' ORDER BY name_street ASC;");    

echo "<form id='form' action='physician.php?id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."' method='post' enctype='multipart/form-data'>
<center><h2><b>Виберіть вулицю <select class='text' name='street' style='width:200px' id='street'>	</center>
<option value='0'>Всі лікарі</option>";
		for ($i=0;$i<count($street_name);$i++)
		{
			if (($_POST['street']==$street_name[$i]['id'])&&($_POST['street']!=0))
				{echo "<option value='".$street_name[$i]['id']."' SELECTED>".$street_name[$i]['name_street']."</option>";}
			else{
		echo "<option value='".$street_name[$i]['id']."'>".$street_name[$i]['name_street']."</option>";}
		}
		echo " </select><input type='submit' name='put' value='Вибрати' id='home'></h2></b>";
if ($_POST['street']>0)
	{
	$street=$base->select_street("SELECT * FROM `mis`.`mis_street_old` WHERE id_street='".$_POST['street']."' ORDER BY home ASC;");	
	echo "<center><h2><b>Виберіть будинок <select class='text' name='home' style='width:200px'>	</center>";
		for ($i=0;$i<count($street);$i++)
		{
			if (($_POST['home']==$street[$i]['id'])&&($_POST['home']!=0)){
			echo "<option value='".$street[$i]['id']."' SELECTED>".$street[$i]['home']."</option>";
			}
			else
			{echo "<option value='".$street[$i]['id']."'>".$street[$i]['home']."</option>";}
		}
		echo " </select><input type='submit' name='put2' value='Вибрати'></h2></b></form>";
	}




echo "<br><table width=100% id='old'><tr><td style='border-bottom: 1px solid #666' width=30%><center><FONT size=5 color=blue><b>Прізвище імя по-батькові</td>
<td style='border-bottom: 1px solid #666' width=70%><FONT size=5 color=blue>  &nbsp</td></tr>";

		if($_GET['id_spec']!="")
		{
		if ((($_POST['put'])||($_POST['put2']))&&($_POST['street']!='0'))
			{
				if(($_POST['put2'])){
			$mas_doctor=$base->Get_doctor_spec_full("
			SELECT distinct mis_physican_in_hospital.id,id_physician,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.name,mis_guide_physician.third_name
			FROM `mis_physican_in_hospital`, mis_guide_physician,mis_street_old WHERE mis_street_old.id = '".$_POST['home']."' AND mis_street_old.id_street='".$_POST['street']."' AND mis_street_old.id_p_in_h=mis_physican_in_hospital.id AND `id_physician`=  mis_guide_physician.id AND`active`= '0'");
												 }
				 else
				{
		    $mas_doctor=$base->Get_doctor_spec_full("
			SELECT distinct mis_physican_in_hospital.id,id_physician,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.name,mis_guide_physician.third_name
			FROM `mis_physican_in_hospital`, mis_guide_physician,mis_street_old WHERE mis_street_old.id_street='".$_POST['street']."' AND mis_street_old.id_p_in_h=mis_physican_in_hospital.id AND `id_physician`=  mis_guide_physician.id AND`active`= '0'");

				}
			}else{
			
						if($_GET['id_type']==6)
						{
						 $mas_doctor=$base->Get_doctor_spec_full("
						SELECT distinct mis_physican_in_hospital.id,id_physician,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.name,mis_guide_physician.third_name
						FROM `mis_physican_in_hospital`, mis_guide_physician,mis_street_old WHERE tul ='1' AND `id_speciality`='".$_GET['id_spec']."' AND `id_physician`=  mis_guide_physician.id AND`active`= '0'");
						
						}
			else
						{
						$mas_doctor=$base->Get_doctor_spec($_GET['id_hosp'],$_GET['id_spec']);
						}}
		
		/*echo "<tr><td class='TD_b' width=30%><Font size=5><a class='text' href='' >".$mas_spec[$i]['name']."</a><br></td><td class='TD_b' width=70% align=right>";*/
			for ($j=0;$j<100;$j++)
			{
				if($mas_doctor[$j])
				{
					echo "<tr><td class='TD_b' width=40%><Font size=5><a class='text' style='display: block; width=100%' href='calendar.php?num=".$mas_doctor[$j]['id']."&m=".date('m')."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."' >".$mas_doctor[$j]['family']." ".$mas_doctor[$j]['name']." ".$mas_doctor[$j]['third_name']." </a></td>
					<td class='TD_b' width=60%><Font size=5><a class='text' style='display: block; width=100%' href='calendar.php?num=".$mas_doctor[$j]['id']."&m=".date('m')."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."' >".$mas_doctor[$j]['affibiation']." </a></td></tr>		
					";
				}
			}
		echo "";
		}

echo "</table>";	
	
}else{
echo "<table width=100% id='old'><tr><td style='border-bottom: 1px solid #666' width=30%><center><FONT size=5 color=blue><b>Прізвище імя по-батькові</td>
<td style='border-bottom: 1px solid #666' width=70%><FONT size=5 color=blue>  &nbsp</td></tr>";

		if($_GET['id_spec']!="")
		{
								if($_GET['id_type']==6)
						{
						 $mas_doctor=$base->Get_doctor_spec_full("
						SELECT distinct mis_physican_in_hospital.id,id_physician,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.name,mis_guide_physician.third_name
						FROM `mis_physican_in_hospital`, mis_guide_physician,mis_street_old WHERE `tul` ='1' AND `id_speciality`='".$_GET['id_spec']."' AND `id_physician`=  mis_guide_physician.id AND`active`= '0'");
						
						}
			else
						{
						$mas_doctor=$base->Get_doctor_spec($_GET['id_hosp'],$_GET['id_spec']);
						}
		/*echo "<tr><td class='TD_b' width=30%><Font size=5><a class='text' href='' >".$mas_spec[$i]['name']."</a><br></td><td class='TD_b' width=70% align=right>";*/
			for ($j=0;$j<100;$j++)
			{
				if($mas_doctor[$j])
				{
					echo "<tr><td class='TD_b' width=40%><Font size=5><a class='text' style='display: block; width=100%' href='calendar.php?num=".$mas_doctor[$j]['id']."&m=".date('m')."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."' >".$mas_doctor[$j]['family']." ".$mas_doctor[$j]['name']." ".$mas_doctor[$j]['third_name']." </a></td>
					<td class='TD_b' width=60%><Font size=5><a class='text' style='display: block; width=100%' href='calendar.php?num=".$mas_doctor[$j]['id']."&m=".date('m')."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."' >".$mas_doctor[$j]['affibiation']." </a></td></tr>		
					";
				}
			}
		echo "";
		}

echo "</table>";	}
	

}
echo "</td></tr></table>"
?>








