<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='new_special.php'>Редагування лікарів</a></Font>";
include "admin_menu.php";
if ($_SESSION['role']>1)
	{
echo " <b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
<center><FONT size=8>Редагування вулиць </FONT><br><br><table width=100% ><tr><td>";

if ($_SESSION['role']==3)
	{
	if ($_POST['new_name_street'])
		{

			$sql = "INSERT INTO `mis`.`mis_street` (`name_street`) VALUES ('".$_POST['new_name_street']."');";
			$base->ins($sql);

	    }
	if ($_GET['id']!='')
		{
			$sql = "DELETE FROM `mis`.`mis_street` WHERE id='".$_GET['id']."';";
			$base->ins($sql);
		}
$street_name=$base-> select_street_name("SELECT * FROM `mis`.`mis_street` Where 1 ORDER BY name_street ASC;");	

		echo"	<form action='new_street.php' method='post' enctype='multipart/form-data'>
		<table align=left>
		<tr><td>Введіть нову вулицю</td><td><input name='new_name_street' maxlength='50' size='41' class='input-text' type='text' ></tr>
		<tr><td><input type='submit' name='put' value='Додати'></td></tr></table>
		<br><br><br><br><br>
		";
	
	

echo "</table><br><br><table align=center id='zapus' width=100%>";
	for ($i=0;$i<count($street_name);$i++)
	{
	if ($street_name[0]['id']){
		$street=$base->select_street("SELECT * FROM `mis`.`mis_street_old` WHERE id_street='".$street_name[$i]['id']."';");	
	echo "<tr><td>".$street_name[$i]['name_street']."</td><td>";
	if  ($street[0]['id']!=0){echo"<font color='red'><center><b>X</b></font>";}
	else {echo"<center><a href='new_street.php?id=".$street_name[$i]['id']."'>Видалити</a>";}
	echo"</td></tr>";
	}	}
echo "</table>";	


//-----------------------------------------------якщо незалогінений---------------------------------------
}}
	else 
	{
	header("Location: my_admin.php");
	}
echo "</td></tr></table>";



 
?>








