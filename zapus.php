<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();

include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='my_profile.php?doctor=".$_GET['doctor']."'>Мій профіль</a></Font>";
include ("menu.php");


//----------------------------------Перевірка авторизації----------------------------------------

	//----------------------------------Форма авторизації----------------------------------------
	if (!$_SESSION['name_sesion_a'])
	{
		header("Location: my_admin.php");
	}
	else
	//----------------------------------Лікар авторизувався----------------------------------------
	{
	
	include ("admin_menu.php");
	echo "<b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";
	
if($_POST['log'])
{
	echo "<table border=1 width=100%>";
	$base->sql_connect();
	$base->sql_query="SELECT * FROM `mis_patient` WHERE `phone1` ='".$_POST['log']."' OR `phone2` ='".$_POST['log']."'";
	$base->sql_execute();
	while($Mas = mysql_fetch_array($base->sql_result))
	{
		$id_patient = $Mas['id'];
	echo "<tr><td><Font size=4>".$Mas['family']." ".$Mas['name']." ".$Mas['third_name']."<a style='float:right;' href='zapus.php?patient=".$_GET['patient']."&zapus=ok&id_patient=".$id_patient."'>Записати цього паціента</a></td></tr>";
	}
	
}	
if($_GET['zapus']=='ok')
{
$base->upd_scedule($_GET['patient'],$_GET['id_patient']);
}	
if($_GET['patient'])
{
	
	echo"		
	<form action='zapus.php?patient=".$_GET['patient']."' method='post'>
	<b><center><br><br>Введіть телефон паціента<input name='log' maxlength='50' size='41' class='input-text' type='text'><br>
	<input type='submit' value='Знайти'>";
	
	
}
else



	
if($_GET['id_sp']){	
    
        $base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE `id` ='".$_GET['id_sp']."';";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$name['name'] = $Mas['spec_name'];
			}
		  
echo "<table width=100% cellspacing=3 id='t'><tr>
<td width=25%><FONT size=6 color=blue ><center><b>Метод обстеженя - (".$name['name'].")</td>
</tr>";

echo "<table width=100% id='old'><tr><td style='border-bottom: 1px solid #666' width=30%><center><FONT size=5 color=blue><b>Прізвище імя по-батькові</td></tr>";

		if($_GET['id_sp']!="")
		{
		$mas_doctor=$base->Get_doctor_spec($_SESSION['likarnja'],$_GET['id_sp']);
		
			for ($j=0;$j<100;$j++)
			{
				if($mas_doctor[$j])
				{
					echo "<tr><td class='TD_b' width=40%><Font size=5><a class='text' style='display: block; width=100%' href='zap_calendar.php?doctor=".$mas_doctor[$j]['id']."&m=".date('m')."' >".$mas_doctor[$j]['family']." ".$mas_doctor[$j]['name']." ".$mas_doctor[$j]['third_name']." </a></td>
							
					";
				}
			}
		echo "";
		}

echo "</table>";	
	
	
	
}
else	
if(!$_GET['id_sp']){	
$mas_spec=$base->Get_spec($_SESSION['likarnja']);	
$e=0;
for ($i=0;$i<count($mas_spec);$i++)
	{
		if($mas_spec[$i]['metod']=='1')
		{
		$e++;
		}
	}
if ($e>0){
echo "<table width=100% cellspacing=3 id='t'><tr>
<td width=25%><FONT size=6 color=blue><center><b>Методи обстежень</td>
</tr>";}
	for ($i=0;$i<count($mas_spec);$i++)
	{
		if($mas_spec[$i]['metod']=='1')
		{
		
		$mas_doctor=$base->Get_doctor_spec($_SESSION['likarnja'],$mas_spec[$i]['id']);
		for ($j=0;$j<4;$j++)
		{
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE `id` ='".$mas_spec[$i+$j]['id']."';";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$id_role[$j] = $Mas['role'];
			}
		}
		echo "<tr>";
		for ($j=0;$j<4;$j++)
		{
		if (($id_role[$j]==1) && ($mas_spec[$i+$j]['id']) && ($mas_spec[$i+$j]['metod']==1))
							{
		echo "<td style='border: 1px solid #666' width=25%><Font size=5><center><a class='text' style='display: block; width=100%' href='zapus.php?id_sp=".$mas_spec[$i+$j]['id']."'><br>".$mas_spec[$i+$j]['name']."<br><br></a></font></td>";
							}
							
		}

		echo "</tr>";
		$i=$i+3;
		}
	}
	//}
echo "</table>";	}
	
	}	
echo "";
?>