<!DOCTYPE html>
<html>
<head>
    <title>Add Seller</title>
    <link rel="stylesheet" type="text/css" href="assets/css/cssforseller.css?verssion=2">
</head>
<body>
    <?php
    // Establish database connection
    

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="solartech_solar_solution";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $seller_name = $_POST['seller_name'];
        $seller_fname = $_POST['seller_fname'];
        $seller_user_name = $_POST['seller_user_name'];
        $seller_password = $_POST['seller_password'];
        $seller_email = $_POST['seller_email'];
        $seller_image = $_POST['seller_image'];
        $seller_address = 2;

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("INSERT INTO seller (seller_name, seller_fname, seller_user_name, seller_password, seller_email, seller_image, seller_address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $seller_name, $seller_fname, $seller_user_name, $seller_password, $seller_email, $seller_image, $seller_address);

        if ($stmt->execute()) {
            echo "Seller added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
    ?>

    <h2>Add Seller</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="seller_name">Seller Name:</label>
        <input type="text" name="seller_name" required><br><br>

        <label for="seller_fname">Seller First Name:</label>
        <input type="text" name="seller_fname" required><br><br>

        <label for="seller_user_name">Seller User Name:</label>
        <input type="text" name="seller_user_name" required><br><br>

        <label for="seller_password">Seller Password:</label>
        <input type="password" name="seller_password" required><br><br>

        <label for="seller_email">Seller Email:</label>
        <input type="email" name="seller_email" required><br><br>

        <label for="seller_image">Seller Image:</label>
        <input type="text" name="seller_image" required><br><br>

        <label for="seller_address">Seller Address:</label>
        <input type="number" name="seller_address" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
