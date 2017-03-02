<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
//get the base name directory of the url
$this_folder = basename(__DIR__);
//if statement when submit button is pressed
if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    //make a postfield variable to include all the posted data
    $postfield=$_POST;
    //unset the submit button because it is also sent as a posted data
    unset($postfield['submit_save']);
    //if statement when a file name is true
    if ($_FILES['file']['name']) {
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . "." . $extension;
        move_uploaded_file($_FILES['file']["tmp_name"], "../../files/gallery/" . $image);
        ImageResize('../../files/gallery/' . $image, '../../files/gallery/' . $image, 1920, 1000);
        $postfield['img_url']=$image;
    }
    //include post that aren't included in the form that is posted
    $postfield['created_date']=date('Y-m-d H:i:s');
    $postfield['created_by']=$user_username;
    //query out the insert of the table which includes the table name,pkid and the postfield data
    $query=get_query_insert($table['gallery'],$postfield);
    $database->query($query);
    //tracking what the user is doing
    do_tracking($user_username, 'Add New Gallery');
    //after completing head back to the listing page
    header("Location:listing.php?type=new&return=success");
    //exit everything
    exit();
}
?>
<!DOCTYPE html>
<html>
<? include('../head.php') ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <? include('../header.php') ?>
    <? include('../left.php') ?>

    <div class="content-wrapper">
        <form class="form-horizontal" action="<?=$_SERVER['PHP_SELF']."?".http_build_query($_GET)?>" method="post" enctype="multipart/form-data">

            <section class="content-header">
                <h1>
                    Gallery > New
                </h1>
                <br>
                <?= get_button($this_folder, 'save', null) . " " . get_button($this_folder, 'cancel', null) ?>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Status</label>

                                    <div class="col-sm-10">
                                        <input type="checkbox" name="status" value="1" checked>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Category</label>

                                    <div class="col-sm-10">
                                        <select class="form-control selectpicker" name="cat_pkid" id="cat_pkid" required>
                                            <option value="">--Please Select--</option>
                                            <?
                                            $queryCat = "select * from " . $table['category'] . " order by sort_order asc";
                                            $resultCat = $database->query($queryCat);
                                            while ($rs_cat = $resultCat->fetchRow()) {
                                                echo '<option value="' . $rs_cat['pkid'] . '">' . $rs_cat['title'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Upload</label>

                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="file" id="file" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Display Order</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control number" name="sort_order" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-header">
                <?= get_button($this_folder, 'save', null) . " " . get_button($this_folder, 'cancel', null) ?>
            </section>
        </form>
    </div>
</div>
<? include('../js.php') ?>
<script>
    $("#file").fileinput({
        showRemove:false,
        showUpload:false,
        showCancel:false,
        maxFileCount:1,
        maxFileSize:25000
    });
</script>
</body>
</html>
