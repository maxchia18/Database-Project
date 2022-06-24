<?php
// $getDonation = "SELECT BloodDonation.*,Appointment.* FROM Appointment 
//                 INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
//                 WHERE CentreID = $centreID AND AppointmentStatus = 'completed' ORDER BY AppointedDate,AppointedSession";
// $getDonationResult = mysqli_query($conn, $getDonation);

$bloodGroup = array("A+","A-","B+","B-","AB+","AB-","O+","O-");
$getBlood = "SELECT COALESCE(SUM(BloodDonation.DonationAmount),0) as 'sum', Blood.BloodGroup,BloodStock.CentreID FROM BloodDonation
             INNER JOIN Blood ON BloodDonation.BloodID = Blood.BloodID
             INNER JOIN BloodStock ON BloodDonation.DonationID = BloodStock.DonationID
             WHERE BloodStock.CentreID = $centreID
             GROUP BY Blood.BloodGroup ORDER BY sum DESC";
$getBloodResult = mysqli_query($conn, $getBlood);

// $leftOver = array_diff($bloodGroup,$getBlood['BloodGroup']);
?>

<!DOCTYPE html>

<html>

<body>
    <div class="content container border w3-round-large" style="height:80vh;overflow:auto;">
        <h3>Blood Stock<span class="index"><?php echo $centreName ?></h3>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Blood Group</th>
                    <th scope="col">Total Amount (ml)</th>
                    <th scope="col">Status </th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($getBlood = mysqli_fetch_array($getBloodResult)) {
                    echo "
                    <tr>
                        <th>$getBlood[BloodGroup]</th>
                        <td>$getBlood[sum]</th>
                        <td>
                        <i class='fas fa-check-circle' style='color:green;'></i>
                        <i class='fa fa-minus-circle' style='color:orange;'></i>
                        <i class='fa-solid fa-circle-xmark' style='color:red;'></i></th>
                    </tr>";
                }
                // foreach($leftOver as $group){
                //     echo"
                //     <tr>
                //         <th>$group</th>
                //         <td>0</th>
                //         <td>
                //         <i class='fas fa-check-circle' style='color:green;'></i>
                //         <i class='fa fa-minus-circle' style='color:orange;'></i>
                //         <i class='fa-solid fa-circle-xmark' style='color:red;'></i></th>
                //     </tr>";
                // }
                ?>
            </tbody>
        </table>
    </div>


    <script>

    </script>
</body>

</html>