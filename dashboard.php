<?php
session_start();
include('db_conn.php');

// Function to validate Discord link
function isValidDiscordLink($link) {
    return strpos($link, 'https://discord.com') === 0;
}

// Function to validate Telegram link
function isValidTelegramLink($link) {
    return strpos($link, 'https://t.me/') === 0;
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // If user is not logged in, redirect to login page
    header('Location: index.php');
    exit;
}

// Get user's bio, profile picture, username, title, cursor URL, background, music URL, and splash screen text from the database
$username = $_SESSION['username'];
$get_info_sql = "SELECT bio, pfp, username, title, cursor_url, background, music_url, splash_text, discord_link, telegram_link FROM usernames WHERE username='$username'";
$result = mysqli_query($conn, $get_info_sql);
$row = mysqli_fetch_assoc($result);
$bio = $row['bio'];
$pfp = $row['pfp'];
$currentUsername = $row['username'];
$title = $row['title'];
$cursorUrl = $row['cursor_url'];
$background = $row['background'];
$musicUrl = $row['music_url'];
$splashText = $row['splash_text'];
$discordLink = $row['discord_link']; // Added for Discord link
$telegramLink = $row['telegram_link']; // Added for Telegram link

// Process updates if form is submitted
if (isset($_POST['save_changes'])) {
    $new_bio = $_POST['new_bio'];
    $new_pfp = $_POST['new_pfp'];
    $new_username = $_POST['new_username'];
    $new_title = $_POST['new_title'];
    $new_cursor_url = $_POST['new_cursor_url'];
    $new_background = $_POST['new_background'];
    $new_music_url = $_POST['new_music_url'];
    $new_splash_text = $_POST['new_splash_text'];
    $new_discord_link = $_POST['new_discord_link']; // Added for Discord link
    $new_telegram_link = $_POST['new_telegram_link']; // Added for Telegram link

    // Update bio
    $update_bio_sql = "UPDATE usernames SET bio='$new_bio' WHERE username='$username'";
    mysqli_query($conn, $update_bio_sql);

    // Update profile picture
    $update_pfp_sql = "UPDATE usernames SET pfp='$new_pfp' WHERE username='$username'";
    mysqli_query($conn, $update_pfp_sql);

    // Update username if changed and not already taken
    if ($new_username !== $currentUsername) {
        $check_username_sql = "SELECT * FROM usernames WHERE username='$new_username'";
        $check_result = mysqli_query($conn, $check_username_sql);
        if (mysqli_num_rows($check_result) == 0) {
            $update_username_sql = "UPDATE usernames SET username='$new_username' WHERE username='$username'";
            mysqli_query($conn, $update_username_sql);
            // Update session username
            $_SESSION['username'] = $new_username;
            $username = $new_username; // Update username variable for consistency
        } else {
            // Username already taken
            echo "Username '$new_username' is already taken.";
        }
    }

    // Validate Discord link
    if (!empty($new_discord_link) && !isValidDiscordLink($new_discord_link)) {
        echo "Invalid Discord link. Discord link must start with 'https://discord.com'.";
        exit; // Stop further execution
    }
    
    // Validate Telegram link
    if (!empty($new_telegram_link) && !isValidTelegramLink($new_telegram_link)) {
        echo "Invalid Telegram link. Telegram link must start with 'https://t.me/'.";
        exit; // Stop further execution
    }

    // Update display name (title)
    $update_title_sql = "UPDATE usernames SET title='$new_title' WHERE username='$username'";
    mysqli_query($conn, $update_title_sql);

    // Update cursor URL
    $update_cursor_sql = "UPDATE usernames SET cursor_url='$new_cursor_url' WHERE username='$username'";
    mysqli_query($conn, $update_cursor_sql);

    // Update background
    $update_background_sql = "UPDATE usernames SET background='$new_background' WHERE username='$username'";
    mysqli_query($conn, $update_background_sql);

    // Update music URL
    $update_music_sql = "UPDATE usernames SET music_url='$new_music_url' WHERE username='$username'";
    mysqli_query($conn, $update_music_sql);

    // Update splash screen text
    $update_splash_text_sql = "UPDATE usernames SET splash_text='$new_splash_text' WHERE username='$username'";
    mysqli_query($conn, $update_splash_text_sql);

    // Update Discord link
    $update_discord_link_sql = "UPDATE usernames SET discord_link='$new_discord_link' WHERE username='$username'";
    mysqli_query($conn, $update_discord_link_sql);

    // Update Telegram link
    $update_telegram_link_sql = "UPDATE usernames SET telegram_link='$new_telegram_link' WHERE username='$username'";
    mysqli_query($conn, $update_telegram_link_sql);

    // Redirect to dashboard after changes
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome to the Dashboard, <?php echo $_SESSION['username']; ?>!</h1>
    <h2>Edit Bio:</h2>
    <form method="post" action="">
        <textarea name="new_bio" placeholder="Enter your new bio"><?php echo $bio; ?></textarea><br>
        <h2>Edit Profile Picture:</h2>
        <input type="text" name="new_pfp" placeholder="Enter the URL of your new profile picture" value="<?php echo $pfp; ?>"><br>
        <h2>Edit Username:</h2>
        <input type="text" name="new_username" placeholder="Enter your new username" value="<?php echo $currentUsername; ?>"><br>
        <h2>Edit Display Name:</h2>
        <input type="text" name="new_title" placeholder="Enter your new display name" value="<?php echo $title; ?>"><br>
        <h2>Edit Cursor:</h2>
        <input type="text" name="new_cursor_url" placeholder="Enter the URL of your custom cursor image" value="<?php echo $cursorUrl; ?>"><br>
        <h2>Edit Background:</h2>
        <input type="text" name="new_background" placeholder="Enter the URL of your new background" value="<?php echo $background; ?>"><br>
        <h2>Edit Music:</h2>
        <input type="text" name="new_music_url" placeholder="Enter the URL of your new music" value="<?php echo $musicUrl; ?>"><br>
        <h2>Edit Splash Screen Text:</h2>
        <input type="text" name="new_splash_text" placeholder="Enter your new splash screen text" value="<?php echo $splashText; ?>"><br>
        <h2>Edit Discord Link:</h2>
        <input type="text" name="new_discord_link" placeholder="Enter your new Discord link" value="<?php echo $discordLink; ?>"><br>
        <h2>Edit Telegram Link:</h2>
        <input type="text" name="new_telegram_link" placeholder="Enter your new Telegram link" value="<?php echo $telegramLink; ?>"><br>
        <button type="submit" name="save_changes">Save</button>
    </form>
    <a href="logout.php">Logout</a>
</body>
</html>
