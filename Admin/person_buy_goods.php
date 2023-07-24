<?php 
session_start(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('DBConnection.php');
    echo "data will be submitted";
    $sold_company_id = $_POST['sold_company_id'];
    $sold_country_id = $_POST['sold_country_id'];
    $sold_unit_id = $_POST['sold_unit_id'];
    $sold_cate_id_select =$_POST['sold_category_id'];
    $sold_quantity = $_POST['sold_quantity'];
    // $quantity = $_POST['quantity'];
    $sold_unit_quantity =$_POST['sold_unit_quantity'];
    $sold_goods_name = $_POST['sold_goods_name'];
    $sold_person_id = $_POST['sold_person_id'];
    $sold_currency_id = $_POST['sold_currency_id'];
    $sold_buy_price = $_POST['sold_price'];
    // $sold_bill_NO ="";
    $queryBillNo ="SELECT bill_number FROM `bill` ORDER by bill_number DESC LIMIT 1";
    $billNoResult = $conn->query($queryBillNo);
    if($billNoResult ->num_rows>0){
        while($sold_bill_NO = $billNoResult->fetch_assoc()){
       echo $bill_number =$sold_bill_NO ["bill_number"]+1;
        }
      $_SESSION['bill_number'] = $bill_number ;
    }

    $sql = "INSERT INTO `customers_bys_goods` (`currency_id`, `person_id`, `seller_id`, `price`, `quantity`, `buy_date`, `categ_id`, `comp_id`, `count_id`, `unit_amount`, `bill_number`, `goods_name`)
     VALUES ('$sold_currency_id', '$sold_person_id', '1', '$sold_buy_price', '$sold_quantity', NOW(), '$sold_cate_id_select', '$sold_company_id', '$sold_country_id', '$sold_unit_quantity', '1', '$sold_goods_name');";


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
