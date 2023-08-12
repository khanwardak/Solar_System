<?php
if(isset($_POST['selecte']) ){
    include('DBConnection.php');
   $loanCurrency = $_POST['selecte'];
  // $paidAfghanis = $_POST['paidAfghani'];
  $paidAmount =0;
  $paidAfghani =$_POST['paidAfghani'];
  $paidDoller = $_POST['paidDoller'];
   $bill_number = $_POST['bill_number'];
    $Afgloan = $_POST['Afgloan'];
    $dollerLoan = $_POST['dollerLoan'];
   $loan =0;
   if($loanCurrency ==='doller'){
    $paidAmount = $_POST['paidAmount'];
    echo $loan = $dollerLoan;
    try{
        $sqlAddLoanD = "INSERT INTO `loan` (`bill_number`, `total_loan`, `paid_loan`, `total_paid`,`currency`,`date`) 
        VALUES ('$bill_number', '$loan', '$paidAmount', '$paidAmount','$loanCurrency',NOW());";
       if( !$conn ->query($sqlAddLoanD)){
        echo 'somthing went workg';
       }
       }catch(Exception $e){
        echo'dkjfhkjdhfkjdhfkj'. $e;
       }
   }
   else{
    echo 'kjdhfkjhkjfjk';
   }
   if($loanCurrency==='Afghani'){
    $paidAmount = $_POST['paidAmount'];
     echo   $loan = $Afgloan;
     try{
        $sqlAddLoanAFG = "INSERT INTO `loan` (`bill_number`, `total_loan`, `paid_loan`, `total_paid`,`currency`,`date`) 
        VALUES ('$bill_number', '$loan', '$paidAmount', '$paidAmount','$loanCurrency',NOW());";
        $conn ->query($sqlAddLoanAFG);
       }catch(Exception $e){
        echo $e;
       }
   }
  
}
?>
