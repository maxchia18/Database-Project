<?php
include "header.php";

$errMsg = "";
$errVis = "none";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailData = mysqli_real_escape_string($conn, $_POST['email']);
    $passwordData = mysqli_real_escape_string($conn, $_POST['password']);
    //get hashed password
    $sql = "SELECT Password FROM User WHERE Email = '$emailData'";
    $result = mysqli_query($conn, $sql);
    $passwordHashed = mysqli_fetch_assoc($result);
    echo $passwordData;
    echo $passwordHashed['Password'];
    if (password_verify($passwordData, $passwordHashed['Password'])) {
        echo "correct";
        $passwordHashed = $passwordHashed['Password'];
        $loginData = "SELECT * FROM User WHERE Email = '$emailData' AND Password = '$passwordHashed'";
        $result = mysqli_query($conn, $loginData);

        $count = mysqli_num_Rows($result);
        //If result matched, table row must be 1 row
        if ($count == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['UserType'] = $user['UserType'];
            $_SESSION['UserID'] = $user['UserID'];
            $_SESSION['UserName'] = $user['FirstName'];

            echo $_SESSION['UserName'];
            echo $_SESSION['UserType'];
            echo $_SESSION['userID'];
        } else if ($count == 0) {
            $errVis = "block";
            $errMsg = "Email doesn't exist";
        }

        if (isset($_SESSION['UserID'])) {
?>
            <script>
                alert("Login Successful, directing you to home page.");
                window.location = "index.php";
            </script>
<?php
        }
        $errVis = "none";
        $errMsg = "";
    } else {
        $errVis = "block";
        $errMsg = "Incorrect password, please try again.";
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
    <!-- bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--font-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <style>
        #formContainer {
            width: 30%;
            margin: 10vh auto;
        }

        #msg {
            color: red;
            display: <?php echo $errVis ?>;
            margin-top: 4%;
            margin-left: -70%;
        }
    </style>
</head>

<body>
    <div id="formContainer" class="rounded container shadow p-3 bg-white">
        <form class="needs-validation" id="loginForm" method="POST">
            <h3>Sign in</h3>
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
                    <span id="msg"><?php echo $errMsg ?></span>
                </div>
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