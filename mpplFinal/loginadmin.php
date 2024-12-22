<?php 
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($connection, "SELECT * FROM admin WHERE username = '$username' AND password='$password'")
        or die(mysqli_error($connection));
    
    $cek = mysqli_num_rows($data);
    if ($cek > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = 'login';
        header("Location: alldataadmin.php");       
        exit();
    } else {
        header("Location: loginadmin.php?pesan=gagal");
        exit();
    }
}
                                    

                                
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LOGIN ADMIN</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </head>    
    <style>
        .content { 
          background-image: url('assets/bgreal.jpg');
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: 100% 100%;
        }
        body {
             background: linear-gradient(to bottom, #D9D9D9, #6F96E8); /* Dari oranye ke kuning */
        }
        .divider:after,
        .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
        }
        .h-custom {
        height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
        .h-custom {
        height: 100%;
        }
        }

        @keyframes animasiColor {
        0%{
            background-position:  left;
        }
        100%{
            background-position:  right;
        }
        }

        body{
            background-repeat: no-repeat;
            animation: animasiColor 2s infinite alternate;
            transition: all ease;
            overflow-y: hidden; 
        }
        input::placeholder {
            font-size: 14px; /* Atur ukuran font sesuai kebutuhan */
            color: gray; /* (Opsional) Atur warna placeholder */
            font-style: italic; /* (Opsional) Tambahkan gaya teks */
        }
        
        

    </style>
<body class="content">
    <section class="vh-100 bg-foto">
    
        <div class="container py-5 h-100 ">
        <div class="row d-flex justify-content-center align-items-center h-100 ">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class=" card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                    <h3 class="mb-4 text-center"><strong>ADMIN</strong></h3>
                        <form method="POST" action="">
                            <div class="inputan">
                                <div class="form-outline mb-4">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="Input Username" name="username" required/>
                                </div>
                    
                                <div class="form-outline mb-5">
                                    <label class="form-label" >Password</label>
                                    <input type="password" class="form-control form-control-lg" placeholder="Input password" name="password" require/>
                                </div>
                        
                            </div>
                            <?php
                                if(isset($_GET['pesan'])){
                                    if($_GET['pesan'] == "gagal") {
                                        $error_msg[] = "Login gagal! username dan password salah!";
                                    } else if($_GET['pesan'] == "logout") {
                                        $success_msg[] = "Anda telah berhasil logout!";
                                    } else if($_GET['pesan'] == "belum_login") {
                                        $warning_msg[] = "Anda harus login terlebih dahulu!";
                                    } else if($_GET['pesan'] == "signup_berhasil") {
                                        $success_msg[] = "Akun Berhasil Dibuat!";
                                    } else if($_GET['pesan'] == "error") {
                                        $error_msg[] = "ERROR!";
                                    }  

                                }
                            ?>
                            <!-- Checkbox -->
                            <div class="text-center">
                                <button class="btn btn-secondary btn-lg btn-block d-grip col-12 mx-auto text-center-round" name="loginA">Login</button>

                                <hr class="my-4">
                                <a href="loginsiswa.php">
                                    <p class="nav-link" style="text-align: center; font-size: 15px;">As Siswa</p>
                                </a>
                                <p>Don't have a user account yet? Register <a href="registeradmin.php" class="link-info">here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="row">
                    <a href="landingpage.php">
                        <button type="button" class="btn btn-outline-light"><i class="bi bi-arrow-left"></i> Back</button>
                    </a>
                </div>

                <h1 class="my-4 display-3 fw-bold text-light">Make a positive  <br />
                    <span class="text-light">impact for the next generation</span>
                </h1>

                <p class="text-light">
                    <p class="text-light">
                    Update data to provide 
                    an engaging experience
                    </p>
                </p>
            </div>
        </div>
        </div>
    
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
