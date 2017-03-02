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
        array('db' => 'status', 'dt' => 0, 'formatter' => function ($d, $row) {
            if ($d == "1") {
                return "<b style=\"color:#5cb85c\">Enabled</b>";
            } else {
                return "<b style=\"color:#c9302c\">Disabled</b>";
            }
        }),
        array('db' => 'img_url', 'dt' => 1, 'formatter' => function ($d, $row) {
            return '<img src="../files/gallery/'.$d.'" height="100px">';
        }),
        array('db' => 'cat_pkid', 'dt' => 2, 'formatter' => function ($d, $row){
            global $table;
            $database = new database();

            $queryCat = "select * from " .$table['category']. " where pkid=$d";
            $resultCat = $database->query($queryCat);
            $arrayCat = $resultCat->fetchRow();

            return $arrayCat['title']." | ".$arrayCat['title_cn'];
        }),
        array('db' => 'sort_order', 'dt' => 3),
        array('db' => 'pkid', 'dt' => 4, 'formatter' => function ($d, $row) {
            if ($_SESSION['user_role'] == "1")
                return get_button(basename(__DIR__), 'edit', $d) . ' ' . get_button(basename(__DIR__), 'delete', $d);
            else {
                return get_button(basename(__DIR__), 'edit', $d);
            }
        }),
    );
    //where statement where necessary
    $where="";
    //encode the data into a json and include all the parameter required
    echo json_encode(
        SSP::complex($_GET, $sql_details, $table['gallery'], 'pkid', $columns, null, $where)
    );
    //exit everything
    exit();
}
//if statement when delete button is selected
if ($_POST['method'] == "delete_listing") {
    //get the pkid
    $pkid = $_POST['pkid'];
    //query out the delete of the table which includes the table name and pkid
    $query=get_query_delete($table['gallery'],$pkid);
    $database->query($query);
    //tracking what the user is doing
    do_tracking($user_username, 'Delete Gallery');
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
                Gallery
            </h1>
            <br>
            <?=get_button($this_folder,'new',null)?>
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
                                    <th>Image</th>
                                    <th>Category</th>
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
    var table=$('#data-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "<?=$this_folder?>/listing.php?type=get_listing_data",
        "order": [[ 2, "asc" ]]
    });
</script>
</body>
</html>