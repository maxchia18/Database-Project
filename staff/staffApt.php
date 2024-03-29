<?php
include "staffHeader.php";
include "completeApt.php";

$getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND AppointmentStatus = 'ongoing' ORDER BY AppointedDate,AppointedSession";
$getAptResult = mysqli_query($conn, $getAppointment);
$aptCount = mysqli_num_rows($getAptResult);
?>

<!DOCTYPE html>

<html>

<head>
    <style>
        #error {
            display: none;
            color: red !important;
        }

        #aptHistory {
            display: none;
        }
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
        <li class="nav-item"><a class="nav-link active" aria-current="page" href='staffApt.php'>Appointment<span class="count"><?php echo $aptCount; ?></span></a></li>
        <li class="nav-item"><a class="nav-link" href="staffDonHistory.php">Donation</a></li>
        <li class="nav-item"><a class="nav-link" href="staffBloodStock.php">Blood Stock</a></li>
        <li class="nav-item"><a class="nav-link" href="staffDonorData.php">Donor</a></li>
        <li class="nav-item"><a class="nav-link" href="staffData.php">Staff</a></li>
        <li class="nav-item"><a class="nav-link" href="staffCentre.php">Centre</a></li>
    </ul>

    <div class="content container border w3-round-large w3-padding" style="height:80vh;overflow:auto;">
        <div id="newApt">
            <div class='row'>
                <h3 class='col-11'>New Appointment<span class="index"># ➜ Appointment ID</h3>
                <button type='button' class='btn btn-primary col' id='new' onclick='toggleApt(this.id);'>History</button>
            </div>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th style="display:none;">iswhole</th>
                        <th style="display:none;">isaphresis</th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date</th>
                        <th scope="col">Session</th>
                        <th scope="col">Centre</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($apt = mysqli_fetch_assoc($getAptResult)) {
                        $getDonor = "SELECT User.*,Donor.* 
                                FROM User INNER JOIN Donor ON User.UserID = Donor.UserID
                                WHERE Donor.UserID = $apt[DonorID]";
                        $getDonorResult = mysqli_query($conn, $getDonor);
                        $donorData = mysqli_fetch_assoc($getDonorResult);
                        echo "<tr>
                    <td scope='row'><b>$apt[AppointmentID]</b></td>
                    <td style='display:none;'>$donorData[IsWhole]</th>
                    <td style='display:none;'>$donorData[IsAphresis]</th>
                    <td>$donorData[FirstName] $donorData[LastName]</td>
                    <td>$donorData[Gender]</td>
                    <td>$apt[AppointedDate]</td>
                    <td>$apt[AppointedSession]</td>
                    <td>$centreName</td>
                    <td><button type='button' class='completeApt btn btn-info border w3-round-xlarge' name='completeApt' data-bs-toggle='modal' data-bs-target='#completeDonation'>	
                    <i class='fa fa-check'></i></button></td>
                </tr>";
                    } ?>
                </tbody>
            </table>
            <?php
            if (mysqli_num_rows($getAptResult) == 0) {
                echo "<h2 class='w3-center mt-5'>No new appointment, check back later.</h2>";
            } ?>
        </div>

        <div id="aptHistory">
            <div class='row'>
                <h3 class='col-10'>Appointment History<span class="index"># ➜ Appointment ID</h3>
                <button type='button' class='btn btn-primary col' id='history' onclick='toggleApt(this.id);'>New Appointment</button>
            </div>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Date</th>
                        <th scope="col">Session</th>
                        <th scope="col">Centre</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND AppointmentStatus != 'ongoing' ORDER BY AppointedDate,AppointedSession";
                    $getAptResult = mysqli_query($conn, $getAppointment);
                    while ($apt = mysqli_fetch_assoc($getAptResult)) {
                        $getDonor = "SELECT User.*,Donor.* 
                                FROM User INNER JOIN Donor ON User.UserID = Donor.UserID
                                WHERE Donor.UserID = $apt[DonorID]";
                        $getDonorResult = mysqli_query($conn, $getDonor);
                        $donorData = mysqli_fetch_assoc($getDonorResult);
                        $aptStatus = ucfirst($apt['AppointmentStatus']);
                        echo "<tr>
                        <td scope='row'><b>$apt[AppointmentID]</b></td>
                        <td>$donorData[FirstName] $donorData[LastName]</td>
                        <td>$donorData[Gender]</td>
                        <td>$apt[AppointedDate]</td>
                        <td>$apt[AppointedSession]</td>
                        <td>$centreName</td>
                        <td>$aptStatus<td>
                    </tr>";
                    } ?>
                </tbody>
            </table>
            <?php
            if (mysqli_num_rows($getAptResult) == 0) {
                echo "<h2 class='w3-center mt-5'>No appointment is made yet, check back later.</h2>";
            } ?>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="completeDonation" tabindex="-1" aria-labelledby="completeDonationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completeDonationLabel">Blood Donation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="donation" action="" method="POST">
                        <input type="hidden" id="isAphresis">
                        <div class="form-group mb-3">
                            <label class="form-label" for="aptID">Appointment ID</label>
                            <input type="text" class="form-control" id="aptID" name="aptID" readonly>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="bloodgroup">Blood Group</label>
                                    <select class="form-select" name="bloodgroup" required>
                                        <option value="" disabled selected hidden>- Select Blood Type -</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="haemo">Haemoglobin Level (gm/dL)</label>
                                    <input type="number" min="0" step="0.1" class="form-control" id="haemo" name="haemo" placeholder="Haemoglobin Level" onkeyup="checkHaemo(this.value);" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="weight">Weight (kg)</label>
                            <input type="number" min="0" step="0.1" class="form-control" id="weight" name="weight" placeholder="Weight" onkeyup="checkWeight(this.value);" required />
                        </div>
                        <div class="form-group mb-3" id="type">
                            <label class="form-label" for="donationType">Donation Type</label></br>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="whole" name="donationType" value="w" required>
                                Whole Blood<label class="form-check-label" for="whole"></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="aphresis" name="donationType" value="a">
                                Aphresis<label class="form-check-label" for="aphresis"></label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="amount">Donated Amount (ml)</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount" readonly />
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="complete" name="complete" class="btn btn-primary me-auto">Complete</button>
                            <p class="me-auto" id="error"></p>
                            <button type="submit" id="remove" name="remove" class="btn btn-danger">Remove</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function toggleApt(id) {
            let newApt = document.getElementById('newApt');
            let historyApt = document.getElementById('aptHistory');

            if (id == 'new') {
                newApt.style.display = "none";
                historyApt.style.display = "block";
            } else {
                newApt.style.display = "block";
                historyApt.style.display = "none";
            }

        }

        function setEditable(x) {
            let completeBtn = document.getElementById('complete');
            let amount = document.getElementById('amount');
            let type = document.getElementsByName('donationType');
            let form = document.getElementsByClassName('form-control');
            let error = document.getElementById('error');

            if (x == true) {
                error.style.display = "none";
                amount.readOnly = false;
                completeBtn.disabled = false;
                type.disabled = false;
                form.required = true;
            } else {
                error.innerHTML = "INELIGIBLE";
                error.style.display = "block";
                completeBtn.disabled = true;
                type.disabled = true;
                form.required = false;
            }
        }

        function checkHaemo(haemo) {
            let weight = document.getElementById('weight');

            if (haemo < 11 || haemo > 16) {
                setEditable(false);
                weight.disabled = true;
                weight.required = false;
            } else {
                setEditable(true);
                weight.disabled = false;
                weight.required = true;
            }
        }

        function checkWeight(weight) {
            let haemo = document.getElementById('haemo');
            let amount = document.getElementById('amount');
            let isAphresis = document.getElementById('isAphresis').value;
            let aphresis = document.getElementById('aphresis');

            if (weight < 45) {
                setEditable(false);
                haemo.disabled = true;
                haemo.required = false;
            } else if (weight >= 45) {
                if (weight <= 50) {
                    amount.max = 350;
                    if (isAphresis == 1) {
                        aphresis.disabled = true;
                        aphresis.checked = false;
                    }
                }
                if (weight > 50) {
                    amount.max = 450;
                    if (weight >= 55 && isAphresis == 1) {
                        aphresis.disabled = false;
                    }
                }
                setEditable(true);
                haemo.disabled = false;
                haemo.required = true;
            }

        }

        $(document).ready(function() {
            $('.completeApt').on('click', function() {
                //retrieve data from table
                $tr = $(this).closest('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                //set the value 
                $('#aptID').val(data[0]);

                let whole = document.getElementById('whole');
                let aphresis = document.getElementById('aphresis');
                if (data[1] == 0) {
                    whole.disabled = true;
                } else {
                    whole.disabled = false;
                }
                $('#isAphresis').val(data[2]);
                if (data[2] == 0) {
                    aphresis.disabled = true;
                } else {
                    aphresis.disabled = false;
                }
            });
        });
    </script>
    
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