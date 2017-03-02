<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details=get_module($this_folder);
$pkid=mysql_real_escape_string($_GET['id']);

$query="select * from ".$table[$module_details['db_table']]." where pkid=$pkid";
$result=$database->query($query);
$rs_array=$result->fetchRow();

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield=$_POST;
    unset($postfield['submit_save']);
    unset($postfield['addon']);

    if ($_FILES['file']['name']) {
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . "." . $extension;
        $path="../../files/".$module_details['folder']."/".$image;
        move_uploaded_file($_FILES['file']["tmp_name"], $path);
        ImageResize($path, $path, 1200, 575);
        $postfield['img_url']=$image;
    }

    $postfield['status']=$_POST['status'];
    $postfield['updated_date']=date('Y-m-d H:i:s');
    $postfield['updated_by']=$user_username;

    $query=get_query_update($table[$module_details['db_table']],$pkid,$postfield);
    $database->query($query);

    $query=get_query_delete_all($table['addon_company_type'],"type_id=$pkid");
    $database->query($query);

    foreach($_POST['addon'] as $k=>$v){
        $query=get_query_insert($table['addon_company_type'],array('addon_id'=>$v,'type_id'=>$pkid));
        $database->query($query);
    }

    do_tracking($user_username, 'Add New '.$module_details['title']);

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
        <form class="form-horizontal" action="<?=$_SERVER['PHP_SELF']."?".http_build_query($_GET)?>" method="post" enctype="multipart/form-data">

            <section class="content-header">
                <h1>
                    <?=$module_details['title']?> > Edit
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
                                        <input type="checkbox" name="status" value="1" <?=$rs_array['status']=="1"?"checked":"" ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Title</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" value="<?=$rs_array['title']?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                        <input type="text" class="form-control" name="price" value="<?=$rs_array['price']?>">
                                            </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Secretary Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <span class="input-group-addon">RM</span>
                                            <input type="text" class="form-control number" name="sec_price" value="<?=$rs_array['sec_price']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Content</label>

                                    <div class="col-sm-10">
                                        <textarea class="editor" name="content"><?=$rs_array['content']?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Malaysian Only</label>

                                    <div class="col-sm-10">
                                        <input type="checkbox" class="form-control" name="malaysian_only" value="1" <?=$rs_array['malaysian_only']=="1"?"checked":""?>>
                                    </div>
                                </div>
                                <hr>
                                <blockquote>Add On</blockquote>
                                <?
                                $resultAddonToCompany=get_query_data($table['addon_company_type'],"type_id=$pkid");
                                while($rs_addontocompany=$resultAddonToCompany->fetchRow()){
                                    $addon_array[]=$rs_addontocompany['addon_id'];
                                }

                                $resultAddon = get_query_data($table['addon'], "1 order by sort_order asc");
                                while ($rs_addon = $resultAddon->fetchRow()) {
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"><?= $rs_addon['title'] ?></label>

                                        <div class="col-sm-8">
                                            <input type="checkbox" class="form-control" name="addon[]"
                                                   value="<?= $rs_addon['pkid'] ?>" <? if(in_array($rs_addon['pkid'],$addon_array)) echo "checked" ?>>
                                        </div>
                                    </div>
                                <? } ?>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Display Order</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control number" name="sort_order" value="<?=$rs_array['sort_order']?>">
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
        showRemove:false,
        showUpload:false,
        showCancel:false,
        maxFileCount:1,
        maxFileSize:25000,
        <?if($rs_array['img_url']!=""){?>
        initialPreview: [
            "<img src='../files/<?=$module_details['folder']?>/<?=$rs_array['img_url']?>' class='file-preview-image img-responsive'>"
        ],
        <?}?>
    });

</script>
</body>
</html>

