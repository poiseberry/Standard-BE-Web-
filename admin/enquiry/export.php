<?php
require('../config.php');

global $table, $highlightOn, $highlightOff;
$database = new database();

$queryListing = "select * from " . $table['enquiry']." order by pkid asc";
$resultListing = $database->query($queryListing);
$results = $database->query($queryListing);

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Kuala_Lumpur');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require ('../include/excel/Classes/PHPExcel.php');


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
        ->setSize(10);
// Set document properties
$objPHPExcel->getProperties()->setCreator("Decubic")
        ->setLastModifiedBy("Decubic")
        ->setTitle("Enquiry Export")
        ->setSubject("Enquiry Export")
        ->setDescription("Enquiry Export")
        ->setKeywords("Enquiry Export")
        ->setCategory("Enquiry Export");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Enquiry Export')
        ->setCellValue('A3', 'Name')
        ->setCellValue('B3', 'Company')
        ->setCellValue('C3', 'Contact')
        ->setCellValue('D3', 'Email')
        ->setCellValue('E3', 'Message')
        ->setCellValue('F3', 'Date & Time');

$key = 3;

while ($results_array = $results->fetchRow()) {
    $key++;
    $objPHPExcel->getActiveSheet()
            ->setCellValue('A' . $key, $results_array['name'])
            ->setCellValue('B' . $key, $results_array['company'])
            ->setCellValue('C' . $key, $results_array['phone'])
            ->setCellValue('D' . $key, $results_array['email'])
            ->setCellValue('E' . $key, $results_array['enquiry'])
            ->setCellValue('F' . $key, $results_array['created_date']);



    $ws = $objPHPExcel->getActiveSheet();
    $ws->getCell('C' . $key)->setValueExplicit($results_array['phone'], PHPExcel_Cell_DataType::TYPE_STRING);
    $ws->getCell('F' . $key)->setValueExplicit($results_array['created_date'], PHPExcel_Cell_DataType::TYPE_STRING);
}





// Set fonts

$objPHPExcel->getActiveSheet()->getStyle('A3:S3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(13);
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Enquiry Export');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Enquiry-'.uniqid().'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
