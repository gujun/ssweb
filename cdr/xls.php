<?php
session_start();
set_include_path(get_include_path().PATH_SEPARATOR.'../libs/');

//var $doc;

if (isset ($_SESSION['cdr']) === false) {
        include_once 'nofile.php';
        die();
}

$doc = $_SESSION['cdr'];

//require 'php-excel.class.php';                
include 'PHPExcel.php';                         
//include 'PHPExcel/Writer/Excel2007.php';      
include 'PHPExcel/Writer/Excel5.php'; 




//$xls = new Excel_XML('UTF-8',false,'cdr');    
//$xls->addArray($doc);                         
//$xls->generateXML('cdr');                             
$objPHPExcel = new PHPExcel();                  
$objPHPExcel->getProperties()->setCreator("CARI VOIP system");
$objPHPExcel->getProperties()->setLastModifiedBy("CARI VOIP system");
$objPHPExcel->getProperties()->setTitle('cdr'); 
$objPHPExcel->getProperties()->setSubject('cdr');
$objPHPExcel->getProperties()->setDescription('cdr generated by CARI VOIP system');
$objPHPExcel->getProperties()->setKeywords('cdr');
$objPHPExcel->getProperties()->setCategory('cdr');
                                                        
$objPHPExcel->setActiveSheetIndex(0);  

$rowIdx = 1;
foreach($doc as $row=>$cols){   
                 
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowIdx,$cols[0]);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowIdx,$cols[1]);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowIdx,$cols[2]);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowIdx,$cols[3]);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowIdx,$cols[4]);
	$rowIdx++;
}
$randToken = md5(uniqid(rand(), true));
$xlsfile = "../output/cdr${randToken}.xls";
$objPHPExcel->getActiveSheet()->setTitle("cdr");

$objPHPExcel->setActiveSheetIndex(0);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save($xlsfile);
//header("Location: $xlsfile");
//require 'passfile.php';

if(!is_file($xlsfile)){
	include_once 'nofile.php';
	die();
} 
if(!is_readable($xlsfile)){
	include_once 'nofile.php';
}
else{
	require 'passfile.php';
	passfile($xlsfile,'cdr.xls','xls',true);     
}
     unlink($xlsFile);
?>
