<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".$_GET['id_type']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$i = $Mas['id'];
	}

echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> </Font>";
$base->sql_close();

include ("menu.php");

echo " <center><div class='lifted'><table width=100%><tr><td>";

include ("info/".$_GET['info']."");
echo "</table>"
?>








