<?php
include "header.php";

$getHistory = "SELECT BloodDonation.*,Appointment.* FROM Appointment 
               INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
               WHERE AppointmentStatus = 'completed' AND Appointment.DonorID = $userID 
               ORDER BY BloodDonation.DonationID";
$getHistoryResult = mysqli_query($conn, $getHistory);
$count = mysqli_num_rows($getHistoryResult);

?>

<!DOCTYPE html>

<html>

<head>
    <style>
        body {
            overflow: hidden;
        }

        #sidebar {
            height: 120%;
            width: 20%;
            position: fixed;
            z-index: 1;
            left: 0;
            overflow-x: hidden;
            padding-top: 20px;
            background-color: #ffca93;
        }

        .main {
            margin-left: 20%;
            margin-bottom: 5%;
            height: 92vh;
            overflow-y: auto !important;
        }

        .alink {
            text-decoration: none;
            color: black;
            margin: 10%;
            transition: 0.5s;
            vertical-align: middle;
        }

        #link1:hover {
            color: white;
            transition: 0.5s;
        }

        .bg {
            margin: 5% auto;
            width: 105%;
        }

        #bg1 {
            background-color: white;
            border-radius: 25px;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div class="w3-center"><i class="fa fa-user w3-xxxlarge"></i>
            <h2 class="mb-4">Profile</h2>
        </div>
        <div class='bg' id='bg1'>
            <a id="link2" class='alink' href="#">My Profile
                <i class="fa fa-user" style="margin-left:14.3%;"></i></a>
            </a>
        </div>
    </div>

    <div class="main w3-padding-large">
        <h1 class="mb-4">My Profile</h1>
        <div class="container shadow-sm rounded border w3-padding">

        </div>
    </div>
</body>

</html>