<?php
include "header.php";
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>�������</a> -> <a href='my_admin.php'>��������</a> -> <a href='Get_exel.php'>������ � ���������</a></Font>";
include "admin_menu.php";
echo "<b style='float:right'>�� ������ �� ��'�� ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";

$num_mis = array('ѳ����','�����','��������','������','�������','�������','������','�������','��������','�������','��������','�������');
$mas_doctor=$base->Get_doctor($_SESSION['likarnja']);
$date_m = date("m");
$year=date("Y");
	echo "<center>
	 <FONT size=8>������ � ���������</FONT><br> <FONT color='blue'> ������� ����� �� ���� ��� ������� �������� ������ </font>
		<form action='1.php' method='post' enctype='multipart/form-data'>
		
		<select class='text' name='year'>";
		for ($mis=2012;$mis<2026;$mis++)
		{
		if ($mis==$year) {echo "<option value='".($mis)."' SELECTED>".$mis."</option>";}
        else {
		echo "<option value='".($mis)."'>".$mis."</option>";}
		}
		echo "</select>
		
		<select class='text' name='mis'>";
		for ($mis=0;$mis<12;$mis++)
		{
		if ($mis+1==$date_m) {echo "<option value='".($mis+1)."' SELECTED>".$num_mis[$mis]."</option>";}
        else {
		echo "<option value='".($mis+1)."'>".$num_mis[$mis]."</option>";}
		}
		echo "</select>
		<select class='text' name='likarnya'>
		<option value='0'>----------------�� ����-----------------</option>";
		for ($mis=0;$mis<count($mas_doctor);$mis++)
		{
		echo "<option value='".$mas_doctor[$mis]['id']."'>".$mas_doctor[$mis]['family']." ".$mas_doctor[$mis]['name']." ".$mas_doctor[$mis]['third_name']."(".$mas_doctor[$mis]['spec_name'].")</option>";
		}
		echo "<input type='submit' value='�������� ������ ��� ���������� �������'>
		</form>
	<br><br><br>";    
	
?>	
	
	<center><FONT color='blue'><b>������������ ������� ������ �����</b></FONT></center>
	  <form action="Get_exel.php" method="post" enctype="multipart/form-data">
      <input type="file" name="filename"  value="�����">
      <input type="submit" value="����������� ����"><br>
	</div>
	<center>
<? 
//echo $_FILES["filename"]["type"];
 $allowed = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         if ((!in_array($_FILES["filename"]["type"], $allowed))) {
		 echo "<FONT COLOR=red><B>���� �� �����������</B></FONT>";
         } else { 

//����������� ����� � ����� �� ������
if (isset($_FILES["filename"]["tmp_name"])) {
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
    move_uploaded_file($_FILES["filename"]["tmp_name"], "sheets/".date("i-s").$_FILES["filename"]["name"]);

	$base->logs("������� ������ (".$_FILES["filename"]["name"].")");
	
//ϳ��������� ����� ��� �������  
include_once("Class/class reader.php");
include_once("Class/func-date.php");
require_once "Class/mysql-class.php";
if ($_GET['active']){echo "<script type='text/javascript'> var active=true; </script>";}

$data = new XLSToDB(date("i-s").$_FILES["filename"]["name"], 'CP1251');

$fileXLS=date("i-s").$_FILES["filename"]["name"];

$links="sheets/".date("i-s").$_FILES["filename"]["name"];
$base = new class_mysql_base();

echo "<br>";


	//�������� ������� �����
	$num=$data->getshet($fileXLS)-1;
	$err=0;
	//�����
	echo"<table border=1>";
	$myArr=array("��� ˳����","�������","���","��-�������","��� ������������","���� �������","��� �������","��� ����","ʳ������ ����","ʳ������ ��������","������","������� ��������");
	for ($i=0;$i<=11;$i++){echo "<td valign=top class='text'><center>&nbsp;".$myArr[$i]."</td>";}
	//���� �����
	
	//---------------------------�������� �� ������� �������-------------------------------	
	/**/for ($j=0;$j<=$num;$j++)
	/**/{
	/**/$variantArray=$data->get($fileXLS,$j);
	/**/
	/**/
	/**/foreach ($variantArray as $key=>$mas)
	/**/	{
	/**/	if(($mas[5]==""))
	/**/			{
	/**/			$err++;
	/**/			echo "<FONT color='red'>��������� ������� � ����� <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> � ������������ <b>".$mas[4]."</b> ������ <b>".$mas[5]."</b> ���� ������������!<br></FONT>";
					break;
	/**/			}
			if(($mas[5][0].$mas[5][1]>'31')||($mas[5][3].$mas[5][4]>'12'))
					{
					$err++;
					echo "<FONT color='red'>��������� ������� � ����� <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> � ������������ <b>".$mas[4]."</b> ���� <b>".$mas[5]."</b> ������� <br></FONT>";
	/**/			break;
			}
			if(($mas[6][0].$mas[6][1]>24)||($mas[6][3].$mas[6][4]>59)||($mas[6][2]!=':'))
					{
					$err++;
					echo "<FONT color='red'>��������� ������� � ����� <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> � ������������ <b>".$mas[4]."</b> ��� <b>".$mas[6]."</b> �������� <br></FONT>";
				break;
			}
		
			if(($mas[7][0].$mas[7][1]>24)||($mas[7][3].$mas[7][4]>59)||($mas[7][2]!=':'))
					{
					$err++;
					echo "<FONT color='red'>��������� ������� � ����� <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> � ������������ <b>".$mas[4]."</b> ��� <b>".$mas[7]."</b> �������� <br></FONT>";
				break;
			}
	/**/	}
		if($err>0)break;
	/**/	
	/**/}				
	//--------------------------------------------------------------------------------------
	if ($err==0)
				{
	$base->sql_connect();
				$sql="INSERT INTO `mis`.`mis_working_time_log` (`id_physician`,`upload_schedule`,`note`,`file_path`)VALUES ('".$_SESSION['name_sesion_a']."', '".date("Y-m-d H:i:s")."', '".$_FILES["filename"]["name"]."','".$links."')";
				$base->sql_query=$sql;
				$base->sql_execute();
				$last_id_log=mysql_insert_id();
	
	for ($j=0;$j<=$num;$j++)
	{
	$variantArray=$data->get($fileXLS,$j);
		
	foreach ($variantArray as $key=>$mas)
		{
		echo "<tr>";
		
			//������� ������ ���� ��� �����
			$rizn_hour=Parse_time($mas[6],$mas[7]);
			//������� ��� ��� ������ ��������
			$time_patient=floor($rizn_hour/$mas[8]);

			echo "<td><center>".$mas[0]."<br>";
			echo "<td><center>".$mas[1]."<br>";
			echo "<td><center>".$mas[2]."<br>";
			echo "<td><center>".$mas[3]."<br>";
			echo "<td><center>".$mas[4]."<br>";
			echo "<td><center>".Parse_date($mas[5])."<br>";
			echo "<td><center>".$mas[6]."<br>";
			echo "<td><center>".$mas[7]."<br>";
			echo "<td><center>".$rizn_hour." min/".$time_patient;
			echo "<td><center>".$mas[8]."<br>";
			echo "<td><center>".$mas[9]."<br>";
			
			if ($err==0)
				{
					
				
				//-----------------------------------------------------------------------------
				//-----------------���� ���� ������� �� ������� � ��--------------------------
				
				//-------������� mis_working_time----------------------------------------------
				$last_id=$base->Put_workin_time($mas[0],Parse_date($mas[5]),$mas[6],$mas[7],$mas[8],$mas[9]);
				
				
				
				//--------------------------------------������� ������� ��������� ��� �����---------------------------------
					echo "<td><center>";
			
					//������� ���� ��������� ����
					//-------------------------------------
					$t_start = new DateTime($mas[6]);
					//-------------------------------------
			
					for ($i=0;$i<$mas[8];$i++)
						{
						//��������� ��������� ��� ��� ������� ��������
						$time_start_out=date("G-i",mktime($t_start->format('G'), $t_start->format('i')+$time_patient*$i)); 
						$time_end_out=date("G-i",mktime($t_start->format('G'), $t_start->format('i')+$time_patient*($i+1))); 
						echo "<a href=''>".$time_start_out." - ".$time_end_out."</a><br>";
						//-------������� mis_shedule---------------------------------------------------
						//������ ����

						if ($time_start_out[1]!="-"){
						$parse_time_start=$time_start_out[0].$time_start_out[1].":".$time_start_out[3].$time_start_out[4];
													}
						else
						{
						$parse_time_start=$time_start_out[0].":".$time_start_out[2].$time_start_out[3];
						}
						if ($time_end_out[1]!="-"){
						$parse_time_end=$time_end_out[0].$time_end_out[1].":".$time_end_out[3].$time_end_out[4];
													}
						else
						{
						$parse_time_end=$time_end_out[0].":".$time_end_out[2].$time_end_out[3];
						}
						//����� � ��...
						
							
						
						$base->Put_to_schedule($mas[0],$last_id,Parse_date($mas[5]),$parse_time_start,$parse_time_end,$last_id_log,$mas[9]);
						//-----------------------------------------------------------------------------
						//-----------------------------------------------------------------------------
						}
					echo "</td>";
				
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
}}

?> 
</center>
<script type="text/javascript">
$(document).ready(function() { 
if (active==true){
 setTimeout(function f(){history.go(-1)}, 3000); 
    f();}
});
</script>
