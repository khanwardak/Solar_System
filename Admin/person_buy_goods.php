<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('DBConnection.php');
    echo "data will be submitted";
    $sold_company_id = $_POST['sold_company_id'];
    $sold_country_id = $_POST['sold_country_id'];
    $sold_unit_id = $_POST['sold_unit_id'];
    $sold_cate_id_select = $_POST['sold_category_id'];
    $sold_quantity = $_POST['sold_quantity'];
    // $quantity = $_POST['quantity'];
    $sold_unit_quantity = $_POST['sold_unit_quantity'];
    $sold_goods_name = $_POST['sold_goods_name'];
    $sold_person_id = $_POST['sold_person_id'];
    $sold_currency_id = $_POST['sold_currency_id'];
    $sold_buy_price = $_POST['sold_price'];

    // Check if the bill number has been inserted already
    if (!isset($_SESSION['bill_number'])) {
        // Get the last bill number from the "bill" table
        $queryBillNo = "SELECT bill_number FROM `bill` ORDER BY bill_number DESC LIMIT 1";
        $billNoResult = $conn->query($queryBillNo);
        
        if ($billNoResult->num_rows > 0) {
            $sold_bill_NO = $billNoResult->fetch_assoc();
            $bill_number = $sold_bill_NO["bill_number"] + 1;
        } else {
            // If no existing bill numbers found, start the sequence from 1.
            $bill_number = 1;
        }

        // Create new bill number and insert it into the "bill" table
        $createBillNo = "INSERT INTO `bill` (`bill_number`) VALUES ('$bill_number');";
        if (!$conn->query($createBillNo)) {
            echo "Oops! Something went wrong. Unable to create a new bill number.";
        } else {
            // Set the flag to indicate that the bill number has been inserted
            $_SESSION['bill_number'] = $bill_number;
        }
    } else {
        // Retrieve the bill number from the session variable
        $bill_number = $_SESSION['bill_number'];
    }

    // Rest of the code for inserting data into the "customers_bys_goods" table
    $sql = "INSERT INTO `customers_bys_goods` (`currency_id`, `person_id`, `seller_id`, `price`, `quantity`, `buy_date`, `categ_id`, `comp_id`, `count_id`, `unit_amount`, `bill_number`, `goods_name`)
    VALUES ('$sold_currency_id', '$sold_person_id', '1', '$sold_buy_price', '$sold_quantity', NOW(), '$sold_cate_id_select', '$sold_company_id', '$sold_country_id', '$sold_unit_quantity', '$bill_number', '$sold_goods_name');";

    if ($conn->query($sql) === TRUE) {
        // Query was successful, display a success message
        echo '<script>
        alert("Data submitted successfully!");
        </script>';
    } else {
        // Error occurred while executing the query
        echo '<script>
        alert("Something went wrong: ' . $conn->error . '");
        </script>';
    }
}

if (isset($_GET['session'])) {
    // Clear the bill number from the session to start fresh for the next insert
    unset($_SESSION['bill_number']);
    // session_unset();
    // session_destroy();
    //echo  $_SESSION['bill_number'];
    ob_clean();
    header('Location:goods.php');
    exit;
} 
?>
