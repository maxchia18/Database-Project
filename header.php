<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Kuala_Lumpur");

include "dbConnection.php";

// if ($_SESSION['role'] == 'admin') {
//     header('Location: dashboard.php');
//     ob_end_flush();
//     exit();
// }

?>

<!DOCTYPE html>
<html>

<head>
    <title>Blood Donation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/logo.png">
    <!-- bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--font-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        html,
        body {
            height: 100%;
        }

        nav {
            background-color: lightyellow;
        }

        .navbar-brand {
            font-size: 5vh !important;
        }

        #menu {
            text-decoration: none !important;
            font-size: large !important;
            color: black !important;
            padding-right: 10px;
        }

        #menu:hover {
            color: red !important;
            transition: 0.2s;
        }

        #profile,
        #history {
            padding-right: 15px;
        }
    </style>
</head>

<body>
    <header class="shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand h1" href="index.php"><img src="img/logo.png" width="50" height="50">Blood Donation</a>
                <div class="dropdown">
                    <button class="btn" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i id="menu" class="fa-solid fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="profile.php"><i id="profile" class="fa fa-user"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="history.php"><i id="history" class="fa fa-history"></i>History</a></li>
                    </ul>
                </div>

            </div>
        </nav>
    </header>
</body>

</html>