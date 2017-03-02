<?
require '../config.php';
global $table;
$database = new database();

$id=$_POST['id'];

$queryFile="select * from ".$table['media']." where pkid=$id";
$resultFile=$database->query($queryFile);
$rs_file=$resultFile->fetchRow();

$query="delete from ".$table['media']." where pkid=$id";
$database->query($query);

unlink("../../files/media/".$rs_file['img_url']);
echo "success";
?>