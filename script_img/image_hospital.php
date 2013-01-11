<?php
require_once "../Class/mysql-class.php";
$base = new class_mysql_base();
$base->sql_connect();
	$sql="SELECT * FROM `mis_hospital` WHERE `id`='".$_GET['id']."'";
	$base->sql_query=$sql;
	$base->sql_execute();
		while($Masuv = mysql_fetch_array($base->sql_result))
	{
		header("Content-type: image/gif");

		echo ($Masuv['photo']);
	}
$base->sql_execute();

?>