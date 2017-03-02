<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);

    $postfield['complete_status'] = 1;
    $postfield['created_date'] = date('Y-m-d H:i:s');
    $postfield['created_by'] = $user_username;

    $query = get_query_insert($table['post'], $postfield);
    $result = $database->query($query);
    $genID = $result->insertID();

    do_tracking($user_username, 'Add New Post');

    header("Location:new-post.php?id=$genID");
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
                    Post Listing > New
                </h1>
                <br>
                <?= get_button($this_folder, 'next', null) . " " . get_button($this_folder, 'cancel', null) ?>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control" name="template_id" id="template_id">
                                            <option value="1">Full WYSIWYG</option>
                                            <option value="2">Full WYSIWYG with Sidebar</option>
                                            <option value="3">Full WYSIWYG with Gallery</option>
                                            <option value="4">Full WYSIWYG with Related Post</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <img src="" id="template_preview" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-header">
                <?= get_button($this_folder, 'next', null) . " " . get_button($this_folder, 'cancel', null) ?>
                <br>
                <br>
                <br>
            </section>
        </form>
    </div>
</div>
<? include('../js.php') ?>
<script>
    $("#template_preview").attr('src','img/template/'+$("#template_id").val()+'.jpg');
    $("#template_id").on('change', function () {
       $("#template_preview").attr('src','img/template/'+this.value+'.jpg');
    });
</script>
</body>
</html>

