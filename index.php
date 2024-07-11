<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing</title>
</head>
<body>
<?php
// Check if the user is logged in
if(isset($_SESSION['username'])) {
    // If logged in, show only the Dashboard link
    echo '<a href="/website/dashboard.php">Dashboard</a>';
} else {
    // If not logged in, show both Login and Sign Up links
    echo '<a href="/website/login.php">Login</a>';
    echo '<a href="/website/register.php"> Sign Up</a>';
}
?>
</body>
</html>
