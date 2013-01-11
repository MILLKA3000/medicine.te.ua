<?php
session_start();
include ("auth.php");
require_once "Spreadsheet/Excel/Writer.php";
require_once "Class/mysql-class.php";
$likarnja=$_SESSION['likarnja'];
// ���� Excel
$xls = new Spreadsheet_Excel_Writer();
// ��������� ������� ����� ����
$xls->_codepage = 0x04E3;
$base = new class_mysql_base();
//��������� � ����� ��� ����� �� �����
	

$mas_doctor=$base->get_doctor($likarnja);

$date_d = date("d");
$date_m = date("m");
$date_y = ($_POST['year']);
//$date_y = date("Y");
//$date_y="2013";
if($_POST['mis'])
{
$misjac=$_POST['mis'];
$t_start = new DateTime($date_y."-".$misjac."-01");
$dayofmonth=$t_start->format('t');
}
$day=array("��������","³������","������","������","�'������","������","�����");
		
if ($_POST['likarnya']==0)
{
	if ($misjac==$date_m)
	{
//������ �����
	for ($i=0;$i<$base->get_doctor_sum($likarnja);$i++)
		{
		$name_sheet=$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name'][0].".".$mas_doctor[$i]['third_name'][0].".-".$mas_doctor[$i]['spec_name'];
		$name_sheet=substr($name_sheet, 0, 20);
		$name_sheet=$name_sheet."...";
//����� ����� ��� ���������� �����
		$cart =& $xls->addWorksheet($name_sheet);
		$myArr=array("��� ˳����","�������","���","��-�������","��� ������������","���� �������","��� �������","��� ����","ʳ������ ��������","������ �������","����");
		$cart->writeRow(0,0,$myArr);
			$cart->setColumn(0,0,1);
			$cart->setColumn(0,1,10);
			$cart->setColumn(0,2,10);
			$cart->setColumn(0,3,10);
			$cart->setColumn(0,4,20);
			$cart->setColumn(0,5,10);
			$cart->setColumn(0,6,8);
			$cart->setColumn(0,7,8);
			$cart->setColumn(0,8,8);
			$cart->setColumn(0,9,10);
			$cart->setColumn(0,10,10);
			for ($j=0;$j<date("t")-(date("d")-1);$j++)
			{
			$n=date('N',mktime(0, 0, 0, $date_m, $date_d+$j, $date_y));
			$date = $date_d+$j.".".$date_m.".".$date_y;
			$myArr2[$j]=array($mas_doctor[$i]['id'],$mas_doctor[$i]['family'],$mas_doctor[$i]['name'],$mas_doctor[$i]['third_name'],$mas_doctor[$i]['spec_name'],$date,"","","","",$day[$n-1]);
			$cart->writeRow($j+1,0,$myArr2[$j]); 
			}
		}
		$base->sql_close();
//���������� � ����
		$xls->send("������� ".date('dS M Y').".xls");
		$xls->close();
	}
	
	if ($misjac>$date_m)
	{
//������ �����
	for ($i=0;$i<$base->get_doctor_sum($likarnja);$i++)
		{
		$name_sheet=$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name'][0].".".$mas_doctor[$i]['third_name'][0].".-".$mas_doctor[$i]['spec_name'];
				$name_sheet=substr($name_sheet, 0, 27);
		$name_sheet=$name_sheet."...";
//����� ����� ��� ���������� �����
		$cart =& $xls->addWorksheet($name_sheet);
		$myArr=array("��� ˳����","�������","���","��-�������","��� ������������","���� �������","��� �������","��� ����","ʳ������ ��������","������ �������","����");
		$cart->writeRow(0,0,$myArr);
			$cart->setColumn(0,0,1);
			$cart->setColumn(0,1,10);
			$cart->setColumn(0,2,10);
			$cart->setColumn(0,3,10);
			$cart->setColumn(0,4,20);
			$cart->setColumn(0,5,10);
			$cart->setColumn(0,6,8);
			$cart->setColumn(0,7,8);
			$cart->setColumn(0,8,8);
			$cart->setColumn(0,9,10);
			for ($j=0;$j<$dayofmonth;$j++)
			{
			$n=date('N',mktime(0, 0, 0, $t_start->format('m'), $j+1, $date_y));
			
			if ($j<9) {$date = "0".($j+1).".".$t_start->format('m').".".$date_y;}
			else {$date = ($j+1).".".$t_start->format('m').".".$date_y;} 
			$myArr2[$j]=array($mas_doctor[$i]['id'],$mas_doctor[$i]['family'],$mas_doctor[$i]['name'],$mas_doctor[$i]['third_name'],$mas_doctor[$i]['spec_name'],$date,"","","","",$day[$n-1]);
			$cart->writeRow($j+1,0,$myArr2[$j]); 
			}
		}
		$base->sql_close();
//���������� � ����
		$xls->send("������� ".date('dS M Y').".xls");
		$xls->close();
	}
	
	if ($misjac<$date_m)
	{
//������ �����
	for ($i=0;$i<$base->get_doctor_sum($likarnja);$i++)
		{
		$name_sheet=$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name'][0].".".$mas_doctor[$i]['third_name'][0].".-".$mas_doctor[$i]['spec_name'];
				$name_sheet=substr($name_sheet, 0, 27);
		$name_sheet=$name_sheet."...";
//����� ����� ��� ���������� �����
		$cart =& $xls->addWorksheet($name_sheet);
		$myArr=array("��� ˳����","�������","���","��-�������","��� ������������","���� �������","��� �������","��� ����","ʳ������ ��������","������ �������","����");
		$cart->writeRow(0,0,$myArr);
			$cart->setColumn(0,0,1);
			$cart->setColumn(0,1,10);
			$cart->setColumn(0,2,10);
			$cart->setColumn(0,3,10);
			$cart->setColumn(0,4,20);
			$cart->setColumn(0,5,10);
			$cart->setColumn(0,6,8);
			$cart->setColumn(0,7,8);
			$cart->setColumn(0,8,8);
			$cart->setColumn(0,9,10);
			for ($j=0;$j<$dayofmonth;$j++)
			{
			$n=date('N',mktime(0, 0, 0, $t_start->format('m'), $j+1, $date_y));
			
			if ($j<9) {$date = "0".($j+1).".".$t_start->format('m').".".$date_y;}
			else {$date = ($j+1).".".$t_start->format('m').".".$date_y;} 
			$myArr2[$j]=array($mas_doctor[$i]['id'],$mas_doctor[$i]['family'],$mas_doctor[$i]['name'],$mas_doctor[$i]['third_name'],$mas_doctor[$i]['spec_name'],$date,"","","","",$day[$n-1]);
			$cart->writeRow($j+1,0,$myArr2[$j]); 
			}
		}
		$base->sql_close();
//���������� � ����
		$xls->send("������� ".date('dS M Y').".xls");
		$xls->close();
	}
}
	else 
if ($_POST['likarnya']>0)
{
	if ($misjac==$date_m)
	{
//������ �����
	for ($i=0;$i<$base->get_doctor_sum($likarnja);$i++)
		{
		if ($mas_doctor[$i]['id']==$_POST['likarnya']){
		$name_sheet=$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name'][0].".".$mas_doctor[$i]['third_name'][0].".-".$mas_doctor[$i]['spec_name'];
				$name_sheet=substr($name_sheet, 0, 28);
		$name_sheet=$name_sheet."...";
//����� ����� ��� ���������� �����

		$cart =& $xls->addWorksheet($name_sheet);
		$myArr=array("��� ˳����","�������","���","��-�������","��� ������������","���� �������","��� �������","��� ����","ʳ������ ��������","������ �������","����");
		$cart->writeRow(0,0,$myArr);
			$cart->setColumn(0,0,1);
			$cart->setColumn(0,1,10);
			$cart->setColumn(0,2,10);
			$cart->setColumn(0,3,10);
			$cart->setColumn(0,4,20);
			$cart->setColumn(0,5,10);
			$cart->setColumn(0,6,8);
			$cart->setColumn(0,7,8);
			$cart->setColumn(0,8,8);
			$cart->setColumn(0,9,10);
			for ($j=0;$j<date("t")-(date("d")-1);$j++)
			//{$n=date('N',mktime(0, 0, 0, $date_m, $date_d+$j, $date_y));
			{$n=date('N',mktime(0, 0, 0, $date_m, $date_d+$j, $date_y));
			$date = $date_d+$j.".".$date_m.".".$date_y;
			$myArr2[$j]=array($mas_doctor[$i]['id'],$mas_doctor[$i]['family'],$mas_doctor[$i]['name'],$mas_doctor[$i]['third_name'],$mas_doctor[$i]['spec_name'],$date,"","","","",$day[$n-1]);
			
			$cart->writeRow($j+1,0,$myArr2[$j]); 
			}
			
			}
		}
		$base->sql_close();
//���������� � ����
		
		$xls->send($name_sheet." ".date('dS M Y').".xls");
		$xls->close();
	}
	
	if ($misjac>$date_m)
	{
//������ �����
	for ($i=0;$i<$base->get_doctor_sum($likarnja);$i++)
		{if ($mas_doctor[$i]['id']==$_POST['likarnya']){
		$name_sheet=$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name'][0].".".$mas_doctor[$i]['third_name'][0].".-".$mas_doctor[$i]['spec_name'];
				$name_sheet=substr($name_sheet, 0, 28);
		$name_sheet=$name_sheet."...";
//����� ����� ��� ���������� �����
		$cart =& $xls->addWorksheet($name_sheet);
		$myArr=array("��� ˳����","�������","���","��-�������","��� ������������","���� �������","��� �������","��� ����","ʳ������ ��������","������ �������","����");
		$cart->writeRow(0,0,$myArr);
			$cart->setColumn(0,0,1);
			$cart->setColumn(0,1,10);
			$cart->setColumn(0,2,10);
			$cart->setColumn(0,3,10);
			$cart->setColumn(0,4,20);
			$cart->setColumn(0,5,10);
			$cart->setColumn(0,6,8);
			$cart->setColumn(0,7,8);
			$cart->setColumn(0,8,8);
			$cart->setColumn(0,9,10);
			for ($j=0;$j<$dayofmonth;$j++)
			//{$n=date('N',mktime(0, 0, 0, $date_m, $date_d+$j, $date_y));
			{$n=date('N',mktime(0, 0, 0, $t_start->format('m'), $j+1, $date_y));
			
			if ($j<9) {$date = "0".($j+1).".".$t_start->format('m').".".$date_y;}
			else {$date = ($j+1).".".$t_start->format('m').".".$date_y;} 
			$myArr2[$j]=array($mas_doctor[$i]['id'],$mas_doctor[$i]['family'],$mas_doctor[$i]['name'],$mas_doctor[$i]['third_name'],$mas_doctor[$i]['spec_name'],$date,"","","","",$day[$n-1]);
			$cart->writeRow($j+1,0,$myArr2[$j]); 
			}}
		}
		$base->sql_close();
//���������� � ����
		$xls->send($name_sheet." ".date('dS M Y').".xls");
		$xls->close();
	}
	if ($misjac<$date_m)
	{
//������ �����
	for ($i=0;$i<$base->get_doctor_sum($likarnja);$i++)
		{if ($mas_doctor[$i]['id']==$_POST['likarnya']){
		$name_sheet=$mas_doctor[$i]['family']." ".$mas_doctor[$i]['name'][0].".".$mas_doctor[$i]['third_name'][0].".-".$mas_doctor[$i]['spec_name'];
				$name_sheet=substr($name_sheet, 0, 28);
		$name_sheet=$name_sheet."...";
//����� ����� ��� ���������� �����
		$cart =& $xls->addWorksheet($name_sheet);
		$myArr=array("��� ˳����","�������","���","��-�������","��� ������������","���� �������","��� �������","��� ����","ʳ������ ��������","������ �������","����");
		$cart->writeRow(0,0,$myArr);
			$cart->setColumn(0,0,1);
			$cart->setColumn(0,1,10);
			$cart->setColumn(0,2,10);
			$cart->setColumn(0,3,10);
			$cart->setColumn(0,4,20);
			$cart->setColumn(0,5,10);
			$cart->setColumn(0,6,8);
			$cart->setColumn(0,7,8);
			$cart->setColumn(0,8,8);
			$cart->setColumn(0,9,10);
			for ($j=0;$j<$dayofmonth;$j++)
			//{$n=date('N',mktime(0, 0, 0, $date_m, $date_d+$j, $date_y));
			{$n=date('N',mktime(0, 0, 0, $t_start->format('m'), $j+1, $date_y));
			
			if ($j<9) {$date = "0".($j+1).".".$t_start->format('m').".".$date_y;}
			else {$date = ($j+1).".".$t_start->format('m').".".$date_y;} 
			$myArr2[$j]=array($mas_doctor[$i]['id'],$mas_doctor[$i]['family'],$mas_doctor[$i]['name'],$mas_doctor[$i]['third_name'],$mas_doctor[$i]['spec_name'],$date,"","","","",$day[$n-1]);
			$cart->writeRow($j+1,0,$myArr2[$j]); 
			}}
		}
		$base->sql_close();
//���������� � ����
		$xls->send($name_sheet." ".date('dS M Y').".xls");
		$xls->close();
	}
	
}
?>