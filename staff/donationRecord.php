<?php
$getDonation = "SELECT BloodDonation.*,Appointment.* FROM Appointment 
                INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
                WHERE CentreID = $centreID AND AppointmentStatus = 'completed' ORDER BY AppointedDate,AppointedSession";
$getDonationResult = mysqli_query($conn, $getDonation);
?>

<!DOCTYPE html>

<html>

<body>
    <div class="content container border w3-round-large" style="height:80vh;overflow:auto;">
        <h3>Donation Record<span class="index"># ➜ Donation ID</h3>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Session</th>
                    <th scope="col">Centre</th>
                    <th scope="col">Blood Group</th>
                    <th scope="col">Type</th>
                    <th scope="col">Amount (ml)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($getDonation = mysqli_fetch_assoc($getDonationResult)) {
                    $getDonor = "SELECT User.*,Donor.*,Blood.BloodGroup FROM Donor 
                                 INNER JOIN User ON User.UserID = Donor.UserID
                                 INNER JOIN Blood ON Blood.DonorID = Donor.UserID
                                 WHERE User.UserID = $getDonation[DonorID]";
                    $getDonorResult = mysqli_query($conn, $getDonor);
                    $donorData = mysqli_fetch_assoc($getDonorResult);
                    
                    ($getDonation['DonationType'] == 'w')?$donationType = "Whole Blood":
                                                          $donationType = "Aphresis";
                    
                    echo "<tr>
                    <td scope='row'><b>$getDonation[DonationID]</b></td>
                    <td>$donorData[FirstName] $donorData[LastName]</td>
                    <td>$getDonation[AppointedDate]</td>
                    <td>$getDonation[AppointedSession]</td>
                    <td>$centreName</td>
                    <td>$donorData[BloodGroup]</td>
                    <td>$donationType</td>
                    <td>$getDonation[DonationAmount]</td>
                </tr>";
                } ?>
            </tbody>
        </table>
        <?php
        if (mysqli_num_rows($getDonationResult) == 0) {
            echo "<h2 class='w3-center mt-5'>No donation record yet, check back later.</h2>";
        } ?>
    </div>

    <script>

    </script>
</body>

</html>