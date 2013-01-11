<center><b><font color='red'>Редагування</font></b></center>
<style>.frameBody{font-family:sans-serif;font-size:12px;margin:0;width:100%;height:100%}.frameBody p{border:1px #bbb solid;padding:2px}.rte-zone{width:100%;background:white;margin:0;padding:0;height:260px;border:1px #999 solid;clear:both}.rte-toolbar{overflow:hidden}.rte-toolbar a,.rte-toolbar a img{border:0}.rte-toolbar p{float:left;margin:0;padding-right:5px}</style>
<style type="text/css">body,textarea{font-family:sans-serif;font-size:12px}body{margin:20px;padding-bottom:40px}</style>
<?php
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

$sql_old="SELECT  * FROM  mis_zwit  WHERE id_zvit=".$_GET['id'].";";
					$zwites=$base->get_doctor_select_zwit($sql_old);
					
					
echo"<form action='http://medicine.te.ua/zwit.php' method='post' enctype='multipart/form-data'>";
echo"<input  name='id'  style='visibility: hidden;' value='".$_GET['id']."' />";
echo"<table><tr><td><b>Дата</b></td> <td><input  id='inputDate4' name='date' value='".$zwites[0]['date_zwit']."' /></td></tr>";
		echo "<tr><td><b>Лікарня</b></td> <td> <select class='zwit_lik' name='zwit_lik' >
		<option value='0'>Тернопільський державний медичний університет(ТДМУ)</option>";
		for ($i=0;$i<count($mas_spec);$i++)
		{
			if ($_GET['hosp']==$mas_spec[$i]['id_title'])
				{
					echo "<option value='".$mas_spec[$i]['id_title']."' selected=selected>".$mas_spec[$i]['title']."</option>";
				}else{
		echo "<option value='".$mas_spec[$i]['id_title']."'>".$mas_spec[$i]['title']."</option>";
		}}
		echo"</select></td></tr>";
		if($_GET['hosp']!='')
			{
								if ($_GET['hosp']=='0')
										{
											$sql="SELECT zv.id, doctor.family, doctor.name,doctor.photo, doctor.third_name,doctor.affibiation,zv.id_speciality,special.spec_name,zv.id_physician
											FROM  mis_guide_physician AS doctor, mis_guide_speciality AS special, mis_physican_in_hospital AS zv WHERE zv.id_physician = doctor.id AND zv.id_speciality = special.id AND special.role = '1' AND zv.tul='1' ORDER BY zv.id_speciality,doctor.family ASC";
											$mas_doctor=$base->get_doctor_select($sql);
										}
										else if ($_GET['hosp']>0)	
											{
													$mas_doctor=$base->Get_doctor($_GET['hosp']);
											}
					echo"<tr><td><b>Лікар</b></td> <td>
					<select class='doc' name='doc'>	";
		
		for ($i=0;$i<count($mas_doctor);$i++)
		{
			if ($_GET['num']==$mas_doctor[$i]['id']){echo "<option value='".$mas_doctor[$i]['id']."' selected=selected>".$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name']." ".$mas_doctor[$i]['third_name']."(".$mas_doctor[$i]['spec_name'].")</option>";}else{
		echo "<option value='".$mas_doctor[$i]['id']."'>".$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name']." ".$mas_doctor[$i]['third_name']."(".$mas_doctor[$i]['spec_name'].")</option>";
		}}
					
					
					echo"</select></td></tr></table>";
			}

echo"<center><b><font size='6'>Звіт</font></b></center><br>";
?>
<div class='auth-form-min' style='margin-left:0px;width:100%;'>
<p>
    <textarea name="description"  id="id_description" 
    class="rte-zone"><?echo $zwites[0]['zvit'];?><br></textarea>
</p>
<input type="submit" name='ok_upd'/>
</form>

<script type="text/javascript" src="../script/jquery.rte.js"></script>
<script type="text/javascript">
    $('.rte-zone').rte("css url", "toolbox images url");
</script>

</div>
<script type="text/javascript">
$('.zwit_lik').change(function() {
                
            window.location.href='zwit_edit.php?new=active&hosp='+ encodeURIComponent($('select[name=\'zwit_lik\']').val());
		
    });
</script>
<?



?>