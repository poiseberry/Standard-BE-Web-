<?php
require '../config.php';
require '../include/ssp.class.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);

if ($type == "get_listing_data") {
    $columns = array(
        array('db' => 'username', 'dt' => 0),
        array('db' => 'ip', 'dt' => 1),
        array('db' => 'created_date', 'dt' => 2),
        array('db' => 'pkid', 'dt' => 3, 'formatter' => function ($d, $row) {
            if ($_SESSION['user_role'] == "1")
                return get_button(basename(__DIR__), 'edit', $d) . ' ' . get_button(basename(__DIR__), 'delete', $d);
            else {
                return '';
            }
        }),
    );
    $where = "";
    echo json_encode(
        SSP::complex($_GET, $sql_details, $table['user_logs'], 'pkid', $columns, null, $where)
    );
    exit();
}

if ($_POST['method'] == "delete_listing") {
    $pkid = $_POST['pkid'];
    $query = get_query_delete($table['user_logs'], $pkid);
    $database->query($query);

    do_tracking($user_username, 'Delete Access Logs');

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
                Access Logs
            </h1>
            <br>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>IP</th>
                                    <th>Date & Time</th>
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
        "order": [[2, "desc"]]
    });
</script>
</body>
</html>