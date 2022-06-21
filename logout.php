<!DOCTYPE html>

<html>

<head>
    <script>
        if (confirm("Are you sure?")) {
            <?php
            session_start();
            session_unset();
            session_destroy();
            ?>

            alert("Successfully logout, click OK to return to homepage.");
            window.location = "index.php";
        }
    </script>
</head>

</html>