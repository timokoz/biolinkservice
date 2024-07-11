<?php
// Include the database connection file
include('db_conn.php');

// Check if the username parameter is set in the URL
if(isset($_GET['username'])) {
    // Retrieve the username from the URL
    $username = $_GET['username'];

    // Prepare and execute the SQL query to fetch user information
    $sql = "SELECT * FROM usernames WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists in the database
    if($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <title>/<?php echo $user['username']; ?></title>
    <style>

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000000;
            cursor: url(<?php echo $user['cursor_url']; ?>), auto;
            overflow: hidden;
            overflow-x: hidden;
            overflow-y: hidden;      
        }

        a {
            cursor: inherit;
        }

        /* Background container */
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: url(<?php echo $user['background']; ?>);
            background-repeat: no-repeat;
            background-size: cover;
            filter: blur(10px);
            z-index: -1;
            background-position: center;
        }

        /* Profile container */
        .profile-container {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        /* Profile picture */
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .badge {
            width: 30px;
            height: 25px;
            transition: transform 200ms ease-in-out;
        }


        .badge:hover {
            transform: scale(1.05);
        }


        /* Profile title */
        .profile-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        /* Bio */
        .bio {
            margin-bottom: 20px;
        }

        /* Other profile information */
        .profile-info {
            margin-bottom: 10px;
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        #clickanywhere {
            background-color: #080808;
            color: white;
            text-shadow: 0 0 10px rgba(255, 255, 255, 1);
            font-size: 12px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 1;
            transition: opacity 0.5s ease-in-out;
            opacity: 0.98;
        }

        .social-icons {
            margin-top: 0;
            color: #fff;
            font-size: 28px;
            transition: .2s ease-in-out;
            padding: 0 2px;
        }

        .fa-brands, .fab {
            font-family: "Font Awesome 6 Brands";
        }

        .fa-brands, .fab {
            font-weight: 400;
        }

    </style>
</head>
<body>
<?php if (!empty($user['background']) && pathinfo($user['background'], PATHINFO_EXTENSION) === 'mp4'): ?>
    <!-- Splash screen -->
    <div id="clickanywhere">
        <h1><?php echo !empty($user['splash_text']) ? $user['splash_text'] : "click to enter"; ?></h1>
    </div>

    <!-- Audio player -->
    <audio id="song" volume="<?php echo !empty($user['music_url']) ? '0' : '0.3'; ?>">
        <source id="audioSource" src="<?php echo !empty($user['music_url']) ? '' : $user['background']; ?>">
    </audio>

    <video playsinline draggable="false" loop id="myVideo" class="background-container">
        <source src="<?php echo $user['background']; ?>" type="video/mp4">
    </video>

    <script>
        document.addEventListener("click", function () {
            var clickAnywhereElement = document.getElementById("clickanywhere");
            clickAnywhereElement.style.opacity = "0";
            setTimeout(function () {
                clickAnywhereElement.style.display = "none";
            }, 500);
            var video = document.getElementById("myVideo");
            var audio = document.getElementById("song");
            video.volume = 0.3; // Set video volume to 0.3
            video.play();
            audio.play();
        });
    </script>
<?php elseif (!empty($user['music_url'])): ?>
    <!-- Splash screen -->
    <div id="clickanywhere">
        <h1><?php echo !empty($user['splash_text']) ? $user['splash_text'] : "click to enter"; ?></h1>
    </div>

    <!-- Audio player -->
    <audio id="song" volume="0.3">
        <source id="audioSource" src="<?php echo $user['music_url']; ?>">
    </audio>

    <video playsinline draggable="false" loop id="myVideo" class="background-container">
        <source src="<?php echo $user['background']; ?>" type="video/mp4">
    </video>

    <script>
        document.addEventListener("click", function () {
            var clickAnywhereElement = document.getElementById("clickanywhere");
            clickAnywhereElement.style.opacity = "0";
            setTimeout(function () {
                clickAnywhereElement.style.display = "none";
            }, 500);
            var video = document.getElementById("myVideo");
            var audio = document.getElementById("song");
            video.volume = 0.3; // Set video volume to 0.3
            video.play();
            audio.play();
        });
    </script>
<?php endif; ?>

    </div>

    <!-- Background container -->
    <div class="background-container"></div>

    <!-- Profile container -->
    <div class="profile-container">
        <!-- Profile picture -->
        <?php if(!empty($user['pfp'])): ?>
            <img class="profile-picture" src="<?php echo $user['pfp']; ?>" alt="Profile Picture">
        <?php endif; ?>
        
        <!-- Profile title -->
        <h1 class="profile-title"><span class="tooltip"><?php echo !empty($user['title']) ? $user['title'] : $user['username']; ?><span class="tooltiptext">User ID: <?php echo $user['id']; ?></span></span></h1>

        <!-- Admin badge -->
        <?php if($user['power'] === 'Admin'): ?>
        <div class="tooltip">
            <img class="badge" src="badges/staff.gif" alt="Admin Badge">
            <span class="tooltiptext">User is a staff member</span>
        </div>
        <?php endif; ?>

        <!-- Early Supporter badge -->
        <?php if($user['early_supporter'] === 1): ?>
        <div class="tooltip">
            <img class="badge" src="badges/early.png" alt="Early Supporter Badge">
            <span class="tooltiptext">User is an early supporter</span>
        </div>
        <?php endif; ?>

        <!-- Verified badge -->
                <?php if($user['verified'] === 1): ?>
        <div class="tooltip">
            <img class="badge" src="badges/verified.png" alt="Verified Badge">
            <span class="tooltiptext">User is verified</span>
        </div>
        <?php endif; ?>

        <!-- Booster badge -->
        <?php if($user['verified'] === 1): ?>
        <div class="tooltip">
            <img class="badge" src="badges/booster.gif" alt="Booster Badge">
            <span class="tooltiptext">User is a Booster</span>
        </div>
        <?php endif; ?>

        <!-- Donator badge -->
        <?php if($user['donator'] === 1): ?>
        <div class="tooltip">
            <img class="badge" src="badges/donator.gif" alt="Donator Badge">
            <span class="tooltiptext">User is a Donator</span>
        </div>
        <?php endif; ?>

        <!-- Bio -->
        <p class="bio"><?php echo $user['bio']; ?></p>

        <!-- Discord link -->
        <?php if(!empty($user['discord_link'])): ?>
        <div class="tooltip">
        <a href="<?php echo $user['discord_link']; ?>" target="_blank"><i class="fa-brands fa-discord social-icons"></i></a>
            <span class="tooltiptext">Discord</span>
        </div>
        <?php endif; ?>

        <!-- Telegram link -->
        <?php if(!empty($user['telegram_link'])): ?>
        <div class="tooltip">
            <a href="<?php echo $user['telegram_link']; ?>" target="_blank"><i class="fa-brands fa-telegram social-icons"></i></a>
            <span class="tooltiptext">Telegram</span>
        </div>
        <?php endif; ?>


    </div>
</body>
</html>

<?php
    } else {
        // User not found
        include('404.php');
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Username parameter not provided in the URL
    include('404.php');
}
?>