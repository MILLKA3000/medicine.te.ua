<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".$_GET['id_type']."'";
$base->sql_execute();
if ($_GET['id_type']==7){$_GET['id_hosp']='1';} 
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$id = $Mas['id'];
	}
	
$base->sql_query="SELECT * FROM mis_hospital WHERE `id` ='".$_GET['id_hosp']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$hosp = $Mas['title'];
		$id_hosp = $Mas['id'];
	}	
						if($_GET['id_type']==6)
						{
						echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='special.php?id_type=".$_GET['id_type']."'>".$s."</a></Font>";
						
						}
			else 
						{
						echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='hospital.php?id_type=".$id."'>".$s."</a>  -> <a href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>".$hosp."</a></Font>";
						}

$base->sql_close();

include ("menu.php");

echo " <center><div class='lifted'>
		<p><FONT size=8>Крок №2: Виберіть спеціальність лікаря, або метод обстеження </FONT><br><br><table width=100%><tr><td>";
if(($_GET['id_type']!="")){
		if($_GET['id_type']==6)
	{
$mas_spec=$base->Get_spec_tul("SELECT distinct id_speciality, spec_name, metod FROM `mis_physican_in_hospital`, mis_guide_speciality WHERE `tul` = '1' AND `id_speciality`=  mis_guide_speciality.id");
	
	}else{
$mas_spec=$base->Get_spec($_GET['id_hosp']);
}
$e=0;	
for ($i=0;$i<count($mas_spec);$i++)
	{
		if($mas_spec[$i]['metod']=='0')
		{
		$e++;  
        }
    }
  if ($e>0){
echo "<table width=100% cellspacing=3 id='t'><tr>
<td width=25%><FONT size=6 color=blue><center><b>Спеціальності</td>
</tr>";}
else {echo "<h1 align='center'><FONT size=7 color='red'>Пропонуємо адміністрації лікувального закладу долучитися до системи!</FONT></h1>";} // Марценюк
$kilk=0;
	for ($i=0;$i<count($mas_spec);$i++)
	{
		if($mas_spec[$i])
		{
		if($_GET['id_type']==6)
	{
			$mas_doctor=$base->Get_doctor_spec_tul("SELECT distinct mis_physican_in_hospital.id,mis_physican_in_hospital.id_hospital,id_physician,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.name,mis_guide_physician.third_name FROM `mis_physican_in_hospital`, mis_guide_physician 	WHERE `tul` = '1' AND `id_speciality`= '".(int) $id_spec."' AND`id_physician`=  mis_guide_physician.id AND`active`= '0'");
		}
		
		else{$mas_doctor=$base->Get_doctor_spec($_GET['id_hosp'],$mas_spec[$i]['id']);}
		for ($j=0;$j<4;$j++)
		{
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE `id` ='".$mas_spec[$i+$j]['id']."';";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_role[$j] = $Mas['role'];
			$sp_metod[$j] = $Mas['metod'];
			}
		}
        
        if ($kilk==0){echo "<tr>";}
		
		for ($j=0;$j<4;$j++)
		{
		if (($id_role[$j]==1) && ($mas_spec[$i+$j]['id'])&&($sp_metod[$j]==0))
							{
		echo "<td style='border: 1px solid #666' width=25%><Font size=5><center><a class='text' style='display: block; width=100%' href='physician.php?id_spec=".$mas_spec[$i+$j]['id']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."'><br>".$mas_spec[$i+$j]['name']."<br><br></a></font></td>";
        $kilk++;}
        if ($kilk==4){echo "</tr>";$kilk=0;}
							
							
		}
        
		
		$i=$i+3;
		}
	}
echo "</table>";
$e=0;	
for ($i=0;$i<count($mas_spec);$i++)
	{
		if($mas_spec[$i]['metod']==1)
		{
		$e++;  
        }
    }
    
  if ($e>0 && $id<=3){
echo "<table width=100% cellspacing=3 id='t'><tr>
<td width=25% colspan='4'><FONT size=6 color=blue><center><b>Методи обстеження (запис проводить лікар)</td>
</tr>";}
else if ($e>0 && $id>3){
echo "<table width=100% cellspacing=3 id='t'><tr>
<td width=25% colspan='4'><FONT size=6 color=blue><center><b>Методи обстеження</td>
</tr>";}
//print_r($mas_spec);
$kilk==0;
	for ($i=0;$i<count($mas_spec);$i++)
	{
		if($mas_spec[$i])
		{
		
		$mas_doctor=$base->Get_doctor_spec($_GET['id_hosp'],$mas_spec[$i]['id']);
		for ($j=0;$j<4;$j++)
		{
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE `id` ='".$mas_spec[$i+$j]['id']."';";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_role[$j] = $Mas['role'];
			$sp_metod[$j] = $Mas['metod'];
			}
		}
		if ($kilk==0){echo "<tr>";}
		for ($j=0;$j<4;$j++)
		{
		if (($mas_spec[$i+$j]['id']!='')&&($sp_metod[$j]==1)&&($id>3))
							{
		echo "<td style='border: 1px solid #666' width=25%><Font size=5><center><a class='text' style='display: block; width=100%' href='physician.php?id_spec=".$mas_spec[$i+$j]['id']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."'><br>".$mas_spec[$i+$j]['name']."<br><br></a></font></td>";
							$kilk++;}
                            else 
                            {
                              if (($mas_spec[$i+$j]['id'])&&($sp_metod[$j]==1))
                              {
                                echo "<td style='border: 1px solid #666' width=25%><Font size=5><center><br>".$mas_spec[$i+$j]['name']."<br><br></font></td>";
                              $kilk++;}  
				
                            }
		if ($kilk==4){echo "</tr>";$kilk=0;}				
		}
		
		$i=$i+3;
		}
	}
echo "</table>";	

}
echo "</td></tr></table>"
?>








