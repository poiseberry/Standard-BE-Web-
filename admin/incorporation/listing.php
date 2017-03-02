<?php
require '../config.php';
require '../include/ssp.class.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details = get_module($this_folder);

if ($type == "get_listing_data") {
    $columns = array(
        array('db' => 'pkid', 'dt' => 0, 'formatter' => function ($d, $row) {
            return $d;
        }),
        array('db' => 'company_type', 'dt' => 1, 'formatter' => function ($d, $row) {
            global $company_type_array;
            return $company_type_array[$d];
        }),
        array('db' => 'name', 'dt' => 2, 'formatter' => function ($d, $row) {
            return $d;
        }),
        array('db' => 'contact', 'dt' => 3, 'formatter' => function ($d, $row) {
            return $d;
        }),
        array('db' => 'email', 'dt' => 4, 'formatter' => function ($d, $row) {
            return $d;
        }),
        array('db' => 'created_date', 'dt' => 5, 'formatter' => function ($d, $row) {
            return $d;
        }),
        array('db' => 'pkid', 'dt' => 6, 'formatter' => function ($d, $row) {
            if ($_SESSION['user_role'] == "1")
                return get_button(basename(__DIR__), 'edit', $d)." ".get_button(basename(__DIR__), 'delete', $d);
            else {
                return '';
            }
        }),
    );
    $where = "status=1";
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
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company Type</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Date Added</th>
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
        "order": [[0, "desc"]]
    });
</script>
</body>
</html>