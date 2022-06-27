<?php
include "staffHeader.php";
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

<head>
    <style>

    </style>
</head>

<body>
    <?php
    $getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND AppointmentStatus = 'ongoing' ORDER BY AppointedDate,AppointedSession";
    $getAptResult = mysqli_query($conn, $getAppointment);
    $aptCount = mysqli_num_rows($getAptResult); ?>
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a class="nav-link" href='staffApt.php'>Appointment<span class="count"><?php echo $aptCount; ?></span></a></li>
        <li class="nav-item"><a class="nav-link" href="staffDonHistory.php">Donation Records</a></li>
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="staffBloodStock.php">Blood Stock</a></li>
        <li class="nav-item"><a class="nav-link" href="donorData.php">Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="staffData.php">Staff</a></li>
    </ul>
    
    <div class="main content container border w3-round-large" style="height:80vh;overflow:auto;">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- sorttable -->
    <script>
        $('th').click(function() {
            var table = $(this).parents('table').eq(0)
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
            this.asc = !this.asc
            if (!this.asc) {
                rows = rows.reverse()
            }
            for (var i = 0; i < rows.length; i++) {
                table.append(rows[i])
            }
        })

        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index),
                    valB = getCellValue(b, index)
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
            }
        }

        function getCellValue(row, index) {
            return $(row).children('td').eq(index).text()
        }
    </script>
</body>

</html>