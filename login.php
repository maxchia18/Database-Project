<?php
include "header.php";

error_reporting(0);
ini_set('display_errors', 0);
$errMsg = "";
$errVis = "none";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signIn'])) {
        $emailData = mysqli_real_escape_string($conn, $_POST['email']);
        $passwordData = mysqli_real_escape_string($conn, $_POST['password']);
        //get hashed password
        $sql = "SELECT Password FROM User WHERE Email = '$emailData'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            $passwordHashed = mysqli_fetch_assoc($result);
            if (password_verify($passwordData, $passwordHashed['Password'])) {
                $passwordHashed = $passwordHashed['Password'];
                $loginData = "SELECT * FROM User WHERE Email = '$emailData' AND Password = '$passwordHashed'";
                $result = mysqli_query($conn, $loginData);


                $user = mysqli_fetch_assoc($result);
                $_SESSION['UserType'] = $user['UserType'];
                $_SESSION['UserID'] = $user['UserID'];
                $_SESSION['UserName'] = $user['FirstName'] . " " . $user['LastName'];

                echo $_SESSION['UserName'];
                echo $_SESSION['UserType'];
                echo $_SESSION['userID'];

                if (isset($_SESSION['UserID'])) { ?>
                    <script>
                        window.location = "index.php";
                    </script><?php
                            }
                            $errVis = "none";
                            $errMsg = "";
                        } else {
                            $errVis = "block";
                            $errMsg = "Incorrect password, please try again.";
                        }
        } else {
            $errVis = "block";
            $errMsg = "Email does not exist.";
        }
    }
}
if (isset($_SESSION['UserID'])) {
    redirectHome($userType);
}
                    ?>

<!DOCTYPE html>
<html>

<head>
    <title>Blood Donation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="icon" href="img/logo.png">

    <style>
        #formContainer {
            width: 30%;
            margin: 10vh auto;
            background: linear-gradient(to bottom right, #FF9601, #F9FF4C);
        }

        .msg {
            color: red;
            display: <?php echo $errVis ?>;
            margin-top: 4%;
            margin-left: -65%;
            font-size: small;
        }

        #noacc:hover {
            transition: 1s;
        }
    </style>
</head>

<body>
    <div id="formContainer" class="rounded container shadow p-3">
        <form class="needs-validation" id="loginForm" method="POST">
            <h2>Sign in</h2>
            <div class="form-group my-3">
                <label class="form-label" for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required />
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                    <span class="input-group-text" onclick="toggle()">
                        <i id="toggleEye" class="fa fa-eye"></i>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="form-group mb-3 col">
                    <button type="submit" id="signIn" name="signIn" class="btn btn-primary btn-block">Sign in</button>
                </div>
                <div class="col">
                    <span class="msg"><?php echo $errMsg ?></span>
                </div>
            </div>
            <div class="form-group mb-3">
                <a href="registration.php" id="noacc">No Account Yet? Sign up now.</a>
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