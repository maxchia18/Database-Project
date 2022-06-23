<?php
session_start();

if ($userType == "staff") {
    session_unset();
    session_destroy();
?>
<script>
        alert("Successfully logout, click OK to return to homepage.");
</script>
<?php
    header("Location: ../index.php");
}

session_unset();
session_destroy();
header("Location: index.php");
?>