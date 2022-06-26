<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Kuala_Lumpur");

include "dbConnection.php";

if ($userType == 'staff') {
    header('Location: staff/dashboard.php');
    ob_end_flush();
    exit();
}

//redirect user away from login and register if logged in
function redirectHome($userType)
{
    if ($userType == 'staff') {
        header('Location: staff/dashboard.php');
        ob_end_flush();
        exit();
    }
    if ($userType == "donor") {
        header('Location: index.php');
        ob_end_flush();
        exit();
    }
}
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
    <!--w3cs-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!--font-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css -->
    <link rel="stylesheet" href="style/style.css">

    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        header {
            background-color: white !important;
            z-index: 999;
            box-shadow: 5px 5px 5px lightgrey;
        }

        .navbar-brand {
            margin-left: 2%;
            font-size: 3.5vh !important;
            font-weight: bold;
        }
    </style>
    
</head>

<body>
    <header class='shadow-sm'>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a href="index.php" style="text-decoration:none;"><img src="img/logo.png" width="40" height="40">Home</a>
                <a class="navbar-brand" href="index.php" style="color:#ff7169;">Blood Donation</a>
                <?php if (isset($_SESSION['UserID'])) {
                    $logout = "\"logout.php\"";
                    echo "<button type='button' class='btn btn-danger' onclick='location.href=$logout;'>Log Out</button>";
                } else {
                    $login = "\"login.php\"";
                    echo "<button type='button' class='btn btn-warning' onclick='location.href=$login;'>Log In</button>";
                } ?>
            </div>
        </nav>
    </header>

</body>

</html>