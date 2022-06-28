<?php
include "header.php";

$getDonor = "SELECT User.*, Donor.*,Blood.BloodGroup FROM User
             INNER JOIN Donor ON User.UserID = Donor.UserID
             INNER JOIN Blood ON User.UserID = Blood.DonorID
             WHERE User.UserID = $userID";
$getDonorResult = mysqli_query($conn, $getDonor);
$getDonor = mysqli_fetch_assoc($getDonorResult);

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

        .link2:hover {
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

        #msg {
            color: red;
        }

        #aptCount {
            background-color: #ffa178;
            transition: 1s;
        }

        #donationCount {
            background-color: rgb(250, 250, 140);
            transition: 1s;
        }

        #aptCount:hover {
            background-color: #ff7169;
            transition: 1s;
            cursor: pointer;
        }

        #donationCount:hover {
            background-color: gold;
            transition: 1s;
            cursor: pointer;
        }

        .count:hover {
            cursor: pointer;
        }

        .link-icon {
            margin-right: 5%;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div class="w3-center"><i class="fa fa-user w3-xxxlarge"></i>
            <h2 class="mb-4">Profile</h2>
        </div>
        <div class='bg'>
            <a class="alink" href="appointment.php"><i class="fa fa-check-circle link-icon"></i>Appointment</a>
        </div>
        <div class='bg'>
            <a class="alink" href="donationHistory.php"><i class="fa fa-history link-icon"></i>Donation History</a>
        </div>
        <div class='bg' id='bg1'>
            <a class="alink" href="profile.php">
                <i class="fa fa-user link-icon"></i>Profile
            </a>
        </div>
    </div>

    <div class="main w3-padding-large">
        <h1 class="mb-4">Profile</h1>
        <div class="container shadow-sm rounded border w3-padding">
            <form id="profile" method="POST">
                <div class="form-group row mb-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="fName">First Name</label>
                        <input type="text" class="form-control" id="fName" name="fName" maxlength="50">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="lName">Last Name</label>
                        <input type="text" class="form-control" id="lName" name="lName" maxlength="50">
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="form-group col">
                        <label class="form-label" for="weight">Weight</label>
                        <input type="text" class="form-control" id="weight" name="weight">
                    </div>
                    <div class="form-group col">
                        <label class="form-label" for="age">Age</label>
                        <input type="text" class="form-control" id="age" name="age">
                    </div>
                    <div class="form-group col">
                        <label class="form-label" for="bloodGroup">Blood Group</label>
                        <input type="text" class="form-control" id="bloodGroup" name="bloodGroup" disabled>
                    </div>
                    <div class="form-group col">
                        <label class="form-label" class="form-label" for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" name="gender" disabled>
                    </div>
                </div>
                <div class="form-group my-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </form>
        </div>

        <?php
        $getCount = "SELECT COUNT(Appointment.AppointmentID) as 'aptCount'
            FROM Appointment WHERE Appointment.DonorID = $userID";
        $getCountResult = mysqli_query($conn, $getCount);
        $getCount = mysqli_fetch_assoc($getCountResult);
        ?>
        <h1 class="mb-2">You have made</h1>
        <div class="row px-2">
            <div class="container rounded border col count p-2" id="aptCount" onclick="window.location.href='appointment.php';">
                <h3>Appointment<span class="float-end"><?php echo $getCount["aptCount"]; ?></span></h3>
            </div>
            <div class="col-1"></div>
            <?php
            $getCount = "SELECT COUNT(BloodDonation.DonationID) as 'donCount'
            FROM Appointment INNER JOIN BloodDonation 
            ON Appointment.AppointmentID = BloodDonation.AppointmentID WHERE Appointment.DonorID = $userID";
            $getCountResult = mysqli_query($conn, $getCount);
            $getCount = mysqli_fetch_assoc($getCountResult);
            ?>
            <div class="container rounded border col count p-2" id="donationCount" onclick="window.location.href='donationHistory.php';">
                <h3><?php echo $getCount["donCount"]; ?><span class="float-end">Donation</span></h3>
            </div>
        </div>
    </div>

    <script>
        $("#profile :input:not(button)").prop("readOnly", true);

        $(document).ready(function() {
            $('#fName').val('<?php echo $getDonor['FirstName']; ?>');
            $('#lName').val('<?php echo $getDonor['LastName']; ?>');
            $('#weight').val('<?php echo $getDonor['Weight']; ?> kg');
            $('#age').val('<?php echo $getDonor['Age']; ?>')
            $('#bloodGroup').val('<?php echo $getDonor['BloodGroup']; ?>');
            $('#gender').val('<?php echo $getDonor['Gender']; ?>');
            $('#email').val('<?php echo $getDonor['Email']; ?>');
        });
    </script>
</body>

</html>