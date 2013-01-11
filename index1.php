
<?
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a></Font>";
include ("menu.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
$mas_hosp_type=$base->Get_guide_hospital();
echo " <center><div class='lifted'>
		<p><FONT size=8>Крок №1: Виберіть лікувальний заклад </FONT><br><br><br><table width=100% cellspacing=5 id='old'>";
	for ($i=0;$i<25;$i++)
	{
		if($mas_hosp_type[$i])
		{
			if (($mas_hosp_type[$i]['sort']==1) || ($mas_hosp_type[$i]['sort']==0))
				{
echo "<tr><td style='border: 1px solid #666'><Font size=5><center><a style='display: block; width=100%;height=100%' class='text' href='special.php?id_type=".$mas_hosp_type[$i]['id']."' ><br>".$mas_hosp_type[$i]['name']."<br><br></a></td></tr>";
			    }else {
		//echo "<tr><td style='border: 1px solid #666'><Font size=5><center><a style='display: block; width=100%;height=100%' class='text' href='hospital.php?id_type=".$mas_hosp_type[$i]['id']."' ><br>".$mas_hosp_type[$i]['name']."<br><br></a></td></tr>";
						  }
		}
	}
echo "</table>";
/*print_r($_SERVER['REMOTE_ADDR']);
print_r($_SERVER['SERVER_ADDR']);*/
//print_r($_SERVER);
?>









</p></div></td></tr></table>
