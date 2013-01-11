
<html>
<link rel="shortcut icon" href="http://t3.gstatic.com/images?q=tbn:ANd9GcTtLuVpDj_Ci4idOFbLD4suNjQueIFxQIa0fpOx0n8ZOeZcZBan">
<head>
<?
session_start();
if($_SESSION['name_sesion_a']!=''){echo"<meta http-equiv= 'Refresh' content='1000; http://medicine.te.ua/index.php'>";} 
if($_SESSION['name_sesion']!=''){echo"<meta http-equiv= 'Refresh' content='540; http://medicine.te.ua/auth.php?action=logout'>";}

?>


<!--<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">-->
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

<style type="text/css">
   body {
		background-image: url(images/spec/BG.jpg);
		}
  </style>

<?
include ("auth.php");
?>

<link type="text/css" rel="stylesheet" media="all" href="style/other.css" />
<link type="text/css" rel="stylesheet" media="all" href="style/menu.css" />
<link href="style/jquery.tcollapse.css" rel="stylesheet" type="text/css" media="all" />

<LINK REL="stylesheet" TYPE="text/css" HREF="style/print.css" MEDIA="print">
<script src="http://shublog.ru/files/js/jquery-1.6.4.js"></script>
<script src="script/pop.js"></script>
<script src="script/hide.js"></script>
<div id="printe">

<body >
 <div class='hed'> 
 <?


if ( (!$_SESSION['name_sesion']) && (!$_SESSION['name_sesion_a']) )
	{
	echo "
	<a href='my_patient.php?status=active' style='text-decoration:none;  height:30px; position:absolute; right:50px; top:90px; color:yellow'><b><FONT size=4>Мої записи (для пацієнта)</b>
    <br><a style='font-size:11pt;text-decoration:none;  height:20px; position:absolute; right:90px; top:115px; color:yellow' href='info.php?info=patient.htm'>Інструкція для паціента</a>
	<a href='my_admin.php' style='text-decoration:none;  height:30px; position:absolute; right:100px; top:40px; color:yellow'><b><FONT size=4>Вхід для персоналу</b></a>
	";
	}
	else if ($_SESSION['name_sesion'] && $_SESSION['grant']!="false")
	{
	echo "<a href='my_patient.php?status=active' style='text-decoration:none; width:250px; height:30px; position:absolute; right:40px; top:30px'><b><FONT size=4>Мої записи (для пацієнта)</b></a>";
	echo "<a href='auth.php?action=logout' style='text-decoration:none; width:50px; height:30px; position:absolute; right:150px;top:75px'><h3>ВИХІД</h3></a>";
	}
	else if ($_SESSION['name_sesion_a'])
	{
	echo "<a href='my_admin.php' style='text-decoration:none; width:250px; height:30px; position:absolute; right:10px; top:30px'><b><FONT size=4> Адміністрування </b></a>";
    if ($_SESSION['role']==1)
    {
        echo "<a style='font-size:9pt;text-decoration:none; width:150px; height:20px; position:absolute; right:100px; top:55px' href='info.php?info=doctor.htm'>Інструкція для лікаря</a>";
    }
    else 
    if ($_SESSION['role']==2)
    {
        echo "<a style='font-size:9pt;text-decoration:none; width:200px; height:20px; position:absolute; right:50px; top:55px' href='info.php?info=admin.htm'>Інструкція для адміністратора</a>";
    }
	echo "<a href='auth.php?action=logout' style='font-size:14pt;text-decoration:none; width:70px; height:30px; position:absolute; right:150px;top:75px'>ВИХІД</a>";
	}
	
if (($_GET['id_type']=='4')&&($_GET['id_hosp']=='62')) {echo "<img src='images/header/header(old).jpg'>";
}else{echo "<img src='images/header/header.jpg'>";}
?>
 <img src='images/header/x.jpg'>


 </div></div>
