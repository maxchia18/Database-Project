<?php
include "header.php";

$sql = "SELECT * FROM Appointment WHERE DonorID = '$userID' ORDER BY AppointmentID DESC";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['cancelBtn'])){
        $aptID = $_POST['aptID'];

        $updateCancel = "UPDATE Appointment SET AppointmentStatus = 'cancelled' WHERE AppointmentID = $aptID";
        if($cancelResult = mysqli_query($conn,$updateCancel)){
            echo "<script>alert('Cancelled successfully!');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
            background-color: #ff7169;
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
            box-shadow: 10px 10px lightpink;
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
        <?php
        if ($count == 0) {
            echo "
            <div class='apt container rounded w3-round-large my-3' style='background-color:#ff7169;'>
            <h2 class='pt-0 pb-3 w3-center' id='noRecord'>Seems like you haven't made any appointment yet!</br>
                    <a href='appointmentNew.php'>Make now</a>?
                </h2>";
        } else {
            $i = 0;
            while ($apt = mysqli_fetch_assoc($result)) {
                $status = $apt['AppointmentStatus'];
                $btnVis = "none";

                if ($status == "ongoing") {
                    $statusUpdate = "Ongoing";
                    $statusColor = "rgb(255, 255, 185);";
                    $btnVis = "block";
                } else if ($status == "completed") {
                    $statusUpdate = "<a href='donationHistory.php' target='_blank'>Completed</a>";
                    $statusColor = "lightblue";
                } else if ($status == "cancelled") {
                    $statusUpdate = "Cancelled";
                    $statusColor = "lightsalmon";
                } else if ($status == "rejected") {
                    $statusUpdate = "Rejected";
                    $statusColor = "lightsalmon";
                }
                $getName = "SELECT CentreName FROM DonationCentre WHERE CentreID = $apt[CentreID]";
                $nameResult = mysqli_query($conn, $getName);
                $nameRow = mysqli_fetch_assoc($nameResult);
                echo "
                <div id='apt$apt[AppointmentID]' class='apt container rounded w3-round-large my-3' style='background-color:$statusColor;'>
                    <div class='row'>
                        <h4 class='col-11'>AppointmentID #$apt[AppointmentID]</h4> 
                        <div class='col' id='btn$i' style='display:" ?><?php echo $btnVis; ?><?php
                                                                                                echo "'>
                            <form method='POST'><input type='hidden' name='aptID' value='$apt[AppointmentID]'>
                            <button type='submit' class='cancelBtn col btn btn-danger' name='cancelBtn' title='Cancel Appointment'
                            onclick='return confirm(\"Are you sure you want to cancel?\");'><i class='fa-solid fa-times'></i></button>
                            </form>    
                        </div>
                    </div>       
                    <p class='mb-2'><i class='fas fa-bell' style='margin-right:2%;'></i>$statusUpdate</p>
                    <p class='my-2'><i class='fas fa-map-marker-alt' style='margin-right:2%;'></i>$nameRow[CentreName]</i></p>
                        <div class='w3-row'>
                            <div class='w3-threequarter'>
                                <p><i class='fa fa-calendar-alt' style='margin-right:2.4%;'></i>$apt[AppointedDate], $apt[AppointedSession]</p>
                            </div>
                        </div>
                </div>";
                $i++;
            }
        } ?>
</div>
    </div>
</body>

</html>