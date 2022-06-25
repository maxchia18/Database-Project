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
            background-color: gold;
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

        .his {
            padding: 1%;
            padding-bottom: 0;
            box-shadow: 10px 10px lightblue;
            background-color: rgb(255, 255, 185);
        }

        .detailBtn{
            padding:4% 10%;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div class="w3-center"><i class="fa fa-history w3-xxxlarge"></i>
            <h2 class="mb-4">History</h2>
        </div>
        <div class='bg' id='bg1'>
            <a id="link2" class='alink' href="#">Donation History
                <i class="fa fa-check-circle" style="margin-left:14.3%;"></i></a>
            </a>
        </div>
    </div>
    <div class="main w3-padding-large">
        <h1 class="mb-4">Donation History</h1>
    <?php
    if($count = 0){
        echo "
        <div class='apt container rounded w3-round-large my-3' style='background-color:gold;'>
            <h2 class='pt-0 pb-3 w3-center' id='noRecord'>Seems like you don't have donation record yet!</br>
                <a href='appointmentNew.php'>Make appointment now</a>?
            </h2>";
    } else{
        while($history = mysqli_fetch_assoc($getHistoryResult)){
            $getName = "SELECT CentreName FROM DonationCentre WHERE CentreID = $history[CentreID]";
            $nameResult = mysqli_query($conn, $getName);
            $nameRow = mysqli_fetch_assoc($nameResult);

            if($history['DonationType']=='w'){
                $donationType = "Whole";
            } else{
                $donationType = "Aphresis";
            }
            echo "
            <div class='his container rounded w3-round-large my-3'>
                <div class='row'>
                    <h4 class='col-11'>DonationID #$history[DonationID]</h4>
                    <div class='col'>
                        <button type='button' class='detailBtn col btn btn-warning' title='Donation Details'><i class='fa-solid fa-expand'></i></button>
                    </div>
                </div>
                <p class='mb-2'><i class='fa-solid fa-droplet' style='margin-right:2%;'></i>$donationType, $history[DonationAmount]</p>
                <p class='my-2'><i class='fas fa-map-marker-alt' style='margin-right:2%;'></i>$nameRow[CentreName]</i></p>
                <div class='w3-row'>
                    <div class='w3-threequarter'>
                        <p><i class='fa fa-calendar-alt' style='margin-right:2.4%;'></i>$history[AppointedDate], $history[AppointedSession]</p>
                    </div>
                </div>
            </div>";
        }} ?><?php
        // // if ($count == 0) {
        // //     echo"
        // <div class='apt container rounded w3-round-large my-3' style='background-color:gold;'>
        // <h2 class='pt-0 w3-center' id='noRecord'>Seems like you haven't made any appointment yet!</br>
        //         <a href='appointmentNew.php'>Make now</a>?
        //     </h2>";
        // // } else {
        // //     $i=0;
        // //     while ($apt = mysqli_fetch_assoc($result)) {
        // //         $status = $apt['AppointmentStatus'];

        // //         $getName = "SELECT CentreName FROM DonationCentre WHERE CentreID = $apt[CentreID]";
        // //         $nameResult = mysqli_query($conn, $getName);
        // //         $nameRow = mysqli_fetch_assoc($nameResult);
        // //         echo "
        // //         <div id='apt$i' class='apt container rounded w3-round-large my-3' style='background-color:$statusColor;'>
        // //         <h4 class='mb-3'>AppointmentID #$apt[AppointmentID]</h4>        
        // //         <p class='my-2'><i class='fas fa-bell' style='margin-right:2%;'></i>$statusUpdate</p>
        // //         <p class='my-2'><i class='fas fa-map-marker-alt' style='margin-right:2%;'></i>$nameRow[CentreName]</i></p>
        // //             <div class='w3-row'>
        // //                 <div class='w3-threequarter'>
        // //                     <p><i class='fa fa-calendar-alt' style='margin-right:2.4%;'></i>$apt[AppointedDate], $apt[AppointedSession]</p>
        // //                 </div>
        // //             </div>
        // //         </div>";
        // //         $i++;
        // //     }
        // } 
        ?>
        </div>
        </div>
</body>

</html>