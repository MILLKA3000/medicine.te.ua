
<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
if (($_POST['login'])&&($_POST['pass']))
		{
		$password=crypt(md5($_POST['login']), md5($_POST['pass']));
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_physician` WHERE `username` ='".$_POST['login']."' AND `password` ='".$password."'";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_admin = $Mas['id'];
			$id_admin_family = $Mas['family'];
			$id_admin_name = $Mas['name'];
			$id_admin_first_name = $Mas['third_name'];
			}	
		if ($id_admin!='')
		{
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_physican_in_hospital` WHERE `id_physician` ='".$id_admin."';";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_num = $Mas['id'];
			$id_likarnja = $Mas['id_hospital'];
			$id_spec = $Mas['id_speciality'];
			}	
		
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE `id` ='".$id_spec."';";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_role = $Mas['role'];
			}	
		
		session_start();
		$_SESSION['name_sesion_a'] = $id_admin;
		$_SESSION['family_a'] = $id_admin_family;
		$_SESSION['name_a'] = $id_admin_name;
		$_SESSION['first_name_a'] = $id_admin_first_name;
		$_SESSION['likarnja'] = $id_likarnja;
		$_SESSION['spec'] = $id_spec;
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['role'] = $id_role;
		$_SESSION['num'] = $id_num;


	/*$date_today = date("m-d-Y"); //��������� 03.12.01
	$today[1] = date("H:i:s"); //�������� 1 �������� ������� 17:16:17
	$date_in="���: ".$today[1]." � ����: ".$date_today;
		$sql = "INSERT INTO `mis`.`mis_logs` (`id_acount` ,`date` ,`action` ,`adress`) VALUES ('".$_SESSION['name_sesion_a']."', '".$date_in."', '�������������', 'www.".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']."');";
$base->ins($sql);*/
		$base->logs("�������������");
		}
		
		}
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>�������</a> -> <a href='my_admin.php'>��������</a></Font>";
include ("menu.php");


//----------------------------------�������� �����������----------------------------------------

	//----------------------------------����� �����������----------------------------------------
	if (!$_SESSION['name_sesion_a'])
	{
		echo "

		
		
		
		<center>
		<div class='lifted'><p>
		<center> <FONT size=8>���� ��� ���������</FONT><br><br>
		<div class='auth-form'> <h3><b> ������������� <br><br><br> <table width=100%> <form action='my_admin.php' method='post' > <b>
			<tr><td width=25% ><b style='float:right;'>������ ���� <span class='jQtooltip mini' title='������� ����� �������� �� �����'>!</span></td><td><input name='login' maxlength='50' size='41' class='input-text' type='text' id='all'></td></tr>
			<tr><td width=25%><b style='float:right;'>������ ������ <span class='jQtooltip mini' title='������� ����� �������� �� �����'>!</span></td><td><input name='pass' maxlength='50' size='41' class='input-text' type='password' id='all2'></td></tr>
			<tr><td></td><td><input style='float:center;' type='submit' value='����'></td></tr></table></form></div></div>";
	}
	else
	//----------------------------------˳��� �������������----------------------------------------
	{
	
	include ("admin_menu.php");
	
	echo "<b style='float:right'>�� ������ �� ��'�� ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
	<center> <FONT size=8>������������� ������</FONT><br><br></center>
<div style='margin-left:100px;'>
	<b><font color='green'>Version  1.16 (13.12.2012) </font></b><br>
		���������: <br>
	-	��������� ��������� ������� �� ����� ��.<br>
	-	�������� ��������� �� �����. <br><br>
	<b><font color='green'>Version  1.15 (08.11.2012) </font></b><br>
	����������:<br>
	-	��������� ������� � ����� ����� MS Excel<br>
	-	��� ���������� ���� � ������� � �����, �� ������ ����� ������� ��� �������� ����.<br>
</div>
	";
	
	
	}	
echo "";
?>