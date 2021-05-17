<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 11/29/2017
 * Time: 1:59 PM
 */
session_start();
include 'asset/asset.php';

?>
<style>
    body {
        font-family: THSarabunNew;
    }
</style>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ระบบเบี้ยยังชีพ</title>
</head>
<body>
<?php

include 'asset/navbar.php';
include 'modules/welfare_new/process/welfare_action.php';
if (isset($_GET['r'])) {
    switch ($_GET['r']) {
        case 'login';
            include 'modules/welfare_new/modal_login.php';
            break;
        case 'index';
            if (isset($_SESSION['ID'])) {
                include 'modules/welfare_new/welfare_new.php';
            } else {
                include 'modules/welfare_new/modal_login.php';
            }
            break;
        case 'request';
            if (isset($_SESSION['ID'])) {
                include 'modules/welfare_new/welfare_request.php';
            } else {
                include 'modules/welfare_new/modal_login.php';
            }
            break;
        case 'result';
            if (isset($_SESSION['ID'])) {
                include 'modules/welfare_new/welfare_result.php';
            } else {
                include 'modules/welfare_new/modal_login.php';
            }
            break;
        case 'history';
            if (isset($_SESSION['ID'])) {
                include 'modules/welfare_new/welfare_history.php';
            } else {
                include 'modules/welfare_new/modal_login.php';
            }
            break;
        case 'register';
            include 'modules/welfare_new/modal_register.php';
            break;
        case 'close';
            echo '<script>window.location.href=\'welfare_index.php?r=login\'</script>';
            break;
        default :
            if (isset($_SESSION['ID'])) {
                include 'modules/welfare_new/welfare_new.php';
            } else {
                include 'modules/welfare_new/modal_login.php';
            }
            break;
    }
} else {
    if (isset($_SESSION['ID'])) {
        echo '<script>window.location.href=\'welfare_index.php?r=index\'</script>';
    } else {
        echo '<script>window.location.href=\'welfare_index.php?r=login\'</script>';
    }
}
?>
</body>
</html>
