<?php
include "completeApt.php";

?>

<!DOCTYPE html>

<html>

<head>
    <style>
        #error {
            display: none;
            color: red !important;
        }
    </style>

    <script>

    </script>
</head>

<body>
    <div class="content container border w3-round-large" style="height:80vh;overflow:auto;">
        <h3>New Appointment<span class="index"># ➜ Appointment ID</h3>

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
                    <td><button type='button' id='completeApt' class='actionBtn btn btn-info border w3-round-xlarge' name='completeApt' data-bs-toggle='modal' data-bs-target='#completeDonation'>	
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
                                    <input type="number" min="0" step="0.1" class="form-control" id="haemo" name="haemo" placeholder="Haemoglobin Level" onchange="checkHaemo(this.value);" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="weight">Weight (kg)</label>
                            <input type="number" min="0" step="0.1" class="form-control" id="weight" name="weight" placeholder="Weight" onchange="checkWeight(this.value);" required />
                        </div>
                        <div class="form-group mb-3" id="type">
                            <label class="form-label" for="donationType">Donation Type</label></br>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="whole" name="donationType" value="whole" required>
                                Whole Blood<label class="form-check-label" for="whole"></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="aphresis" name="donationType" value="aphresis">
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

    <script>
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
            $('#completeApt').on('click', function() {
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
</body>

</html>