<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<title>Menu</title>  
    <div class="menu-container" style="text-align:center;">
        <div class="menu-items">
        <img style="display: block;margin-top:-2rem !important;
margin: 0 auto;" src="images/menu.png" alt="food" width="285px" height="400px">
            <?php
            $user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null;
            $servername = "127.0.0.1";
            $username = "root";
            $password = "";
            $database = "menu";
            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetching menu items from the database
            $sql = "SELECT * FROM menu_items";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="menu-item" style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); padding: 20px; margin: 0 auto; width:20rem; margin-top:2rem;">';
                    echo "<h3>" . $row["Name"] . "</h3>";
                    echo '<div><img style="display: block;margin-top:-2rem !important; margin: 0 auto;" src="images/' .
                        $row["Name"] .
                        '.png" alt="food" width="160rem" height="150rem"></div>';
                    echo "<p>" . $row["Description"] . "</p>";
                    echo '<p>Price: $' .
                        number_format($row["Price"], 2) .
                        "</p>";
                    echo "</div>";
                }
            } else {
                echo "No menu items available.";
            }

            $conn->close();
            ?><br><br>
            <button onclick="location.href='/Project/php/order.php?user_id=<?php echo $user_id; ?>'" type="button">Place Order</button>
            <button onclick="location.href='/Project/php/show_orders.php?user_id=<?php echo $user_id; ?>'" type="button">View Cart</button>
        </div>
    </div>
</body>
</html>

