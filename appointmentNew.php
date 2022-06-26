<?php
include "header.php";

//choose Date and Session first, then only show available place
$bloodbank = "SELECT DonationCentre.*, BloodBankCentre.* FROM DonationCentre
              INNER JOIN BloodBankCentre ON DonationCentre.CentreID = BloodBankCentre.CentreID";
$mobile = "SELECT DonationCentre.*, MobileCentre.* FROM DonationCentre 
           INNER JOIN MobileCentre ON DonationCentre.CentreID = MobileCentre.CentreID";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['appoint'])) {
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
    $minDate = date("Y-m-d");
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

        $getLastDate = "SELECT LastDonationDate FROM Donor WHERE UserID = $userID";
        $lastDateResult = mysqli_query($conn, $getLastDate);
        $getLastDate = mysqli_fetch_assoc($lastDateResult);
        $lastDate = $getLastDate['LastDonationDate'];
        $datetime = new DateTime($lastDate);

        if ($status == "completed" || $status == "cancelled") {
            $msgVis = "block";
            if ($status == "cancelled") {
                $checkApt = "SELECT Appointment.*,BloodDonation.DonationType FROM Appointment
                             INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
                             WHERE Appointment.DonorID = $userID AND AppointmentStatus = 'completed'
                            ORDER BY Appointment.AppointmentID DESC LIMIT 1";
                $checkResult = mysqli_query($conn, $checkApt);
                $getDonation = mysqli_fetch_assoc($checkResult);
            }
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
            overflow-y: auto;
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
            <div class="container shadow-sm rounded border w3-padding" id='form'>
                <h3 class='w3-center' id='hasApt'>We appreciate your kindness, but you have an ongoing
                    <a href='appointment.php' style="color:blue;">appointment</a> to attend.
                </h3>
                <div style="display:<?php echo $msgVis ?>;">
                    <h4><?php echo $message ?>
                        <hr>
                    </h4>
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
                <div class="form-group mb-2">
                    <button type="submit" id="appoint" name="appoint" class="btn btn-primary btn-block" onclick="return  confirm('Are you sure?')">Done</button>
                </div>
            </div>
        </form>

        <hr style="margin-top:5vh;">

        <h1 class="mb-4">Centre Details</h1>
        <div class="container shadow rounded border w3-padding" id='centreDetails'>
            <div class='row mt-4'>
                <h3 class='col'>Blood Bank</h3>
                <input type='text' id='bFilter' class='col form-check-input px-1 py-3 rounded' placeholder='Search...'>
            </div>
            <table class="table table-hover table-striped mt-3 mb-5">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Centre</th>
                        <th scope="col">Address</th>
                        <th scope="col">Tel No.</th>
                        <th scope="col">Tel Fax</th>
                    </tr>
                </thead>
                <tbody id='bTable'>
                    <?php
                    $result = mysqli_query($conn, $bloodbank);
                    $index = 1;
                    while ($getCentre = mysqli_fetch_assoc($result)) {
                        echo "
                <tr>
                    <td scope='row'>$index</td>
                    <td>$getCentre[CentreName]</td>
                    <td class='col-5'>$getCentre[CentreAddress]</td>
                    <td>$getCentre[TelNo]</td>
                    <td>$getCentre[TelFax]</td>
                </tr>";
                        $index++;
                    }
                    ?>
                </tbody>
            </table>
            <div class='row'>
                <h3 class='col'>Mobile Centre</h3>
                <input type='text' id='mFilter' class='col form-check-input px-1 py-3 rounded' placeholder='Search...'>
            </div>
            <table class="table table-hover table-striped mt-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Centre</th>
                        <th>Address</th>
                        <th>Organizer</th>
                        <th>Tel No.</th>
                        <th>Start</th>
                        <th>End</th>
                    </tr>
                </thead>
                <tbody id='mTable'>
                    <?php
                    $result = mysqli_query($conn, $mobile);
                    $index = 1;
                    while ($getCentre = mysqli_fetch_assoc($result)) {
                        echo "
                <tr>
                    <td scope='row'>$index</td>
                    <td class='col-2'>$getCentre[CentreName]</td>
                    <td class='col-3'>$getCentre[CentreAddress]</td>
                    <td class='col-2'>$getCentre[OrganizerName]</td>
                    <td>$getCentre[TelNo]</td>
                    <td>$getCentre[StartDate]</td>
                    <td>$getCentre[EndDate]</td>
                </tr>";
                        $index++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
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

        function setMaxDate(centreValue) {
            const date = document.getElementById("date");
            let text = centreValue.split(",");

            centreID = text[0];
            startDate = text[1];
            endDate = text[2];
            date.disabled = false;
            date.value = startDate;
            date.min = startDate;
            date.max = endDate;

            //bloodbank
            if (startDate == undefined) {
                date.min = "<?php echo $minDate ?>";
                date.value = "<?php echo $minDate ?>";
            }
        }
    </script>

    <!-- sorttable -->
    <script>
        $('th').click(function() {
            var table = $(this).parents('table').eq(0)
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
            this.asc = !this.asc
            if (!this.asc) {
                rows = rows.reverse()
            }
            for (var i = 0; i < rows.length; i++) {
                table.append(rows[i])
            }
        })

        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index),
                    valB = getCellValue(b, index)
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
            }
        }

        function getCellValue(row, index) {
            return $(row).children('td').eq(index).text()
        }
    </script>

    <!--search table-->
    <script>
        $(document).ready(function() {
            $("#bFilter").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#bTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $("#mFilter").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#mTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>