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
    $userId =null;
    if(isset($_POST['seller'])){
        $userId =$_POST['seller'];   
    }if(isset($_POST['sellerAdmin'])){
        $userId =$_POST['sellerAdmin']; 
    }
    // if(isset($_COOKIE['role_admin']) && $_COOKIE['role_admin']==1){
    //     $userId= $_COOKIE["userID_admin"];
    // }elseif(isset($_COOKIE['role_seller']) && $_COOKIE['role_seller']==2){
    //     $userId= $_COOKIE["userID_seller"];
    // }
    if (!isset($_SESSION['bill_number'])) {
      
        $queryBillNo = "SELECT bill_number FROM `bill` ORDER BY bill_number DESC LIMIT 1";
        $billNoResult = $conn->query($queryBillNo);
        
        if ($billNoResult->num_rows > 0) {
            $sold_bill_NO = $billNoResult->fetch_assoc();
            $bill_number = $sold_bill_NO["bill_number"] + 1;
        } else {
            
            $bill_number = 1;
        }

        $createBillNo = "INSERT INTO `bill` (`bill_number`) VALUES ('$bill_number');";
        if (!$conn->query($createBillNo)) {
            echo "Oops! Something went wrong. Unable to create a new bill number.";
        } else {
          
            $_SESSION['bill_number'] = $bill_number;
        }
    } else {
        // Retrieve the bill number from the session variable
        $bill_number = $_SESSION['bill_number'];
    }

   
    $sql = "INSERT INTO `customers_bys_goods` (`currency_id`, `person_id`, `seller_id`, `price`, `quantity`, `buy_date`, `categ_id`, `comp_id`, `count_id`, `unit_amount`, `bill_number`,`unit_id`, `goods_name`)
    VALUES ('$sold_currency_id', '$sold_person_id','$userId', '$sold_buy_price', '$sold_quantity', NOW(), '$sold_cate_id_select', '$sold_company_id', '$sold_country_id', '$sold_unit_quantity', '$bill_number',$sold_unit_id, '$sold_goods_name');";

    if ($conn->query($sql) === TRUE) {
        
        echo '<script>
        alert("Data submitted successfully!");
        </script>';
    } else {
        
        echo '<script>
        alert("Something went wrong: ' . $conn->error . ''.$userId.'");
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
