<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details = get_module($this_folder);
$pkid = mysql_real_escape_string($_GET['id']);

$query = "select * from " . $table['incorporation_member'] . " where pkid=$pkid";
$result = $database->query($query);
$rs_array = $result->fetchRow();

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);

    $postfield['updated_date'] = date('Y-m-d H:i:s');
    $postfield['updated_by'] = $user_username;

    $query = get_query_update($table['incorporation_member'], $pkid, $postfield);
    $database->query($query);

    do_tracking($user_username, 'Edit Member - ' . $module_details['title']);

    header("Location:edit.php?id=".$rs_array['form_id']."&type=edit&return=success");
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
                    <?= $module_details['title'] ?> #<?= $rs_array['form_id'] ?> > <?= $rs_array['name'] ?> > Edit
                </h1>
                <br>
                <?= get_button($this_folder, 'save', null) ?>
                <a href="<?=$this_folder?>/edit.php?id=<?= $rs_array['form_id'] ?>" class="btn btn-danger btn-xs"><i
                            class="fa fa-close"></i> Cancel</a>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Full Name As Per Identity Card</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                               value="<?= $rs_array['name'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">NRIC</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="ic"
                                               value="<?= $rs_array['ic'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Passport</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="passport"
                                               value="<?= $rs_array['passport'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nationality</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="country"
                                               value="<?= $rs_array['country'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Date of Birth</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="dob"
                                               value="<?= $rs_array['dob'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Gender</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="gender"
                                               value="<?= $rs_array['gender'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Use InA2nd address</label>

                                    <div class="col-sm-10">
                                        <input type="checkbox" name="use_office_address"
                                               value="1" <?= $rs_array['use_office_address'] == "1" ? "checked" : "" ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Address as Per Identity Card</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address_1"
                                               value="<?= $rs_array['address_1'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Address Line 2</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address_2"
                                               value="<?= $rs_array['address_2'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">City</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="city"
                                               value="<?= $rs_array['city'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">State</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="state"
                                               value="<?= $rs_array['state'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Postal Code</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="postal_code"
                                               value="<?= $rs_array['postal_code'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Contact (Mobile)</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="contact"
                                               value="<?= $rs_array['contact'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Contact (Office)</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="contact_office"
                                               value="<?= $rs_array['contact_office'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="email"
                                               value="<?= $rs_array['email'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Number of shares held</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="share"
                                               value="<?= $rs_array['share'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Identity Card</label>

                                    <div class="col-sm-10">
                                        <a href="../files/member/<?= $rs_array['file_url'] ?>" target="_blank"
                                           class="btn btn-default btn-xs">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= get_button($this_folder, 'save', null) ?>
                <a href="<?=$this_folder?>/edit.php?id=<?= $rs_array['form_id'] ?>" class="btn btn-danger btn-xs"><i
                            class="fa fa-close"></i> Cancel</a>
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

