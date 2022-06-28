<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "dbProject";

global $conn;

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

global $userID;
global $userName;
global $userType;

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
    $userName = $_SESSION['UserName'];
    $userType = $_SESSION['UserType'];
}

//redirect user away from login and register if logged in
function redirectHome($userType)
{
    if ($userType == 'staff') {
        header('Location: staff/staffApt.php');
        ob_end_flush();
        exit();
    }
    if ($userType == "donor") {
        header('Location: index.php');
        ob_end_flush();
        exit();
    }
}
?>