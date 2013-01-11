

<?php

include "header.php";
require_once "Class/mysql-class.php";
?>
<script type="text/javascript" src="script/jquery.tcollapse.js"></script>
<?
$base = new class_mysql_base();
//------------------------------------------------------------------------------------------------------------------------------------
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".$_GET['id_type']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$i = $Mas['id'];
	}
	
$base->sql_query="SELECT * FROM mis_hospital WHERE `id` ='".$_GET['id_hosp']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$hosp = $Mas['title'];
		$id_hosp = $Mas['id'];
	}	
	
$base->sql_query="SELECT mis_physican_in_hospital.otpusk,mis_guide_physician.photo,mis_physican_in_hospital.date_otpusk,mis_physican_in_hospital.start_date_otpusk,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,mis_guide_speciality.spec_name,mis_guide_speciality.id 
FROM mis_guide_physician,mis_guide_speciality,mis_physican_in_hospital 
WHERE mis_physican_in_hospital.id_physician=mis_guide_physician.id 
AND mis_physican_in_hospital.id_speciality=mis_guide_speciality.id 
AND mis_physican_in_hospital.id='".$_GET['num']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$name = $Mas['name'];
		$family = $Mas['family'];
		$third_name = $Mas['third_name'];
		$name_spec = $Mas['spec_name'];
		$id_spec = $Mas['id'];
		$affibiation = $Mas['affibiation'];
		$photo=$Mas['photo'];
		$otpusk=$Mas['otpusk'];
		$date_otpusk=$Mas['date_otpusk'];
		$start_date_otpusk=$Mas['start_date_otpusk'];
	}	

echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='hospital.php?id_type=".$_GET['id_type']."'>".$s."</a>
 -> <a href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."'>".$hosp."</a>
 -> <a href='physician.php?id_type=".$_GET['id_type']."&id_hosp=".$id_hosp."&id_spec=".$id_spec."'>".$name_spec."</a>
  -> <a href='calendar.php?num=".$_GET['num']."&m=".$_GET['m']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."' >".$family." ".$name[0].".".$third_name[0].".</a></Font>";
$base->sql_close();
//------------------------------------------------------------------------------------------------------------------------------------
include "menu.php";

//місяць дня
  $misjac=date('m');
  if ($_GET['year']){$year=$_GET['year'];}else{$year=date('Y');$_GET['year']=$year;}
   if(($_GET['m']!='') && ($_GET['m']<=12) && ($_GET['m']>0) && ((int)$_GET['m'])){$misjac=$_GET['m'];}
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
    $dayofweek = date('w',mktime(0, 0, 0, $misjac, $day_count, $year));
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
		
  echo "<center ><div class='lifted'>
		<p> <FONT size=8>Крок №4: Виберіть дату та час </FONT><br><br>
		";
		if ($photo){
  echo "<img width=150px  style='float:left;margin-right:26px;margin-left:26px;' src='script_img/image_doctor.php?num=".$_GET['num']."'>";
  }else echo "<img width=150px height=150px style='float:left;margin-right:26px;margin-left:26px;' src='images/spec/nophoto.png'>";

  echo"
		<table align=left><tr>
		<td><Font size=5>".$family." ".$name." ".$third_name."</td>
		</tr><tr>
		<td><Font size=5>".$name_spec."</td>
		</tr><tr>
		<td><Font size=5>".$affibiation."</td>
		</tr><tr>
		<td><Font size=5>".$hosp."</td>
		</tr></table>
		<br><br><br><br><br><br><br><br>
		";
		
  if ($_GET['m']==0){$_GET['m']=12;$_GET['year']=$_GET['year']-1;echo "<a href='calendar.php?year=".($_GET['year'])."&num=".$_GET['num']."&m=".($_GET['m'])."&id_city=".$_GET['id_city']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."' ><img src='images/calendar/prev.jpeg'></a>";}
  else {echo "<a href='calendar.php?year=".($_GET['year'])."&num=".$_GET['num']."&m=".($_GET['m']-1)."&id_city=".$_GET['id_city']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."' ><img src='images/calendar/prev.jpeg'></a>";}
  echo "<b><FONT size='14' color='gray'>".$num_mis[$misjac-1]."  </FONT></b>";
  if ($_GET['m']==12){$_GET['m']=1;$_GET['year']=$_GET['year']+1;echo "<a href='calendar.php?year=".($_GET['year'])."&num=".$_GET['num']."&m=".($_GET['m'])."&id_city=".$_GET['id_city']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."' ><img src='images/calendar/next.jpeg'></a>";}
  else
  {echo "<a href='calendar.php?year=".($_GET['year'])."&num=".$_GET['num']."&m=".($_GET['m']+1)."&id_city=".$_GET['id_city']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."' ><img src='images/calendar/next.jpeg'></a>";}
  
  
  echo "<div class='ob'>  <table  width=100% background='images/calendar/fon.gif' id='table0' ><tr>";
 for($j=0;$j<7;$j++)
  {
	echo "<td width=14% class='TD_b' ><b><center>".$arr[$j]."</center></td>";
  }
  echo "</tr>";
  //запрос по лікарю-----------------------------------------
  /**/$kil_cshedule=$base->Get_to_schedule_kil($_GET['num']);
  
  /**/$mas_cshedule=$base->Get_to_schedule($_GET['num']);
  //---------------------------------------------------------
  for($i = 0; $i < count($week); $i++)
  {
    echo "<tbody><tr>";
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
		echo "<td valign='top'  class='TD_b'><div class='circle'><font color=red><center><b>".$week[$i][$j]."</center></div></font>";
		}
		else
		{
         echo "<td valign='top'  class='TD_b'><font color=red><center><b>".$week[$i][$j]."</center></font>";
		}
			
		for($sch=0;$sch<$kil_cshedule;$sch++)
		{
		if(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]==$week[$i][$j])&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==$misjac))
		{	

			$start=$mas_cshedule[$sch]['timebegin'][0].$mas_cshedule[$sch]['timebegin'][1].$mas_cshedule[$sch]['timebegin'][2].$mas_cshedule[$sch]['timebegin'][3].$mas_cshedule[$sch]['timebegin'][4];
			$end=$mas_cshedule[$sch]['timeend'][0].$mas_cshedule[$sch]['timeend'][1].$mas_cshedule[$sch]['timeend'][2].$mas_cshedule[$sch]['timeend'][3].$mas_cshedule[$sch]['timeend'][4];
			if (($otpusk==1)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6].$mas_cshedule[$sch]['date'][7].$mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]<=$date_otpusk[5].$date_otpusk[6].$date_otpusk[7].$date_otpusk[8].$date_otpusk[9])&&
				//($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6].$mas_cshedule[$sch]['date'][7].$mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$start_date_otpusk[5].$start_date_otpusk[6].$start_date_otpusk[7].$start_date_otpusk[8].$start_date_otpusk[9])){echo "<center><div class='text'><b><font color=red>Відпустка до ".$date_otpusk[8].$date_otpusk[9]." ".$num_mis[($date_otpusk[5].$date_otpusk[6])-1]."</font><br>";break;}else{
				($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6].$mas_cshedule[$sch]['date'][7].$mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$start_date_otpusk[5].$start_date_otpusk[6].$start_date_otpusk[7].$start_date_otpusk[8].$start_date_otpusk[9])){echo "<center><div class='text'><b><font color=red>Тимчасово відсутній</font><br>";break;}else{
			
			if ((($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$n)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==date('m')))||
			(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]<=$dayofmonth)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]>date('m'))))
				{
				
						if ($mas_cshedule[$sch]['patient_id']==1)
						{
							echo "<center><div class='text'><font color='lime'><a href='new_patient.php?time=".$mas_cshedule[$sch]['id']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'>".$start." - ".$end."</a><br>";
						}
					else 
						if ($mas_cshedule[$sch]['patient_id']>1)
						{
							echo "<center><div class='text'><b><font color=red>Занято</font><br>";
						}
				}
				else echo "<center><div class='text'><b><font color=red> ".$start." - ".$end." </font><br>";}
		}
		}
		echo "</div></div></td>";
		}
		//Інші дні
        else 
		{	if (($week[$i][$j]==$n)&&(date('m')==$misjac)) 
		{
		echo "<td valign='top'  class='TD_b'><div class='circle'><center><b>".$week[$i][$j]."</b></center></div>";
		}
			else
			{
			echo "<td valign='top'  class='TD_b'><center><b>".$week[$i][$j]."</center>";
			}
		for($sch=0;$sch<$kil_cshedule;$sch++)
		{
		//echo $mas_cshedule[$sch]['date'][0].$mas_cshedule[$sch]['date'][1].$mas_cshedule[$sch]['date'][2].$mas_cshedule[$sch]['date'][3];		
		
		if(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]==$week[$i][$j])&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==$misjac)&&(($mas_cshedule[$sch]['date'][0].$mas_cshedule[$sch]['date'][1].$mas_cshedule[$sch]['date'][2].$mas_cshedule[$sch]['date'][3]==$year)))
		{	
// 
			$start=$mas_cshedule[$sch]['timebegin'][0].$mas_cshedule[$sch]['timebegin'][1].$mas_cshedule[$sch]['timebegin'][2].$mas_cshedule[$sch]['timebegin'][3].$mas_cshedule[$sch]['timebegin'][4];
			$end=$mas_cshedule[$sch]['timeend'][0].$mas_cshedule[$sch]['timeend'][1].$mas_cshedule[$sch]['timeend'][2].$mas_cshedule[$sch]['timeend'][3].$mas_cshedule[$sch]['timeend'][4];
				if (($otpusk==1)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6].$mas_cshedule[$sch]['date'][7].$mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]<=$date_otpusk[5].$date_otpusk[6].$date_otpusk[7].$date_otpusk[8].$date_otpusk[9])&&
				//($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6].$mas_cshedule[$sch]['date'][7].$mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$start_date_otpusk[5].$start_date_otpusk[6].$start_date_otpusk[7].$start_date_otpusk[8].$start_date_otpusk[9])){echo "<center><div class='text'><b><font color=red>Відпустка до ".$date_otpusk[8].$date_otpusk[9]." ".$num_mis[($date_otpusk[5].$date_otpusk[6])-1]."</font><br>";break;}else{
				($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6].$mas_cshedule[$sch]['date'][7].$mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$start_date_otpusk[5].$start_date_otpusk[6].$start_date_otpusk[7].$start_date_otpusk[8].$start_date_otpusk[9])){echo "<center><div class='text'><b><font color=red>Тимчасово відсутній</font><br>";break;}else{
				//echo 	$mas_cshedule[$sch]['date']." ".$start_date_otpusk." ".$date_otpusk;
				if ((($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]>=$n)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]==date('m')))||
			(($mas_cshedule[$sch]['date'][8].$mas_cshedule[$sch]['date'][9]<=$dayofmonth)&&($mas_cshedule[$sch]['date'][5].$mas_cshedule[$sch]['date'][6]>date('m')))||
			($mas_cshedule[$sch]['date'][0].$mas_cshedule[$sch]['date'][1].$mas_cshedule[$sch]['date'][2].$mas_cshedule[$sch]['date'][3]>date('Y')))
				{
				if ($mas_cshedule[$sch]['patient_id']==1)
					{
					echo "<center><div class='text'><b><a href='new_patient.php?time=".$mas_cshedule[$sch]['id']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'>".$start." - ".$end."</a><br>";
					}
				else 
					if ($mas_cshedule[$sch]['patient_id']>1)
						{
						echo "<center><div class='text'><b><font color=red>Занято</font><br>";
						}
				}
				else echo "<center><div class='text'><b><font color=red> ".$start." - ".$end." </font><br>";}
		}
		}
		echo "</div></td>";
		}
      }
      else echo "<td class='TD_b'>&nbsp;</td>";
    }
    echo "</tr></tbody>";
  } 
  echo "</table></p></div>";
?>
<a href="#" class="uncollapse">Розгорнути календар</a>
<a href="#" class="collapse">Згорнути календар</a>


		 <script type="text/javascript">
            $().ready(
            function() {
                //$('#table0').tCollapse();
                $('.uncollapse').click(
            function(){
                    $('#table0').removeCollapse();
                    return false;
                }
            );
                $('.collapse').click(
                function(){
                    $('#table0').tCollapse();
                    return false;
                }
            );
            }
        );
        </script>
