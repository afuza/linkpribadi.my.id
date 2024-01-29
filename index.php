<?php
session_start();

require_once('core/function.php');

if (verify_session()) {
    header("Location: /dashboard/home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    secure_login($_POST["username"], $_POST["password"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Link Pribadi adalah sebuah layanan yang memungkinkan Anda untuk mempersingkat tautan yang panjang menjadi lebih singkat.">
    <link rel="icon" href="https://zetas.b-cdn.net/linkpribadi/assets/img/bingung.png" type="image/x-icon">
    <link rel="shortcut icon" href="https://zetas.b-cdn.net/linkpribadi/assets/img/bingung.png" type="image/x-icon">
    <title>SHORTLINK</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://zetas.b-cdn.net/linkpribadi/assets/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://zetas.b-cdn.net/assets/css/vendors/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="https://zetas.b-cdn.net/assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="https://zetas.b-cdn.net/assets/css/vendors/themify.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="https://zetas.b-cdn.net/assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">
        <div class="login-card">
            <div class="img-sagiri">
                <img class="img-lo" src="https://zetas.b-cdn.net/linkpribadi/assets/img/sagirigun.png" alt="sagiri">
            </div>
            <div class="col-12">
                <form method="POST" class="login-form">
                    <br />
                    <br />
                    <div class="form-group mb-3">
                        <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                            <input class="form-control" name="username" autocomplete="off" type="text" required="" placeholder="username">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                            <input class="form-control" type="password" name="password" required="" placeholder="*********">
                        </div>
                    </div>
                    <div class="form-group mb-2 text-center">
                        <button class="btn btn-secondary btn-block" type="submit"><i class="icon-key"></i>
                            Signin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <?php
    if (@$_GET['msg'] == "error_login") {
        echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Username atau Password salah!'
      })
    </script>";
    } else if (@$_GET['msg'] == "success_logout") {
        echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Anda berhasil logout!'
      })
    </script>";
    } else if (@$_GET['msg'] == "error_access" || @$_GET['msg'] == "invalid_credentials") {
        echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Anda Tidak Ada Akses!'
      })
    </script>";
    }
    ?>
    <script src="https://zetas.b-cdn.net//assets/js/icons/feather-icon/feather.min.js">
    </script>
    <script src="https://zetas.b-cdn.net//assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Plugin used-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
</body>

</html>