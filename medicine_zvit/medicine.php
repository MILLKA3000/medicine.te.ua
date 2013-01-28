<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link type="text/css" rel="stylesheet" media="all" href="http://medicine.te.ua/style/other.css" />
<link type="text/css" rel="stylesheet" media="all" href="http://medicine.te.ua/style/menu.css" />
<style type="text/css">
   body {
		background-image: url(http://medicine.te.ua/images/spec/BG.jpg);
		}
  </style>
  <body>
<?php
require_once "../Class/mysql-class.php";
$base = new class_mysql_base();
echo"<a href='http://intranet.tdmu.edu.ua/index.php?dir_name=general&file_name=index.php'>Головна сторінка</a>";	
echo " <center><div class='lifted'>";
echo "<table width=100% id='old' cellspacing=1>";
if ($_POST['lik']==''){$_POST['lik']='0';}
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
	

	echo "<form action='medicine.php' method='post'>";
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
	
	if 	($mas_doctor[0]['id']==''){echo"<center>Вибачте нажаль нічого не найдено</center>";}	
	if ($_POST['lik']=='0')
			{

	$mas_doctor=$base->get_doctor_select_zwit($sql);
			}
			else 
				{
					$mas_doctor=$base->get_doctor_select_zwit($sql_old);
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
				echo "<tr><td width=3% style='border: 1px solid #666'><img width=35px  style='float:left;' src='http://medicine.te.ua/script_img/image_doctor.php?num=".$mas_doctor[$j]['id']."'></td>";
				}else echo "<td width=3% style='border: 1px solid #666'><img width=35px  style='float:left;' src='http://medicine.te.ua/images/spec/nophoto.png'></td>";
				
					echo "<td width=8% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['date_zwit']." </td>
					<td width=8% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['family']." <br>".$mas_doctor[$j]['name']." <br>".$mas_doctor[$j]['third_name']."</td>
					<td width=55% style='border: 1px solid #666'><Font size=3>".$mas_doctor[$j]['zvit']."</td>
					
					
					</tr>		
					";
					
				}
			}
		echo "";
	


echo "</table>";	
		


echo"</div>";
?>
