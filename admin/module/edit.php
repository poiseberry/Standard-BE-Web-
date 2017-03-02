<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$pkid = mysql_real_escape_string($_GET['id']);

$query = "select * from " . $table['module'] . " where pkid=$pkid";
$result = $database->query($query);
$rs_array = $result->fetchRow();

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);

    $postfield['status'] = $_POST['status'];
    $postfield['updated_date'] = date('Y-m-d H:i:s');
    $postfield['updated_by'] = $user_username;

    $query = get_query_update($table['module'], $pkid, $postfield);
    $database->query($query);

    do_tracking($user_username, 'Edit Module');

    header("Location:listing.php?type=edit&return=success");
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
                    System Module > Edit
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
                                    <label class="col-sm-2 control-label">Parent</label>

                                    <div class="col-sm-10">
                                        <div class="checkbox">
                                            <input type="radio" name="parent_status"
                                                   value="1" <?= $rs_array['parent_status'] == "1" ? "checked" : "" ?>>
                                            Yes
                                            <input type="radio" name="parent_status"
                                                   value="0" <?= $rs_array['parent_status'] == "0" ? "checked" : "" ?>>
                                            No
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label class="col-sm-2 control-label">Title</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="title" required
                                                   value="<?= $rs_array['title'] ?>">
                                        </div>
                                    </div>
                                <div id="div_parent_no">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Parent Module</label>

                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="parent_id" id="parent_id">
                                                <option value="">--Please Select--</option>
                                                <?
                                                $queryBrand = "select * from " . $table['module'] . " where parent_id=0 order by sort_order asc";
                                                $resultBrand = $database->query($queryBrand);
                                                while ($rs_brand = $resultBrand->fetchRow()) {
                                                    if ($rs_array['parent_id'] == $rs_brand['pkid'])
                                                        echo '<option value="' . $rs_brand['pkid'] . '" selected>' . $rs_brand['title'] . '</option>';
                                                    else
                                                        echo '<option value="' . $rs_brand['pkid'] . '">' . $rs_brand['title'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Folder</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="folder"
                                                   value="<?= $rs_array['folder'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">DB Table</label>

                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="db_table"
                                                   value="<?= $rs_array['db_table'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Display Order</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control number" name="sort_order"
                                               value="<?= $rs_array['sort_order'] ?>">
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
    $("input[name='parent_status']").on('ifChecked', function () {
        if (this.value == "0") {
            $("#div_parent_no").show(500);
        } else {
            $("#div_parent_no").hide(500);
        }
    });

    <?if($rs_array['parent_status'] == "1"){?>
    $("#div_parent_no").hide();
    <?}?>
</script>
</body>
</html>

