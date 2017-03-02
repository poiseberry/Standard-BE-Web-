<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details = get_module($this_folder);

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);
    unset($postfield['addon']);

    if ($_FILES['file']['name']) {
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . "." . $extension;
        $path = "../../files/" . $module_details['folder'] . "/" . $image;
        move_uploaded_file($_FILES['file']["tmp_name"], $path);
        ImageResize($path, $path, 1200, 575);
        $postfield['img_url'] = $image;
    }

    $postfield['created_date'] = date('Y-m-d H:i:s');
    $postfield['created_by'] = $user_username;

    $query = get_query_insert($table[$module_details['db_table']], $postfield);
    $result=$database->query($query);
    $genID=$result->insertID();

    foreach($_POST['addon'] as $k=>$v) {
        $query = get_query_insert($table['addon_company_type'], array('addon_id'=>$v,'type_id'=>$genID));
        $database->query($query);
    }

    do_tracking($user_username, 'Add New ' . $module_details['title']);

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
                    <?= $module_details['title'] ?> > New
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
                                    <label class="col-sm-2 control-label">Title</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="text" class="form-control number" name="price">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Secretary Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="text" class="form-control number" name="sec_price">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Content</label>

                                    <div class="col-sm-10">
                                        <textarea class="editor" name="content"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Malaysian Only</label>

                                    <div class="col-sm-10">
                                        <input type="checkbox" class="form-control" name="malaysian_only" value="1">
                                    </div>
                                </div>
                                <hr>
                                <blockquote>Add On</blockquote>
                                <?
                                $resultAddon = get_query_data($table['addon'], "1 order by sort_order asc");
                                while ($rs_addon = $resultAddon->fetchRow()) {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"><?= $rs_addon['title'] ?></label>

                                        <div class="col-sm-8">
                                            <input type="checkbox" class="form-control" name="addon[]"
                                                   value="<?= $rs_addon['pkid'] ?>">
                                        </div>
                                    </div>
                                <? } ?>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Display Order</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control number" name="sort_order">
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
        maxFileSize: 25000
    });

    $("#file2").fileinput({
        showRemove: false,
        showUpload: false,
        showCancel: false,
        maxFileCount: 1,
        maxFileSize: 25000
    });
</script>
</body>
</html>

