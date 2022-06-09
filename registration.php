<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $weight = $_POST['weight'];
    $bloodtype = $_POST['bloodtype'];
    $icno = $_POST['icno'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $tac = $_POST['checkTAC'];
    $submit = $_POST['signUp'];

    //aphresis or whole blood donation condition
    $isWhole = 0;
    $isAphresis = 0;
    if (($age >= 17 || $age <= 60) && $weight >= 45) {
        $isWhole = 1;
    }

    if ($age <= 55) {
        $isAphresis = 1;
    }

    //check for existing ID
    $checkQuery = "SELECT DonorID FROM Donor WHERE DonorID = '$icno'";
    $result = mysqli_query($conn, $checkQuery);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Donor(DonorID, FirstName, LastName, Weight, BloodType, Email, Password,IsWhole,IsAphresis)
    VALUES('$icno','$fname','$lname','$weight','$bloodtype','$email','$password','$isWhole','$isAphresis')";

        if ($conn->query($sql) == TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo '<script type ="text/JavaScript">';
        echo 'alert("IC Number exists.")';
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>

    </style>

    <script>
        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('.name').keyup(function(event) {
                var textBox = event.target;
                var start = textBox.selectionStart;
                var end = textBox.selectionEnd;
                textBox.value = textBox.value.charAt(0).toUpperCase() + textBox.value.slice(1).toLowerCase();
                textBox.setSelectionRange(start, end);
            });
        });
    </script>
</head>

<body>
    <div class="regForm container">
        <form id="regForm" method="POST">
            <h3 class="mt-3">Register</h3>
            <div class="row">
                <div class="col">
                    <div class="form-group my-3">
                        <label class="form-label" for="fname">First Name</label>
                        <input type="text" class="form-control name" id="fname" name="fname" placeholder="First Name" onkeydown="return /^[a-zA-Z-'. ]*$/i.test(event.key)" maxlength="50" required />
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group my-3">
                        <label class="form-label" for="lname">Last Name</label>
                        <input type="text" class="form-control name" id="lname" name="lname" placeholder="Last Name" onkeydown="return/^[a-zA-Z-'. ]*$/i.test(event.key)" maxlength="50" required />
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label class="form-label" for="icno">Identity Card No.</label>
                        <input type="text" class="form-control" id="icno" name="icno" placeholder="No need '-'" pattern="[0-9]+" maxlength="12" required />
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label class="form-label" for="age">Age</label>
                        <input type="number" min="0" class="form-control" id="age" name="age" placeholder="Age" required />
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="weight">Weight (kg)</label>
                <input type="number" min="0" step="0.01" class="form-control" id="weight" name="weight" placeholder="Weight" required />
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="bloodtype">Blood Type</label>
                <select class="form-select" name="bloodtype">
                    <option disabled>- Select Your Blood Type -</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" maxlength="50" required />
                <div class="invalid-feedback"></div>
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
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="checkTAC" name="checkTAC" value="checked" required>
                <label class="form-check-label" for="checkTAC">By checking this, you acknowledge all of the information are correct, that you are physically and mentally suitable to donate blood, and agreed to our Terms and Condition</label>
            </div>
            <div class="form-group mb-3">
                <button type="submit" id="signUp" name="signUp" class="btn btn-primary btn-block" onclick="return  confirm('Are you sure?')">Create Account</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
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
    </script>
</body>


</html>