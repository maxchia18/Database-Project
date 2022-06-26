<?php
include "header.php";

$getDonor = "SELECT User.*, Donor.*,Blood.BloodGroup FROM User
             INNER JOIN Donor ON User.UserID = Donor.UserID
             INNER JOIN Blood ON User.UserID = Blood.DonorID
             WHERE User.UserID = $userID";
$getDonorResult = mysqli_query($conn, $getDonor);
$getDonor = mysqli_fetch_assoc($getDonorResult);

if ($getDonor['Gender'] == 'M') {
    $gender = "Male";
} else {
    $gender = "Female";
}
?>

<!DOCTYPE html>

<html>

<head>
    <style>
        body {
            overflow: hidden;
        }

        #sidebar {
            height: 120%;
            width: 20%;
            position: fixed;
            z-index: 1;
            left: 0;
            overflow-x: hidden;
            padding-top: 20px;
            background-color: #ffca93;
        }

        .main {
            margin-left: 20%;
            margin-bottom: 5%;
            height: 92vh;
            overflow-y: auto !important;
        }

        .alink {
            text-decoration: none;
            color: black;
            margin: 10%;
            transition: 0.5s;
            vertical-align: middle;
        }

        #link1:hover {
            color: white;
            transition: 0.5s;
        }

        .bg {
            margin: 5% auto;
            width: 105%;
        }

        #bg1 {
            background-color: white;
            border-radius: 25px;
        }

        #msg {
            color: red;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div class="w3-center"><i class="fa fa-user w3-xxxlarge"></i>
            <h2 class="mb-4">Profile</h2>
        </div>
        <div class='bg' id='bg1'>
            <a id="link2" class='alink' href="#">My Profile
                <i class="fa fa-user" style="margin-left:14.3%;"></i></a>
            </a>
        </div>
    </div>

    <div class="main w3-padding-large">
        <h1 class="mb-4">Hi there, <?php echo $getDonor['FirstName']; ?>.</h1>
        <div class="container shadow-sm rounded border w3-padding">
            <form id="profile" method="POST">
                <div class="form-group row mb-3">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="fName">First Name</label>
                        <input type="text" class="form-control" id="fName" name="fName" onkeydown="return /^[a-zA-Z-'./ ]*$/i.test(event.key)" maxlength="50">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="lName">Last Name</label>
                        <input type="text" class="form-control" id="lName" name="lName" onkeydown="return /^[a-zA-Z-'./ ]*$/i.test(event.key)" maxlength="50">
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="form-group col">
                        <label class="form-label" for="weight">Weight</label>
                        <input type="number" class="form-control" id="weight" name="weight">
                    </div>
                    <div class="form-group col">
                        <label class="form-label" for="age">Age</label>
                        <input type="text" class="form-control" id="age" name="age">
                    </div>
                    <div class="form-group col">
                        <label class="form-label" for="bloodGroup">Blood Group</label>
                        <input type="text" class="form-control" id="bloodGroup" name="bloodGroup" disabled>
                    </div>
                    <div class="form-group col">
                        <label class="form-label" class="form-label" for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" name="gender" disabled>
                    </div>
                </div>
                <div class="form-group my-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="pw" style="display:none;">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="50" />
                    </div>
                </div>
            </form>
        </div>

        <script>
            $("#profile :input:not(button)").prop("readOnly", true);

            $(document).ready(function() {
                $('#fName').val('<?php echo $getDonor['FirstName']; ?>');
                $('#lName').val('<?php echo $getDonor['LastName']; ?>');
                $('#weight').val('<?php echo $getDonor['Weight']; ?>');
                $('#age').val('<?php echo $getDonor['Age']; ?>')
                $('#bloodGroup').val('<?php echo $getDonor['BloodGroup']; ?>');
                $('#gender').val('<?php echo $gender; ?>');
                $('#email').val('<?php echo $getDonor['Email']; ?>');
            });
        </script>
</body>

</html>