<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();

include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='new_physician.php'>Новий користувач</a></Font>";
include ("admin_menu.php");


//----------------------------------Перевірка авторизації----------------------------------------

	//----------------------------------Форма авторизації----------------------------------------
if ($_SESSION['role']>1)
	{
echo " <b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
<center><FONT size=8>Створити нового користувача </FONT><br><br>";
	
	//----------------------------------Лікар авторизувався----------------------------------------
if (($_POST['put']=='Додати')&&($_POST['spec']!='null'))
{
   if (($_POST['family']!='')&&($_POST['spec']!='null')&&($_POST['name']!='')&&($_POST['third_name']!='')&&($_POST['login']!='')&&($_POST['pass']!='')&&($_POST['affibiation']!='')){ 
$password=crypt(md5($_POST['login']), md5($_POST['pass']));
$base->logs("Заведений новий користувач - ".$_POST['family']." ".$_POST['name']." ".$_POST['third_name']."");
	$base->sql_connect();
	$sql="INSERT INTO `mis`.`mis_guide_physician` (
`family` ,
`name` ,
`third_name` ,
`id_city` ,
`username` ,
`password` ,
`affibiation`
)
VALUES (
 '".$_POST['family']."', '".$_POST['name']."', '".$_POST['third_name']."', '1', '".$_POST['login']."', '".$password."', '".$_POST['affibiation']."'
);";

	$base->sql_query=$sql;
	$base->sql_execute();
	
$last_id=mysql_insert_id();
	
	$sql="INSERT INTO `mis`.`mis_physican_in_hospital` (
`id` ,
`id_physician` ,
`id_hospital` ,
`id_speciality` ,
`login` ,
`password` ,
`position` ,
`assigned` ,
`rejected`
)
VALUES (
NULL , '".$last_id."', '".$_POST['sity']."', '".$_POST['spec']."', '', '', '', NULL , NULL
);";
	$base->sql_query=$sql;
	$base->sql_execute();
    
    
 if ($_POST['spec2']!='null')
    {
    $sql="INSERT INTO `mis`.`mis_physican_in_hospital` (
`id` ,
`id_physician` ,
`id_hospital` ,
`id_speciality` ,
`login` ,
`password` ,
`position` ,
`assigned` ,
`rejected`
)
VALUES (
NULL , '".$last_id."', '".$_POST['sity']."', '".$_POST['spec2']."', '', '', '', NULL , NULL
);";
	$base->sql_query=$sql;
	$base->sql_execute();
    }
 }}else echo"<FONT color=red><b>Введіть всі записи</FONT>";
	
	
	echo "<form action='new_physician.php' method='post' enctype='multipart/form-data'>
		<table><tr>
		<tr><td>Прізвище </td><td><input name='family' maxlength='50' size='41' class='input-text' type='text'></tr>
		<tr><td>Ім'я</td><td><input name='name' maxlength='50' size='41' class='input-text' type='text'></tr>
		<tr><td>По-батькові</td><td><input name='third_name' maxlength='50' size='41' class='input-text' type='text'></tr>
		<tr><td>Спеціальність 1</td><td><select class='text' name='spec'>
        <option value='null' SELECTED>---Пусто---</option>";
        $i=0;
		$mas_spec = array(array());
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE 1;";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$mas_spec[$i]['id_spec'] = $Mas['id'];
			$mas_spec[$i]['name_spec'] = $Mas['spec_name'];
			$mas_spec[$i]['spec_code'] = $Mas['spec_code'];
			$i++;
			}
			
		for ($i=0;$i<count($mas_spec);$i++)
		{
			if (($_SESSION['role']<3) && ($mas_spec[$i]['spec_code']!='111'))
	{ 
		echo "<option value='".$mas_spec[$i]['id_spec']."'>".$mas_spec[$i]['name_spec']."</option>";
	}else
		{
			if ($_SESSION['role']>2){
		echo "<option value='".$mas_spec[$i]['id_spec']."'>".$mas_spec[$i]['name_spec']."</option>";}
		}
		}
	echo "</select> <a href='#' class='add' style='text-decoration:none;'>[ + ]</a></td></tr>";
    
    echo "	<tr><td><div id='select'>Спеціальність 2</td><td><select class='text' name='spec2' id='select0'>
    <option value='null' SELECTED>---Пусто---</option>";		
    $i=0;
		$mas_spec = array(array());
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_guide_speciality` WHERE 1;";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$mas_spec[$i]['id_spec'] = $Mas['id'];
			$mas_spec[$i]['name_spec'] = $Mas['spec_name'];
			$mas_spec[$i]['spec_code'] = $Mas['spec_code'];
			$i++;
			}
			
		for ($i=0;$i<count($mas_spec);$i++)
		{
		if (($_SESSION['role']<3) && ($mas_spec[$i]['spec_code']!='111'))
	{ 
		echo "<option value='".$mas_spec[$i]['id_spec']."'>".$mas_spec[$i]['name_spec']."</option>";
	}else
		{if ($_SESSION['role']>2){
		echo "<option value='".$mas_spec[$i]['id_spec']."'>".$mas_spec[$i]['name_spec']."</option>";}
		}
		}
	echo "</select> <a href='#' class='del' style='text-decoration:none;' id='select1'>[  - ]</a></div></td></tr>";
    
if ($_SESSION['role']>2)
	{    	
	echo "<tr><td>Лікарня </td><td><select class='text' name='sity'>";	
	$i=0;
		$mas_spec = array(array());
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_hospital` WHERE 1;";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$mas_spec[$i]['id_title'] = $Mas['id'];
			$mas_spec[$i]['title'] = $Mas['title'];
			$i++;
			}
			
		for ($i=0;$i<count($mas_spec);$i++)
		{
		echo "<option value='".$mas_spec[$i]['id_title']."'>".$mas_spec[$i]['title']."</option>";
		}
    }
    else
    {
    echo "<tr><td>Лікарня </td><td><select class='text' name='sity'>";	
	$i=0;
		$mas_spec = array(array());
		$base->sql_connect();
		$base->sql_query="SELECT * FROM `mis_hospital` WHERE 1;";
		$base->sql_execute();
		while($Mas = mysql_fetch_array($base->sql_result))
			{
			$mas_spec[$i]['id_title'] = $Mas['id'];
			$mas_spec[$i]['title'] = $Mas['title'];
			$i++;
			}
			
		for ($i=0;$i<count($mas_spec);$i++)
		{
		  if ($_SESSION['likarnja']==$mas_spec[$i]['id_title'])
            {
		      echo "<option value='".$mas_spec[$i]['id_title']."'>".$mas_spec[$i]['title']."</option>";
            }
		}    
    }
		
echo "		
		</tr>
		<tr><td>Логін </td><td><input name='login' maxlength='50' size='41' class='input-text' type='text'></tr>
		<tr><td>Пароль </td><td><input name='pass' maxlength='50' size='41' class='input-text' type='text'></tr>
		<tr><td>Додаткове </td><td><input name='affibiation' maxlength='80' size='60' class='input-text' type='text'></tr>
		<tr><td><input type='submit' name='put' value='Додати'></td></tr></table>";
	
	
		}
	else 
	{
	header("Location: my_admin.php");
	}
echo "";
?>

<script type="text/javascript">
            $().ready(
            function() {
                $('#select').hide();
                $('#select0').hide();
                $('#select1').hide();
                $('.add').click(
            function(){
                    $('#select').show();
                    $('#select0').show();
                    $('#select1').show();
                    return false;
                });
                $('.del').click(
            function(){
                    $('#select').hide();
                    $('#select0').hide();
                    $('#select1').hide();
                    return false;
                });
            }
        );
        </script>