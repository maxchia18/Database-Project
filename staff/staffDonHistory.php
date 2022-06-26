<?php
$getDonation = "SELECT BloodDonation.*,Appointment.* FROM Appointment 
                INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
                WHERE CentreID = $centreID AND AppointmentStatus = 'completed' ORDER BY AppointedDate,AppointedSession";
$getDonationResult = mysqli_query($conn, $getDonation);

$getYear = "SELECT DISTINCT YEAR(AppointedDate) as 'year' FROM Appointment WHERE CentreID = $centreID";
$getYearResult = mysqli_query($conn, $getYear);

$getMonth = "SELECT DISTINCT MONTH(AppointedDate) as 'month' FROM Appointment WHERE CentreID = $centreID ORDER BY AppointedDate";
$getMonthResult = mysqli_query($conn, $getMonth);
?>

<!DOCTYPE html>

<html>

<body>
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
</body>

</html>