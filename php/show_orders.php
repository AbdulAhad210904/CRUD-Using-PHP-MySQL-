<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
    <title>Cart</title>
</head>
<body>
    <?php
    // Database connection
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $database = "menu"; 
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user_id from the URL
    $user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;

    if (!$user_id) { ?>
        <p>User ID not specified.</p>
    <?php } else {// Fetch orders for the specific user
        $sql = "SELECT * FROM orders WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) { ?>
            <h1>Orders for User (User ID: <?php echo $user_id; ?>)</h1>
            <ul>
    <?php while ($row = $result->fetch_assoc()) { ?>
                <li>
                    Order ID: <?php echo $row["order_id"]; ?><br>
                    Item: <?php echo $row["item"]; ?><br>
                    Quantity: <?php echo $row["quantity"]; ?><br>
                    Order Date: <?php echo $row["order_date"]; ?><br><br>
                </li>
    <?php } ?>
            </ul>                    
        <button onclick="location.href='/Project/php/create_menu.php?user_id=<?php echo $user_id; ?>'" type="button">Go Back</button>
    <?php } else { ?>
            <p>No orders found for this user.</p>
    <?php }}

    $conn->close();
    ?>
</body>
</html>
