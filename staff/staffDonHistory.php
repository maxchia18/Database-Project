<?php
include "staffHeader.php";
$getDonation = "SELECT BloodDonation.*,Appointment.* FROM Appointment 
                INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
                WHERE CentreID = $centreID AND AppointmentStatus = 'completed' ORDER BY AppointedDate,AppointedSession";
$getDonationResult = mysqli_query($conn, $getDonation);

$getYear = "SELECT DISTINCT YEAR(Appointment.AppointedDate) as 'year' FROM Appointment
            INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
            WHERE CentreID = $centreID";
$getYearResult = mysqli_query($conn, $getYear);

$getMonth = "SELECT DISTINCT MONTH(AppointedDate) as 'month' FROM Appointment
            INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
            WHERE CentreID = $centreID";
$getMonthResult = mysqli_query($conn, $getMonth);
?>

<!DOCTYPE html>

<html>

<body>
    <?php
    $getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND AppointmentStatus = 'ongoing' ORDER BY AppointedDate,AppointedSession";
    $getAptResult = mysqli_query($conn, $getAppointment);
    $aptCount = mysqli_num_rows($getAptResult); ?>

    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a class="nav-link" href='staffApt.php'>Appointment<span class="count"><?php echo $aptCount; ?></span></a></li>
        <li class="nav-item"><a class="nav-link active"  aria-current="page" href="staffDonHistory.php">Donation Records</a></li>
        <li class="nav-item"><a class="nav-link" href="staffBloodStock.php">Blood Stock</a></li>
        <li class="nav-item"><a class="nav-link" href="donorData.php">Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="staffData.php">Staff</a></li>
    </ul>

    <div class="content container border w3-round-large pt-2" style="height:80vh;overflow:auto;">
        <div class="row">
            <h3 class="col-8">Donation Record<span class="index"># ➜ Donation ID</h3>
            <div class="col form-group">
                <select class="form-select p-1 yearMonth" id="viewYear" name="viewYear" required>
                    <option value="all">- Select Year -</option>
                    <?php while ($getYear = mysqli_fetch_assoc($getYearResult)) {
                        echo "<option value='$getYear[year]'>$getYear[year]</option>";
                    } ?>
                </select>
            </div>
            <div class="col form-group">
                <select class="form-select p-1 yearMonth" id="viewMonth" name="viewMonth" required>
                    <option value="all">- Select Month -</option>
                    <?php while ($getMonth = mysqli_fetch_assoc($getMonthResult)) {
                        echo "<option value='$getMonth[month]'>$getMonth[month]</option>";
                    } ?>
                </select>
            </div>
        </div>

        <table class="table table-hover table-striped" id="donHisTable">
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

                    ($getDonation['DonationType'] == 'w') ? $donationType = "Whole Blood" :
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#viewYear,#viewMonth").on("change", function() {
                var year = $('#viewYear').find("option:selected").val();
                var month = $('#viewMonth').find("option:selected").val();
                SearchData(year, month);
            });
        });

        function SearchData(year, month) {
            if (year == "all" && month == "all") {
                $('#donHisTable tbody tr').show();
            } else {
                $('#donHisTable tbody tr:has(td)').each(function() {
                    rowYear = $(this).find('td:eq(2)').text().substring(0, 4);
                    rowMonth = $(this).find('td:eq(2)').text().substring(5, 7);
                    if (rowMonth.charAt(0) == '0') {
                        rowMonth = rowMonth.substring(1, 2);
                    } else {
                        rowMonth = $(this).find('td:eq(2)').text().substring(5, 7);
                    }

                    if (year != "all" && month != "all") {
                        if (year == rowYear && month == rowMonth) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    }
                });
            }
        }
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