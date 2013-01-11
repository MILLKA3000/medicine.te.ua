<?
/*  var $sql_login="milenium";
  var $sql_passwd="milenium";
  var $sql_database="mis";
  var $sql_host="217.196.164.19";
*/
 /* var $sql_login="mis";
  var $sql_passwd="1qaz2wsx";
  var $sql_database="mis";
  var $sql_host="80.243.147.133";*/
  
 class class_mysql_base

{
  var $sql_login="sergiy";
  var $sql_passwd="kolobok";
  var $sql_database="mis";
//var $sql_host="192.168.1.222";
    var $sql_host="80.243.147.133";
  
  var $conn_id;
  var $sql_query;
  var $sql_err;
  var $sql_result;
  var $mas_doctor = array(array());

function sql_connect()
 {
  $this->conn_id = mysql_connect($this->sql_host,$this->sql_login,$this->sql_passwd);
  mysql_select_db($this->sql_database);
/*mysql_query($this->conn_id,'SET NAMES "UTF8"');
mysql_query($this->conn_id,"SET collation_connection='utf8_general_ci'");
mysql_query($this->conn_id,"SET collation_server='utf8_general_ci'");
mysql_query($this->conn_id,"SET character_set_client='utf8'");
mysql_query($this->conn_id,"SET character_set_connection='utf8'");
mysql_query($this->conn_id,"SET character_set_results='utf8'");
mysql_query($this->conn_id,"SET character_set_server='utf8'");*/
 mysql_query('SET NAMES cp1251', $this->conn_id);
//  mysql_query('SET NAMES UTF8', $this->conn_id);
  mysql_query("SET character_set_results='cp1251'",$this->conn_id);
  mysql_query("SET character_set_client='cp1251'",$this->conn_id);
//  mysql_query("SET character_set_server='utf8'",$this->conn_id);
 /* mysql_query("SET collation_connection='cp1251'",$this->conn_id);
mysql_query("SET collation_server='cp1251'",$this->conn_id);
mysql_query("SET character_set_client='cp1251'",$this->conn_id);
mysql_query("SET character_set_connection='cp1251'",$this->conn_id);
mysql_query("SET character_set_results='cp1251'",$this->conn_id);
mysql_query("SET character_set_server='cp1251'",$this->conn_id);*/
  //mysql_query("SET character_set_results='utf8'",$this->conn_id);
 }

function sql_execute()
 {
  $this->sql_result=mysql_query($this->sql_query,$this->conn_id);
  $this->sql_err=mysql_error();
 }

function sql_close()
 {
  mysql_close($this->conn_id);
 }
//Функції обробки даних
//Получення даних з звязуючої таблиці для формування списків лікарів
function logs($log)
 {
	$date_today = date("m-d-Y"); //присвоено 03.12.01
	$today[1] = date("H:i:s"); //присвоит 1 элементу массива 17:16:17
	$date_in="Час: ".$today[1]." і дата: ".$date_today;
	$date_old=date("Y-m-d");
	$sql = "INSERT INTO `mis`.`mis_logs` (`id_acount` ,`date`,`date_old` ,`action` ,`adress`) VALUES ('".$_SESSION['name_sesion_a']."', '".$date_in."','".$date_old."', '".$log."', 'www.".$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']."');";
	$this->ins($sql);
 }

function get_doctor($id_hospital)
{
$kil=0;
$this->sql_connect();
$this->sql_query="SELECT zv.id, doctor.family, doctor.name, doctor.photo, doctor.third_name,doctor.affibiation,zv.id_speciality,special.spec_name,zv.id_physician
FROM 
 mis_guide_physician AS doctor,
 mis_guide_speciality AS special,
 mis_physican_in_hospital AS zv
WHERE 
zv.id_physician = doctor.id
AND 
zv.id_speciality = special.id 
AND 
special.role = '1' 
AND
zv.id_hospital=".(int) $id_hospital."
ORDER BY 
zv.id_speciality,doctor.family ASC";
$this->sql_execute();
while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['family'] = $Mas['family'];
		$mas_doctor[$kil]['name'] = $Mas['name'];
		$mas_doctor[$kil]['third_name'] = $Mas['third_name'];
		$mas_doctor[$kil]['spec_name'] = $Mas['spec_name'];
		$mas_doctor[$kil]['id_spec'] = $Mas['id_speciality'];
		$mas_doctor[$kil]['affibiation'] = $Mas['affibiation'];
		$mas_doctor[$kil]['id_physician'] = $Mas['id_physician'];
		$mas_doctor[$kil]['photo'] = $Mas['photo'];
		$kil++;
	}
	//$this->sql_close();
return $mas_doctor;
}
function get_doctor_select($sql)
{
$kil=0;
$this->sql_connect();
$this->sql_query=$sql;
$this->sql_execute();
while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['family'] = $Mas['family'];
		$mas_doctor[$kil]['name'] = $Mas['name'];
		$mas_doctor[$kil]['third_name'] = $Mas['third_name'];
		$mas_doctor[$kil]['spec_name'] = $Mas['spec_name'];
		$mas_doctor[$kil]['id_spec'] = $Mas['id_speciality'];
		$mas_doctor[$kil]['affibiation'] = $Mas['affibiation'];
		$mas_doctor[$kil]['id_physician'] = $Mas['id_physician'];
		$mas_doctor[$kil]['photo'] = $Mas['photo'];
		$kil++;
	}
	$this->sql_close();
return $mas_doctor;
}

function get_doctor_select_zwit($sql)
{
$kil=0;
$this->sql_connect();
$this->sql_query=$sql;
$this->sql_execute();
while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['family'] = $Mas['family'];
		$mas_doctor[$kil]['name'] = $Mas['name'];
		$mas_doctor[$kil]['third_name'] = $Mas['third_name'];
		$mas_doctor[$kil]['spec_name'] = $Mas['spec_name'];
		$mas_doctor[$kil]['id_spec'] = $Mas['id_speciality'];
		$mas_doctor[$kil]['affibiation'] = $Mas['affibiation'];
		$mas_doctor[$kil]['id_physician'] = $Mas['id_physician'];
		$mas_doctor[$kil]['photo'] = $Mas['photo'];
		$mas_doctor[$kil]['id_zvit']=$Mas['id_zvit'];
		$mas_doctor[$kil]['date_zwit']=$Mas['date'];
		$mas_doctor[$kil]['zvit']=$Mas['zwites'];
		$mas_doctor[$kil]['note_zwit']=$Mas['note'];
		$kil++;
	}
	$this->sql_close();
return $mas_doctor;
}

//Сумма листів яку потрібно створити по кількості лікарів 
function get_doctor_sum($id_hospital)
{
$kil=0;
$this->sql_connect();
$this->sql_query="SELECT zv.id, doctor.family, doctor.name, doctor.third_name,special.spec_name
FROM  mis_guide_physician AS doctor, mis_guide_speciality AS special, mis_physican_in_hospital AS zv WHERE 
zv.id_physician = doctor.id AND zv.id_speciality = special.id AND 
special.role = '1' AND zv.id_hospital=".(int) $id_hospital." ORDER BY zv.id_physician ASC";
$this->sql_execute();
while($Mas = mysql_fetch_array($this->sql_result))
	{
		$kil++;
	}
	//$this->sql_close();
return $kil;
} 


function Put_patient($id_time,$family,$name,$first_name,$adress,$phone1,$phone2,$date,$email)
	{
	
	$this->sql_connect();
	$sql="INSERT INTO `mis`.`mis_patient` (`family` ,`name` ,`third_name` ,`id_city` ,`adress`,`phone1`,`phone2`,`birthday`,`email`)VALUES ('".$family."', '".$name."', '".$first_name."', 1, '".$adress."', '". $phone1."', '".$phone2."', '".$date."', '".$email."')";
    
	$this->sql_query=$sql;
	$this->sql_execute();
	$last_id=mysql_insert_id();
	$sql="UPDATE `mis`.`mis_schedule` SET `assigned_patient_id` = '".(int) $last_id."' WHERE `mis_schedule`.`id` =".(int) $id_time.";";
	$this->sql_query=$sql;
	$this->sql_execute();
	
	$this->sql_close();
	return $last_id;
	} 
function upd_scedule($id_time,$id_patient)
	{
	$this->sql_connect();
	$sql="UPDATE `mis`.`mis_schedule` SET `assigned_patient_id` = '".(int) $id_patient."' WHERE `mis_schedule`.`id` =".(int) $id_time.";";
	$this->sql_query=$sql;
	$this->sql_execute();
	$this->sql_close();
	}

 
function Put_workin_time($id,$date,$time_start,$time_end,$patient_sum,$room)
	{
	$this->sql_connect();
	$sql="INSERT INTO `mis`.`mis_working_time` (`id_physician_in_hospital` ,`work_date` ,`work_time_start` ,`work_time_end` ,`patient_amount`,`room`)VALUES ('".(int) $id."', '".$date."', '".$time_start."', '".$time_end."', '".$patient_sum."', '".$room."')";
	$this->sql_query=$sql;
	$this->sql_execute();
	$last_id=mysql_insert_id();
	$this->sql_close();
	return $last_id;
	} 
	
function Put_to_schedule($id_p_in_h,$id_time,$date,$time_start,$time_end,$id_log,$room)
	{
	$this->sql_connect();
	$sql="INSERT INTO `mis`.`mis_schedule` (`id_physician_in_hospital` ,`id_timetable` ,`work_date` ,`timebegin` ,`timeend` ,`assigned_patient_id`,`id_log`,`room`)VALUES ('".$id_p_in_h."' , '".(int) $id_time."' ,'".$date."' , '".$time_start."', '".$time_end."','1','".$id_log."','".$room."')";
	$this->sql_query=$sql;
	$this->sql_execute();
	$this->sql_close();
	}
	
function Get_to_schedule_kil($id_p_in_h)
	{
	$kil=0;
	$this->sql_connect();
	$sql="SELECT * FROM `mis_schedule` WHERE `id_physician_in_hospital` = '".(int) $id_p_in_h."'";
    $this->sql_query=$sql;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$kil++;
	}
	$this->sql_close();
	return $kil;
	}
	
function Get_to_schedule($id_p_in_h)
	{
	$kil=0;
	$this->sql_connect();
	$sql="SELECT * FROM `mis_schedule` WHERE `id_physician_in_hospital` = '".(int) $id_p_in_h."'  ORDER BY timebegin ASC;";
    $this->sql_query=$sql;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['date'] = $Mas['work_date'];
		$mas_doctor[$kil]['timebegin'] = $Mas['timebegin'];
		$mas_doctor[$kil]['timeend'] = $Mas['timeend'];
		$mas_doctor[$kil]['patient_id'] = $Mas['assigned_patient_id'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}
	
function Get_to_schedule_for_patient($id_patient)
	{
	$kil=0;
	$this->sql_connect();
	$sql="SELECT * FROM `mis_schedule` WHERE `assigned_patient_id` = '".(int) $id_patient."'";
    $this->sql_query=$sql;
	$this->sql_execute();
	while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['date'] = $Mas['work_date'];
		$mas_doctor[$kil]['timebegin'] = $Mas['timebegin'];
		$mas_doctor[$kil]['timeend'] = $Mas['timeend'];
		$mas_doctor[$kil]['physican_id'] = $Mas['id_physician_in_hospital'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}
		
	
	
function Get_time($id)
	{
	$kil=0;
	$this->sql_connect();
	$sql="SELECT * FROM `mis_schedule` WHERE `id` = '".(int) $id."'";
    $this->sql_query=$sql;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['date'] = $Mas['work_date'];
		$mas_doctor[$kil]['timebegin'] = $Mas['timebegin'];
		$mas_doctor[$kil]['timeend'] = $Mas['timeend'];
		$mas_doctor[$kil]['patient_id'] = $Mas['assigned_patient_id'];
		$mas_doctor[$kil]['room'] = $Mas['room'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}
	
function Get_guide_hospital()
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$sql="SELECT *FROM `mis_guide_hospital_type` WHERE 1 ORDER BY `sort` ASC";
    $this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['name'] = $Masuv['type_name'];
	$mas[$kil]['sort'] = $Masuv['sort'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function Get_city($id_type)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$sql="SELECT distinct `mis_guide_city`.`id`,`mis_guide_city`.`city_name` FROM `mis_hospital`,`mis_guide_city` WHERE `mis_hospital`.`hospital_type_id`='".(int) $id_type."'";
    $this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['name'] = $Masuv['city_name'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function Get_hospital($id_type)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$sql="SELECT * FROM `mis_hospital` WHERE `hospital_type_id`='".(int) $id_type."' ORDER BY `mis_hospital`.`sort`,`mis_hospital`.`title` ASC";
	$this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['name'] = $Masuv['title'];
	$mas[$kil]['photo'] = $Masuv['photo'];
	$mas[$kil]['contacts'] = $Masuv['contacts'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function Get_hospital_one($sql)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['title'] = $Masuv['title'];
	$mas[$kil]['photo'] = $Masuv['photo'];
	$mas[$kil]['contacts'] = $Masuv['contacts'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function Get_hospital2($id_type)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$sql="SELECT * FROM `mis_hospital` WHERE `hospital_type_id`='".(int) $id_type."'";
	$this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['name'] = $Masuv['title'];
	$mas[$kil]['photo'] = $Masuv['photo'];
	$mas[$kil]['contacts'] = $Masuv['contacts'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function Get_spec($id_hosp)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$sql="SELECT distinct id_speciality, spec_name, metod FROM `mis_physican_in_hospital`, mis_guide_speciality WHERE `id_hospital` = '".(int) $id_hosp."' AND `id_speciality`=  mis_guide_speciality.id AND mis_guide_speciality.spec_code!='111' AND active='0'";
	$this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id_speciality'];
	$mas[$kil]['name'] = $Masuv['spec_name'];
	$mas[$kil]['metod'] = $Masuv['metod'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
	function Get_spec_tul($sql)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id_spec'] = $Masuv['id'];
	$mas[$kil]['id'] = $Masuv['id_speciality'];
	$mas[$kil]['name'] = $Masuv['spec_name'];
	$mas[$kil]['metod'] = $Masuv['metod'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function Get_doctor_spec($id_hosp,$id_spec)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$sql="SELECT distinct mis_physican_in_hospital.id,id_physician,mis_guide_physician.family,mis_guide_physician.affibiation,mis_guide_physician.name,mis_guide_physician.third_name
FROM `mis_physican_in_hospital`, mis_guide_physician 
WHERE `id_hospital` = '".$id_hosp."' AND `id_speciality`= '".(int) $id_spec."' AND`id_physician`=  mis_guide_physician.id AND`active`= '0'";
	$this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['id_h_in_s'] = $Masuv['id_physician'];
	$mas[$kil]['family'] = $Masuv['family'];
	$mas[$kil]['name'] = $Masuv['name'];
	$mas[$kil]['third_name'] = $Masuv['third_name'];
	$mas[$kil]['affibiation'] = $Masuv['affibiation'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
	function Get_doctor_spec_tul($sql)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	
	$this->sql_query=$sql;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['id_h_in_s'] = $Masuv['id_physician'];
	$mas[$kil]['family'] = $Masuv['family'];
	$mas[$kil]['name'] = $Masuv['name'];
	$mas[$kil]['third_name'] = $Masuv['third_name'];
	$mas[$kil]['affibiation'] = $Masuv['affibiation'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function Get_doctor_spec_full($parameter)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$this->sql_query=$parameter;
	$this->sql_execute();
		while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['id_h_in_s'] = $Masuv['id_physician'];
	$mas[$kil]['family'] = $Masuv['family'];
	$mas[$kil]['name'] = $Masuv['name'];
	$mas[$kil]['third_name'] = $Masuv['third_name'];
	$mas[$kil]['affibiation'] = $Masuv['affibiation'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}
function ins($parameter)
	{
	$this->sql_connect();
	$this->sql_query=$parameter;
	$this->sql_execute();
	$last=mysql_insert_id();
	$this->sql_close();
	
	return $last;
	}
function select_street($parameter)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$this->sql_query=$parameter;
	$this->sql_execute();
	while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['id_street'] = $Masuv['id_street'];
	$mas[$kil]['home'] = $Masuv['home'];
	$mas[$kil]['id_p_in_h'] = $Masuv['id_p_in_h'];
	$mas[$kil]['id_type'] = $Masuv['id_type'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}

function select_street_name($parameter)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$this->sql_query=$parameter;
	$this->sql_execute();
	while($Masuv = mysql_fetch_array($this->sql_result))
	{
	$mas[$kil]['id'] = $Masuv['id'];
	$mas[$kil]['name_street'] = $Masuv['name_street'];
	$kil++;
	}
	$this->sql_close();
	return $mas;
	}

function select_doctor_in_hosp($parameter)
	{
	$kil=0;
	$mas = array(array());
	$this->sql_connect();
	$this->sql_query=$parameter;
	$this->sql_execute();
		while($Mass = mysql_fetch_array($this->sql_result))
	{	
		$mas[$kil]['id_doctor'] = $Mass['id_physician'];
		$mas[$kil]['name'] = $Mass['name'];
		$mas[$kil]['family'] = $Mass['family'];
		$mas[$kil]['third_name'] = $Mass['third_name'];
		$mas[$kil]['name_spec'] = $Mass['spec_name'];
		$mas[$kil]['id_spec'] = $Mass['id'];
		$mas[$kil]['affibiation'] = $Mass['affibiation'];
		$mas[$kil]['id_spec'] = $Mass['id_speciality'];
		$mas[$kil]['id_hosp'] = $Mass['id_hospital'];
		$mas[$kil]['photo']=$Mass['photo'];
        $mas[$kil]['active']=$Mass['active'];
	}
	$this->sql_close();
	return $mas;
	}


function Get_to_schedule_new($parameter)
	{
	$kil=0;
	$this->sql_connect();
    $this->sql_query=$parameter;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['id_physician_in_hospital'] = $Mas['id_physician_in_hospital'];
		$mas_doctor[$kil]['date'] = $Mas['work_date'];
		$mas_doctor[$kil]['timebegin'] = $Mas['timebegin'];
		$mas_doctor[$kil]['timeend'] = $Mas['timeend'];
		$mas_doctor[$kil]['patient_id'] = $Mas['assigned_patient_id'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}

function Get_patient_new($parameter)
	{
	$kil=0;
	$this->sql_connect();
    $this->sql_query=$parameter;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['family'] = $Mas['family'];
		$mas_doctor[$kil]['name'] = $Mas['name'];
		$mas_doctor[$kil]['third_name'] = $Mas['third_name'];
		$mas_doctor[$kil]['adress'] = $Mas['adress'];
		$mas_doctor[$kil]['phone1'] = $Mas['phone1'];
		$mas_doctor[$kil]['phone2'] = $Mas['phone2'];
		$mas_doctor[$kil]['email'] = $Mas['email'];
		$mas_doctor[$kil]['birthday'] = $Mas['birthday'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}

function Get_mark_new($parameter)
	{
	$kil=0;
	$this->sql_connect();
    $this->sql_query=$parameter;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['id_patient'] = $Mas['id_patient'];
		$mas_doctor[$kil]['id_schedule'] = $Mas['id_schedule'];
		$mas_doctor[$kil]['id_num'] = $Mas['id_num'];
		$mas_doctor[$kil]['mark'] = $Mas['mark'];
		$mas_doctor[$kil]['date'] = $Mas['date'];
		$mas_doctor[$kil]['doc'] = $Mas['doc'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}
function Get_logs($parameter)
	{
	$kil=0;
	$this->sql_connect();
    $this->sql_query=$parameter;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id_log'] = $Mas['id_log'];
		$mas_doctor[$kil]['id_acount'] = $Mas['id_acount'];
		$mas_doctor[$kil]['date'] = $Mas['date'];
		$mas_doctor[$kil]['action'] = $Mas['action'];
		$mas_doctor[$kil]['adress'] = $Mas['adress'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}
function Get_physican($parameter)
	{
	$kil=0;
	$this->sql_connect();
    $this->sql_query=$parameter;
	$this->sql_execute();
		while($Mas = mysql_fetch_array($this->sql_result))
	{
		$mas_doctor[$kil]['id'] = $Mas['id'];
		$mas_doctor[$kil]['family'] = $Mas['family'];
		$mas_doctor[$kil]['name'] = $Mas['name'];
		$mas_doctor[$kil]['third_name'] = $Mas['third_name'];
		$kil++;
	}
	$this->sql_close();
	return $mas_doctor;
	}
	//END
}
	?>