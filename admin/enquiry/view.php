<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
//get the base name directory of the url
$this_folder = basename(__DIR__);
//get the id from the url
$pkid=mysql_real_escape_string($_GET['id']);
//query out the contact table to obtain data from it
$query="select * from ".$table['enquiry']." where pkid=$pkid";
$result=$database->query($query);
$rs_array=$result->fetchRow();
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
                    Enquiry > View
                </h1>
                <br>
                <?= get_button($this_folder, 'cancel', null) ?>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" value="<?= $rs_array['name'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Company</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" value="<?= $rs_array['company'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="email" value="<?= $rs_array['email'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Contact</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="phone" value="<?= $rs_array['phone'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Message</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="enquiry" rows="5" disabled><?= $rs_array['enquiry'] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                	<label class="col-sm-2 control-label">Date Created</label>

                                	<div class="col-sm-10">
                                		<input class="form-control" type="text" name="date" value="<?= $rs_array['created_date'] ?>" disabled>
                                	</div>
                                </div>                                                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-header">
                <?= get_button($this_folder, 'cancel', null) ?>
            </section>
        </form>
    </div>
</div>
<? include('../js.php') ?>
<script type="text/JavaScript" src="include/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var roxyFileman = '<?=$full_path?>include/fileman/index.html';

    CKEDITOR.replace('description', {filebrowserBrowseUrl: roxyFileman,
        filebrowserImageBrowseUrl: roxyFileman + '?type=image',
        removeDialogTabs: 'link:upload;image:upload', allowedContent: true});
</script>
</body>
</html>

