<?
include ("auth.php");
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
include ("header.php");
echo "<b>&nbsp&nbsp&nbsp<Font size=3><a href='index.php'>Головна</a> -> <a href='my_admin.php'>Персонал</a> -> <a href='new_special.php'>Редагування спеціальностей</a></Font>";
if (!$_SESSION['name_sesion_a'])
	{
		header("Location: my_admin.php");
	}
	else
	//----------------------------------Лікар авторизувався----------------------------------------
	{
include ("admin_menu.php");
if ($_SESSION['role']==3)
	{
	

	
echo " <center><b style='float:right'>Ви зайшли під ім'ям ".$_SESSION['family_a']." ".$_SESSION['name_a']." ".$_SESSION['first_name_a']."</b><br><br>
		<FONT size=8>Зміна логіну</FONT><br><br><table width=100%><tr><td>";
if (($_GET['login'])&&($_GET['pass']))	
{		
		$new_pass=crypt(md5($_GET['login']), md5($_GET['pass']));
		$base->ins("UPDATE mis_guide_physician SET password='".$new_pass."' WHERE id=".(int)$_GET['id'].";");
		echo "<center>Для логіна: ".$_GET['login']." <br> Пароль змінено на ".$_GET['pass']."</center>";
}
else{
echo "<FONT size=4><center>Введіть логін старий та новий пароль</FONT><br><br><table>
<form action='new_login.php' method='post'>
			 <b>
			<tr><td><b>LOGIN </td><td><input name='login' maxlength='50' size='41' class='input-text' type='text' ></td></tr>
			<tr><td><b>PASSWORD </td><td><input name='pass' maxlength='50' size='41' class='input-text' type='password' ></td></tr>
			<tr><td><input type='submit' value='Змінити'></td></tr></table><br>
";
if(($_POST['login']))
	{	
		$sql="SELECT * FROM mis_guide_physician WHERE username='".$_POST['login']."';";
		$login_true=$base->get_doctor_select($sql);	
		echo "<center>Виберіть користувача якому хочете присвоїти новий пароль</center><br>";
		echo "<table width=100% id='old' cellspacing=1>";
		for ($i=0;$i<count($login_true);$i++){
		if ($login_true[$i]['photo']){
				echo "<tr><td width=3% style='border: 1px solid #666'><img width=25px  style='float:left;margin-right:26px;margin-left:26px;' src='script_img/image_doctor.php?num=".$mas_doctor[$j]['id']."'></td>";
				}else echo "<td width=3% style='border: 1px solid #666'><img width=25px  style='float:left;margin-right:26px;margin-left:26px;' src='images/spec/nophoto.png'></td>";
				
					echo "<td width=30% style='border: 1px solid #666'><Font size=3>".$login_true[$i]['family']." ".$login_true[$i]['name']." ".$login_true[$i]['third_name']." </td>
					<td width=20% style='border: 1px solid #666'><Font size=3>".$login_true[$i]['spec_name']."</td>
					<td width=35% style='border: 1px solid #666'><Font size=3>".$login_true[$i]['affibiation']."</td>
					<td width=15% style='border: 1px solid #666'><Font size=3><a href='new_login.php?id=".$login_true[$i]['id']."&login=".$_POST['login']."&pass=".$_POST['pass']."' class='text'><center>Змінити</a></td>
					
					</tr>";	}
		if ($login_true==null){echo"<center>Вибачте такого користувача не існує. Перевірьте правельність вводу логіна.</center>";}
	}
	}	
}
	//-----------------------------------------------якщо незалогінений---------------------------------------
	else 
	{
	header("Location: my_admin.php");
	}
}
echo "</td></tr></table>"
?>








