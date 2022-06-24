<?php
include "header.php";

$sql = "SELECT * FROM Appointment WHERE DonorID = '$userID' ORDER BY AppointmentID DESC";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);
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
            background-color: 	#ff7169;
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

        .apt {
            padding: 1%;
            padding-bottom: 0;
            box-shadow: 10px 10px lightblue;
            background-color: gold;
        }
    </style>

</head>

<body>
    <div id="sidebar">
        <div class="w3-center"><i class="fas fa-syringe w3-xxxlarge"></i>
            <h2 class="mb-4">Appointment</h2>
        </div>
        <div class='bg' id='bg1'>
            <a id="link2" class='alink' href="#">Check Appointment
                <i class="fa fa-check-circle" style="margin-left:14.3%;"></i></a>
            </a>
        </div>
        <div class='bg' id='bg2'>
            <a id="link1" class='alink' href="appointmentNew.php"> New Appointment
                <i class="fa fa-plus-circle" style="margin-left:19.3%;"></i></a>
        </div>
    </div>
    <div class="main w3-padding-large">
        <h1 class="mb-4">Appointment</h1>
        <div class='apt container rounded w3-round-large my-3'>
        <?php
        if ($count == 0) {
            echo"<h2 class='pt-0 w3-center' id='noRecord'>Seems like you haven't made any appointment yet!</br>
                    <a href='appointmentNew.php'>Make now</a>?
                </h2>";
        } else {
            while ($apt = mysqli_fetch_assoc($result)) {
                $status = $apt['AppointmentStatus'];

                if ($status == "ongoing") {
                    $statusUpdate = "Ongoing";
                    $statusColor = "gold";
                } else if($status == "completed") {
                    $statusUpdate = "Completed";
                    $statusColor = "rgb(50, 190, 50)";
                } else if($status == "cancelled") {
                    $statusUpdate = "Cancelled";
                    $statusColor = "rgb(255, 90, 90)";
                } else if($status == "rejected"){
                    $statusUpdate = "Rejected";
                    $statusColor = "rgb(255, 90, 90)";
                }
                ?><style>.apt{background-color: <?php echo $statusColor?>;}</style><?php
                $getName = "SELECT CentreName FROM DonationCentre WHERE CentreID = $apt[CentreID]";
                $nameResult = mysqli_query($conn, $getName);
                $nameRow = mysqli_fetch_assoc($nameResult);
                echo "
                <h4 class='mb-3'>AppointmentID #$apt[AppointmentID]</h4>        
                <p class='my-2'><i class='fas fa-bell' style='margin-right:2%;'></i>$statusUpdate</p>
                <p class='my-2'><i class='fas fa-map-marker-alt' style='margin-right:2%;'></i>$nameRow[CentreName]</i></p>
                    <div class='w3-row'>
                        <div class='w3-threequarter'>
                            <p><i class='fa fa-calendar-alt' style='margin-right:2.4%;'></i>$apt[AppointedDate], $apt[AppointedSession]</p>
                        </div>
                    </div>
                </div>";
            }
        } ?>
        <!-- <div class='w3-quarter'>
                            <p style='text-align:right;font-size:large;'><i class='fa-solid fa-pen-to-square' style='color:green;'></i></p>
                        </div> -->
    </div>
    </div>
</body>

</html>