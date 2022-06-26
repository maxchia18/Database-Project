<?php

$getStaff = "SELECT User.*, Staff.CentreID FROM User
             INNER JOIN Staff ON User.UserID = Staff.UserID";
$result = mysqli_query($conn, $getStaff);


$bloodbank = "SELECT DonationCentre.*, BloodBankCentre.* FROM DonationCentre
              INNER JOIN BloodBankCentre ON DonationCentre.CentreID = BloodBankCentre.CentreID";
$mobile = "SELECT DonationCentre.*, MobileCentre.* FROM DonationCentre 
           INNER JOIN MobileCentre ON DonationCentre.CentreID = MobileCentre.CentreID";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addStaffBtn'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $centre = $_POST['centre'];
        $usertype = "staff";

        //check for existing ID
        $checkQuery = "SELECT Email FROM User WHERE Email = '$email'";
        $result = mysqli_query($conn, $checkQuery);
        $count = mysqli_num_rows($result);

        if ($count == 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO User(FirstName, LastName, Gender, Email, Password, UserType)
                    VALUES('$fname','$lname','$gender','$email','$password','$usertype')";
            if (mysqli_query($conn, $sql)) {
                $userID = mysqli_insert_id($conn);
                $sql2 = "INSERT INTO Staff(UserID, CentreID)
                        VALUE('$userID','$centre')";

                if (mysqli_query($conn, $sql2)) { ?>
                    <script type="text/JavaScript">
                        alert("New staff added successful.");
                    </script><?php
                    echo "<meta http-equiv='refresh' content='0'>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        } else {
            echo '<script type ="text/JavaScript">';
            echo 'alert("Email exists.")';
            echo '</script>';
        }
    }

    if(isset($_POST['removeBtn'])){
        $staffID = $_POST['staffID'];

        $delSQL = "DELETE FROM User WHERE UserID = $staffID";
        if(mysqli_query($conn,$delSQL)){
            echo "<script>alert('Staff #'+$staffID+' deleted.')</script>";
        }else{
            mysqli_error($conn);
        }
    }

                // 70019@siswa.unimas.my
}


?>

<!DOCTYPE html>

<html>

<head>
    <style>

    </style>

    <script>

    </script>
</head>

<body>
    <div class="content container border w3-round-large w3-padding" style="height:80vh;overflow:auto;">
        <div class="row">
            <h3 class="col-11">Staffs<span class="index"># ➜ Staff ID</h3>
            <div class="col form-group">
                <button type="button" class='addStaff btn btn-success w3-round p-1 px-2' id="addBtn" name='addStaff' data-bs-toggle='modal' data-bs-target='#addStaff'><i class="fa fa-plus"></i></button>
                <button type="button" class='addStaff btn btn-danger w3-round p-1 px-2' id="delBtn" name='delStaff' data-bs-toggle='modal' data-bs-target='#delStaff'><i class="fa fa-minus"></i></button>
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

    <!-- addModal -->
    <div class="modal fade" id="addStaff" tabindex="-1" aria-labelledby="addStaffLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStaffLabel">Add Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="donation" action="" method="POST">
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="fname">First Name</label>
                                    <input type="text" class="form-control name" id="fname" name="fname" placeholder="First Name" onkeydown="return /^[a-zA-Z-'./ ]*$/i.test(event.key)" maxlength="50" required />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="lname">Last Name</label>
                                    <input type="text" class="form-control name" id="lname" name="lname" placeholder="Last Name" onkeydown="return/^[a-zA-Z-'./ ]*$/i.test(event.key)" maxlength="50" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3" id="gender">
                            <label class="form-label">Gender</label></br>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="male" name="gender" value="Male" required>
                                Male<label class="form-check-label" for="male"></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="female" name="gender" value="Female">
                                Female<label class="form-check-label" for="female"></label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" maxlength="50" required />
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="50" required />
                                <span class="input-group-text" onclick="toggle()">
                                    <i id="toggleEye" class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="centre">Donation Centre</label>
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
                                        $value = $centre['CentreID'];
                                        echo "<option id='mobile$i' value='$value'>$centre[CentreName]</option>";
                                        $i++;
                                    } ?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="addStaffBtn" name="addStaffBtn" class="btn btn-primary me-auto px-5">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- delModal -->
    <div class="modal fade" id="delStaff" tabindex="-1" aria-labelledby="delStaffLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delStaffLabel">Remove Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="donation" action="" method="POST">
                        <div class="form-group mb-3">
                            <input type="number" step="1" class="form-control" id="staffID" name="staffID" placeholder="Enter Staff ID" required />
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="removeBtn" name="removeBtn" class="btn btn-danger" onclick="confirm('There is no going back after deleting!\nAre you sure?');">Remove</button>
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
                // textBox.value = textBox.value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                //     return letter.toUpperCase();
                // });
                textBox.setSelectionRange(start, end);
                return textBox.value;
            });
        });
    </script>
</body>

</html>