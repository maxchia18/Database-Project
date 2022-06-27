<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['complete']) || isset($_POST['remove'])) {
        $aptID = $_POST['aptID'];
        $bloodgroup = $_POST['bloodgroup'];
        $haemo = $_POST['haemo'];
        $weight = $_POST['weight'];
        $donationType = $_POST['donationType'];
        $amount = $_POST['amount'];

        //get data
        $getData = "SELECT Appointment.*,Donor.*,Blood.BloodID FROM Appointment 
                INNER JOIN Donor ON Appointment.DonorID = Donor.UserID 
                INNER JOIN Blood ON Appointment.DonorID = Blood.DonorID 
                WHERE AppointmentID = $aptID";
        $getDataResult = mysqli_query($conn, $getData);
        $getData = mysqli_fetch_assoc($getDataResult);
        $donorID = $getData['DonorID'];
        $bloodID = $getData['BloodID'];
        $appointedDate = $getData['AppointedDate'];
        $lastDate = $getData['LastDonationDate'];
        $datetime = new DateTime($appointedDate);
        $datetime->modify('-6 months');
        $_6months = $datetime->format('Y-m-d');
        $compLastDate = new DateTime($lastDate);
    }


    if (isset($_POST['complete'])) {
        // update data
        $updateApt = "UPDATE Appointment SET AppointmentStatus = 'completed' WHERE AppointmentID = $aptID";
        $updateBloodResult = mysqli_query($conn, $updateApt);

        //check aphhresis eligibility
        $checkEligible = "SELECT COUNT(*) AS 'total' FROM Appointment WHERE DonorID = $donorID AND Appointment.AppointmentStatus = 'completed'";
        $checkResult = mysqli_query($conn, $checkEligible);
        $checkEligible = mysqli_fetch_assoc($checkResult);
        if ($weight > 55 && $checkEligible['total'] > 1 && $lastDate > $_6months && $getData['Age'] <= 55) {
            $updateDonor = "UPDATE Donor SET IsAphresis = 1, Weight = '$weight',LastDonationDate = '$appointedDate' WHERE UserID = $donorID";
            $updateDonorResult = mysqli_query($conn, $updateDonor);
        } else {
            $updateDonor = "UPDATE Donor SET IsAphresis = 0, Weight = '$weight', LastDonationDate = '$appointedDate' WHERE UserID = $donorID";
            $updateDonorResult = mysqli_query($conn, $updateDonor);
        }

        $updateBlood = "UPDATE Blood SET BloodGroup = '$bloodgroup', HaemoglobinLevel = '$haemo' WHERE DonorID = $donorID";
        $updateBloodResult = mysqli_query($conn, $updateBlood);

        //insert donation
        $insertDonation = "INSERT INTO BloodDonation(BloodID, AppointmentID, DonationAmount, DonationType, StaffID)
                      VALUES('$bloodID','$aptID','$amount','$donationType','$userID')";

        if (mysqli_query($conn, $insertDonation)) {
            $donationID = mysqli_insert_id($conn);
            $insertHistory = "INSERT INTO DonationHistory(DonorID, DonationID) VALUES('$donorID','$donationID')";
            $insertStock = "INSERT INTO BloodStock(DonationID, CentreID) VALUES('$donationID','$centreID')";
            if (mysqli_query($conn, $insertHistory) && mysqli_query($conn, $insertStock)) {
                echo "<script>
                alert('Appointment #'+$aptID+' Completed!');
                </script>";
            }
        } else {
            echo mysqli_error($conn);
        }
    }


    //remove appointment
    if (isset($_POST['remove'])) {
        $updateApt = "UPDATE Appointment SET AppointmentStatus = 'rejected' WHERE AppointmentID = $aptID";
        $updateBloodResult = mysqli_query($conn, $updateApt);

        $updateDonor = "UPDATE Donor SET Weight = '$weight' WHERE UserID = $donorID";
        $updateDonorResult = mysqli_query($conn, $updateDonor);

        $updateBlood = "UPDATE Blood SET BloodGroup = '$bloodgroup', HaemoglobinLevel = '$haemo' WHERE DonorID = $donorID";
        $updateBloodResult = mysqli_query($conn, $updateBlood);

        echo "<script>
        alert('Appointment #'+$aptID+' Removed!');
        </script>";
    }

    //refresh
    echo "<meta http-equiv='refresh' content='0'>";
}
