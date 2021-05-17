<?php
/**
 * Created by PhpStorm.
 * User: Programmer-ITG
 * Date: 12/8/2017
 * Time: 2:55 PM
 */
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Back-End</title>
    <?php include 'backend/components/link.php'; ?>
    <?php include 'backend/process/backend_process.php'; ?>
    <style>
        body {
            font-family: THSarabunNew;
        }
    </style>
</head>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<?php include 'backend/components/script.php'; ?>
<?php if (isset($_SESSION['BID'])): ?>
    <?php include 'backend/components/menu.php'; ?>
<?php endif; ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <?php
        if (isset($_GET['r'])) {
            switch ($_GET['r']) {
                case 'index';
                    if (isset($_SESSION['BID'])) {
                        include 'backend/index.php';
                    } else {
                        include 'backend/process/login.php';
                    }
                    break;
                case 'add';
                    if (isset($_SESSION['BID'])) {
                        include 'backend/create.php';
                    } else {
                        include 'backend/process/login.php';
                    }
                    break;
                case 'view';
                    if (isset($_SESSION['BID'])) {
                        include 'backend/view.php';
                    } else {
                        include 'backend/process/login.php';
                    }
                    break;
                case 'pay';
                    if (isset($_SESSION['BID'])) {
                        include 'backend/pay.php';
                    } else {
                        include 'backend/process/login.php';
                    }
                    break;
                case 'welfare';
                    if (isset($_SESSION['BID'])) {
                        include 'backend/welfare.php';
                    } else {
                        include 'backend/process/login.php';
                    }
                    break;
                case 'print';
                    if (isset($_SESSION['BID'])) {
                        include 'print.php';
                    } else {
                        include 'backend/process/login.php';
                    }
                    break;
                case 'logout';
                    include 'backend/process/logout.php';
                    break;
                default;
                    include 'backend/process/login.php';
                    break;
            }
        } else {
            include 'backend/process/logout.php';
        }
        ?>
    </div>
</div>
<?php include 'backend/components/footer.php' ?>
</body>
</html>

