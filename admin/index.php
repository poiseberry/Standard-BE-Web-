<?
require_once '../admin/config.php';
global $table;
$database = new database();

if(!empty($_SESSION['user_id']) && !empty($_SESSION['user_username'])){
    header("Location: dashboard.php");
    exit();
}else{
    header("Location: login.php");
    exit();
}
?>