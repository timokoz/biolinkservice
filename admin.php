<?php
session_start();
include('db_conn.php');

// Check if admin is logged in, redirect to login page if not
if (!isset($_SESSION['username']) || $_SESSION['power'] != 'Admin') {
    header('Location: index.php');
    exit;
}

// Array to store generated keys
$generatedKeys = array();

// Generate new invite keys
if(isset($_POST['generate_keys'])) {
    $num_keys = $_POST['num_keys'];

    // Generate and insert new keys into the database
    for ($i = 0; $i < $num_keys; $i++) {
        $key_value = generateRandomString(10); // Function to generate random key value
        $insert_sql = "INSERT INTO invite_keys (key_value) VALUES ('$key_value')";
        mysqli_query($conn, $insert_sql);
        $generatedKeys[] = $key_value; // Store the generated key in the array
    }
}

// Function to generate random string for invite key
function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

// Assign admin privileges to a user
if(isset($_POST['assign_admin'])) {
    $username = $_POST['username'];

    // Update the user's role to 'Admin' in the database
    $update_sql = "UPDATE usernames SET power = 'Admin' WHERE username = '$username'";
    mysqli_query($conn, $update_sql);

    echo "User '$username' is now an admin.";
}

// Function to assign badges to a user
function assignBadge($username, $badgeName) {
    global $conn;
    // Update the user's badge in the database
    $update_sql = "UPDATE usernames SET $badgeName = 1 WHERE username = '$username'";
    mysqli_query($conn, $update_sql);
}

// Check if badge assignment form is submitted
if(isset($_POST['assign_badge'])) {
    $username = $_POST['username'];
    $badgeName = $_POST['badge'];

    // Call function to assign badge to user
    assignBadge($username, $badgeName);

    echo "Badge '$badgeName' assigned to user '$username'.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h2>Generate Invite Keys</h2>
    <form method="post" action="">
        <label for="num_keys">Number of Keys:</label>
        <input type="number" id="num_keys" name="num_keys" min="1" required>
        <button type="submit" name="generate_keys">Generate Keys</button>
    </form>
    <?php if(isset($_POST['generate_keys'])): ?>
    <?php endif; ?>

    <!-- Form to assign admin privileges -->
    <h2>Assign Admin Privileges</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit" name="assign_admin">Assign Admin</button>
    </form>

    <!-- Form to assign badges -->
    <h2>Assign Badges</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="badge">Select Badge:</label>
        <select id="badge" name="badge">
            <option value="booster">Booster</option>
            <option value="donator">Donator</option>
            <option value="early_supporter">Early Supporter</option>
            <option value="verified">Verified</option>
        </select>
        <button type="submit" name="assign_badge">Assign Badge</button>
    </form>

    <?php if(!empty($generatedKeys)): ?>
    <p>Generated Keys:</p>
    <ul>
        <?php foreach($generatedKeys as $key): ?>
        <li><?php echo $key; ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <a href="dashboard.php">Dashboard</a>
    <a href="logout.php">Logout</a>
</body>
</html>
