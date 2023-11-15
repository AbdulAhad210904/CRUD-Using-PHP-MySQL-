<?php
$signup_successful = false;
$signup_failed = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "menu"; 
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle signup form submission
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Insert a new user into the database
        $sql = "INSERT INTO user_login (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === true) {
            $signup_successful = true;
        } else {
            $signup_failed = true;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<title>SignUp</title>  
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php if ($signup_successful) { ?>
            <p>Signup successful</p>
            <button onclick="location.href='/Project/php/login.php'" type="button">Go to Login</button>
        <?php } else { ?>
            <?php if ($signup_failed) { ?>
                <p>Signup failed. Please try again.</p>
            <?php } ?>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Sign Up">
            </form>
        <?php } ?>
    </div>
</body>
</html>
