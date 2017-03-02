<?
require_once '../admin/config.php';
global $table;
$database = new database();

session_destroy();

header("Location: login.php");
exit();
?>