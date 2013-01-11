<script src="http://shublog.ru/files/js/jquery-1.6.4.js"></script>
<meta http-equiv= 'Refresh' content='60; http://medicine.te.ua/auth.php?action=logout'>
<?
include ("../auth.php");
require_once "../Class/mysql-class.php";
require_once "../Class/func-date.php";
$base = new class_mysql_base();

//----------------------------------Перевірка авторизації----------------------------------------

	//----------------------------------Форма авторизації----------------------------------------
	//----------------------------------Лікар авторизувався----------------------------------------
	
	   
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
		$contacts = $Mas['contacts'];
		$id_hosp = $Mas['id'];
	}	
	
$base->sql_query="SELECT mis_guide_physician.photo,mis_guide_physician.name,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.third_name,mis_guide_speciality.spec_name,mis_guide_speciality.id,mis_guide_speciality.metod 
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
		$metod_spec = $Mas['metod'];
		$affibiation = $Mas['affibiation'];
		$photo=$Mas['photo'];
        
		
	}	
$time=$base->Get_time($_GET['time']);    
echo "<html>
<br>					
<b><FONT SIZE=5>Талон амбулаторного пацієнта</FONT></b><br><br><br>


Код пацієнта_________________________________________<br>
П.І.Б. <u>".$_SESSION['family_p']." ".$_SESSION['name_p']." ".$_SESSION['first_name_p']."</u><br>
Стать: ч-1 ж-2<br>
Дата народження  ".$_SESSION['date']."<br>
Адреса: вул., буд. кв. ".$_SESSION['adress']."<br>
Категорія: інв.. ВВв -1; уч.ВВв-2;інв..Праці-3;інв..арм.-4; <br>
		   інв.дит.-5;воїн інт.-6;лікв.-7;евак.-8;реаб.-9;<br>
		   Прац.с/г-10;служб.-11;студ.-12;пенс-13;<br>
		   Один.-14;декр.-15;медпрац.-16;іногород.-17.<br>
Місце роботи___________________________________________<br>
Профшкідливість________________________________________<br>
Мета обслугов:лікув-діагн.-1;консультат-2;дисп.нагл.-3<br>
			   Профогл.-4;медико-соц.-5;інша-6<br>
Місце обслуговування: полікл (дата, код лікаря)________<br>
_______________________________________________________<br>
_______________________________________________________<br>
На дому (дата код лікаря)______________________________<br>
_______________________________________________________<br>
_______________________________________________________<br>
Діагноз(и):основний:___________________________________<br>
_______________________________________________________<br>
Супутні________________________________________________<br>
_______________________________________________________<br>
_______________________________________________________<br>
Захворювання(кожне) гостре-1;вперше в житті зареєстроване<br>
					хронічне-2;відоме раніше хронічне-3;<br>
					загостр.хрон-4;<br>
Вид травми: а) звязані з виробництвом в промисл-1; в с/г-2;на буд.-3<br>
				дор.трансп-4;інші-5.<br>
				б)не звязані з виробн.-побутова-6;вулична-7;<br>
				 дор.трансп.-8;спортивна-9;інша-10.<br>
Оперативна допомога на прийомі__________________________<br>
Дисп.нагляд:взято-1;перереєстр-2;оглянуто-3;знято-4.<br>
Діагноз:<br>
А_____________________шифр_________дата повт.явки_______<br>
Б_____________________шифр_________дата повт.явки_______<br>
В_____________________шифр_________дата повт.явки_______<br>

Лікув.-проф.заходи:сан-кур-1;госпіт-2;амб-пол-3;дієт.харч-4;<br>
					інші-5.<br>
Знятий з 'Д'обліку: здоровий-1;перевед.в інш.лік.заклад-2;<br>
					помер-3;інша-4.<br>
Інвалідність: І гр.		ІІ гр.		ІІІ гр.<br>
Інвалідизуючий д-з:______________________________________<br>
АТ_______________ФГ________________О/огляд_______________<br>
Госпіталізація___________________________________________<br>
Консультація_____________________________________________<br>
</html>
";

//header("Location: calendar.php?num=".$_GET['num']."&m=".$_GET['m']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."");	
echo "<script type='text/javascript'>";
echo "var addres = 'http://medicine.te.ua/new_patient.php?time=".$_GET['time']."&id_type=".$_GET['id_type']."&id_hosp=".$_GET['id_hosp']."&id_spec=".$_GET['id_spec']."&num=".$_GET['num']."'";
echo "</script>";
?>


<script type="text/javascript">
$(document).ready(function() { 
  /*  window.print();
	self.location.href = addres;
	//window.document.location.href = addres;

    //history.go(-1);*/
	if(confirm('Бажаєте продовжити роботу?'))
	{window.print();
	self.location.href = addres;}
else {window.print();
	self.location.href = "http://medicine.te.ua/auth.php?action=logout";}
});
</script>