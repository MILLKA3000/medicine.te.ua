<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".$_GET['id']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$i = $Mas['id'];
	}
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='city.php?id=".$i."'>".$s."</a></Font>";
$base->sql_close();
include ("menu.php");


echo " <center><div class='lifted'>
		<p><FONT size=8>Виберіть місто лікувального закладу </FONT><br><br><table width=100%><tr><td>";
if($_GET['id']){
$mas_city=$base->Get_city($_GET['id']);
	for ($i=0;$i<50;$i++)
	{
		if($mas_city[$i])
		{
		echo "<Font size=5><a class='text' href='hospital.php?id_city=".$mas_city[$i]['id']."&id_type=".$_GET['id']."' >".$mas_city[$i]['name']."</a><br>";
		}
	}
	
	

}
echo "</td></tr></table>"
?>








