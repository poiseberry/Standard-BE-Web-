<?php
require_once "../config.php";
require_once "../include/dompdf/autoload.inc.php";
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details = get_module($this_folder);
$pkid = mysql_real_escape_string($_GET['id']);

$query = "select * from " . $table[$module_details['db_table']] . " where pkid=$pkid";
$result = $database->query($query);
$rs_array = $result->fetchRow();

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$html=file_get_contents('http://www.ina2nd.com.my/beta/admin/incorporation/pdf_view.php?id='.$pkid);
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("application-".$pkid.".pdf", array("Attachment" => false));

?>