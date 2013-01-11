<?php
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
  $misjac=date('m');
  $year=date('Y');
   if($_GET['m']){$misjac=$_GET['m'];}
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='one_calendar.php?doctor=".$_GET['doctor']."&m=".($_GET['m'])."'>Графіки</a></Font>";
include "admin_menu.php";
echo "<b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";
//місяць дня

  // Вычисляем число дней в текущем месяце
  $t_start = new DateTime($year."-".$misjac."-01");
 $dayofmonth=$t_start->format('t');
 /* $dayofmonth=date("t",mktime($t_start->format('t'));
  echo $dayofmonth;*/

  //число дня
  $n=date('j');
  
  // Счётчик для дней месяца
  $day_count = 1;

  // 1. Первая неделя
  $num = 0;
  for($i = 0; $i < 7; $i++)
  {
    // Вычисляем номер дня недели для числа
    $dayofweek = date('w',mktime(0, 0, 0, $misjac, $day_count, date('Y')));
    // Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
    $dayofweek = $dayofweek - 1;
    if($dayofweek == -1) $dayofweek = 6;

    if($dayofweek == $i)
    {
      // Если дни недели совпадают,
      // заполняем массив $week
      // числами месяца
      $week[$num][$i] = $day_count;
      $day_count++;
    }
    else
    {
      $week[$num][$i] = "";
    }
  }

  // 2. Последующие недели месяца
  while(true)
  {
    $num++;
    for($i = 0; $i < 7; $i++)
    {
      $week[$num][$i] = $day_count;
      $day_count++;
      // Если достигли конца месяца - выходим
      // из цикла
      if($day_count > $dayofmonth) break;
    }
    // Если достигли конца месяца - выходим
    // из цикла
    if($day_count > $dayofmonth) break;
  }

  // 3. Выводим содержимое массива $week
  // в виде календаря
  // Выводим таблицу
  $arr = array('Понеділок','Вівторок','Середа','Четвер','Пятниця','Субота','Неділя');
	$num_mis = array('Січень','Лютий','Березень','Квітень','Травень','Червень','Липень','Серпень','Вересень','Жовтень','Листопад','Грудень');
		
  echo "<center > <FONT size=8>Редагування календара</FONT><br><br>
		";

  if ($_GET['m']==1){echo "<a href='one_calendar.php?doctor=".$_GET['doctor']."&m=".($_GET['m'])."' ><img src='images/calendar/prev.jpeg'></a>";}
  else {echo "<a href='one_calendar.php?doctor=".$_GET['doctor']."&m=".($_GET['m']-1)."' ><img src='images/calendar/prev.jpeg'></a>";}
  echo "<b><FONT size='14' color='gray'>".$num_mis[$misjac-1]."  </FONT></b>";
  if ($_GET['m']==12){echo "<a href='one_calendar.php?doctor=".$_GET['doctor']."&m=".($_GET['m'])."' ><img src='images/calendar/next.jpeg'></a>";}
  else
  {echo "<a href='one_calendar.php?doctor=".$_GET['doctor']."&m=".($_GET['m']+1)."' ><img src='images/calendar/next.jpeg'></a>";}
  
  
  echo "<div class='ob'><table width=100% background='images/calendar/fon.gif' ><tr>";
 for($j=0;$j<7;$j++)
  {
	echo "<td width=14% class='TD_b' ><b><center>".$arr[$j]."</center></td>";
  }
  echo "</tr>";
  //запрос по лікарю-----------------------------------------
  /**/$kil_cshedule=$base->Get_to_schedule_kil($_GET['doctor']);
  
  /**/$mas_cshedule=$base->Get_to_schedule($_GET['doctor']);
  //---------------------------------------------------------
  for($i = 0; $i < count($week); $i++)
  {
    echo "<tr>";
    for($j = 0; $j < 7; $j++)
    {
      if(!empty($week[$i][$j]))
      {
        // Если имеем дело с субботой и воскресенья
        // подсвечиваем их

		
        if($j == 5 || $j == 6) 
		{	
		if (($week[$i][$j]==$n)&&(date('m')==$misjac)) 
		{
		echo "<td valign='top' height='150' class='TD_b'><div class='circle'><font color=red><center><b>".$week[$i][$j]."</center></div></font>";
		}
		else
		{
         echo "<td valign='top' height='150' class='TD_b'><font color=red><center><b>".$week[$i][$j]."</center></font>";
		}
		for($sch=0;$sch<$kil_cshedule;$sch++)
		{
		if(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]==$week[$i][$j])&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==$misjac))
		{	

			$start=$mas_cshedule[$sch]['timebegin'][0].$mas_cshedule[$sch]['timebegin'][1].$mas_cshedule[$sch]['timebegin'][2].$mas_cshedule[$sch]['timebegin'][3].$mas_cshedule[$sch]['timebegin'][4];
			$end=$mas_cshedule[$sch]['timeend'][0].$mas_cshedule[$sch]['timeend'][1].$mas_cshedule[$sch]['timeend'][2].$mas_cshedule[$sch]['timeend'][3].$mas_cshedule[$sch]['timeend'][4];
			if ((($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$n)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==date('m')))||
			(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]<=$n)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]>date('m'))))
				{
						if ($mas_cshedule[$sch]['patient_id']==1)
						{
							echo "<center><div class='text'><b>".$start." - ".$end."</a><br>";
						}
					else 
						if ($mas_cshedule[$sch]['patient_id']>1)
						{
								
					$base->sql_connect();
					$base->sql_query="SELECT * FROM mis_patient WHERE `id` ='".$mas_cshedule[$sch]['patient_id']."'";
					$base->sql_execute();
					while($Mas = mysql_fetch_array($base->sql_result))
					{
						$p['family'] = $Mas['family'];
						$p['name'] = $Mas['name'];
						$p['third_name'] = $Mas['third_name'];
					}
							
							echo "<center><div class='text'><b><font color=red>".$p['family']." ".$p['name'][0]." ".$p['third_name'][0]."</font><br>";
						}
				}
				
		}
		}
		echo "</div></div></td>";
		}
		//Інші дні
        else 
		{	if (($week[$i][$j]==$n)&&(date('m')==$misjac)) 
		{
		echo "<td valign='top' height='150' class='TD_b'><div class='circle'><center><b>".$week[$i][$j]."</b></center></div>";
		}
			else
			{
			echo "<td valign='top' height='150' class='TD_b'><center><b>".$week[$i][$j]."</center>";
			}
		for($sch=0;$sch<$kil_cshedule;$sch++)
		{
		if(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]==$week[$i][$j])&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==$misjac))
		{	

			$start=$mas_cshedule[$sch]['timebegin'][0].$mas_cshedule[$sch]['timebegin'][1].$mas_cshedule[$sch]['timebegin'][2].$mas_cshedule[$sch]['timebegin'][3].$mas_cshedule[$sch]['timebegin'][4];
			$end=$mas_cshedule[$sch]['timeend'][0].$mas_cshedule[$sch]['timeend'][1].$mas_cshedule[$sch]['timeend'][2].$mas_cshedule[$sch]['timeend'][3].$mas_cshedule[$sch]['timeend'][4];
				if ((($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$n)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==date('m')))||
			(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]<=$n)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]>date('m'))))
				{
				if ($mas_cshedule[$sch]['patient_id']==1)
					{
					
					echo "<center><div class='text'><b>".$start." - ".$end."</a><br>";
					}
				else 
					if ($mas_cshedule[$sch]['patient_id']>1)
						{
						
					$base->sql_connect();
					$base->sql_query="SELECT * FROM mis_patient WHERE `id` ='".$mas_cshedule[$sch]['patient_id']."'";
					$base->sql_execute();
					while($Mas = mysql_fetch_array($base->sql_result))
					{
						$p['family'] = $Mas['family'];
						$p['name'] = $Mas['name'];
						$p['third_name'] = $Mas['third_name'];
					}
					
						echo "<center><div class='text'><b><font color=red>".$p['family']." ".$p['name'][0]." ".$p['third_name'][0]."</font><br>";
						}
				}
				
		}
		}
		echo "</div></td>";
		}
      }
      else echo "<td class='TD_b'>&nbsp;</td>";
    }
    echo "</tr>";
  } 
  echo "</table></p></div>";
?>
