<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['categoryId'])){
    $cate_id = $_GET['categoryId'];
    $deleteCateGoryById ="UPDATE `category` SET `status` = '1' WHERE `category`.`categ_id` ='$cate_id';";
    if(!$conn->query($deleteCateGoryById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the category: ' . $e->getMessage();
}
?>
<!-- deleteCompany start -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['companyId'])){
    $companyId = $_GET['companyId'];
    $deleteCompanyById ="UPDATE `company` SET `status` = '1' WHERE `company`.`comp_id` ='$companyId';";
    if(!$conn->query($deleteCompanyById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the category: ' . $e->getMessage();
}
?>
<!-- deleteCompany end -->

<!-- delete countery start -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['companyId'])){
    $companyId = $_GET['companyId'];
    $deleteCompanyById ="UPDATE `company` SET `status` = '1' WHERE `company`.`comp_id` ='$companyId';";
    if(!$conn->query($deleteCompanyById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the company: ' . $e->getMessage();
}
?>
<!-- delete countery start -->

<!-- delete countery start  -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['countId'])){
    $count_id = $_GET['countId'];
    $deleteCounteryById ="UPDATE `country` SET `status` = '1' WHERE `country`.`count_id` ='$count_id';";
    if(!$conn->query($deleteCounteryById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the countery: ' . $e->getMessage();
}
?>
<!-- delete countery end -->

<!-- delete currency start -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['currency_id'])){
    $currency_id = $_GET['currency_id'];
    $deleteCurrencyById ="UPDATE `currency` SET `status` = '1' WHERE `currency`.`currency_id` = '$currency_id';";
    if(!$conn->query($deleteCurrencyById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the currency: ' . $e->getMessage();
}
?>
<!-- delete currency end -->

<!-- delete unit start -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['unit_id'])){
    $unit_id = $_GET['unit_id'];
    $deleteunit_idById ="UPDATE `unit` SET `status` = '1' WHERE `unit`.`unit_id` = '$unit_id';";
    if(!$conn->query($deleteunit_idById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the countery: ' . $e->getMessage();
}
?>
<!-- delete unit end -->

<!-- delete our loan start -->

<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['ourloan_id'])){
    $ourloan_id = $_GET['ourloan_id'];
    $deleteOurLoandById ="UPDATE `ourloan` SET `status` = '1' WHERE `ourloan`.`ourloan_id` = '$ourloan_id';";
    if(!$conn->query($deleteOurLoandById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the countery: ' . $e->getMessage();
}
?>
<!-- delete our loan end -->

<!-- delete user start -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_POST['user_id'])){
    $user_id = $_POST['user_id'];
    $deleteUserById ="DELETE FROM user WHERE user_id='$user_id'";
    if(!$conn->query($deleteUserById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the countery: ' . $e->getMessage();
}
?>
<!-- delete user end -->

<!-- delete firm start  -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['firm_id'])){
    $firm_id = $_GET['firm_id'];
    $deleteFirmById ="UPDATE `firm` SET `status` = '1' WHERE `firm`.`firm_id` ='$firm_id';";
    if(!$conn->query($deleteFirmById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the countery: ' . $e->getMessage();
}
?>
<!-- delete firm end -->

<!-- delete post start  -->
<?php
try {
  require_once('DBConnection.php');
if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $deletePostById ="UPDATE `post` SET `isDelete` = '1' WHERE `post`.`post_id` = '$post_id';";
    if(!$conn->query($deletePostById)){
       echo 'په بښنې سره نه شو کولای حذب کړو';
    }
    else{
        echo 'په بریالی توګه سره حذب شو';
    }
}
 
} catch (Exception $e) {
  echo 'Error deleting the countery: ' . $e->getMessage();
}
?>
<!-- delete post end -->

<!-- delete service start -->
<?php
if(isset($_GET['service_id'])){
  $service_di =$_GET['service_id'];
  try{
    include('DBConnection/php');
    $sqlDeleteService = "UPDATE `service` SET `isDelete` = '1' WHERE `service`.`service_id` ='$service_di';";
    if(!$conn->query($sqlDeleteService)){
      echo "Opps Some things went wrong";
    }
  }catch(Exception $e){
    echo "can not delete".$e;
  }
}
?>
<!-- delete service end -->

<!-- delete members start -->
<?php 
if(isset($_GET['member_id'])){
  try{
    include('DBConnection.php');
    $member_id = $_GET['member_id'];
    $sqlDeleteMember ="UPDATE `team_members` SET `isDelete` = '1' 
    WHERE `team_members`.`team_member_id` = '$member_id';";
    if(!$conn->query($sqlDeleteMember)){
      echo 'Can not delete the members';
    }
   
  }catch(Exception $e){
    echo $e;
  }
}
?>
<!-- delete members end -->

<!-- delete header start  -->
<?php
  if(isset($_GET['page_header_id'])){
    $page_header_id = $_GET['page_header_id'];
    include('DBConnection.php');
    try{
      $sqlDeletePageHeader = "UPDATE `pagesheader` SET `isDelete` = '1' WHERE `pagesheader`.`page_header_id` = '$page_header_id'; ";
      if(!$conn->query($sqlDeletePageHeader)){
        echo 'can not upadate page headers';
      }
    }catch(Exception $e){
      echo $e;
    }

  }
?>
<!-- delete header end -->