<?php

$getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND IsCompleted = 0 ORDER BY AppointedDate,AppointedSession";
$getAptResult = mysqli_query($conn, $getAppointment);

?>

<!DOCTYPE html>

<html>

<head>
    <style>
        .completeApt {
            width: 50%;
            background-color: rgb(15, 165, 15);
            color: #fff;
            font-weight: bold;
            transition: 0.5s;
        }

        .completeApt:hover{
            background-color: green;
            color:yellow;
            transition: 0.5s;
        }
    </style>

    <script>

    </script>
</head>

<body>
    <div class="container border w3-round-large" id="newapt" style="height:80vh;overflow:auto;">
        <h3>New Appointment</h3>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Session</th>
                    <th scope="col">Centre</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($apt = mysqli_fetch_assoc($getAptResult)) {
                    $getName = "SELECT FirstName,LastName FROM User WHERE UserID = $apt[DonorID]";
                    $getNameResult = mysqli_query($conn, $getName);
                    $name = mysqli_fetch_assoc($getNameResult);
                    echo "<tr>
                    <th scope='row'>$apt[AppointmentID]</th>
                    <td>$name[FirstName] $name[LastName]</td>
                    <td>$apt[AppointedDate]</td>
                    <td>$apt[AppointedSession]</td>
                    <td>$centreName</td>
                    <td><button type='button' class='completeApt btn border w3-round-xlarge' name='completeApt'>	
                    <i class='fa fa-check'></i></button></td>
                </tr>";
                } ?>
            </tbody>
        </table>
    </div>


</body>

</html>