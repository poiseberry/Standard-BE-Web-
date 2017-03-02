<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
error_reporting(0);

//database config
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'ina2ndco_vk');
define('DB_PASSWORD', 'Dunksme@1');
define('DB_NAME', 'ina2ndco_website_2017');

$sql_details = array(
    'user' => DB_USERNAME,
    'pass' => DB_PASSWORD,
    'db' => DB_NAME,
    'host' => DB_HOST
);

$tablePrefix = 'dc_';

$table['banner'] = $tablePrefix . 'banner';
$table['company_type'] = $tablePrefix . 'company_type';
$table['incorporation'] = $tablePrefix . 'incorporation';
$table['incorporation_member'] = $tablePrefix . 'incorporation_member';
$table['addon'] = $tablePrefix . 'addon';
$table['addon_company_type'] = $tablePrefix . 'addon_company_type';
$table['state'] = $tablePrefix . 'state';
$table['country'] = $tablePrefix . 'country';
$table['enquiry'] = $tablePrefix . 'enquiry';

$table['module'] = $tablePrefix . 'module';
$table['setting'] = $tablePrefix . 'setting';
$table['tracking'] = $tablePrefix . 'tracking';
$table['user'] = $tablePrefix . 'user';
$table['user_logs'] = $tablePrefix . 'user_logs';

//include extra file
require_once('include/database/class.database.php');
require_once('include/PHPMailer-master/PHPMailerAutoload.php');
require_once('include/function.php');

//site config
$admin_site_title = "Admin - InA2nd";
$be_path = "/beta/admin/";
$fe_path = "/beta/";
$site_error_url = "http://" . $_SERVER['HTTP_HOST'] . $fe_path . "404.php";
$site_http_url = "http://" . $_SERVER['HTTP_HOST'] . $fe_path;
$site_admin_email = get_site_admin_email();

//function
function is_login()
{
    global $be_path;
    if (empty($_SESSION['user_id']) || empty($_SESSION['user_username'])) {
        if(!preg_match("/pdf/",$_SERVER['PHP_SELF'])){
        echo '<script>window.location.href="http://' . $_SERVER['HTTP_HOST'] . $be_path . '"</script>';
        exit();
    }
    }
}

if (preg_match("/admin/", $_SERVER['PHP_SELF'])) {
    if (!preg_match("/login/", $_SERVER['PHP_SELF']) && !preg_match("/logout/", $_SERVER['PHP_SELF']) && !preg_match("/index/", $_SERVER['PHP_SELF'])) {
        is_login();
    }
}

//misc config
$today = date("Y-m-d H:i:s");

$green = "style=\"color:#5cb85c\"";
$red = "style=\"color:#c9302c\"";
$blue = "style=\"color:#428bca\"";
$yellow = "style=\"color:#f0ad4e\"";

$active = "<td $green><b>Active</b></td>";
$inactive = "<td $red><b>Inactive</b></td>";

$return = $_GET['return'];
$type = $_GET['type'];

//session
$user_username = $_SESSION['user_username'];
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'];

?>