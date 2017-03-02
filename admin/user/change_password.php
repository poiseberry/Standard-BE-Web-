<?php
require '../config.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$pkid = $user_id;

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);
    unset($postfield['new_password']);

    $postfield['password'] = protect('encrypt', $_POST['new_password']);
    $postfield['updated_date'] = date('Y-m-d H:i:s');
    $postfield['updated_by'] = $user_username;

    $query = get_query_update($table['user'], $pkid, $postfield);
    $database->query($query);

    do_tracking($user_username, 'Change Password');

    header("Location:change_password.php?type=edit&return=success");
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
                    Users > Change Password
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
                                    <label class="col-sm-2 control-label">New Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" required
                                               value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Confirm New Password</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="new_password" required
                                               value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-header">
                <?= get_button($this_folder, 'save', null) . " " . get_button($this_folder, 'cancel', null) ?>
                <br>
                <br>
                <br>
            </section>
        </form>
    </div>
</div>
<? include('../js.php') ?>
</body>
</html>

