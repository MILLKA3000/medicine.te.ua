<?php
include "header.php";
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>�������</a> -> <a href='my_admin.php'>��������</a> -> <a href='user_upload.php'>����������� ������ ������������</a></Font>";
include "admin_menu.php";
echo "<b style='float:right'>�� ������ �� ��'�� ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";

	//echo $pass_crypt=crypt(md5("tyrchun", "tyrchun"));
?>
<div class='auth-form-min' style='margin-left:0px;width:100%;'>	
<center><b><font color=red>��� ������������ ������������ ������� � Excel ������� ��� ���</font><br></center><br>
 1 - ����� ("�������","���","��-�������","����","������","����볿","˳�����","������������")<br>
 2 - ˳����� �� ������������ ��������� � ID !<br>
 3 - ���� ID ������������ ������� ����� ������� "0" ,
     ��� ��� ���� ��� ������� �������� ����������� ������� 
     ���� ������ ������ �� ������� �����������!<br>
 4 - ID ˳���� � �����������! <br>
 5 - �� ������ �� ������ ���� �������!
 </b></div>
	<center>
	<div class='auth-form-min' style='margin-left:0px;width:450px;'>
	<center><FONT color='blue'><b>������������ ������������</b></FONT></center>
	  <form action="user_upload.php" method="post" enctype="multipart/form-data">
      <input type="file" name="filename"  value="�����">
      <input type="submit" value="����������� ����"><br>
	</div>
	<center>
<? 
//����������� ����� � ����� �� ������
   if (isset($_FILES["filename"]["tmp_name"])) {
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
    move_uploaded_file($_FILES["filename"]["tmp_name"], "user/".date("i-s").$_FILES["filename"]["name"]);
//ϳ��������� ����� ��� �������  
include_once("Class/user_reader.php");
require_once "Class/mysql-class.php";
if ($_GET['active']){echo "<script type='text/javascript'> var active=true; </script>";}
$data = new XLSToDB(date("i-s").$_FILES["filename"]["name"], 'CP1251');
$fileXLS=date("i-s").$_FILES["filename"]["name"];
$links="user/".date("i-s").$_FILES["filename"]["name"];
$base = new class_mysql_base();

	//�������� ������� �����
	$num=$data->getshet($fileXLS)-1;
	$err=0;
	//�����
	echo"<table border=1>";
	$myArr=array("��� ˳����","�������","���","��-�������","����","������","����볿","˳�����","������������");
	for ($i=0;$i<=8;$i++){echo "<td valign=top class='text'><center>&nbsp;".$myArr[$i]."</td>";}
	//���� �����
	
	//--------------------------------------------------------------------------------------
	if ($err==0)
				{
	for ($j=0;$j<=$num;$j++)
	{
	$variantArray=$data->get($fileXLS,$j);
		
	foreach ($variantArray as $key=>$mas)
		{
		echo "<tr>";
			echo "<td></td>";
			echo "<td><center>".$mas[0]."<br>";
			echo "<td><center>".$mas[1]."<br>";
			echo "<td><center>".$mas[2]."<br>";
			echo "<td><center>".$mas[3]."<br>";
			echo "<td><center>".$mas[4]."<br>";
			echo "<td><center>".$mas[5]."<br>";
			$sql="SELECT * FROM mis_hospital WHERE id='".$mas[6]."';";
			$hosp = $base->Get_hospital_one($sql);
			if ($hosp[0]['title']!=""){echo "<td><center><font color=green><b>".$hosp[0]['title']."</font></b><br>";}else{echo "<td><center><FONT color=red>�����������</FONT><br>";}
			$sql="SELECT * FROM mis_guide_speciality WHERE id='".$mas[7]."';";
			$spec = $base->Get_spec_tul($sql);
			if ($spec[0]['name']!=""){echo "<td><center><font color=green><b>".$spec[0]['name']."</font></b><br>";}else{echo "<td><center><FONT color=red>�����������</FONT><br>";}
			
			if (($mas[0]!='')&&($mas[1]!='')&&($mas[2]!='')&&($mas[3]!='')&&($mas[4]!='')&&($mas[5]!='')&&($mas[6]!='')&&($mas[7]!=''))
			{
				
				//������� � ���� ������������
				$pass = crypt(md5($mas[3]), md5($mas[4]));
				$last_id=$base->ins("INSERT INTO `mis_guide_physician` (`family`,`name`,`third_name`,`username`,`password`,`affibiation`,`id_city`)VALUES('".$mas[0]."','".$mas[1]."','".$mas[2]."','".$mas[3]."','".$pass."','".$mas[5]."','��������');");
				
				//$last_id=$base->mysql_insert_id();
				$base->ins("INSERT INTO mis_physican_in_hospital (id_physician,id_hospital,id_speciality)VALUES(".$last_id.",".$mas[6].",".$mas[7].");");
				
			
			}
			}
			
		echo "</td>";
		echo "</tr>";
		}
		
	}}
	if ($err==0)
			{
			echo "<FONT color='green'><b>������������ ������</b></FONT>";
			}
}


?> 
</center>
