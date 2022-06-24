<?php

$getAppointment = "SELECT * FROM Appointment WHERE CentreID = $centreID AND IsCompleted = 0 ORDER BY AppointedDate,AppointedSession";
$getAptResult = mysqli_query($conn, $getAppointment);

?>

<!DOCTYPE html>

<html>

<head>
    <style>
        .completeApt {
            width: 50%;
            background-color: rgb(15, 165, 15);
            color: #fff;
            font-weight: bold;
            transition: 0.5s;
        }

        .completeApt:hover {
            background-color: green;
            color: yellow;
            transition: 0.5s;
        }
    </style>

    <script>

    </script>
</head>

<body>
    <div class="container border w3-round-large" id="newapt" style="height:80vh;overflow:auto;">
        <h3>New Appointment</h3>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th style="display:none;">iswhole</th>
                    <th style="display:none;">isaphresis</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">Session</th>
                    <th scope="col">Centre</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($apt = mysqli_fetch_assoc($getAptResult)) {
                    $getDonor = "SELECT User.FirstName,User.LastName,Donor.IsWhole, Donor.IsAphresis 
                                FROM User INNER JOIN Donor WHERE User.UserID = $apt[DonorID]";
                    $getDonorResult = mysqli_query($conn, $getDonor);
                    $donorData = mysqli_fetch_assoc($getDonorResult);

                    echo "<tr>
                    <th scope='row'>$apt[AppointmentID]</th>
                    <th style='display:none;'>$donorData[IsWhole]</th>
                    <th style='display:none;'>$donorData[IsAphresis]</th>
                    <td>$donorData[FirstName] $donorData[LastName]</td>
                    <td>$apt[AppointedDate]</td>
                    <td>$apt[AppointedSession]</td>
                    <td>$centreName</td>
                    <td><button type='button' class='completeApt btn btn-info border w3-round-xlarge' name='completeApt' data-bs-toggle='modal' data-bs-target='#completeDonation'>	
                    <i class='fa fa-check'></i></button></td>
                </tr>";
                } ?>
            </tbody>
        </table>
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
                                    <label class="form-label" for="haemo">Haemoglobin Level (%)</label>
                                    <input type="number" min="0" step="0.1" class="form-control" id="haemo" name="haemo" placeholder="Haemoglobin Level" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="weight">Weight (kg)</label>
                            <input type="number" min="0" step="0.1" class="form-control" id="weight" name="weight" placeholder="Weight" onkeyup="checkWeight(this.value);" required />
                        </div>
                        <div class="form-group mb-3">
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
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount" readonly />
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="complete" name="complete" class="btn btn-primary me-auto">Complete</button>
                            <button type="button" id="remove" name="remove" class="btn btn-danger" style="display:none;">Remove</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function checkWeight(weight) {
            let amount = document.getElementById('amount');
            let completeBtn = document.getElementById('complete');
            let removeBtn = document.getElementById('remove');
            if (weight >= 45 && weight <= 50) {
                amount.value = "350";
                completeBtn.disabled = false;
                removeBtn.style.display = "none";
            } else if (weight > 50) {
                amount.value = "450";
                completeBtn.disabled = false;
                removeBtn.style.display = "none";
            } else if (weight < 45) {
                amount.value = "INELIGIBLE";
                completeBtn.disabled = true;
                removeBtn.style.display = "block";
            }
        }

        $(document).ready(function() {
            $('.completeApt').on('click', function() {
                //retrieve data from table
                $tr = $(this).closest('tr');
                var data = $tr.children("th").map(function() {
                    return $(this).text();
                }).get();

                //set the value for appointment ID
                $('#aptID').val(data[0]);

                let whole = document.getElementById('whole');
                let aphresis = document.getElementById('aphresis');
                if (data[2] == 0) {
                    aphresis.disabled = true;
                }
                if (data[1] == 0) {
                    whole.disabled = true;
                }

            });
        });
    </script>
</body>

</html>