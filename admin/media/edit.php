<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);

if ($_POST['method'] == 'upload_video') {
    $video_url = mysql_real_escape_string($_POST['video']);
    if (preg_match('/youtube/', $video_url)) {
        $img = explode("=", $video_url);
        $img_url = 'https://img.youtube.com/vi/' . $img[1] . '/maxresdefault.jpg';

        if ($img[1] == "") {
            echo json_encode(array('error' => 'Invalid Video Link'));
            exit();
        }

        $queryInsert = "insert into " . $table['media'] . " (video_img_url,video_url,created_date,created_by) values
            ('$img_url','$video_url',now(),'$user_username')";
        $resultInsert=$database->query($queryInsert);
        $genID=$resultInsert->insertID();

        echo json_encode(array('return' => 'Successfully Added','img_url'=>$img_url,'genID'=>$genID));
        exit();
    } else if (preg_match('/vimeo/', $video_url)) {
        $img = str_replace('https://vimeo.com/', '', $video_url);
        $hash = file_get_contents("https://vimeo.com/api/v2/video/" . $img . ".json");
        $hash = json_decode($hash);
        $img_url = $hash[0]->thumbnail_large;

        if ($img_url == "") {
            echo json_encode(array('error' => 'Invalid Video Link'));
            exit();
        }

        $queryInsert = "insert into " . $table['media'] . " (video_img_url,video_url,created_date,created_by) values
            ('$img_url','$video_url',now(),'$user_username')";
        $resultInsert=$database->query($queryInsert);
        $genID=$resultInsert->insertID();

        echo json_encode(array('return' => 'Successfully Added','img_url'=>$img_url,'genID'=>$genID));
        exit();
    } else {
        echo json_encode(array('error' => 'Invalid Video Link'));
        exit();
    }
}

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);
    unset($postfield['video']);
    unset($postfield['photo']);
    unset($postfield['gallery_order']);

    $postfield['updated_date'] = date('Y-m-d H:i:s');
    $postfield['updated_by'] = $user_username;

    $gallery_raw = array_filter(explode(",", $_POST['gallery_order']));
    foreach ($gallery_raw as $k => $v) {
        $record = explode("=", $v);
        $id = explode("_", $record[0]);
        $id = $id[1];
        $order = $record[1];
        $queryUpdate = "update " . $table['media'] . " set sort_order='$order' where pkid=$id";
        $database->query($queryUpdate);
    }

    do_tracking($user_username, 'Edit Media Gallery');

    header("Location:edit.php?type=edit&return=success");
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
              onsubmit="submit_form();"
              enctype="multipart/form-data">

            <section class="content-header">
                <h1>
                    Gallery > Edit
                </h1>
                <br>
                <?= get_button($this_folder, 'save', null) ?>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Upload Image</label>

                                    <div class="col-sm-10">
                                        <input id="gallery" type="file" name="photo[]" multiple
                                               class="file-loading">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Upload Video</label>

                                    <div class="col-sm-10">
                                        <input class="form-control" name="video" id="video"
                                               placeholder="Paste Youtube / Vimeo URL here">
                                        <br>
                                        <button type="button" class="btn btn-success btn-xs" id="submit_video"><i
                                                class="fa fa-plus"></i> Add Video
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>

                                    <div class="col-sm-10 js-grid" id="gallery_box">
                                        <?
                                        $queryGallery = "select * from " . $table['media'] . " order by sort_order asc,pkid asc";
                                        $resultGallery = $database->query($queryGallery);
                                        while ($rs_gallery = $resultGallery->fetchRow()) {
                                            if($rs_gallery['img_url']!=""){
                                                $img_url="../files/media/".$rs_gallery['img_url'];
                                            }else{
                                                $img_url=$rs_gallery['video_img_url'];
                                            }
                                            echo '<div class="col-sm-3 thumbnail" style="height:200px;" id="gallery_' . $rs_gallery['pkid'] . '">
                                                <button type="button" class="btn-xs btn-danger" onclick="delete_gallery(' . $rs_gallery['pkid'] . ')" title="Delete"><i class="glyphicon glyphicon-remove"></i></button>
                                                <img src="' . $img_url . '" style="max-height: 160px;">
                                            </div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-header">
                <?= get_button($this_folder, 'save', null) ?>
                <br>
                <br>
                <br>
            </section>

            <input type="hidden" name="gallery_order" id="gallery_order">
        </form>
    </div>
</div>
<? include('../js.php') ?>
<script>
    $("#submit_video").on('click', function (e) {
        $.ajax({
            url: '<?=$this_folder?>/edit.php',
            type: 'POST',
            data: {'method': 'upload_video','video':$("#video").val()},
            dataType: "json",
            success: function (data) {
                $("#video").val('');
                if(data['return']){
                    notie.alert(1, data['return'], 1);
                    $("#gallery_box").append('<div class="col-sm-3 thumbnail" style="height:200px;" id="gallery_' + data['genID'] + '">'
                        + '<button type="button" class="btn-xs btn-danger" onclick="delete_gallery(' + data['genID'] + ')" title="Delete"><i class="glyphicon glyphicon-remove"></i></button>'
                        + '<img src="' + data['img_url'] + '" style="max-height: 160px;">'
                        + '</div>');
                    $('.js-grid').sortable({
                        placeholderClass: 'col-sm-2 thumbnail',
                    });
                }else if(data['error']){
                    notie.alert(3, data['error'], 1);
                }
            }
        });
    });

    $('.js-grid').sortable({
        placeholderClass: 'col-sm-2 thumbnail',
    });

    var $input = $("#gallery");
    $input.fileinput({
        uploadUrl: "<?=$this_folder?>/upload.php",
        uploadAsync: true,
        showUpload: false,
        showRemove: false,
        minFileCount: 1,
        browseOnZoneClick: true,
        allowedFileExtensions: ['jpg', 'jpeg', 'gif', 'png'],
        maxFileSize: 25000,
    }).on("filebatchselected", function (event, files) {
        $input.fileinput("upload");
    }).on('fileuploaded', function (event, data, previewId, index) {
        console.log(data);
        var id = data.response.id[0];
        var name = data.response.image_name[0];

        $("#gallery_box").append('<div class="col-sm-3 thumbnail" style="height:200px;" id="gallery_' + id + '">'
            + '<button type="button" class="btn-xs btn-danger" onclick="delete_gallery(' + id + ')" title="Delete"><i class="glyphicon glyphicon-remove"></i></button>'
            + '<img src="../files/media/' + name + '" style="max-height: 160px;">'
            + '</div>');
    }).on('filebatchuploadcomplete', function (event, data, previewId, index) {
        setTimeout(
            function(){
                $input.fileinput("clear");
            }, 2000);
        $('.js-grid').sortable({
            placeholderClass: 'col-sm-2 thumbnail',
        });
    });

    function delete_gallery(id) {
        notie.confirm('Are you sure you want to delete this item?', 'Yes', 'Cancel', function () {
            $.ajax({
                url: '<?=$this_folder?>/delete_gallery_item.php',
                type: 'POST',
                data: {'id': id},
                success: function (data) {
                    notie.alert(1, 'Successfully Deleted', 1);
                    $('#gallery_' + id).hide(500);
                }
            });
        });
    }

    function submit_form() {
        var data = "";
        $(".js-grid div").each(function (i, el) {
            var p = $(el).attr('id').toLowerCase().replace(" ", "_");
            data += p + "=" + $(el).index() + ",";
        });
        $("#gallery_order").val(data);
    }
</script>
</body>
</html>

