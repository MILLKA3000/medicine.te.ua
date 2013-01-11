<?php
require_once "Class/mysql-class.php";
$base = new class_mysql_base();
$res = array('named' => 'admin', 'login' => 'admin');
if (isset($_POST['auth_name'])) {
  //$name=mysql_real_escape_string($_POST['auth_name']);
  //$pass=mysql_real_escape_string($_POST['auth_pass']);
  //$query = "SELECT * FROM users WHERE name='$name' AND pass='$pass'";
  //$res = mysql_query($query) or trigger_error(mysql_error().$query);


  if (($res['named'] == $_POST['auth_name'] )&&($res['login'] == $_POST['auth_pass'] ) ){
    session_start();
    $_SESSION['name_sesion'] = $res['named'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
  }
 
  header("Location: index.php");
  //header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  exit;
}
if (isset($_GET['action']) AND $_GET['action']=="logout") {
	if($_SESSION['name_sesion_a']){	$base->logs("ֲטירמג");}
  session_start();
  session_destroy();

  header("Location: index.php");
  exit;
}
/*
if (isset($_REQUEST[session_name()])) session_start();
if (isset($_SESSION['name']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
*/
?>
