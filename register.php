<?php
session_start();
include('db_conn.php');

// Redirect to dashboard if already logged in
if(isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}

// Register user
if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $invite_key = $_POST['invite_key']; // Add this line to retrieve the invite key from the form

    // Your registration logic here
    // Check Username Length
    $username_length = strlen($username);
    if ($username_length < 1 || $username_length > 15) {
        // Invalid Length
        echo "Username too long.";
    } else {
        // Check Username Syntax
        $re = '/\A[a-z\d]+(?:[.-][a-z\d]+)*\z/i';
        if (!preg_match($re, $username)) {
            // Invalid Syntax
            echo "Invalid username syntax.";
        } else {
            // Check if username is taken
            $check_sql = "SELECT * FROM usernames WHERE username='$username'";
            $check_result = mysqli_query($conn, $check_sql);
            if (mysqli_num_rows($check_result) > 0) {
                // Username already taken
                echo "Username is already taken.";
            } else {
                // Check if invite key is valid
                $check_key_sql = "SELECT * FROM invite_keys WHERE key_value='$invite_key' AND used = 0";
                $check_key_result = mysqli_query($conn, $check_key_sql);
                if (mysqli_num_rows($check_key_result) == 0) {
                    // Invite key is invalid or already used
                    echo "Invalid or already used invite key.";
                } else {
                    // Hash the password using Argon2
                    $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
                    
                    // Proceed with registration
                    $insert_sql = "INSERT INTO usernames (username, password) VALUES ('$username', '$hashed_password')";
                    
                    if (mysqli_query($conn, $insert_sql)) {
                        // Registration successful, set session variables and mark invite key as used
                        $_SESSION['username'] = $username;
                        $update_key_sql = "UPDATE invite_keys SET used = 1 WHERE key_value='$invite_key'";
                        mysqli_query($conn, $update_key_sql);
                        header('Location: dashboard.php');
                        exit;
                    } else {
                        echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login System</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="invite_key" placeholder="Invite Key" required><br> <!-- Add input field for invite key -->
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>

<?php
mysqli_close($conn);
?>
