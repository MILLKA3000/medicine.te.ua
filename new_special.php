<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>�������</a> -> <a href='my_admin.php'>��������</a> -> <a href='new_special.php'>����������� ��������������</a></Font>";
if (!$_SESSION['name_sesion_a'])
	{
		header("Location: my_admin.php");
	}
	else
	//----------------------------------˳��� �������������----------------------------------------
	{
include ("admin_menu.php");
if ($_SESSION['role']==3)
	{
echo " <center><b style='float:right'>�� ������ �� ��'�� ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
		<FONT size=8>����������� ��������������</FONT><br><br><table width=100%><tr><td>";
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
echo "<FONT size=4><center>�������� ���� ������������</FONT><br><br><table>
<form action='new_special.php' method='post'>
			 <b>
			<tr><td><b>����� </td><td><input name='name' maxlength='50' size='41' class='input-text' type='text' ></td></tr>
			<tr><td><b>��� </td><td><input name='spec' maxlength='50' size='41' class='input-text' type='text' ></td></tr>
			<tr><td><b>����� </td><td><select class='text' name='metod'>
		<option value='0'>��������� ����</option><option value='1'>������ ����������</option></td></tr>
			<tr><td><input type='submit' value='��������'></td></tr></table><br><br><br><br>
";
	
echo "<table width=100% id='zapus' border=1><tr>
<td width=50%><FONT size=6 color=blue><center><b>������������</td><td><FONT>&nbsp</FONT></td></tr>
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
		if ($mas_spec[$i]['metod']==0) {echo "<td><b>˳��� ���������</td>";}else if ($mas_spec[$i]['metod']==1) {echo "<td><b>������ ���������</td>";}
		echo "<td><a href='new_special.php?id=".$mas_spec[$i]['id_spec']."'><center>  �������� </td></tr>";
		}
echo "</table>";	
	}
	//-----------------------------------------------���� ������������---------------------------------------
	else 
	{
	header("Location: my_admin.php");
	}
}
echo "</td></tr></table>"
?>








