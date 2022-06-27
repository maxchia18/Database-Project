<?php
include "staffHeader.php";

$getDonor = "SELECT User.*, Donor.*,Blood.BloodGroup FROM User
            INNER JOIN Donor ON User.UserID = Donor.UserID
            INNER JOIN Blood ON User.UserID = Blood.DonorID";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['viewDonor'])) {
        $value = explode(",", $_POST['donorID']);
        $donorID = $value[0];
        $fName = $value[1];
        $lName = $value[2];
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <style>

    </style>

    <script type="text/javascript">
        $(window).on('load', function() {
            $('#donorHistory').modal('show');
        });
    </script>
</head>

<body>
    <?php
    $getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND AppointmentStatus = 'ongoing' ORDER BY AppointedDate,AppointedSession";
    $getAptResult = mysqli_query($conn, $getAppointment);
    $aptCount = mysqli_num_rows($getAptResult); ?>
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a class="nav-link" href='staffApt.php'>Appointment<span class="count"><?php echo $aptCount; ?></span></a></li>
        <li class="nav-item"><a class="nav-link" href="staffDonHistory.php">Donation Records</a></li>
        <li class="nav-item"><a class="nav-link" href="staffBloodStock.php">Blood Stock</a></li>
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="donorData.php">Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="staffData.php">Staff</a></li>
    </ul>

    <div class="content container border w3-round-large w3-padding" style="height:80vh;overflow:auto;">
        <form method='POST' class="form-inline row">
            <h3 class="col-8">Donors<span class="index"># ➜ Donor ID</h3>
            <div class="form-group ml-4 mb-2 col-3">
                <!-- <input type='number' class="form-control" name='donorID' id='donorID' placeholder="Enter Donor ID"> -->
                <select class="form-select form-control float-end">
                    <option disabled hidden selected>Select Donor ID</option>
                    <?php
                    $getDonorID = mysqli_query($conn, $getDonor);
                    while ($id = mysqli_fetch_assoc($getDonorID)) {
                        echo "<option value='$id[UserID]'>$id[UserID]</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-2 col">
                <button type='submit' name='viewDonor' title="View Records" class='viewDonor btn btn-primary float-end w3-round'>
                    View
                </button>
            </div>
        </form>

        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Age</th>
                    <th scope="col">Email</th>
                    <th scope="col">Blood Group</th>
                    <th scope="col">Last Donation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getDonorResult = mysqli_query($conn, $getDonor);
                while ($donor = mysqli_fetch_assoc($getDonorResult)) {
                    $lastDonate = $donor['LastDonationDate'];
                    if ($lastDonate == "1900-01-01") {
                        $lastDonate = "-";
                    }
                    echo "<tr>
                    <td scope='row'><b>$donor[UserID]</b></td>
                    <td>$donor[FirstName] $donor[LastName]</td>
                    <td>$donor[Gender]</td>
                    <td>$donor[Age]</td>
                    <td>$donor[Email]</td>
                    <td>$donor[BloodGroup]</td>
                    <td>$lastDonate</td>
                </tr>";
                } ?>
            </tbody>
        </table>
        <?php
        if (mysqli_num_rows($getDonorResult) == 0) {
            echo "<h2 class='w3-center mt-5'>No donor registered, check back later.</h2>";
        } ?>
    </div>

    <!-- donorHistory -->
    <div class="modal fade" id="donorHistory" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="donorHistoryLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donorHistoryLabel"><?php echo "#" . $donorID . " " . $fName . " " . $lName; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick='window.location.href="donorData.php";'></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Type</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Centre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $getHistory = "SELECT Appointment.*,BloodDonation.* FROM Appointment 
                                   INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
                                   WHERE Appointment.DonorID = $donorID";
                            $historyResult = mysqli_query($conn, $getHistory);

                            while ($history = mysqli_fetch_assoc($historyResult)) {
                                $getCentre = "SELECT * FROM DonationCentre WHERE CentreID = $history[CentreID]";
                                $centre = mysqli_fetch_assoc(mysqli_query($conn, $getCentre));

                                if ($history["DonationType"] == 'w') {
                                    $donationType = "Whole Blood";
                                } else {
                                    $donationType = "Aphresis";
                                }
                                echo "<tr>
                                <td scope='row'><b>$history[DonationID]</b></td>
                                <td>$history[AppointedDate]</td>
                                <td>$donationType</td>
                                <td>$history[DonationAmount]</td>
                                <td>$centre[CentreName]</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    if(mysqli_num_rows($historyResult)==0){
                        echo "<h3 class='w3-center mt-3'>No donation records, check back later</h3>";
                    }?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.viewDonor').click(function() {
                //retrieve data from table
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();
                //set the value 
                $('#donorID').val(data[0]);
                $('#donorHistoryLabel').html("#" + data[0] + " " + data[1] + "'s Donation History");

                document.cookie = "donorID=" + data[0];
            });

            $('#donorHistory').on('hide.bs.modal', function(e) {
                location.reload();
            })
        });
    </script>

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