<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();

if (empty($_FILES['photo'])) {
    echo json_encode(array('error' => 'No files found for upload.'));
}

$images = $_FILES['photo'];

$success = null;

$paths = array();

$filenames = $images['name'];

for ($i = 0; $i < count($filenames); $i++) {
    $extension = pathinfo($filenames[$i], PATHINFO_EXTENSION);
    $image_name = uniqid() . "." . $extension;

    $target = "../../files/media/" . $image_name;

    if (move_uploaded_file($images['tmp_name'][$i], $target)) {
        ImageResize('../../files/media/' . $image_name, '../../files/media/' . $image_name, 1920, 1920);

        $query = "insert into " . $table['media'] . " (img_url,created_date,created_by) values ('$image_name',now(),'$user_username')";
        $result=$database->query($query);
        $genID=$result->insertID();

        $success = true;
        $paths[] = $target;
        $uploaded['id'][] = $genID;
        $uploaded['image_name'][] = $image_name;
    } else {
        $success = false;
        break;
    }
}

if ($success === true) {
    $output = array();
} elseif ($success === false) {
    $output = array('error' => 'Error while uploading images. Please try again.');
    foreach ($paths as $file) {
        unlink($file);
    }
} else {
    $output = array('error' => 'No files were processed.');
}

if ($success === true) {
    echo json_encode($uploaded);
}else{
    echo json_encode($output);
}

?>