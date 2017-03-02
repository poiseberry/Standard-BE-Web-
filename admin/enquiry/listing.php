<?php
require '../config.php';
require '../include/ssp.class.php';
global $table;
$database = new database();
//get the base name directory of the url
$this_folder = basename(__DIR__);
//if statement to identify the get listing data from ajax url
if ($type == "get_listing_data") {
    //put the data into a sequence where we want and include it in an array
    $columns = array(
        array('db' => 'name', 'dt' => 0),
        array('db' => 'email', 'dt' => 1),
        array('db' => 'created_date', 'dt' => 2),
        array('db' => 'pkid', 'dt' => 3, 'formatter' => function ($d, $row) {
            if ($_SESSION['user_role'] == "1")
                return get_button(basename(__DIR__), 'view', $d) . ' ' . get_button(basename(__DIR__), 'delete', $d);
            else {
                return get_button(basename(__DIR__), 'view', $d);
            }
        }),
    );
    //where statement where necessary
    $where="";
    //encode the data into a json and include all the parameter required
    echo json_encode(
        SSP::complex($_GET, $sql_details, $table['enquiry'], 'pkid', $columns, null, $where)
    );
    //exit everything
    exit();
}
//if statement when delete button is selected
if ($_POST['method'] == "delete_listing") {
    //get the pkid
    $pkid = $_POST['pkid'];
    //query out the delete of the table which includes the table name and pkid
    $query=get_query_delete($table['enquiry'],$pkid);
    $database->query($query);
    //tracking what the user is doing
    do_tracking($user_username, 'Delete Contact');
    //echo the result using json
    echo json_encode(array('result' => 'success'));
    //exit everything
    exit();
}
?>
<!DOCTYPE html>
<html>
<? include('../head.php') ?>

<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

    <?include('../header.php')?>
    <? include('../left.php') ?>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Enquiry
            </h1>
            <br>
            <?if($user_role=="1") echo get_button($this_folder, 'export', null) ?>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
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
    var table=$('#data-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?=$this_folder?>/listing.php?type=get_listing_data",
        "order": [[ 2, "desc" ]]
    });
</script>
</body>
</html>