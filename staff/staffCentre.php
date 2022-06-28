<?php
include "staffHeader.php";

$bloodbank = "SELECT DonationCentre.*, BloodBankCentre.* FROM DonationCentre
              INNER JOIN BloodBankCentre ON DonationCentre.CentreID = BloodBankCentre.CentreID";
$mobile = "SELECT DonationCentre.*, MobileCentre.* FROM DonationCentre 
           INNER JOIN MobileCentre ON DonationCentre.CentreID = MobileCentre.CentreID";
?>

<!DOCTYPE html>

<html>

<head>
    <style>

    </style>

    <script>

    </script>
</head>

<body>
    <?php //get appointment count
    $getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND AppointmentStatus = 'ongoing' ORDER BY AppointedDate,AppointedSession";
    $getAptResult = mysqli_query($conn, $getAppointment);
    $aptCount = mysqli_num_rows($getAptResult); ?>
    <ul class="nav nav-tabs nav-justified mb-3">
        <li class="nav-item"><a class="nav-link" href='staffApt.php'>Appointment<span class="count"><?php echo $aptCount; ?></span></a></li>
        <li class="nav-item"><a class="nav-link" href="staffDonHistory.php">Donation</a></li>
        <li class="nav-item"><a class="nav-link" href="staffBloodStock.php">Blood Stock</a></li>
        <li class="nav-item"><a class="nav-link" href="staffDonorData.php">Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="staffData.php">Staff</a></li>
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="staffCentre.php">Centre</a></li>
    </ul>

    <div class="content container border w3-round-large w3-padding " style="height:80vh;overflow:auto;">
        <h3 class="col-10">Blood Bank <span class="index"># ➜ Centre ID</h3>
        <table class="table table-hover table-striped mt-3 mb-5">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Centre</th>
                    <th scope="col">Address</th>
                    <th scope="col">Tel No.</th>
                    <th scope="col">Tel Fax</th>
                </tr>
            </thead>
            <tbody id='bTable'>
                <?php
                $result = mysqli_query($conn, $bloodbank);
                while ($getCentre = mysqli_fetch_assoc($result)) {
                    echo "
                <tr>
                    <td scope='row'>$getCentre[CentreID]</td>
                    <td>$getCentre[CentreName]</td>
                    <td class='col-5'>$getCentre[CentreAddress]</td>
                    <td>$getCentre[TelNo]</td>
                    <td>$getCentre[TelFax]</td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
        <h3 class='col'>Mobile Centre</h3>
        <table class="table table-hover table-striped mt-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Centre</th>
                    <th>Address</th>
                    <th>Organizer</th>
                    <th>Tel No.</th>
                    <th>Start</th>
                    <th>End</th>
                </tr>
            </thead>
            <tbody id='mTable'>
                <?php
                $result = mysqli_query($conn, $mobile);
                while ($getCentre = mysqli_fetch_assoc($result)) {
                    echo "
                <tr>
                    <td scope='row'>$getCentre[CentreID]</td>
                    <td class='col-2'>$getCentre[CentreName]</td>
                    <td class='col-3'>$getCentre[CentreAddress]</td>
                    <td class='col-2'>$getCentre[OrganizerName]</td>
                    <td>$getCentre[TelNo]</td>
                    <td>$getCentre[StartDate]</td>
                    <td>$getCentre[EndDate]</td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function toggle() {
            var x = document.getElementById("password");
            var toggle = document.getElementById("toggleEye");
            if (x.type === "password") {
                x.type = "text";
                toggle.className = "fa fa-eye-slash";
            } else {
                x.type = "password";
                toggle.className = "fa fa-eye";
            }
        }

        function toggleForm(type) {
            let bbank = document.getElementById('bbankForm');
            let mobile = document.getElementById('mobileForm');

            if (type == 'B') {
                bbank.style.display = "block";
                mobile.style.display = "none";
            } else {
                bbank.style.display = "none";
                mobile.style.display = "block";
            }
        }

        jQuery.noConflict();
        jQuery(document).ready(function($) {
            $('.name').keyup(function(event) {
                var textBox = event.target;
                var start = textBox.selectionStart;
                var end = textBox.selectionEnd;
                textBox.value = textBox.value.charAt(0).toUpperCase() + textBox.value.slice(1);
                // textBox.value = textBox.value.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                //     return letter.toUpperCase();
                // });
                textBox.setSelectionRange(start, end);
                return textBox.value;
            });
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