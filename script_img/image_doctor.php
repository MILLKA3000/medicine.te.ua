<?php
require_once "../Class/mysql-class.php";
$base = new class_mysql_base();
$base->sql_connect();
$base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,mis_guide_speciality.spec_name,mis_guide_speciality.id 
FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
AND mis_physican_in_hospital.id='".$_GET['num']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
	
		header("Content-type: image/gif");

		echo ($Mas['photo']);
	}	
?>