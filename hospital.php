<?
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_guide_hospital_type` WHERE `id` ='".$_GET['id_type']."'";
$base->sql_execute();
while($Mas = mysql_fetch_array($base->sql_result))
	{
		$s = $Mas['type_name'];
		$i = $Mas['id'];
	}
if($_GET['id_type']==6)
						{
							
header("Location: special.php?id_type=6");
						
						}
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='hospital.php?id_type=".$i."'>".$s."</Font>";
$base->sql_close();

include ("menu.php");

echo " <center><div class='lifted'>
		<p><FONT size=8>Крок №2: Виберіть лікувальний заклад </FONT><br><br><table width=100% id='old' cellspacing='0' rules='rows' border='1'>";
if($_GET['id_type']!=""){
// приватно практикуючі лікарі
if($_GET['id_type']==5){echo "<h1><FONT size=7 color='red'>Запрошуємо приватно-практикуючих лікарів долучитися до системи!</FONT></h1>";}
// кінець приватно практикуючі лікарі
if($_GET['id_type']==1){$mas_hosp=$base->Get_hospital2($_GET['id_type']);}

else{$mas_hosp=$base->Get_hospital($_GET['id_type']);}
	for ($i=0;$i<50;$i++)
	{
		if($mas_hosp[$i])
		{
		//------------------реєстратура  1 лікарні---------------------
		/*if ($mas_hosp[$i]['id']==4)
		{
		echo "<tr><td  width=25%> <a style='display: block; width=100%; height=220px;' class='text' href='http://www.zdorov.te.ua/Search_FreeAppointmentsOnWeek.aspx?idMedicalInst=1' >";
		echo "<img width=320px height=230px  src='script_img/image_hospital.php?id=".$mas_hosp[$i]['id']."'>";
		echo "<Font size=5></td><td><a style='display: block; width=100%; height=230px;' class='text' href='http://www.zdorov.te.ua/Search_FreeAppointmentsOnWeek.aspx?idMedicalInst=1' ><br><br><br><br>".$mas_hosp[$i]['name']."<br><Font size=3>".$mas_hosp[$i]['contacts']."<br><br><br><br><br></a></Font>
		</a></td></tr>";
		}
		
		//-------------------------------------------------------------
		else */{
		echo "<tr><td  width=25%> <a style='display: block; width=100%; height=220px;' class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$mas_hosp[$i]['id']."' >";
if ($mas_hosp[$i]['photo']){
  echo "<img width=320px height=230px  src='script_img/image_hospital.php?id=".$mas_hosp[$i]['id']."'>";
  }else echo "<img width=320px height=230px  src='images/spec/no_lik.jpg'>";
	//<img width=320px height=220px  src='script_img/image_hospital.php?id=".$mas_hosp[$i]['id']."'>
    $jj=0;
$base->sql_connect();
$base->sql_query="SELECT * FROM `mis_resurse` WHERE `id_hosp` ='".$mas_hosp[$i]['id']."'";
$base->sql_execute();

while($Mas = mysql_fetch_array($base->sql_result))
	{
        $resurse[$jj]['id_hosp']=$Mas['id_hosp'];
		$resurse[$jj]['title'] = $Mas['title'];
		$resurse[$jj]['link'] = $Mas['link'];
        $resurse[$jj]['images'] = $Mas['images'];
        $resurse[$jj]['type'] = $Mas['type'];
        $jj++;
	}
	echo "	
		<Font size=5></td><td><a style='display: block; width=100%; height=230px;' class='text' href='special.php?id_type=".$_GET['id_type']."&id_hosp=".$mas_hosp[$i]['id']."' ><br><br><br><br>".$mas_hosp[$i]['name']."<br><Font size=3>".$mas_hosp[$i]['contacts']."<br><br><br><br><br></a></Font>
		</a></td>";
        $b=0;
         for ($j=0;$j<$jj;$j++)
	{
        	 
  if ($resurse[$j]['id_hosp']==$mas_hosp[$i]['id'])
  {
        if ($resurse[$j]['type']==1)
        {
            echo "<td width=10% valign='top'>
            
            <center>".$resurse[$j]['title']." 
            <br>
            ".$resurse[$j]['images']."
            
            </td>"; 
        }else{
        echo "<td width=10% valign='top'>
        <a style='text-decoration:none;display:block;border: 1px solid #B2BCD9;margin-right:20px;padding:5px;' href='".$resurse[$j]['link']."'>
        <center>".$resurse[$j]['title']." 
        <br>
        <img  style='float:top;' width='100px' height='100px' src='".$resurse[$j]['images']."'>
        </a> 
        </td>";}
        $b=1;
  }
  else
  {
    
  }
 	}if ($b==0){echo "<td width=10%></td>";}
        echo"</tr>";	}}
	}
	
	

}
echo "</table>"
?>








