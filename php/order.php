<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "menu"; 
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$order_placed = false;
$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : null; // Retrieve user_id from the URL

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["item"]) &&
    isset($_POST["quantity"]) &&
    isset($user_id)
) {
    $item = $_POST["item"];
    $quantity = $_POST["quantity"];

    $sql = "INSERT INTO orders (user_id, item, quantity) VALUES ($user_id, '$item', $quantity)";

    if ($conn->query($sql) === true) {
        $order_placed = true;
    } else {
        echo "Error placing the order: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Place Order</title>
</head>
<body>
<title>Order Food</title>  

  <h1>Place Your Order</h1>

  <?php if ($order_placed) { ?>
    <p>Order placed successfully.</p>
    <button onclick="location.href='/Project/php/show_orders.php?user_id=<?php echo $user_id; ?>'" type="button">View Cart</button>
  <?php } else { ?>
    <form method="post">
      <label for="item">Select Item:</label>
      <select id="item" name="item" required>
        <option value="" disabled selected>Select an item</option>
        <?php
        $sql = "SELECT * FROM menu_items";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' .
                    $row["Name"] .
                    '">' .
                    $row["Name"] .
                    "</option>";
            }
        } else {
            echo '<option value="" disabled>No menu items available</option>';
        }
        ?>
      </select>
      
      <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
      
      <label for="quantity">Quantity:</label>
      <input type="number" id="quantity" name="quantity" required>
      
      <button type="submit">Submit Order</button>
    </form>
  <?php } ?>

</body>
</html>
