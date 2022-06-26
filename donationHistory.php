<?php
include "header.php";

$getHistory = "SELECT BloodDonation.*,Appointment.* FROM Appointment 
               INNER JOIN BloodDonation ON Appointment.AppointmentID = BloodDonation.AppointmentID
               WHERE AppointmentStatus = 'completed' AND Appointment.DonorID = $userID 
               ORDER BY BloodDonation.DonationID";
$getHistoryResult = mysqli_query($conn, $getHistory);
$count = mysqli_num_rows($getHistoryResult);

?>

<!DOCTYPE html>

<html>

<head>
    <style>
        body {
            overflow: hidden;
        }

        #sidebar {
            height: 120%;
            width: 20%;
            position: fixed;
            z-index: 1;
            left: 0;
            overflow-x: hidden;
            padding-top: 20px;
            background-color: gold;
        }

        .main {
            margin-left: 20%;
            margin-bottom: 5%;
            height: 92vh;
            overflow-y: auto !important;
        }

        .alink {
            text-decoration: none;
            color: black;
            margin: 10%;
            transition: 0.5s;
            vertical-align: middle;
        }

        #link1:hover {
            color: white;
            transition: 0.5s;
        }

        .bg {
            margin: 5% auto;
            width: 105%;
        }

        #bg1 {
            background-color: white;
            border-radius: 25px;
        }

        .his {
            padding: 1%;
            padding-bottom: 0;
            box-shadow: 10px 10px lightblue;
            background-color: rgb(255, 255, 185);
        }

        #aptLink{
            text-decoration:none;
        }

        .detailBtn {
            padding: 4% 10%;
        }
    </style>
</head>

<body>
    <div id="sidebar">
        <div class="w3-center"><i class="fa fa-history w3-xxxlarge"></i>
            <h2 class="mb-4">History</h2>
        </div>
        <div class='bg' id='bg1'>
            <a id="link2" class='alink' href="#">Donation History
                <i class="fa fa-history" style="margin-left:14.3%;"></i></a>
            </a>
        </div>
    </div>
    <div class="main w3-padding-large">
        <h1 class="mb-4">Donation History</h1>
        <?php
        if ($count == 0) {
            echo "
            <div class='his container rounded w3-round-large my-3' style='background-color:gold;'>
                <h2 class='pt-0 pb-3 w3-center'>Seems like you don't have donation record yet!</br>
                    <a href='appointmentNew.php'>Make appointment now</a>?
                </h2>
            </div>";
        } else {
            while ($history = mysqli_fetch_assoc($getHistoryResult)) {
                $getName = "SELECT CentreName FROM DonationCentre WHERE CentreID = $history[CentreID]";
                $nameResult = mysqli_query($conn, $getName);
                $nameRow = mysqli_fetch_assoc($nameResult);

                $getBlood = "SELECT * FROM Blood WHERE BloodID = $history[BloodID]";
                $bloodResult = mysqli_query($conn, $getBlood);
                $getBlood = mysqli_fetch_assoc($bloodResult);

                if ($history['DonationType'] == 'w') {
                    $donationType = "Whole Blood";
                } else {
                    $donationType = "Aphresis";
                }
                echo "
            <div class='his container rounded w3-round-large my-3'>
                <div class='row'>
                    <h4 class='col-11'>DonationID #$history[DonationID]</h4>
                    <div class='col'>
                        <button type='button' class='detailBtn col btn btn-warning' title='Donation Details'
                        data-bs-toggle='modal' data-bs-target='#donationDetail'><i class='fa-solid fa-expand'></i></button>

                        <!--get data-->                    
                        <table hidden>
                            <tr style='display:none;'>
                                <td>$history[DonationID]</td>
                                <td>$history[AppointmentID]</td>
                                <td>$nameRow[CentreName]</td>
                                <td>$history[AppointedDate]</td>
                                <td>$history[AppointedSession]</td>
                                <td>$getBlood[BloodGroup]</td>
                                <td>$getBlood[HaemoglobinLevel]</td>
                                <td>$donationType</td>
                                <td>$history[DonationAmount]</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p class='mb-2'><i class='fa-solid fa-droplet' style='margin-right:2%;'></i>$donationType, $history[DonationAmount]ml</p>
                <p class='my-2'><i class='fas fa-map-marker-alt' style='margin-right:2%;'></i>$nameRow[CentreName]</i></p>
                <div class='w3-row'>
                    <div class='w3-threequarter'>
                        <p><i class='fa fa-calendar-alt' style='margin-right:2.4%;'></i>$history[AppointedDate], $history[AppointedSession]</p>
                    </div>
                </div>

                
            </div>";
            }
        } ?>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="donationDetail" tabindex="-1" aria-labelledby="donationDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="donationDetailLabel">Donation Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="donationDetailForm" action="">
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="donationID">Donation ID</label>
                                    <input type="text" class="form-control" id="donationID" name="donationID">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="aptID"><a id='aptLink' href='appointment.php'>Appointment ID</a></label>
                                    <input type="text" class="form-control" id="aptID" name="aptID">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="centre">Donation Centre</label>
                            <input type="text" class="form-control" id="centre" name="centre">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date">Date</label>
                                    <input type="text" class="form-control" id="date" name="date">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="session">Session</label>
                                    <input type="text" class="form-control" id="session" name="session">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="bloodGroup">Blood Group</label>
                                    <input type="text" class="form-control" id="bloodGroup" name="bloodGroup">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="haemo">Haemoglobin Level</label>
                                    <input type="number" class="form-control" id="haemo" name="haemo" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="type">Donation Type</label>
                                    <input type="text" class="form-control" id="type" name="type" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="amount">Donated Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#donationDetailForm :input:not(button)").prop("readOnly", true);

        $(document).ready(function() {
            $('.detailBtn').on('click', function() {
                //retrieve data from table
                $tr = $(this).siblings('table').find('tr');
                var data = $tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                // //set the value 
                $('#donationID').val(data[0]);
                $('#aptID').val(data[1]);
                $('#centre').val(data[2]);
                $('#date').val(data[3]);
                $('#session').val(data[4]);
                $('#bloodGroup').val(data[5]);
                $('#haemo').val(data[6]);
                $('#type').val(data[7]);
                $('#amount').val(data[8]);
            });
        });
    </script>
</body>

</html>