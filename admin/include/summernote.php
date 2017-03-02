<?
require_once '../config.php';

if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        $name = uniqid();
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $filename = $name . '.' . $ext;
        $destination = '../../files/summernote/' . $filename; //change this directory
        $location = $_FILES["file"]["tmp_name"];
        move_uploaded_file($location, $destination);
        echo $site_http_url.'files/summernote/' . $filename;//change this URL
    } else {
        echo $message = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['file']['error'];
    }
}
?>