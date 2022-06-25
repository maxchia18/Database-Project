<?php
$getBlood = "SELECT COALESCE(SUM(BloodDonation.DonationAmount),0) as 'sum', Blood.BloodGroup,BloodStock.CentreID FROM BloodDonation
             INNER JOIN Blood ON BloodDonation.BloodID = Blood.BloodID
             INNER JOIN BloodStock ON BloodDonation.DonationID = BloodStock.DonationID
             WHERE BloodStock.CentreID = $centreID
             GROUP BY Blood.BloodGroup ORDER BY sum DESC";
$getBloodResult = mysqli_query($conn, $getBlood);

$bloodGroup = array("A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-");
$BloodArray = [];

?>

<!DOCTYPE html>

<html>

<body>
    <div class="content container border w3-round-large" style="height:80vh;overflow:auto;">
        <h3>Blood Stock<span class="index"><?php echo $centreName ?></h3>

        <table id="stock" class="table table-hover sorttable">
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
                    $BloodArray[] = $getBlood['BloodGroup'];
                    echo "
                    <tr class='table-success'>
                        <td>$getBlood[BloodGroup]</td>
                        <td>$getBlood[sum]</th>
                        <td>Available</td>
                    </tr>";
                }
                $leftOver = array_diff($bloodGroup, $BloodArray);
                foreach ($leftOver as $group) {
                    echo "
                    <tr class='table-danger'>
                        <td>$group</td>
                        <td>0</th>
                        <td>Shortage</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


</body>

</html>