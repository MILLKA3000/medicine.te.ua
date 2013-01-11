<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();

include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='reg_graf.php?doctor=".$_GET['doctor']."'>Редагування графіка</a></Font>";
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
	
	if($_GET['id']>"0")
	{	
				$base->sql_connect();
	            $base->sql_query="select file_path FROM `mis`.`mis_working_time_log` WHERE `mis_working_time_log`.`id` = '".$_GET['id']."';";
				$base->sql_execute();
                while($Mas = mysql_fetch_array($base->sql_result))
					{
				unlink($Mas['file_path']);	   
                    }
				$base->sql_query="DELETE FROM  `mis`.`mis_working_time_log` WHERE `mis_working_time_log`.`id` = '".$_GET['id']."' AND `mis_working_time_log`.`id_physician` = '".$_SESSION['name_sesion_a']."';";
				$base->sql_execute();
				$base->sql_query="SELECT id_timetable FROM `mis`.`mis_schedule` WHERE `mis_schedule`.`id_log` = '".$_GET['id']."';";
				$base->sql_execute();
				//-------------------------------------
				while($Mas = mysql_fetch_array($base->sql_result))
					{
					$result=$Mas['id_timetable'];
					}

				$base->sql_query="DELETE FROM `mis`.`mis_schedule` WHERE `mis_schedule`.`id_log` = '".$_GET['id']."';";
				$base->sql_execute();
				
				$base->sql_query="DELETE FROM `mis`.`mis_working_time` WHERE `id` = '".$result."';";
				$base->sql_execute();
                
	}
	
	echo "<b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";
	
				$base->sql_connect();
				$base->sql_query="SELECT * FROM mis_working_time_log WHERE id_physician = '".$_SESSION['name_sesion_a']."'";
				$base->sql_execute();
	echo "<table id='zapus' width=100% cellspacing=0><tr><td><FONT size=4 color=blue>Закинутий Вами</FONT></td><td><FONT></FONT></td></tr>";
	while($Mas = mysql_fetch_array($base->sql_result))
					{
		   if ($Mas['note']){
			echo "<tr><td>".$Mas['upload_schedule']."</td><td>".$Mas['note']." <a href='".$Mas['file_path']."'> Скачати </a></td><td><a href='reg_graf.php?id=".$Mas['id']."'> Видалити </a></td></tr>";
            }else
            echo "<tr><td>".$Mas['upload_schedule']."</td><td></td><td><a href='reg_graf.php?id=".$Mas['id']."'> Видалити </a></td></tr>";		
					}
		echo "</table>";
	}	
echo "";
?>