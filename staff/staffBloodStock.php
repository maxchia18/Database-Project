<?php
include "staffHeader.php";
$getBlood = "SELECT COALESCE(SUM(BloodDonation.DonationAmount),0) as 'sum', Blood.BloodGroup,BloodStock.CentreID FROM BloodDonation
             INNER JOIN Blood ON BloodDonation.BloodID = Blood.BloodID
             INNER JOIN BloodStock ON BloodDonation.DonationID = BloodStock.DonationID
             WHERE BloodStock.CentreID = $centreID
             GROUP BY Blood.BloodGroup ORDER BY sum DESC";
$getBloodResult = mysqli_query($conn, $getBlood);

$bloodGroup = array("A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-");
$bloodArray = [];
$amountArray = [];
?>

<!DOCTYPE html>

<html>

<head>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        canvas {
            height: 20vhpx !important;
        }
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

    <div class="main content container border w3-round-large w3-padding" style="height:80vh;overflow:auto;">
        <div class='row'>
            <h3 class="col-11">Blood Stock<span class="index"><i class='fas fa-map-marker-alt' style='color:red;'></i> <?php echo $centreName ?></h3>
            <button type='button' class='btn btn-primary col mx-2' id='chart' data-bs-toggle='modal' data-bs-target='#chartModal'>Chart</button>
        </div>

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
                    $bloodArray[] = $getBlood['BloodGroup'];
                    $amountArray[] = $getBlood['sum'];
                    echo "
                    <tr class='table-success'>
                        <td>$getBlood[BloodGroup]</td>
                        <td>$getBlood[sum]</th>
                        <td>Available</td>
                    </tr>";
                }
                $leftBlood = array_diff($bloodGroup, $bloodArray);
                foreach ($leftBlood as $group) {
                    array_push($bloodArray,$group);
                    array_push($amountArray, '0');
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

    <!-- chart Modal -->
    <div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chartModalLabel">Blood Stock Bar Chart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
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

    <!-- chart -->
    <script>
        var blood = <?php echo json_encode($bloodArray); ?>;
        var amount = <?php echo json_encode($amountArray); ?>;
        // setup 
        const data = {
            labels: blood,
            datasets: [{
                label: 'Blood Stock at <?php echo $centreName; ?>',
                data: amount,
                backgroundColor: [
                    'lightgreen'
                ],
                borderColor: [
                    'green',
                ],
                borderWidth: 1
            }]
        };

        // config
        const config = {
            type: 'bar',
            data,
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // render init block
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
</body>

</html>