<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details = get_module($this_folder);
$pkid = mysql_real_escape_string($_GET['id']);

$query = "select * from " . $table[$module_details['db_table']] . " where pkid=$pkid";
$result = $database->query($query);
$rs_array = $result->fetchRow();

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);

    $postfield['status'] = $_POST['status'];
    $postfield['updated_date'] = date('Y-m-d H:i:s');
    $postfield['updated_by'] = $user_username;
    $postfield['type'] = "admin_email";

    $query = get_query_update($table[$module_details['db_table']], $pkid, $postfield);
    $database->query($query);

    do_tracking($user_username, 'Edit ' . $module_details['title']);

    header("Location:listing.php?type=new&return=success");
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
        <form class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET) ?>" method="post"
              enctype="multipart/form-data">

            <section class="content-header">
                <h1>
                    <?= $module_details['title'] ?> > Edit
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
                                        <input type="checkbox" name="status"
                                               value="1" <?= $rs_array['status'] == "1" ? "checked" : "" ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email Address</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="email" required
                                               value="<?= $rs_array['email'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= get_button($this_folder, 'save', null) . " " . get_button($this_folder, 'cancel', null) ?>
            </section>

        </form>
    </div>
</div>
<? include('../js.php') ?>
<script>
    $("#file").fileinput({
        showRemove: false,
        showUpload: false,
        showCancel: false,
        maxFileCount: 1,
        maxFileSize: 25000,
        <?if($rs_array['img_url'] != ""){?>
        initialPreview: [
            "<img src='../files/<?=$module_details['folder']?>/<?=$rs_array['img_url']?>' class='file-preview-image img-responsive'>"
        ],
        <?}?>
    });

</script>
</body>
</html>

