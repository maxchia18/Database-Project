<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['complete'])) {
        $aptID = $_POST['aptID'];
        $bloodgroup = $_POST['bloodgroup'];
        $haemo = $_POST['haemo'];
        $weight = $_POST['weight'];
        $donationType = $_POST['donationType'];
        $amount = $_POST['amount'];

        //get data
        $getApt = "SELECT * FROM Appointment WHERE AppointmentID = $aptID";
        $getAptResult = mysqli_query($conn, $getApt);
        $getApt = mysqli_fetch_assoc($getAptResult);
        $donorID = $getApt['DonorID'];

        $getBlood = "SELECT * FROM Blood WHERE DonorID = $donorID";
        $getBloodResult = mysqli_query($conn, $getBlood);
        $getBlood = mysqli_fetch_assoc($getBloodResult);
        $bloodID = $getBlood['BloodID'];

        //update data
        $updateApt = "UPDATE Appointment SET IsCompleted = 1 WHERE AppointmentID = $aptID";
        $updateBloodResult = mysqli_query($conn, $updateApt);

        $updateDonor = "UPDATE Donor SET Weight = '$weight' WHERE UserID = $donorID";
        $updateDonorResult = mysqli_query($conn, $updateDonor);

        $updateBlood = "UPDATE Blood SET BloodGroup = '$bloodgroup', HaemoglobinLevel = '$haemo' WHERE DonorID = $donorID";
        $updateBloodResult = mysqli_query($conn, $updateBlood);

        //insert donation
        $insertSQL = "INSERT INTO BloodDonation(BloodID, AppointmentID, DonationAmount, DonationType, StaffID)
                      VALUES('$bloodID','$aptID','$amount','$donationType','$userID')";
        if ($result = mysqli_query($conn, $insertSQL)) {
            echo "<script>
                alert('Appointment #'+$aptID+' Completed!');
                </script>";
            //refresh
            echo "<meta http-equiv='refresh' content='0'>";
        }

    }
}
