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
echo "
<div style='
    padding-top:400px;
    height:200px;
    width:600px;
    transform:rotate(90deg);
-ms-transform:rotate(90deg); /* IE 9 */
-moz-transform:rotate(90deg); /* Firefox */
-webkit-transform:rotate(90deg); /* Safari and Chrome */
-o-transform:rotate(90deg);'> 
    <input size='6'  type='text' value=''>
    ".$_SESSION['family_p']." ".$_SESSION['name_p']." ".$_SESSION['first_name_p'].". &nbsp&nbsp&nbsp&nbsp ".$_SESSION['date'];
	
	echo"<br>������: ".$_SESSION['adress']."
	<br> ĳ������  <input size='2'  type='text' value=''> &nbsp&nbsp&nbsp ���� �� ��� ������� ".date_parse_vupuska($time[0]['date'])." &nbsp&nbsp&nbsp ".$time[0]['timebegin']." - ".$time[0]['timeend']." <br>
    ----------------------------(".$name_spec.")  ".$family." ".$name." ".$third_name."<br>
    ���: <input size='6'  type='text' value=''> &nbsp&nbsp ���: <input size='6'  type='text' value=''> &nbsp&nbsp ���: <input size='6'  type='text' value=''> &nbsp&nbsp ��: <input size='6'  type='text' value=''>
	 <br><br></div>"; 

//header("Location: calendar.php?num=".$_GET['num']."&m=".$_GET['m']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."");	
echo "<script type='text/javascript'>";
echo "var addres = 'http://medicine.te.ua/new_patient.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'";
echo "</script>";
?>
<script type="text/javascript">
$(document).ready(function() { 
  /*  window.print();
self.location.href = addres;*/
if(confirm('������ ���������� ������?'))
	{window.print();
	self.location.href = addres;}
else {window.print();
	self.location.href = "http://medicine.te.ua/auth.php?action=logout";}
	//window.document.location.href = addres;

    //history.go(-1);
});
</script>