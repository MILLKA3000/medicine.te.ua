<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='new_special.php'>Редагування спеціальностей</a></Font>";
if (!$_SESSION['name_sesion_a'])
	{
		header("Location: my_admin.php");
	}
	else
	//----------------------------------Лікар авторизувався----------------------------------------
	{
include ("admin_menu.php");
if ($_SESSION['role']==3)
	{
echo " <center><b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
		<FONT size=8>Редагування спеціальностей</FONT><br><br><table width=100%><tr><td>";
if(($_GET['id']))
	{	
				$base->sql_connect();
				$base->sql_query="DELETE FROM  `mis`.`mis_guide_speciality` WHERE `mis_guide_speciality`.`id` = '".$_GET['id']."';";
				$base->sql_execute();
				
	}
if(($_POST['name']))
	{	
				$base->sql_connect();
				$base->sql_query="INSERT INTO `mis`.`mis_guide_speciality` (`spec_name` ,`spec_code`,`metod`)VALUES ('".$_POST['name']."' , '".$_POST['spec']."', '".$_POST['metod']."');";
				$base->sql_execute();
				
	}	
echo "<FONT size=4><center>Добавити нову спеціальність</FONT><br><br><table>
<form action='new_special.php' method='post'>
			 <b>
			<tr><td><b>Назва </td><td><input name='name' maxlength='50' size='41' class='input-text' type='text' ></td></tr>
			<tr><td><b>Код </td><td><input name='spec' maxlength='50' size='41' class='input-text' type='text' ></td></tr>
			<tr><td><b>Метод </td><td><select class='text' name='metod'>
		<option value='0'>Спеціаліст лікар</option><option value='1'>Методи обстеження</option></td></tr>
			<tr><td><input type='submit' value='Добавити'></td></tr></table><br><br><br><br>
";
	
echo "<table width=100% id='zapus' border=1><tr>
<td width=50%><FONT size=6 color=blue><center><b>Спеціальності</td><td><FONT>&nbsp</FONT></td></tr>
";
	$i=0;
		$mas_spec = array(array());
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE 1;";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$mas_spec[$i]['id_spec'] = $Mas['id'];
			$mas_spec[$i]['name_spec'] = $Mas['spec_name'];
			$mas_spec[$i]['metod'] = $Mas['metod'];
			$i++;
			}
			
		for ($i=0;$i<count($mas_spec);$i++)
		{
		echo "<tr><td><b>".$mas_spec[$i]['name_spec']."</td>";
		if ($mas_spec[$i]['metod']==0) {echo "<td><b>Лікар спеціаліст</td>";}else if ($mas_spec[$i]['metod']==1) {echo "<td><b>Методи обстежень</td>";}
		echo "<td><a href='new_special.php?id=".$mas_spec[$i]['id_spec']."'><center>  Видалити </td></tr>";
		}
echo "</table>";	
	}
	//-----------------------------------------------якщо незалогінений---------------------------------------
	else 
	{
	header("Location: my_admin.php");
	}
}
echo "</td></tr></table>"
?>








