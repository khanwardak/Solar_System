<?php  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('DBConnection.php');
    echo "data will be submitted";

    $company_id = $_POST['company_id'];
   
    $country_id = $_POST['country_id'];
    $unit_id = $_POST['unit_id'];
    $category_id =$_POST['category_id'];
<<<<<<< Updated upstream
    $quantity = $_POST['sold_quantity'];
=======
    $quantity = $_POST['quantity'];
>>>>>>> Stashed changes
    $unit_quantity =$_POST['unit_quantity'];
    $goods_name = $_POST['goods_name'];
    $person_id = $_POST['person_id'];
    $currency_id = $_POST['currency_id'];
<<<<<<< Updated upstream
    $buy_price = $_POST['product_price'];
    

    $sql = "INSERT INTO `customers_bys_goods` (`currency_id`, `person_id`, `seller_id`, `price`, `quantity`, `buy_date`, `categ_id`, `comp_id`, `count_id`, `unit_amount`, `bill_number`, `goods_name`)
     VALUES ('$currency_id', '$person_id', '1', '$buy_price', '$quantity', NOW(), '$category_id', '$company_id', '$country_id', '$unit_quantity', '1', '$goods_name');";
=======
    $buy_price =$_POST['buy_price'];

    $sql = "INSERT INTO `customers_bys_goods` (`currency_id`, `person_id`, `seller_id`, `price`, `quantity`, `buy_date`, `categ_id`, `comp_id`, `count_id`, `unit_amount`, `bill_number`, `goods_name`)
     VALUES ('$currency_id', '$person_id', '1', '$buy_price', '$quantity', '2023-07-02', '$category_id', '$company_id', '$country_id', '$unit_quantity', '1', '$goods_name');";
>>>>>>> Stashed changes

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
?>
