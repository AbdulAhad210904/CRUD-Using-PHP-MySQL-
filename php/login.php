<?php
$login_successful = false;
$login_failed = false;
$user_id = null; // Initialize user_id

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

    // Handle login submission
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // check if the username and password match
        $sql = "SELECT id FROM user_login WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user_id = $row["id"]; // Retrieving user_id
            $login_successful = true;
        } else {
            $login_failed = true;
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
<title>Login Page</title>  
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($login_successful) { ?>
            <p>Login successful</p>
            <button onclick="location.href='/Project/php/create_menu.php?user_id=<?php echo $user_id; ?>'" type="button">View Menu</button>
            <button onclick="location.href='/Project/php/show_orders.php?user_id=<?php echo $user_id; ?>'" type="button">View Cart</button>
        <?php } else { ?>
            <?php if ($login_failed) { ?>
                <p>Login unsuccessful. Please try again.</p>
            <?php } ?>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
            </form>
        <?php } ?>
    </div>
</body>
</html>
