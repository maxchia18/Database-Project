<?php
session_start();
ob_start();
date_default_timezone_set("Asia/Kuala_Lumpur");

include "../dbConnection.php";

$getStaff = "SELECT User.*, Staff.CentreID FROM User INNER JOIN Staff WHERE User.UserID = Staff.UserID AND Staff.UserID = $userID";
$result = mysqli_query($conn, $getStaff);
$staffData = mysqli_fetch_assoc($result);
$centreID = $staffData['CentreID'];

$getCentre = "SELECT * FROM DonationCentre WHERE CentreID = $centreID";
$getCentreResult = mysqli_query($conn, $getCentre);
$centreData = mysqli_fetch_assoc($getCentreResult);
$centreName = $centreData['CentreName'];
$staffName = explode(" ", $userName);


if ($userType == "donor") {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../img/logo.png">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!--w3cs-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!--font-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css -->
    <link rel="stylesheet" href="../style/style.css">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .main {
            overflow: auto;
        }

        header {
            background-color: white !important;
            z-index: 999;
            box-shadow: 5px 5px 5px lightgrey;
        }

        .navbar-brand {
            font-size: 3.5vh !important;
            font-weight: bold;
        }

        .content {
            padding: 0.1% 1%;
        }

        .count {
            margin-left: 5%;
            padding: 0.5% 1%;
            font-size: x-small;
            border-radius: 50%;
            color: black;
            background-color: lightseagreen;
        }

        .index {
            font-size: medium;
            font-weight: 600;
            margin-left: 2%;
            color: red;
        }

        .actionBtn {
            width: 50%;
            background-color: rgb(15, 165, 15);
            color: #fff;
            font-weight: bold;
            transition: 0.5s;
        }

        .actionBtn:hover {
            background-color: green;
            color: yellow;
            transition: 0.5s;
        }

        th {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <h4> Welcome, <?php echo $staffName[0]; ?>
                    <span style="font-size:small"><i class='fas fa-map-marker-alt' style='color:#CC333F;'></i> <?php echo $centreName ?>
                </h4>
                <a class="navbar-brand " href="../index.php" style="color:#CC333F;margin-right:20%;">Blood Donation Dashboard</a>
                <?php if (isset($_SESSION['UserID'])) {
                    $logout = "\"../logout.php\"";
                    echo "<button type='button' class='btn btn-danger' onclick='location.href=$logout;'>Log Out</button>";
                } ?>
            </div>
        </nav>
    </header>

</body>

</html>