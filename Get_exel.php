<?php
include "header.php";
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='Get_exel.php'>Робота з графіками</a></Font>";
include "admin_menu.php";
echo "<b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>";

$num_mis = array('Січень','Лютий','Березень','Квітень','Травень','Червень','Липень','Серпень','Вересень','Жовтень','Листопад','Грудень');
$mas_doctor=$base->Get_doctor($_SESSION['likarnja']);
$date_m = date("m");
$year=date("Y");
	echo "<center>
	 <FONT size=8>Робота з графіками</FONT><br> <FONT color='blue'> Виберіть місяць за який вам потрібно отримати шаблон </font>
		<form action='1.php' method='post' enctype='multipart/form-data'>
		
		<select class='text' name='year'>";
		for ($mis=2012;$mis<2026;$mis++)
		{
		if ($mis==$year) {echo "<option value='".($mis)."' SELECTED>".$mis."</option>";}
        else {
		echo "<option value='".($mis)."'>".$mis."</option>";}
		}
		echo "</select>
		
		<select class='text' name='mis'>";
		for ($mis=0;$mis<12;$mis++)
		{
		if ($mis+1==$date_m) {echo "<option value='".($mis+1)."' SELECTED>".$num_mis[$mis]."</option>";}
        else {
		echo "<option value='".($mis+1)."'>".$num_mis[$mis]."</option>";}
		}
		echo "</select>
		<select class='text' name='likarnya'>
		<option value='0'>----------------Всі лікарі-----------------</option>";
		for ($mis=0;$mis<count($mas_doctor);$mis++)
		{
		echo "<option value='".$mas_doctor[$mis]['id']."'>".$mas_doctor[$mis]['family']." ".$mas_doctor[$mis]['name']." ".$mas_doctor[$mis]['third_name']."(".$mas_doctor[$mis]['spec_name'].")</option>";
		}
		echo "<input type='submit' value='Отримати шаблон для заповнення графіка'>
		</form>
	<br><br><br>";    
	
?>	
	
	<center><FONT color='blue'><b>Завантаження таблиці роботи лікарів</b></FONT></center>
	  <form action="Get_exel.php" method="post" enctype="multipart/form-data">
      <input type="file" name="filename"  value="Огляд">
      <input type="submit" value="Завантажити файл"><br>
	</div>
	<center>
<? 
//echo $_FILES["filename"]["type"];
 $allowed = array('application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         if ((!in_array($_FILES["filename"]["type"], $allowed))) {
		 echo "<FONT COLOR=red><B>Файл не підтримується</B></FONT>";
         } else { 

//Перенесення файлу в папку на сервері
if (isset($_FILES["filename"]["tmp_name"])) {
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
    move_uploaded_file($_FILES["filename"]["tmp_name"], "sheets/".date("i-s").$_FILES["filename"]["name"]);

	$base->logs("Закинув графік (".$_FILES["filename"]["name"].")");
	
//Підключення класу для читання  
include_once("Class/class reader.php");
include_once("Class/func-date.php");
require_once "Class/mysql-class.php";
if ($_GET['active']){echo "<script type='text/javascript'> var active=true; </script>";}

$data = new XLSToDB(date("i-s").$_FILES["filename"]["name"], 'CP1251');

$fileXLS=date("i-s").$_FILES["filename"]["name"];

$links="sheets/".date("i-s").$_FILES["filename"]["name"];
$base = new class_mysql_base();

echo "<br>";


	//Визначаєм кількість листів
	$num=$data->getshet($fileXLS)-1;
	$err=0;
	//Шапка
	echo"<table border=1>";
	$myArr=array("Код Лікаря","Прізвище","Імя","По-батькові","Код спеціальності","Дата прийому","Час початку","Час кінця","Кількість часу","Кількість паціентів","Кабінет","Часовий інтервал");
	for ($i=0;$i<=11;$i++){echo "<td valign=top class='text'><center>&nbsp;".$myArr[$i]."</td>";}
	//Вивід лікарів
	
	//---------------------------Перевірка на помилки парсінгу-------------------------------	
	/**/for ($j=0;$j<=$num;$j++)
	/**/{
	/**/$variantArray=$data->get($fileXLS,$j);
	/**/
	/**/
	/**/foreach ($variantArray as $key=>$mas)
	/**/	{
	/**/	if(($mas[5]==""))
	/**/			{
	/**/			$err++;
	/**/			echo "<FONT color='red'>Виявленно помилку у лікаря <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> у спеціяльності <b>".$mas[4]."</b> формат <b>".$mas[5]."</b> дати неправельний!<br></FONT>";
					break;
	/**/			}
			if(($mas[5][0].$mas[5][1]>'31')||($mas[5][3].$mas[5][4]>'12'))
					{
					$err++;
					echo "<FONT color='red'>Виявленно помилку у лікаря <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> у спеціяльності <b>".$mas[4]."</b> Дата <b>".$mas[5]."</b> недійсна <br></FONT>";
	/**/			break;
			}
			if(($mas[6][0].$mas[6][1]>24)||($mas[6][3].$mas[6][4]>59)||($mas[6][2]!=':'))
					{
					$err++;
					echo "<FONT color='red'>Виявленно помилку у лікаря <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> у спеціяльності <b>".$mas[4]."</b> час <b>".$mas[6]."</b> недійсний <br></FONT>";
				break;
			}
		
			if(($mas[7][0].$mas[7][1]>24)||($mas[7][3].$mas[7][4]>59)||($mas[7][2]!=':'))
					{
					$err++;
					echo "<FONT color='red'>Виявленно помилку у лікаря <b>".$mas[1]." ".$mas[2]." ".$mas[3]."</b> у спеціяльності <b>".$mas[4]."</b> час <b>".$mas[7]."</b> недійсний <br></FONT>";
				break;
			}
	/**/	}
		if($err>0)break;
	/**/	
	/**/}				
	//--------------------------------------------------------------------------------------
	if ($err==0)
				{
	$base->sql_connect();
				$sql="INSERT INTO `mis`.`mis_working_time_log` (`id_physician`,`upload_schedule`,`note`,`file_path`)VALUES ('".$_SESSION['name_sesion_a']."', '".date("Y-m-d H:i:s")."', '".$_FILES["filename"]["name"]."','".$links."')";
				$base->sql_query=$sql;
				$base->sql_execute();
				$last_id_log=mysql_insert_id();
	
	for ($j=0;$j<=$num;$j++)
	{
	$variantArray=$data->get($fileXLS,$j);
		
	foreach ($variantArray as $key=>$mas)
		{
		echo "<tr>";
		
			//Получаєм різницю часу для лікаря
			$rizn_hour=Parse_time($mas[6],$mas[7]);
			//Получаєм час для одного паціента
			$time_patient=floor($rizn_hour/$mas[8]);

			echo "<td><center>".$mas[0]."<br>";
			echo "<td><center>".$mas[1]."<br>";
			echo "<td><center>".$mas[2]."<br>";
			echo "<td><center>".$mas[3]."<br>";
			echo "<td><center>".$mas[4]."<br>";
			echo "<td><center>".Parse_date($mas[5])."<br>";
			echo "<td><center>".$mas[6]."<br>";
			echo "<td><center>".$mas[7]."<br>";
			echo "<td><center>".$rizn_hour." min/".$time_patient;
			echo "<td><center>".$mas[8]."<br>";
			echo "<td><center>".$mas[9]."<br>";
			
			if ($err==0)
				{
					
				
				//-----------------------------------------------------------------------------
				//-----------------якщо нема помилок то записуєм в БД--------------------------
				
				//-------Таблиця mis_working_time----------------------------------------------
				$last_id=$base->Put_workin_time($mas[0],Parse_date($mas[5]),$mas[6],$mas[7],$mas[8],$mas[9]);
				
				
				
				//--------------------------------------обробка часових інтервалів для лікаря---------------------------------
					echo "<td><center>";
			
					//Получаєм обєкт поточного часу
					//-------------------------------------
					$t_start = new DateTime($mas[6]);
					//-------------------------------------
			
					for ($i=0;$i<$mas[8];$i++)
						{
						//обраховуєм доступний час для кількості паціентів
						$time_start_out=date("G-i",mktime($t_start->format('G'), $t_start->format('i')+$time_patient*$i)); 
						$time_end_out=date("G-i",mktime($t_start->format('G'), $t_start->format('i')+$time_patient*($i+1))); 
						echo "<a href=''>".$time_start_out." - ".$time_end_out."</a><br>";
						//-------Таблиця mis_shedule---------------------------------------------------
						//Парсінг часу

						if ($time_start_out[1]!="-"){
						$parse_time_start=$time_start_out[0].$time_start_out[1].":".$time_start_out[3].$time_start_out[4];
													}
						else
						{
						$parse_time_start=$time_start_out[0].":".$time_start_out[2].$time_start_out[3];
						}
						if ($time_end_out[1]!="-"){
						$parse_time_end=$time_end_out[0].$time_end_out[1].":".$time_end_out[3].$time_end_out[4];
													}
						else
						{
						$parse_time_end=$time_end_out[0].":".$time_end_out[2].$time_end_out[3];
						}
						//Запис в БД...
						
							
						
						$base->Put_to_schedule($mas[0],$last_id,Parse_date($mas[5]),$parse_time_start,$parse_time_end,$last_id_log,$mas[9]);
						//-----------------------------------------------------------------------------
						//-----------------------------------------------------------------------------
						}
					echo "</td>";
				
				}	
			
		echo "</td>";
		echo "</tr>";
		}
		
	}}
	if ($err==0)
			{
			echo "<FONT color='green'><b>Завантаженно успішно</b></FONT>";
			}
}
}}

?> 
</center>
<script type="text/javascript">
$(document).ready(function() { 
if (active==true){
 setTimeout(function f(){history.go(-1)}, 3000); 
    f();}
});
</script>
