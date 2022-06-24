<?php
include "header.php";

$bloodbank = "SELECT * FROM DonationCentre WHERE CentreType = 'B'";
$mobile = "SELECT DonationCentre.*, MobileCentre.StartDate, MobileCentre.EndDate FROM DonationCentre 
           INNER JOIN MobileCentre ON DonationCentre.CentreID = MobileCentre.CentreID";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $centre = explode(",", $_POST['centre']);
    $date = $_POST['date'];
    $session = $_POST['session'] . ":00:00";

    $centreID = $centre[0];
    $insertApt = "INSERT INTO Appointment(DonorID, AppointedDate, AppointedSession, CentreID)
                  VALUES ('$userID','$date','$session','$centreID')";

    if ($centre != "" && $session != "") {
        if (mysqli_query($conn, $insertApt)) {
            echo "<script>
                alert('Appointment on " . $date . " at " . $session . " made successfully');
                </script>";
        }
    } else {
        $errVis = "block";
        $errMsg = "Please select all required fields.";
    }
}

$checkApt = "SELECT * FROM Appointment WHERE DonorID = $userID LIMIT 1";
$checkResult = mysqli_query($conn, $checkApt);
$row = mysqli_num_rows($checkResult);
$isCompleted = mysqli_fetch_assoc($checkResult);

if ($row == 0 || ($row==1 && $isCompleted['IsCompleted']==0)) {
    $hasApt = "block";
    $noApt = "none";
} else if($row == 1 && $isCompleted['IsCompleted']==1) {
    $hasApt = "none";
    $noApt = "block";
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            overflow: hidden;
        }

        label {
            font-weight: 600;
        }

        .sidebar {
            height: 120%;
            width: 20%;
            position: fixed;
            z-index: 1;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            padding-top: 20px;
            background-color: rgb(255, 40, 40);
        }

        .main {
            margin-left: 20%;
            height: 92vh;
        }

        #hasApt {
            display: <?php echo $hasApt ?>;
        }

        .form-group {
            display: <?php echo $noApt ?>;
        }

        .alink {
            text-decoration: none;
            color: black;
            margin: 10%;
            transition: 0.5s;
            vertical-align: middle;
        }

        #link2:hover {
            color: white;
            transition: 0.5s;
        }

        .bg {
            margin: 5% auto;
            width: 105%;
        }

        #bg2 {
            background-color: white;
            border-radius: 25px;
        }
    </style>

    <script>
        function setMaxDate(passedvalue) {
            const date = document.getElementById("date");
            let text = passedvalue.split(",");

            startDate = text[1];
            endDate = text[2];
            date.min = startDate;
            date.max = endDate;

            if (startDate == undefined) {
                date.min = new Date().toLocaleDateString('en-ca');
            }
        }
    </script>
</head>

<body>
    <div class="sidebar">
        <div class="w3-center"><i class="fas fa-syringe w3-xxxlarge"></i>
            <h2 class="mb-4">Appointment</h2>
        </div>
        <div class='bg' id="bg1">
            <a id="link2" class='alink' href="appointment.php">Check Appointment
                <i class="fa fa-check-circle" style="margin-left:14.3%;"></i></a>
            </a>
        </div>
        <div class='bg' id="bg2">
            <a id="link1" class='alink' href="#"> New Appointment
                <i class="fa fa-plus-circle" style="margin-left:19.3%;"></i></a>
        </div>
    </div>
    <div class="main w3-padding-large">
        <form id="aptForm" method="POST">
            <h1 class="mb-4">New Appointment</h1>
            <div class="container shadow rounded w3-padding" id='form'>
                <h3 class='w3-center' id='hasApt'>We appreciate your kindness, but you have an ongoing
                    <a href='appointment.php'>appointment</a> to attend.
                </h3>
                <div class="form-group mb-3">
                    <label class="form-label" for="centre">Donation Centre</label>
                    <select class="form-select w3-padding" name="centre" id="centre" onchange="setMaxDate(this.value);" required>
                        <option value="" disabled selected hidden>- Select Donation Centre -</option>
                        <optgroup label="Blood Bank">
                            <?php
                            $result = mysqli_query($conn, $bloodbank);
                            while ($centre = mysqli_fetch_assoc($result)) {
                                echo "<option value='$centre[CentreID]'>$centre[CentreName]</option>";
                            } ?>
                        </optgroup>
                        <optgroup label="Mobile Centre">
                            <?php
                            $result = mysqli_query($conn, $mobile);
                            while ($centre = mysqli_fetch_assoc($result)) {
                                $value = $centre['CentreID'] . "," . $centre['StartDate'] . "," . $centre['EndDate'];
                                echo "<option value='$value'>$centre[CentreName]</option>";
                            } ?>
                        </optgroup>
                    </select>
                </div>

                <div class="row">
                    <div class="form-group mb-3 col">
                        <label class="form-label" for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" required />
                    </div>
                    <div class="form-group mb-3 col">
                        <label class="form-label" for="session">Session</label>
                        <select class="form-select" id="session" name="session" required>
                            <option value="" disabled selected hidden>- Select Donation Session -</option>
                            <?php
                            $session = 8;
                            while ($session < 17) {
                                if ($session < 10) {
                                    $time = "0" . $session . ":00:00";
                                } else {
                                    $time = $session . ":00:00";
                                }
                                echo "<option value='$session'>$time</option>";
                                $session++;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" id="signUp" name="signUp" class="btn btn-primary btn-block" onclick="return  confirm('Are you sure?')">Done</button>
                </div>
            </div>
    </div>
    </form>
    </div>

</body>

</html>