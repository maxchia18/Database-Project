<?php
include "staffHeader.php";
$getStaff = "SELECT User.*, Staff.CentreID FROM User
             INNER JOIN Staff ON User.UserID = Staff.UserID ORDER BY Staff.UserID";
$result = mysqli_query($conn, $getStaff);


$bloodbank = "SELECT DonationCentre.*, BloodBankCentre.* FROM DonationCentre
              INNER JOIN BloodBankCentre ON DonationCentre.CentreID = BloodBankCentre.CentreID";
$mobile = "SELECT DonationCentre.*, MobileCentre.* FROM DonationCentre 
           INNER JOIN MobileCentre ON DonationCentre.CentreID = MobileCentre.CentreID";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['confirmEdit'])) {
        $staffID = $_POST['editStaffID'];
        $getAllStaff = "SELECT * FROM Staff";
        $staffResult = mysqli_query($conn, $getAllStaff);
        $staffArray = [];
        while ($staff = mysqli_fetch_assoc($staffResult)) {
            array_push($staffArray, $staff['UserID']);
        }
        if (in_array($staffID, $staffArray) == 0) {
            echo "<script>
            alert('Staff ID does not exist.'); 
            window.location.href = 'staffData.php';
            </script>";
        }
    }

    if (isset($_POST['editBtn'])) {
        $centre = explode(",", $_POST['centre']);
        $centreID = $centre[0];
        $staffID = $_POST['submitStaffID'];

        $SQL = "UPDATE Staff SET CentreID = '$centreID' WHERE UserID = $staffID";
        if (mysqli_query($conn, $SQL)) {
            echo "<script>
            alert('Staff #'+$staffID+' updated successfully.');
            window.location.href = 'staffData.php';
            </script>";
        } else {
            mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <style>

    </style>

    <script type="text/javascript">

        $(window).on('load', function() {
            document.getElementsByName('submitStaffID').value = <?php echo $staffID;?>;
            $('#editStaff').modal('show');
        });
    </script>
</head>

<body>
    <?php
    $getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND AppointmentStatus = 'ongoing' ORDER BY AppointedDate,AppointedSession";
    $getAptResult = mysqli_query($conn, $getAppointment);
    $aptCount = mysqli_num_rows($getAptResult); ?>
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a class="nav-link" href='staffApt.php'>Appointment<span class="count"><?php echo $aptCount; ?></span></a></li>
        <li class="nav-item"><a class="nav-link" href="staffDonHistory.php">Donation Records</a></li>
        <li class="nav-item"><a class="nav-link" href="staffBloodStock.php">Blood Stock</a></li>
        <li class="nav-item"><a class="nav-link" href="donorData.php">Donor</a></li>
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="staffData.php">Staff</a></li>
    </ul>

    <div class="content container border w3-round-large w3-padding " style="height:80vh;overflow:auto;">
        <div class="row justify-content-around">
            <h3 class="col-10">Staffs<span class="index"># ➜ Staff ID</h3>
            <div class="form-group mb-2 col">
                <button type="button" class='btn btn-success w3-round p-1 px-2 col float-end' id="addBtn" name='addStaff' data-bs-toggle='modal' data-bs-target='#addStaff'><i class="fa fa-plus"></i></button>
            </div>
            <div class="form-group mb-2 col">
                <button type="button" class='btn btn-warning w3-round p-1 mx-2 float-end' id="editBtn" name='editStaff' data-bs-toggle='modal' data-bs-target='#editStaff'>Edit</button>
            </div>
            <div class="form-group mb-2 col">
                <button type="button" class='btn btn-danger w3-round p-1 px-2 float-end' id="delBtn" name='delStaff' data-bs-toggle='modal' data-bs-target='#delStaff'><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Centre</th>
                    <th scope="col">Centre Type</th>

                </tr>
            </thead>
            <tbody>
                <?php
                while ($staff = mysqli_fetch_assoc($result)) {
                    $getCentre = "SELECT CentreName,CentreType FROM DonationCentre WHERE CentreID = $staff[CentreID]";
                    $getCentreResult = mysqli_query($conn, $getCentre);
                    $centreData = mysqli_fetch_assoc($getCentreResult);
                    if ($centreData['CentreType'] == 'B') {
                        $centreType = "Blood Bank";
                    } else {
                        $centreType = "Mobile Centre";
                    }
                    echo "<tr>
                    <td scope='row'><b>$staff[UserID]</b></td>
                    <td>$staff[FirstName] $staff[LastName]</td>
                    <td>$staff[Gender]</td>
                    <td>$staff[Email]</td>
                    <td>$centreData[CentreName]</td>
                    <td>$centreType</td>
                </tr>";
                } ?>
            </tbody>
        </table>
        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<h2 class='w3-center mt-5'>No new appointment, check back later.</h2>";
        } ?>
    </div>

    <!-- editModal -->
    <div class="modal fade" id="editStaff" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editStaffLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <?php
                    $getStaffData = "SELECT User.*, Staff.CentreID FROM User
                                    INNER JOIN Staff ON User.UserID = $staffID";
                    $result = mysqli_query($conn, $getStaffData);
                    $staffData = mysqli_fetch_assoc($result);
                    ?>
                    <h5 class="modal-title" id="editStaffLabel">Edit Staff #<?php echo $staffID . " " . $staffData['FirstName'] . " " . $staffData['LastName']; ?></h5>
                    <button type="button" class="btn-close" onclick="window.location.href='staffData.php'" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCentre" action="editStaff.php" method="POST">
                        <input type="hidden" name="submitStaffID" value='<?php echo $staffID;?>'>
                        <select class="form-select w3-padding" name="centre" id="centre" required>
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
                        <div class="modal-footer">
                            <button type="submit" id="editBtn" name="editBtn" class="btn btn-warning">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function toggle() {
            var x = document.getElementById("password");
            var toggle = document.getElementById("toggleEye");
            if (x.type === "password") {
                x.type = "text";
                toggle.className = "fa fa-eye-slash";
            } else {
                x.type = "password";
                toggle.className = "fa fa-eye";
            }
        }

        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('.name').keyup(function(event) {
                var textBox = event.target;
                var start = textBox.selectionStart;
                var end = textBox.selectionEnd;
                textBox.value = textBox.value.charAt(0).toUpperCase() + textBox.value.slice(1);
                textBox.setSelectionRange(start, end);
                return textBox.value;
            });
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
</body>

</html>