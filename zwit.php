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
});
</script>";
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='zwit.php'>Звіт лікарів</a></Font>";
include "admin_menu.php";
if ($_SESSION['role']==5)
	{
echo " <b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
<center><FONT size=8>Звіт лікарів </FONT><br><br><table width=100% ><tr><td>";
if($_POST['ok'])
{
	
	$base->ins("INSERT INTO `mis_zwit` (`date`,`id_ph_in_hosp`,`zwites`) VALUES ('".$_POST['date']."' ,'".$_POST['doc']."' ,'".$_POST['description']."' )");
}	
if($_POST['ok_upd'])
{
$base->ins("UPDATE  `mis_zwit` SET `id_ph_in_hosp`='".$_POST['doc']."',`zwites`='".$_POST['description']."'  WHERE id_zvit='".$_POST['id']."';");
//	$base->ins("INSERT INTO `mis_zwit` (`date`,`id_ph_in_hosp`,`zwites`) VALUES ('".$_POST['date']."' ,'".$_POST['doc']."' ,'".$_POST['description']."' )");
}	
if ($_GET['type']=='del')
		{
			$base->ins("DELETE FROM `mis_zwit` WHERE id_zvit='".$_GET['id']."' ;");
		}
if ($_GET['type']=='upd')
		{
			include ("shablon/zwit_edit.php");
		}
else
if ($_GET['new']=='active')
		{
			include ("shablon/zwit.php");
		}
	else
		{
echo "<a href='zwit.php?new=active&hosp=0'><font coor='green' size='4'>+ Добавити новий звіт про лікаря</font></a><br><br>";
if (!$_GET['doctor'])
	{
echo "<table width=100% id='old' cellspacing=1>";



$misjac=date('m');
if ($_SESSION['role']==5)
	{
	   
			if ($_POST['lik']=='0')
			{
$sql="SELECT  zwit.id_zvit,zwit.date,zwit.zwites,zwit.note,zv.id, doctor.family, doctor.name,doctor.photo, doctor.third_name,doctor.affibiation,zv.id_speciality,special.spec_name,zv.id_physician
FROM  mis_zwit as zwit,mis_guide_physician AS doctor, mis_guide_speciality AS special, mis_physican_in_hospital AS zv WHERE zv.id_physician = doctor.id AND zv.id_speciality = special.id AND zv.id=zwit.id_ph_in_hosp
AND special.role = '1' AND zv.tul='1' ORDER BY zv.id_speciality,doctor.family ASC";

$mas_doctor=$base->get_doctor_select_zwit($sql);
			}
			else if ($_POST['lik']>0)	
				{
$sql_old="SELECT  zwit.id_zvit,zwit.date,zwit.zwites,zwit.note,zv.id, doctor.family, doctor.name,doctor.photo, doctor.third_name,doctor.affibiation,zv.id_speciality,special.spec_name,zv.id_physician
FROM  mis_zwit as zwit,mis_guide_physician AS doctor, mis_guide_speciality AS special, mis_physican_in_hospital AS zv WHERE zv.id_physician = doctor.id AND zv.id_speciality = special.id AND zv.id=zwit.id_ph_in_hosp
AND special.role = '1' AND zv.id_hospital='".$_POST['lik']."' ORDER BY zv.id_speciality,doctor.family ASC";

					//$mas_doctor=$base->Get_doctor($_POST['lik']);
					$mas_doctor=$base->get_doctor_select_zwit($sql_old);
				}
		
		
	echo "<form action='zwit.php' method='post'>";
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
		echo "<option value='".$mas_spec[$i]['id_title']."'>".$mas_spec[$i]['title']."</option>";
		}}
		echo "<input type='submit' value='Вибрати'> </form><br><br><br>";
	
	}
	else {
	if ($_POST['lik']=='0')
			{

	$mas_doctor=$base->get_doctor_select_zwit($sql);
			}
			else 
				{
					$mas_doctor=$base->get_doctor_select_zwit($sql_old);
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
				echo "<tr><td width=3% style='border: 1px solid #666'><img width=35px  style='float:left;' src='script_img/image_doctor.php?num=".$mas_doctor[$j]['id']."'></td>";
				}else echo "<td width=3% style='border: 1px solid #666'><img width=35px  style='float:left;' src='images/spec/nophoto.png'></td>";
				
					echo "<td width=8% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['date_zwit']." </td>
					<td width=8% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['family']." <br>".$mas_doctor[$j]['name']." <br>".$mas_doctor[$j]['third_name']."</td>
					<td width=55% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['zvit']."</td>
					<td width=15% style='border: 1px solid #666'><Font size=3><a href='zwit.php?id=".$mas_doctor[$j]['id_zvit']."&type=upd&hosp=".$_POST['lik']."&num=".$mas_doctor[$j]['id']."' class='text'><center>Змінити</a>
						<br><br> <a href='zwit.php?id=".$mas_doctor[$j]['id_zvit']."&type=del' class='text'><center>Видалити</a></td>
					
					</tr>		
					";
					
				}
			}
		echo "";
	}


echo "</table>";	
		}	



//-----------------------------------------------якщо незалогінений---------------------------------------
}
	else 
	{
	header("Location: my_admin.php");
	}
echo "</td></tr></table>";



 
?>








