<?
require_once 'config.php';
global $table;
$database = new database();

if ($_POST) {
    $email = mysql_real_escape_string($_POST['email']);
    $password = protect('encrypt', $_POST['password']);

    $queryCheck = "select * from " . $table['user'] . " where username='$email' and password='$password'";
    $resultCheck = $database->query($queryCheck);
    $row_check = $resultCheck->numRows();
    $rs_check = $resultCheck->fetchRow();

    if ($row_check > 0) {
        if ($rs_check['status'] != "0") {
            $_SESSION['user_id'] = $rs_check['pkid'];
            $_SESSION['user_username'] = $rs_check['username'];
            $_SESSION['user_role'] = $rs_check['role'];

            $query="insert into ".$table['user_logs']." (username,ip,created_date) values ('".$rs_check['username']."','".get_ipaddress()."',now())";
            $database->query($query);

            if ($_POST['remember_me'] == "true") {
                setcookie(protect('encrypt', 'user_username'), $email, time() + 7776000, '/', str_replace("www.", "", $_SERVER['HTTP_HOST']));
                setcookie(protect('encrypt', 'user_password'), protect('encrypt', $password), time() + 7776000, '/', str_replace("www.", "", $_SERVER['HTTP_HOST']));
            }

            echo '<script>window.location.href="dashboard.php"</script>';
            exit();
        } else {
            $fail_message = "Your Account has Suspended";
        }
    } else {
        $fail_message = "Incorrect Email / Password";
    }
}
?>
<!DOCTYPE html>
<html>
<? include('head.php') ?>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <center><img src="../img/logo.png" width="300px" alt="ECOGREEN"></center>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in</p>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" maxlength="150" placeholder="Email" name="email" required
                       value="<?= protect('decrypt', $_COOKIE[protect('encrypt', 'user_username')]) ?>">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" maxlength="150" placeholder="Password" name="password"
                       value="<?= protect('decrypt', $_COOKIE[protect('encrypt', 'user_password')]) ?>"
                       required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember_me" value="true"> Remember Me
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
            </div>
        </form>
    </div>
</div>

<? include('js.php') ?>
</body>
</html>
