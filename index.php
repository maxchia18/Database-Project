<?php
include "header.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Blood Donation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" href="img/logo.png">
   
    <style>
        body {
            margin: auto;
            text-align: center;
        }

        h1, h3{
            margin-bottom: 3vh;
        }

        #history, #appointment, #profile{
            padding-top:30% !important;
            height: 60vh !important;
        }

        #history{
            background-color: rgb(254, 254, 140);
            transition:1.5s;
        }

        #history:hover{
            background-color: gold;
            transition:1.5s;
        }
    
        #appointment{
           background-color: rgb(225, 75, 75);
           transition:1.5s;
        }

        #appointment:hover{
            background-color: rgb(255,40,40);
            transition:1.5s;
        }

        #profile{
            background-color: rgb(255, 190, 75);
            transition:1.5s;
        }

        #profile:hover{
            background-color: orange;
            transition:1.5s;
        }
    </style>
</head>

<body>
    <?php if (!isset($userID)) {
        header("Location: login.php");
    } ?>
    <h1>Welcome <?php echo $userName ?>!</h1>
    <h3>What would you like to do today?<h3>
    <div class="w3-row-padding w3-margin-bottom">
        <div class="w3-third">
            <div id="history" class="w3-container w3-padding-16 w3-round-xxlarge"
            onclick="location.href='history.php';">
                <div class="w3-center"><i class="fa fa-history w3-xxxlarge"></i></div>
                <div class="w3-clear"></div>
                <h2>History</h2>
            </div>
        </div>
        <div class="w3-third">
            <div id="appointment" class="w3-container w3-padding-16 w3-round-xxlarge w3-text-black"
            onclick="location.href='appointment.php';">
                <div class="w3-center"><i class="fas fa-syringe w3-xxxlarge"></i></div>
                <div class="w3-clear"></div>
                <h2>Appointment</h2>
            </div>
        </div>
        <div class="w3-third">
            <div  id="profile" class="w3-container w3-padding-16 w3-round-xxlarge"
            onclick="location.href='profile.php';">
                <div class="w3-center"><i class="fa fa-user w3-xxxlarge"></i></div>
                <div class="w3-clear"></div>
                <h2>Profile</h2>
            </div>
        </div>
    </div>
</body>


</html>