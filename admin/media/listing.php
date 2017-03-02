<?php
require '../config.php';
require '../include/ssp.class.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    if (count($postfield['cat_id']) > 0) {
        $filter_cat_id = implode(',', $postfield['cat_id']);
        $where = "pkid in (select post_id from ".$table['post_to_category']." where cat_id in ($filter_cat_id))";
    }
}

if (isset($_POST['submit_clear']) && $_POST['submit_save'] == "true") {
    $where = "";
}

if ($type == "get_listing_data") {
    $columns = array(
        array('db' => 'status', 'dt' => 0, 'formatter' => function ($d, $row) {
            if ($d == "1") {
                return "<b style=\"color:#5cb85c\">Enabled</b>";
            } else {
                return "<b style=\"color:#c9302c\">Disabled</b>";
            }
        }),
        array('db' => 'title', 'dt' => 1),
        array('db' => 'date', 'dt' => 2),
        array('db' => 'pkid', 'dt' => 3, 'formatter' => function ($d, $row) {
            if ($_SESSION['user_role'] == "1")
                return get_button(basename(__DIR__), 'edit', $d) . ' ' . get_button(basename(__DIR__), 'delete', $d);
            else {
                return get_button(basename(__DIR__), 'edit', $d);
            }
        }),
    );

    $default_where = "complete_status=1";

    if ($_GET['where'] != "") {
        $where = " and " . mysql_real_escape_string($_GET['where']);
    }

    echo json_encode(
        SSP::complex($_GET, $sql_details, $table['post'], 'pkid', $columns, null, $default_where . $where)
    );
    exit();
}

if ($_POST['method'] == "delete_listing") {
    $pkid = $_POST['pkid'];
    $query = get_query_delete($table['post'], $pkid);
    $database->query($query);

    do_tracking($user_username, 'Delete Post');

    echo json_encode(array('result' => 'success'));
    exit();
}
?>
<!DOCTYPE html>
<html>
<? include('../head.php') ?>

<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

    <? include('../header.php') ?>
    <? include('../left.php') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Post Listing
            </h1>
            <br>
            <?= get_button($this_folder, 'new', null) ?>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="box-header with-border">
                                <h3 class="box-title">Filters</h3>
                            </div>

                            <div class="col-sm-6">
                                <form action="<?= $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET) ?>" method="post"
                                      class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Category</label>

                                        <div class="col-sm-10">
                                            <select class="form-control selectpicker" name="cat_id[]" id="cat_id"
                                                    multiple>
                                                <option value="">--Please Select--</option>
                                                <?
                                                $queryBrand = "select * from " . $table['post_category'] . " where parent_id=0 order by sort_order asc";
                                                $resultBrand = $database->query($queryBrand);
                                                while ($rs_brand = $resultBrand->fetchRow()) {
                                                    if (in_array($rs_brand['pkid'], $postfield['cat_id']))
                                                        echo '<option value="' . $rs_brand['pkid'] . '" selected>' . $rs_brand['title'] . '</option>';
                                                    else
                                                        echo '<option value="' . $rs_brand['pkid'] . '">' . $rs_brand['title'] . '</option>';
                                                    $querySubCat = "select * from " . $table['post_category'] . " where parent_id=" . $rs_brand['pkid'] . " order by sort_order asc";
                                                    $resultSubCat = $database->query($querySubCat);
                                                    while ($rs_subcat = $resultSubCat->fetchRow()) {
                                                        if (in_array($rs_subcat['pkid'], $postfield['cat_id']))
                                                            echo '<option data-icon="fa fa-angle-double-right" value="' . $rs_subcat['pkid'] . '" selected>' . $rs_subcat['title'] . '</option>';
                                                        else
                                                            echo '<option data-icon="fa fa-angle-double-right" value="' . $rs_subcat['pkid'] . '">' . $rs_subcat['title'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <?= get_button($this_folder, 'submit', null) ?>
                                        <?= $where != "" ? get_button($this_folder, 'clear', null) : "" ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<? include('../js.php') ?>
<script>
    var table = $('#data-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?=$this_folder?>/listing.php?type=get_listing_data&where=<?=$where?>",
        "order": [[2, "desc"]]
    });
</script>
</body>
</html>