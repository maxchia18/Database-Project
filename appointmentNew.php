<?php
include "header.php";

//choose Date and Session first, then only show available place

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

$checkApt = "SELECT * FROM Appointment WHERE DonorID = $userID ORDER BY AppointmentID DESC LIMIT 1";
$checkResult = mysqli_query($conn, $checkApt);
$row = mysqli_num_rows($checkResult);
$AppointmentStatus = mysqli_fetch_assoc($checkResult);
$msgVis = "none";
$message = "";

if ($row == 0) {
    $hasApt = "none";
    $noApt = "block";
} else {
    $status = $AppointmentStatus['AppointmentStatus'];
    if ($status == "ongoing") {
        $hasApt = "block";
        $noApt = "none";
    } else {
        $hasApt = "none";
        $noApt = "block";
        $getDonation = "SELECT DonationType FROM BloodDonation WHERE AppointmentID = $AppointmentStatus[AppointmentID]";
        $getDonationResult = mysqli_query($conn, $getDonation);
        $getDonation = mysqli_fetch_assoc($getDonationResult);

        $lastDate = $AppointmentStatus['AppointedDate'];
        $datetime = new DateTime($lastDate);

        if ($status == "completed") {
            $msgVis = "block";
            if ($getDonation['DonationType'] == 'w') {
                $datetime->modify('+2 months');
                $minDate = $datetime->format('Y-m-d');
                $message = "Thank you for your whole blood donation, you are advised to rest for 2 months (until $minDate) before next donation.";
            } else if ($getDonation['DonationType'] == 'a') {
                $datetime->modify('+2 weeks');
                $minDate = $datetime->format('Y-m-d');
                $message = "Thank you for your aphresis blood donation, you are advised to rest for 2 weeks (until $minDate) before next donation.";
            }
        } else if ($status == "rejected") {
            $msgVis = "block";
            $datetime->modify('+2 weeks');
            $minDate = $datetime->format('Y-m-d');
            $message = "Due to your health condition, you are advised to rest for 2 weeks (until $minDate) before making new appointment.";
        }
    }
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
            background-color: #ff7169;
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
            <div class="container shadow rounded w3-padding border" id='form'>
                <h3 class='w3-center' id='hasApt'>We appreciate your kindness, but you have an ongoing
                    <a href='appointment.php'>appointment</a> to attend.
                </h3>
                <div style="display:<?php echo $msgVis ?>;">
                    <h3><?php echo $message ?>
                        <hr>
                    </h3>
                </div>
                <div class="row">
                    <div class="form-group mb-3 col">
                        <label class="form-label" for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" min="<?php echo $minDate ?>" onchange="setCentre(this.value);" required />
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
                    <label class="form-label" for="centre">Donation Centre</label>
                    <select class="form-select w3-padding" name="centre" id="centre" onchange="setMaxDate(this.value);" disabled required>
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
                            $mobileRow = mysqli_num_rows($result);
                            $i = 0;
                            while ($centre = mysqli_fetch_assoc($result)) {
                                $value = $centre['CentreID'] . "," . $centre['StartDate'] . "," . $centre['EndDate'];
                                echo "<option id='mobile$i' value='$value'>$centre[CentreName]</option>";
                                $i++;
                            } ?>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" id="signUp" name="signUp" class="btn btn-primary btn-block" onclick="return  confirm('Are you sure?')">Done</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function setCentre(date) {
            const datePicker = document.getElementById("date");
            const centre = document.getElementById("centre");
            centre.disabled = false;
            let parsedDate = new Date(date);
            let row = <?php echo $mobileRow; ?>;
            let startDate = [];
            let endDate = [];

            for (let i = 0; i < row; i++) {
                var mobileCentre = document.getElementById("mobile" + i);
                let splitDate = mobileCentre.value.split(',');
                startDate[i] = splitDate[1];

                let tempStartDate = new Date(startDate[i]);
                if (parsedDate > tempStartDate) {
                    mobileCentre.disabled = true;
                } else {
                    mobileCentre.disabled = false;
                }
            }
        }

        function setMaxDate(passedvalue) {
            const date = document.getElementById("date");
            let text = passedvalue.split(",");

            startDate = text[1];
            endDate = text[2];
            date.disabled = false;
            date.value = startDate;
            date.min = startDate;
            date.max = endDate;

            if (startDate == undefined) {
                date.min = "<?php echo $minDate ?>";
                date.value = "<?php echo $minDate ?>";
            }
        }
    </script>
</body>

</html>