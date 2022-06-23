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
?>

<!DOCTYPE html>
<html>

<head>
    <title>Staff Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/logo.png">
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
            overflow: hidden !important;
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
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <h4> Welcome, <?php echo $userName; ?></h4>
                <a class="navbar-brand" href="index.php" style="color:#CC333F;">Blood Donation Dashboard</a>
                <?php if (isset($_SESSION['UserID'])) {
                    $logout = "\"../logout.php\"";
                    echo "<button type='button' class='btn btn-danger' onclick='location.href=$logout;'>Log Out</button>";
                } ?>
            </div>
        </nav>
    </header>
    <ul class="nav nav-tabs nav-justified my-1" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="appointment-tab" data-bs-toggle="tab" data-bs-target="#appointment" type="button" role="tab" aria-controls="appointment" aria-selected="true">Appointment</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donationRecord-tab" data-bs-toggle="tab" data-bs-target="#donationRecord" type="button" role="tab" aria-controls="donationRecord" aria-selected="false">Donation Record</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="bloodStock-tab" data-bs-toggle="tab" data-bs-target="#bloodStock" type="button" role="tab" aria-controls="bloodStock" aria-selected="false">Blood Stock</button>
        </li>
    </ul>
    <div class="tab-content main" id="myTabContent">
        <div class="tab-pane fade show active w3-padding" id="appointment" role="tabpanel" aria-labelledby="appointment-tab">
            <?php include "staffApt.php"; ?>
        </div>
        <div class="tab-pane fade w3-padding" id="donationRecord" role="tabpanel" aria-labelledby="donationRecord-tab">Donation Record</div>
        <div class="tab-pane fade w3-padding" id="bloodStock" role="tabpanel" aria-labelledby="bloodStock-tab">...</div>
    </div>
</body>

</html>