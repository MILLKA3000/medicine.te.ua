<?php
require_once("./xls/XLSReader.class.php");
class XLSToDB {	
	private  $uploaddir = "./user/";	
	private  $valueArray;
	//конструктор, створює дескриптор на відповідний файл
	//$fileName - імя цього файла
	function XLSToDB($fileName, $encoding)
	{
		$this->data = new Spreadsheet_Excel_Reader();
		$this->data->setOutputEncoding($encoding);
	}
//Відкриття файлу		
	function AddFile($newsPicTmpName)
	{
		$newName=time().".xls";
		
		if (move_uploaded_file($newsPicTmpName, $this->uploaddir.$newName)) {
  			return $newName;
		} else {
			return 'error';
		}
	}
//Получаєм кількість листів	
	function getshet($xlsfile)
	{
		$dir = "./user/" . $xlsfile;
		$this->data->read($dir);
		$myArray = array();
		$sumshet=0;
		for ($i = 1; $i <= 300; $i++) 	
		{	
			$myArray[0][0] = $this->data->sheets[$i-1]['cells'][1][1];
			if($myArray[0][0]!='')
			{
			$sumshet++;
			}
		}
	return $sumshet;	
	}
	//масим получаєм з Excel
	function get($xlsfile,$num)
	{
		$dir = "./user/" . $xlsfile;
		$this->data->read($dir);
		$myArray = array();
		//обхід файла
		for ($i = 2; $i <= $this->data->sheets[$num]['numRows']; $i++) 
			for ($j = 1; $j <= 10; $j++) 
		{		
			$myArray[$i-2][$j-1] = $this->data->sheets[$num]['cells'][$i][$j];
		}
		return $myArray;
	}	
	}
	?>