<?php
require '../config.php';
require '../include/image.php';
global $table;
$database = new database();
$this_folder = basename(__DIR__);
$module_details = get_module($this_folder);
$pkid = mysql_real_escape_string($_GET['id']);

$query = "select * from " . $table[$module_details['db_table']] . " where pkid=$pkid";
$result = $database->query($query);
$rs_array = $result->fetchRow();

if (isset($_POST['submit_save']) && $_POST['submit_save'] == "true") {
    $postfield = $_POST;
    unset($postfield['submit_save']);

    $postfield['updated_date'] = date('Y-m-d H:i:s');
    $postfield['updated_by'] = $user_username;

    $query = get_query_update($table[$module_details['db_table']], $pkid, $postfield);
    $database->query($query);

    do_tracking($user_username, 'Add New ' . $module_details['title']);

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
        <form class="form-horizontal" action="<?= $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET) ?>" method="post"
              enctype="multipart/form-data">

            <section class="content-header">
                <h1>
                    <?= $module_details['title'] ?> #<?= $rs_array['pkid'] ?> > Edit
                </h1>
                <br>
                <?= get_button($this_folder, 'save', null) . " " . get_button($this_folder, 'cancel', null) ?>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <blockquote>APPLICANT INFORMATION</blockquote>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                               value="<?= $rs_array['name'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Contact</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="contact"
                                               value="<?= $rs_array['contact'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="Email"
                                               value="<?= $rs_array['email'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <blockquote>PROPOSED COMPANY NAME</blockquote>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">1st Proposed Company Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="company_name_1"
                                               value="<?= $rs_array['company_name_1'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">2nd Proposed Company Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="company_name_2"
                                               value="<?= $rs_array['company_name_2'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">3rd Proposed Company Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="company_name_3"
                                               value="<?= $rs_array['company_name_3'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <blockquote>CLARIFICATION OF YOUR PROPOSED COMPANY NAME</blockquote>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">If single letters included in the proposed
                                        name, it stand for</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="company_name_meaning"
                                               value="<?= $rs_array['company_name_meaning'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">If the proposed name is not in the Bahasa
                                        Malaysia or English, please clarify</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="company_name_extra"
                                               value="<?= $rs_array['company_name_extra'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <blockquote>NATURE OF BUSINESS / PRINCIPAL ACTIVITIES</blockquote>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nature of business to be carried on by the
                                        company</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nature_business"
                                               value="<?= $rs_array['nature_business'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Address</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address_1"
                                               value="<?= $rs_array['address_1'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Address Line 2</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="address_2"
                                               value="<?= $rs_array['address_2'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">City</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="city"
                                               value="<?= $rs_array['city'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">State</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="state"
                                               value="<?= $rs_array['state'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Postal Code</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="postal_code"
                                               value="<?= $rs_array['postal_code'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <blockquote>PARTICULARS OF COMPANY PROMOTERS / DIRECTORS</blockquote>
                                <?
                                $count = 0;
                                $resultMember = get_query_data($table['incorporation_member'], "form_id=$pkid");
                                while ($rs_member = $resultMember->fetchRow()) {
                                    $count++;
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">#<?= $count ?></label>

                                        <div class="col-sm-5">
                                            <label class="control-label"><?= $rs_member['name'] ?></label>
                                            &nbsp;
                                            <a href="<?= $this_folder ?>/member_edit.php?id=<?= $rs_member['pkid'] ?>">
                                                <button type="button" class="btn btn-default btn-xs">Edit</button>
                                            </a>
                                        </div>
                                    </div>
                                <? } ?>
                                <hr>
                                <blockquote>CAPITAL STRUCTURE</blockquote>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Authorised share capital</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="auth_share_capital"
                                               value="<?= $rs_array['auth_share_capital'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Paid up share capital</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="paid_share_capital"
                                               value="<?= $rs_array['paid_share_capital'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <blockquote>COMPANY SHAREHOLDING DETAILS</blockquote>
                                <?
                                $count = 0;
                                $resultMember = get_query_data($table['incorporation_member'], "form_id=$pkid");
                                while ($rs_member = $resultMember->fetchRow()) {
                                    $count++;
                                    ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">#<?= $count ?></label>

                                        <div class="col-sm-10">
                                            <div class="col-sm-3">
                                                <label class="control-label"><?= $rs_member['name'] ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input class="form-control" disabled value="<?= $rs_member['share'] ?>">
                                            </div>
                                            <a href="<?= $this_folder ?>/member_edit.php?id=<?= $rs_member['pkid'] ?>">
                                                <button type="button" class="btn btn-default btn-xs">Edit</button>
                                            </a>
                                        </div>
                                    </div>
                                <? } ?>
                                <hr>
                                <blockquote>BANK INFORMATION</blockquote>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Preferred Bank</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="preferred_bank"
                                               value="<?= $rs_array['preferred_bank'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Branch</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="branch"
                                               value="<?= $rs_array['branch'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Cheque Signatory</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="cheque_signatory"
                                               value="<?= $rs_array['cheque_signatory'] ?>">
                                    </div>
                                </div>
                                <hr>
                                <blockquote>ADD ON</blockquote>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        <?
                                        $addon_array = explode("@@", $rs_array['addon_list']);
                                        $addon_text = implode(",", $addon_array);

                                        if ($addon_text == "") {
                                            $addon_text = "''";
                                        }

                                        $resultAddon = get_query_data($table['addon'], "pkid in ($addon_text)");
                                        $row_addon = $resultAddon->numRows();
                                        while ($rs_addon = $resultAddon->fetchRow()) {
                                            ?>
                                            <label class="col-sm-4 control-label pull-left"><?= $rs_addon['title'] ?></label>
                                        <? }

                                        if ($row_addon == 0) {
                                            ?>
                                            <label class="col-sm-2 control-label">None</label>
                                        <? } ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Remark</label>

                                    <div class="col-sm-10">
                                        <textarea name="remark"
                                                  class="form-control"><?= $rs_array['remark'] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Price</label>

                                    <div class="col-sm-10">
                                        <label class="control-label">RM <?= number_format($rs_array['final_price']) ?></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Date & Time</label>

                                    <div class="col-sm-10">
                                        <label class="control-label"><?= $rs_array['created_date'] ?></label>
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
        showRemove: false,
        showUpload: false,
        showCancel: false,
        maxFileCount: 1,
        maxFileSize: 25000,
        <?if($rs_array['img_url'] != ""){?>
        initialPreview: [
            "<img src='../files/<?=$module_details['folder']?>/<?=$rs_array['img_url']?>' class='file-preview-image img-responsive'>"
        ],
        <?}?>
    });

</script>
</body>
</html>

