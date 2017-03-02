<?
require_once '../admin/config.php';
global $table;
$database = new database();

$today = date('Y-m-d');

$query = "select * from " . $table['enquiry'] . " where created_date like '%$today%'";
$result = $database->query($query);
$array = $result->numRows();

$query = "select * from " . $table['incorporation'] . " where created_date like '%$today%'";
$result = $database->query($query);
$row2 = $result->numRows();
?>
<!DOCTYPE html>
<html>
<? include('head.php') ?>

<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <? include('header.php') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <? include('left.php') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <a href="enquiry/listing.php">
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3><?= $array ?></h3>

                                <p>Today's Enquiry</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="incorporation/listing.php">
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3><?= $row2 ?></h3>

                                <p>Today's Applications</p>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- ./col -->
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<? include('js.php') ?>

</body>
</html>
