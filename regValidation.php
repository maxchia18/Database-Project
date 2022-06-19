<?php
// ob_start();
// include "header.php";

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $fname = $_POST['fname'];
//     $lname = $_POST['lname'];
//     $weight = $_POST['weight'];
//     $bloodgroup = $_POST['bloodgroup'];
//     $icno = $_POST['icno'];
//     $age = $_POST['age'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $tac = $_POST['checkTAC'];
//     $submit = $_POST['signUp'];

//     //aphresis or whole blood donation condition
//     $isWhole = 0;
//     $isAphresis = 0;
//     if (($age >= 17 || $age <= 60) && $weight >= 45) {
//         $isWhole = 1;
//     }

//     if ($age <= 55) {
//         $isAphresis = 1;
//     }

//     //check for existing ID
//     $checkQuery = "SELECT DonorID FROM Donor WHERE DonorID = '$icno'";
//     $result = mysqli_query($conn, $checkQuery);
//     $count = mysqli_num_rows($result);

//     if ($count == 0) {
//         $password = password_hash($password, PASSWORD_DEFAULT);
//         $sql = "INSERT INTO Donor(DonorID, FirstName, LastName, Weight, bloodgroup, Email, Password,IsWhole,IsAphresis)
//     VALUES('$icno','$fname','$lname','$weight','$bloodgroup','$email','$password','$isWhole','$isAphresis')";

//         if ($conn->query($sql) == TRUE) {
//             echo "success";
//         } else {
//             echo "Error: " . $sql . "<br>" . $conn->error;
//         }
//     } else {
//         echo '<script type ="text/JavaScript">';
//         echo 'if(alert("IC Number exists.")){''
//         echo '';  
//         echo '}';
//         echo '</script>';
//         // header("Location: registration.php");
//         // exit();
//     }
// }

// ob_end_flush();
// ?>