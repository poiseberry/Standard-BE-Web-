<?php
require '../config.php';
require '../include/ssp.class.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details = get_module($this_folder);

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
        array('db' => 'price', 'dt' => 2),
        array('db' => 'sort_order', 'dt' => 3),
        array('db' => 'pkid', 'dt' => 4, 'formatter' => function ($d, $row) {
            if ($_SESSION['user_role'] == "1")
                return get_button(basename(__DIR__), 'edit', $d) . " " . get_button(basename(__DIR__), 'delete', $d);
            else {
                return '';
            }
        }),
    );
    $where = "";
    echo json_encode(
        SSP::complex($_GET, $sql_details, $table[$module_details['db_table']], 'pkid', $columns, null, $where)
    );
    exit();
}

if ($_POST['method'] == "delete_listing") {
    $pkid = $_POST['pkid'];
    $query = get_query_delete($table[$module_details['db_table']], $pkid);
    $database->query($query);

    do_tracking($user_username, 'Delete ' . $module_details['title']);

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
                <?= $module_details['title'] ?>
            </h1>
            <br>
            <?= get_button($this_folder, 'new', null) ?>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Title</th>
                                    <th>Price (RM)</th>
                                    <th>Display Order</th>
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
        "ajax": "<?=$this_folder?>/listing.php?type=get_listing_data",
        "order": [[2, "asc"]]
    });
</script>
</body>
</html>