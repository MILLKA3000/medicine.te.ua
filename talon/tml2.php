<script src="http://shublog.ru/files/js/jquery-1.6.4.js"></script>
<meta http-equiv= 'Refresh' content='60; http://medicine.te.ua/auth.php?action=logout'>
<?
include ("../auth.php");
require_once "../Class/mysql-class.php";
require_once "../Class/func-date.php";
$base = new class_mysql_base();

//----------------------------------�������� �����������----------------------------------------

	//----------------------------------����� �����������----------------------------------------
	//----------------------------------˳��� �������������----------------------------------------
	
	   
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".$_GET['id_type']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$i = $Mas['id'];
	}
	
$base->sql_query="SELECT * FROM mis_hospital WHERE `id` ='".$_GET['id_hosp']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$hosp = $Mas['title'];
		$contacts = $Mas['contacts'];
		$id_hosp = $Mas['id'];
	}	
	
$base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_guide_speciality.metod 
FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
AND mis_physican_in_hospital.id='".$_GET['num']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$name = $Mas['name'];
		$family = $Mas['family'];
		$third_name = $Mas['third_name'];
		$name_spec = $Mas['spec_name'];
		$id_spec = $Mas['id'];
		$metod_spec = $Mas['metod'];
		$affibiation = $Mas['affibiation'];
		$photo=$Mas['photo'];
        
		
	}	
$time=$base->Get_time($_GET['time']);    
echo "<html>
<br>					
<b><FONT SIZE=5>����� ������������� ��������</FONT></b><br><br><br>


��� ��������_________________________________________<br>
�.�.�. <u>".$_SESSION['family_p']." ".$_SESSION['name_p']." ".$_SESSION['first_name_p']."</u><br>
�����: �-1 �-2<br>
���� ����������  ".$_SESSION['date']."<br>
������: ���., ���. ��. ".$_SESSION['adress']."<br>
��������: ���.. ��� -1; ��.���-2;���..�����-3;���..���.-4; <br>
		   ���.���.-5;��� ���.-6;���.-7;����.-8;����.-9;<br>
		   ����.�/�-10;�����.-11;����.-12;����-13;<br>
		   ����.-14;����.-15;�������.-16;��������.-17.<br>
̳��� ������___________________________________________<br>
�������������________________________________________<br>
���� ��������:����-����.-1;����������-2;����.����.-3<br>
			   �������.-4;������-���.-5;����-6<br>
̳��� ��������������: ����� (����, ��� �����)________<br>
_______________________________________________________<br>
_______________________________________________________<br>
�� ���� (���� ��� �����)______________________________<br>
_______________________________________________________<br>
_______________________________________________________<br>
ĳ�����(�):��������:___________________________________<br>
_______________________________________________________<br>
������________________________________________________<br>
_______________________________________________________<br>
_______________________________________________________<br>
������������(�����) ������-1;������ � ���� ������������<br>
					�������-2;����� ����� �������-3;<br>
					�������.����-4;<br>
��� ������: �) ������ � ������������ � �������-1; � �/�-2;�� ���.-3<br>
				���.������-4;����-5.<br>
				�)�� ������ � ������.-��������-6;�������-7;<br>
				 ���.������.-8;���������-9;����-10.<br>
���������� �������� �� ������__________________________<br>
����.������:�����-1;���������-2;��������-3;�����-4.<br>
ĳ�����:<br>
�_____________________����_________���� ����.����_______<br>
�_____________________����_________���� ����.����_______<br>
�_____________________����_________���� ����.����_______<br>

˳���.-����.������:���-���-1;�����-2;���-���-3;䳺�.����-4;<br>
					����-5.<br>
������ � '�'�����: ��������-1;�������.� ���.��.������-2;<br>
					�����-3;����-4.<br>
����������: � ��.		�� ��.		��� ��.<br>
������������� �-�:______________________________________<br>
��_______________��________________�/�����_______________<br>
������������___________________________________________<br>
������������_____________________________________________<br>
</html>
";

//header("Location: calendar.php?num=".$_GET['num']."&m=".$_GET['m']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."");	
echo "<script type='text/javascript'>";
echo "var addres = 'http://medicine.te.ua/new_patient.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'";
echo "</script>";
?>


<script type="text/javascript">
$(document).ready(function() { 
  /*  window.print();
	self.location.href = addres;
	//window.document.location.href = addres;

    //history.go(-1);*/
	if(confirm('������ ���������� ������?'))
	{window.print();
	self.location.href = addres;}
else {window.print();
	self.location.href = "http://medicine.te.ua/auth.php?action=logout";}
});
</script>