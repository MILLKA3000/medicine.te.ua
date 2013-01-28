<?php
include "header.php";
?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript" src="datepicker/graf.js"></script>
<?php
	function js_str($s) {
	return '"'.addcslashes($s, "\0..\37\"\\").'"';
	}
	function js_array($array) {
	$temp=array();
	foreach ($array as $value)
		$temp[] = js_str($value);
	return '['.implode(',', $temp).']';
	}
	function cleanDir($dir) {
    $files = glob($dir."/*");
    $c = count($files);
    if (count($files) > 0) {
        foreach ($files as $file) {      
            if (file_exists($file)) {
            unlink($file);
            }   
        }
    }
	}
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='stat.php'>Збір статистики</a></Font>";
include "admin_menu.php"; 
echo "<b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";
//----------------------------------Перевірка авторизації----------------------------------------

	//----------------------------------Форма авторизації----------------------------------------
	if (!$_SESSION['name_sesion_a'])
	{
		header("Location: my_admin.php");
	}
	else
	//----------------------------------Лікар авторизувався----------------------------------------
	{
	$num_mis = array('Січень','Лютий','Березень','Квітень','Травень','Червень','Липень','Серпень','Вересень','Жовтень','Листопад','Грудень');
	$date_m = date("m");
	$year=date("Y");
	$l=0;
	$mas_spec = array(array());
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_hospital` WHERE 1;";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$mas_spec[$l]['id_title'] = $Mas['id'];
			$mas_spec[$l]['title'] = $Mas['title'];
			$l++;
			}
	echo "<center>
	<table width='100%' bgcolor='white'><tr><td>
	<form action='stat.php' enctype='multipart/form-data' method='post'>
	
	Виберіть рік
	<select class='text' name='year'>";
		for ($mis=2012;$mis<$year+1;$mis++)
		{
		if ($mis==$_POST['year']) {echo "<option value='".($mis)."' SELECTED>".$mis."</option>";}
        else {
		echo "<option value='".($mis)."'>".$mis."</option>";}
		}
		echo "</select>
		<br>";
		if ($_POST['old']!='on'){echo "За весь рік <input type='checkbox' name='old' id='id_'> + (Вивід діаграми помісячно)";}
			else{echo "За весь рік <input type='checkbox' name='old' id='id_' checked='checked'> + (Вивід діаграми помісячно)";}
	if ($_POST['old']!='on'){
	echo"<div id='mis_'>Виберіть місяць	<select class='text' name='mis'>";
		for ($mis=0;$mis<12;$mis++)
		{
		if ($mis+1==$_POST['mis']) {echo "<option value='".($mis+1)."' SELECTED>".$num_mis[$mis]."</option>";}
        else {
		echo "<option value='".($mis+1)."'>".$num_mis[$mis]."</option>";}
		}
		echo "</select></div>";}
		echo "<br>Виберіль лікувальний заклад <select class='text' name='lik'>	";
		echo "<option value='0'>Тернопільський державний медичний університет(ТДМУ)</option>";
		for ($i=0;$i<count($mas_spec);$i++)
		{
		if ($mas_spec[$i]['id_title']==$_POST['lik']){echo "<option value='".$mas_spec[$i]['id_title']."' selected=selected>".$mas_spec[$i]['title']."</option>";}else{
		echo "<option value='".$mas_spec[$i]['id_title']."'>".$mas_spec[$i]['title']."</option>";}
		}
		echo "</select><br><input type='submit' value='Отримати'>
	</FORM></td></tr>";
	
	
	//if ($_POST['date'])
	{
	if ($_POST['mis']<10){$_POST['mis']='0'.$_POST['mis'];}
	$zag_kil = array();
	$zag_kil_lik = array();
	$zag_kil_lik_mis = array();
	$i=0;
	
	if ($_POST['old']=='on'){$date="LIKE '".$_POST['year']."%'";}else{$date="LIKE '".$_POST['year']."-".$_POST['mis']."%'";}
		$base->sql_query="SELECT * FROM `mis_schedule` WHERE `assigned_patient_id`>'1'  AND  `work_date` ".$date."; ";
				$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$zag_kil[$i] = $Mas['id'];
					$i++;
					}
					if (count($zag_kil)==0){echo "<tr><td ><b><center>нічого не знайдено </td></tr></table>";}else{
				echo "<tr bgcolor=lime><td ><b>Загальна кількість записаних пацієнтів </td><td><b>".count($zag_kil);
	
	if ($_POST['lik']>0){
	$i=0;
	  $base->sql_query="SELECT * FROM `mis_schedule`,`mis_physican_in_hospital` WHERE `id_hospital` =  '".$_POST['lik']."'
                                    AND `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` 
                                    AND `assigned_patient_id`>'1' 
                                    AND  `work_date` ".$date." ";
									$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$zag_kil_lik[$i] = $Mas['id'];
					$i++;
					}
		echo "<tr bgcolor=lime><td ><b>Загальна кількість записаних пацієнтів (".$mas_spec[$_POST['lik']-1]['title'].")</td><td><b>".count($zag_kil_lik)."(".round((count($zag_kil_lik)/count($zag_kil)*100), 2)."%)";	
			$i=0;
			unset($zag_kil_lik);
	  $base->sql_query="SELECT * FROM `mis_schedule`,`mis_physican_in_hospital` WHERE `id_hospital` =  '".$_POST['lik']."'
                                    AND `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` 
                                    AND `assigned_patient_id`>'1' 
                                    AND  `work_date` ".$date." group by `assigned_patient_id` having count(`assigned_patient_id`)>1";
									$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$zag_kil_lik[$i] = $Mas['id'];
					$i++;
					}
		echo "<tr bgcolor=lime><td ><b>Загальна кількість повторно записаних пацієнтів (".$mas_spec[$_POST['lik']-1]['title'].")</td><td><b>".count($zag_kil_lik)."(".round((count($zag_kil_lik)/count($zag_kil)*100), 2)."%)</tr>";	
			
			if ($_POST['old']=='on')
				{
					
					for ($j=1;$j<13;$j++){
					unset($zag_kil_lik);
					//unset($zag_kil_lik_mis);
					if ($j<10){$j='0'.$j;}
					$date_m="LIKE '".$_POST['year']."-".$j."%'";
					$i=0;
					$base->sql_query="SELECT * FROM `mis_schedule`,`mis_physican_in_hospital` WHERE `id_hospital` =  '".$_POST['lik']."'
                                    AND `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` 
                                    AND `assigned_patient_id`>'1' 
                                    AND  `work_date` ".$date_m." ";
					$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$zag_kil_lik[$i] = $Mas['id'];
					$i++;
					}
				$zag_kil_lik_mis[$j]=count($zag_kil_lik);	
				
				}
				
				echo "<script type='text/javascript'>
					  var mas = ".js_array($zag_kil_lik_mis).";
					  </script>";
				echo "<tr bgcolor='white'><td colspan=2> <div style='width=100%;height:300px;' id='chart_div'></div></td>";	
				}
									}
									else
									{
		$i=0;
	  $base->sql_query="SELECT * FROM `mis_schedule`,`mis_physican_in_hospital` WHERE  `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` AND `tul`='1'
                                    AND `assigned_patient_id`>'1' 
                                    AND  `work_date` ".$date." ";
									$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$zag_kil_lik[$i] = $Mas['id'];
					$i++;
					}
		echo "<tr bgcolor=lime><td ><b>Загальна кількість записаних пацієнтів (Тернопільський державний медичний університет(ТДМУ))</td><td><b>".count($zag_kil_lik)."(".round((count($zag_kil_lik)/count($zag_kil)*100), 2)."%)";	
		$i=0;
		$zagalna_tdmu=count($zag_kil_lik);
			unset($zag_kil_lik);
$base->sql_query="SELECT * FROM `mis_schedule`,`mis_physican_in_hospital` WHERE  `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` AND `tul`='1'
                                    AND `assigned_patient_id`>'1' 
                                    AND  `work_date` ".$date."  group by `assigned_patient_id` having count(`assigned_patient_id`)>1";
									$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$zag_kil_lik[$i] = $Mas['id'];
					$i++;
					}
		echo "<tr bgcolor=lime><td ><b>Загальна кількість повторно записаних пацієнтів (Тернопільський державний медичний університет(ТДМУ))</td><td><b>".count($zag_kil_lik)."(".round((count($zag_kil_lik)/count($zag_kil)*100), 2)."%)";	
		
		
				$mas_tdmu=array();
				$base->sql_query="SELECT *,count(`id_physician_in_hospital`) FROM `mis_schedule`,`mis_physican_in_hospital`,`mis_guide_physician` WHERE  `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` AND `tul`='1'
                                    AND `assigned_patient_id`>'1' AND `id_physician` =  `mis_guide_physician`.`id` 
                                    AND  `work_date` ".$date."  group by `id_physician_in_hospital` having count(`id_physician_in_hospital`)>=1";
									
				$base->sql_execute();
				echo "<tr bgcolor=gray><td ><b><center>Лікарі до яких записались</td><td></td>";
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					echo "<tr bgcolor=gray><td ><b>".$Mas['family']." ".$Mas['name']." ".$Mas['third_name']."</td><td>".$Mas['count(`id_physician_in_hospital`)']."</td>";
					}
					
					
		if ($_POST['old']=='on')
				{
				unset($zag_kil_lik_mis);	
					for ($j=1;$j<13;$j++){
					unset($zag_kil_lik);
					if ($j<10){$j='0'.$j;}
					$date_m="LIKE '".$_POST['year']."-".$j."%'";
					$i=0;
	  $base->sql_query="SELECT * FROM `mis_schedule`,`mis_physican_in_hospital` WHERE  `id_physician_in_hospital`= `mis_physican_in_hospital`.`id` AND `tul`='1'
                                    AND `assigned_patient_id`>'1' 
                                    AND  `work_date` ".$date_m." ";
					$base->sql_execute();
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$zag_kil_lik[$i] = $Mas['id'];
					$i++;
					}
				$zag_kil_lik_mis[$j]=count($zag_kil_lik);	
				
				}
				
				echo "<script type='text/javascript'>
					  var mas = ".js_array($zag_kil_lik_mis).";
					  </script>";
				echo "<tr bgcolor='white'><td colspan=2> <div style='width=100%;height:300px;' id='chart_div'></div></td>";	
				}
				}
									}
}}
?> 
<script type='text/javascript'>
$('#id_').bind('change', function () {
   if ($(this).is(':checked'))
     $("#mis_").hide();
   else
     $("#mis_").show();
});
</script>
