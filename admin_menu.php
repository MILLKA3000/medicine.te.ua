<center>
<div class='lifted'><p>

<table width=95%>
	<tr>
		

<? 

echo "		<Td width=25% valign='top'>
			<b><center><FONT size=4 color=blue>����</FONT></center>";
			
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
echo "<a class='menu' href='my_profile.php?doctor=".$mas[0]['id']."'>̳� �������</a><br>
<a class='menu' href='mark_patient.php'>�� ��������</a><br>
<a class='menu' href='zapus.php'>�������� �������� �� ����������</a><br><br><br>
<FONT size=4 color=blue><center>�� �������</center></FONT>";
for ($i=0;$i<count($mas);$i++)
		{
		
		echo "<a class='menu' href='one_calendar.php?doctor=".$mas[$i]['id']."&m=".date('m')."'> ".$mas[$i]['name']."</a><br>";
		}

	

			}
if ($_SESSION['role']==2){
//----------------------------���� ����� ����� -------------------------------
//echo"	 ������� ������ �������� </a><br>";
echo"	<a class='menu' href='Get_exel.php'> ������������ ������� </a><br>";
echo"	<a class='menu' href='reg_graf.php'> ����������� ������� </a><br>";
echo"	<a class='menu' href='new_doctor.php'> ����������� ����� </a><br>";
echo"	<a class='menu' href='new_physician.php'> �������� ������ �����������</a><br>";
echo"	<a class='menu' href='full_zapus.php'> �������� ��� ��������� ��������</a><br>";
echo"	<a class='menu' href='simeinuy.php'> ѳ������ ���� </a><br>";
echo"<br><br><br><br><br><b><center><FONT size=4 color=blue>�� �����</FONT></center></b><br> �������� : ";
print_r($_SERVER['REMOTE_ADDR']);
echo"<br>������� : ";
print_r($_SERVER['SERVER_ADDR']);

}
//----------------------------���� ������� �����-------------------------------
if ($_SESSION['role']==3){
//echo"	 ����������� ������� </a><br>";
echo"	<a class='menu' href='new_special.php'> ����������� �������������� </a><br>";
echo"	<a class='menu' href='new_doctor.php'> ����������� ����� </a><br>";
echo"	<a class='menu' href='new_physician.php'> �������� ������ �����������</a><br>";
echo"	<a class='menu' href='new_street.php'> ����������� ������</a><br>";
echo"	<a class='menu' href='log.php'> ����������� ����</a><br>";
echo"	<a class='menu' href='user_upload.php'> ����������� ������ ������������</a><br>";
echo"	<a class='menu' href='new_login.php'>������ ���� �����������</a><br>";
echo"	<a class='menu' href='zwit.php'>������� �� ������</a><br>";
echo"	<a class='menu' href='stat.php'>��� ����������</a><br>";    
echo"<br><br><br><br><br><b><center><FONT size=4 color=blue>�� �����</FONT></center></b><br> �������� : ";
print_r($_SERVER['REMOTE_ADDR']);
echo"<br>������� : ";
print_r($_SERVER['SERVER_ADDR']);
echo"<br> ������� ���:<br>";
print_r($_SERVER['argv']);
//echo"	<a class='menu' href='reg_graf.php'> ����������� ������� </a><br>";
//echo"	 �������� ������ ��������</a><br>";

}		
if ($_SESSION['role']==4){
//----------------------------���� ����������-------------------------------
echo"	<a class='menu' href='full_zapus.php'> �������� ��� ��������� ��������</a><br>";
echo"	<a class='menu' href='simeinuy.php'> ѳ������ ���� </a><br>";
}			
if ($_SESSION['role']==5){
//----------------------------���� ����������-------------------------------
echo"	<a class='menu' href='zwit.php'> ��� �����</a><br>";
echo"	<a class='menu' href='stat.php'>��� ����������</a><br>";  

}					
		echo "
		
		</td>
<td width=80% valign='top'>";

?>	
