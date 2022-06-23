<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $weight = $_POST['weight'];
    $bloodgroup = $_POST['bloodgroup'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $submit = $_POST['signUp'];
    $usertype = "donor";

    //check for existing ID
    $checkQuery = "SELECT Email FROM User WHERE Email = '$email'";
    $result = mysqli_query($conn, $checkQuery);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO User(FirstName, LastName, Email, Password, UserType)
                VALUES('$fname','$lname','$email','$password','$usertype')";
        if (mysqli_query($conn, $sql)) {
            $userID = mysqli_insert_id($conn);
            $sql2 = "INSERT INTO Donor(UserID, Weight, Age)
                    VALUE('$userID','$weight','$age')";
            $sql3 = "INSERT INTO Blood(BloodGroup, DonorID)
                    VALUE('$bloodgroup','$userID')";
            if (mysqli_query($conn, $sql2) && mysqli_query($conn, $sql3)) {?>
                <script type="text/JavaScript">
                    alert("Registration Successful, Sign in now.");
                    window.location = "login.php";
                </script><?php
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

if (isset($_SESSION['UserID'])) {
    redirectHome($userType);
}
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        .regForm{
            height:92vh;
            width:100vw;
            overflow-y:auto;
            overflow-x: hidden;
        }

        label {
            font-weight: bold;
        }

        #stay1year {
            display: none;
        }

        #msg {
            color: red;
            display: none;
            margin-top: 0.5%;
            margin-left: -5%;
        }
    </style>
</head>

<body>
    <div class="regForm w3-padding-large">
        <form id="regForm" method="POST">
            <h1 class="mt-3 w3-center">Register Account</h1>
            <div class="row">
                <div class="col">
                    <div class="form-group my-3">
                        <label class="form-label" for="fname">First Name</label>
                        <input type="text" class="form-control name" id="fname" name="fname" placeholder="First Name" onkeydown="return /^[a-zA-Z-'./ ]*$/i.test(event.key)" maxlength="50" required />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group my-3">
                        <label class="form-label" for="lname">Last Name</label>
                        <input type="text" class="form-control name" id="lname" name="lname" placeholder="Last Name" onkeydown="return/^[a-zA-Z-'./ ]*$/i.test(event.key)" maxlength="50" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label class="form-label" for="age">Age</label>
                        <input type="number" min="0" class="form-control" id="age" name="age" placeholder="Age" onkeyup="checkAge();" required />
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3">
                        <label class="form-label" for="weight">Weight (kg)</label>
                        <input type="number" min="0" step="0.01" class="form-control" id="weight" name="weight" placeholder="Weight" onkeyup="checkWeight();" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group mb-3">
                        <label class="form-label " for="nationality">Are you Malaysian?</label></br>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="nationality1" name="nationality" value="yes" onclick="checkNationality();" required>
                            Yes<label class="form-check-label" for="nationality1"></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="nationality2" name="nationality" value="no" onclick="checkNationality();">
                            No<label class="form-check-label" for="nationality2"></label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-3" id="stay1year">
                        <label class="form-label" for="weight">Have you been staying in Malaysia for at least 1 year?</label></br>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="yes1year" name="stay" value="yes1year" onclick="check1year();">
                            Yes<label class="form-check-label" for="yes1year"></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" id="no1year" name="stay" value="no1year" onclick="check1year();">
                            No<label class="form-check-label" for="no1year"></label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="bloodgroup">Blood Group</label>
                    <select class="form-select" name="bloodgroup" required>
                        <option value="" disabled selected hidden>- Select Your Blood Type -</option>
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
                <div class="form-check mb-3 mx-3">
                    <input type="checkbox" class="form-check-input" id="checkTAC" name="checkTAC" value="checked" required>
                    <label class="form-check-label" for="checkTAC">By checking this, you acknowledge all of the information are correct, that you are physically and mentally suitable to donate blood, and agreed to our
                        <a href="https://www.youtube.com/watch?v=iik25wqIuFo" target="_blank">Terms and Condition</a>.</label>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="form-group mb-3 col">
                            <button type="submit" id="signUp" name="signUp" class="btn btn-primary btn-block" onclick="return  confirm('Are you sure?')">Create Account</button>
                        </div>
                        <div class="col-10">
                            <span id="msg"></span>
                        </div>
                    </div>
                </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        function checkNationality() {
            const stay1year = document.getElementById('stay1year');
            if (document.getElementById('nationality2').checked) {
                stay1year.style.display = 'block';
                stay1year.required = true;
            } else {
                stay1year.style.display = 'none';
                stay1year.required = false;
            }
        }

        function check1year() {
            var signup = document.getElementById('signUp');
            var msg = document.getElementById('msg');
            if (document.getElementById('no1year').checked) {
                signup.disabled = true;
                msg.style.display = 'block';
                msg.innerHTML = "We appreciate your kindness, but you have to stay in Malaysia for at least 1 year.";
            } else {
                signup.disabled = false;
                msg.style.display = 'none';
            }
        }


        function checkAge() {
            var age = document.getElementById('age');
            var signup = document.getElementById('signUp');
            var msg = document.getElementById('msg');

            if (age.value > 60 || age.value < 17) {
                signup.disabled = true;
                msg.style.display = 'block';
                msg.innerHTML = "We appreciate your kindness, but you must be within 17 to 60 years old to donate blood.";
            } else {
                signup.disabled = false;
                msg.style.display = 'none';
            }
        }

        function checkWeight() {
            var weight = document.getElementById('weight');
            var signup = document.getElementById('signUp');
            var msg = document.getElementById('msg');

            if (weight.value < 45) {
                signup.disabled = true;
                msg.style.display = 'block';
                msg.innerHTML = "We appreciate your kindness, but your body weight must be of at least 45kg.";
            } else {
                signup.disabled = false;
                msg.style.display = 'none';
            }
        }

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