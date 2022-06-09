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
    <!-- bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--font-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    
    <style>
        #formContainer{
            width: 30%;
            margin:10vh auto;
        }
    </style>
</head>

<body>
    <div id="formContainer" class="rounded container shadow p-3 bg-white">
        <form class="needs-validation" id="loginForm" action="loginValidation.php" method="POST">
            <h3>Sign in</h3>
            <div class="form-group my-3">
                <label class="form-label" for="icno">IC No.</label>
                <input type="email" class="form-control" id="icno" name="icno" placeholder="Email Address" required />
                <div class="invalid-feedback"></div>
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
            <div class="form-group mb-3">
                <button type="submit" id="signIn" name="signIn" class="btn btn-primary btn-block">Sign in</button>
            </div>
            <div class="form-group mb-3">
                <a href="registration.php">No Account Yet? Sign up now.</a>
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