<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <li><a href="dashboard.php">Dashboard</a></li>
            <?
            $queryModule = "select * from " . $table['module'] . " where status=1 and parent_id=0 order by sort_order asc";
            $resultModule = $database->query($queryModule);
            while ($rs_module = $resultModule->fetchRow()) {
                if ($rs_module['parent_status'] == "1") {
                    ?>
                    <li class="treeview">
                        <a href="#"><span><?= $rs_module['title'] ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                            <?
                            $querySubModule = "select * from " . $table['module'] . " where status=1 and parent_id=" . $rs_module['pkid']." order by sort_order asc";
                            $resultSubModule = $database->query($querySubModule);
                            while ($rs_submodule = $resultSubModule->fetchRow()) {
                                ?>
                                <li><a href="<?= $rs_submodule['folder'] ?>/listing.php"><i
                                            class="fa fa-circle-o"></i> <?= $rs_submodule['title'] ?></a></li>
                                <?
                            } ?>
                        </ul>
                    </li>
                    <?
                } else {
                    ?>
                    <li><a href="<?= $rs_module['folder'] ?>/listing.php"><?= $rs_module['title'] ?></a></li>
                    <?
                }
                ?>
            <? } ?>
            <? if ($_SESSION['user_role'] == "1") { ?>
                <li><a href="module/listing.php">System Module</a></li>
            <? } ?>
            <li class="treeview">
                <a href="#"><span>Users</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu" style="display: none;">
                    <? if ($_SESSION['user_role'] == "1") { ?>
                        <li><a href="user/listing.php"><i class="fa fa-circle-o"></i> Listing</a></li>
                    <? } ?>
                    <li><a href="user/change_password.php"><i class="fa fa-circle-o"></i> Change Password</a></li>
                    <? if ($_SESSION['user_role'] == "1") { ?>
                        <li><a href="access_logs/listing.php"><i class="fa fa-circle-o"></i> Access Logs</a></li>
                        <li><a href="tracking/listing.php"><i class="fa fa-circle-o"></i> Action Tracking</a></li>
                    <? } ?>
                </ul>
            </li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </section>
</aside>