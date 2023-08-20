<?php
// error_reporting(E_ALL & ~E_NOTICE);
// ini_set('display_errors', 1);

session_start();

include('../core/beon_core.php');

if (!verify_session()) {
    header("Location: /?msg=error_access");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Link Pribadi adalah sebuah layanan yang memungkinkan Anda untuk mempersingkat tautan yang panjang menjadi lebih singkat.">
    <link rel="icon" href="https://linkpirbadi.b-cdn.net/assets/img/bingung.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://linkpirbadi.b-cdn.net/assets/img/bingung.png" type="image/x-icon">
    <title><?= get_user(); ?></title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://linkpirbadi.b-cdn.net/assets/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.linkpribadi.my.id/assets/css/vendors/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="https://cdn.linkpribadi.my.id/assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="https://cdn.linkpribadi.my.id/assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="https://cdn.linkpribadi.my.id/assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="https://cdn.linkpribadi.my.id/assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/css/bootstrap5-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap5-toggle@5.0.4/js/bootstrap5-toggle.ecmas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

    <!-- data table-->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" />
</head>


<body>
    <div class="container">
        <div class="navbar-simple mb-3 mt-3">
            <div class="row text-center">
                <div class="col-lg-3">
                    <div class="card-link">
                        <a class="nav-svg <?php if ($_SERVER['REQUEST_URI'] == "/dashboard/home.php") {
                                                echo "active";
                                            } ?>" href="home.php">
                            <img class="link-svg" src="../assets/img/dashboard.svg">
                            Dashboard
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card-link">
                        <a class="nav-svg <?php if ($_SERVER['REQUEST_URI'] == "/dashboard/domain.php") {
                                                echo "active";
                                            } ?>" href="domain.php">
                            <img class="link-svg" src="../assets/img/domain.svg">
                            Domain
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card-link">
                        <a class="nav-svg <?php if ($_SERVER['REQUEST_URI'] == "/dashboard/traffic.php") {
                                                echo "active";
                                            } ?>" href="traffic.php">
                            <img class="link-svg" src="../assets/img/traffic.svg">
                            Traffic
                        </a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card-link">
                        <a href="../autoheader.php" class="nav-svg">
                            <img class="link-svg" src="../assets/img/logout.svg">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>