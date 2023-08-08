<?php
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])){
  include('DBConnection.php');
  if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
        $uniqueFileName = time() . uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetDir = 'uploads/';
        $targetFilePath = $targetDir . $uniqueFileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            echo "Image successfully uploaded with unique name: " . $uniqueFileName;
        } else {
            echo "Failed to upload the image.";
        }
  
} else {
    echo "Image file not found in the form data.";
}
  $postId = $_POST['post_id'];
  $postTitle = $_POST['post_titlet'];
  $postText = $_POST['post_text'];
  $sqlUpdatePost ="UPDATE `post` SET `post_title` = '$postTitle', `post_text` = '$postText', `user_id` = '35', `post_img` = '  $targetFilePath', `isDelete` = '0' WHERE `post`.`post_id` = '$postId'; ";
  if(!$conn->query($sqlUpdatePost)){
    echo 'somethigs wrong';
  }
  
  
 }
?>

<?php
 if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_id'])){
      include('DBConnection.php');
      if (isset($_FILES['service_imaged'])) {
        $file = $_FILES['service_imaged'];
        $uniqueFileName = time() . uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetDir = 'uploads/';
        $targetFilePath = $targetDir . $uniqueFileName;
    
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
          echo "Image successfully uploaded with unique name: " . $uniqueFileName;
        } else {
          echo "Failed to upload the image.";
        }
      } else {
        echo "Image file not found in the form data.";
      }
       $service_title = $_POST['service_titled'];
       $service_text = $_POST['service_textd'];
       $service_id = $_POST['service_id'];

       $sqlUpdateService = "UPDATE `service` SET `service_title` = '$service_title', `service_text` = '$service_text', `isDelete` = '0', `service_img` = '$targetFilePath'
                            WHERE `service`.`service_id` = '$service_id';";
      if(!$conn->query($sqlUpdateService )){
        echo "somethings wrong";
      }
  
 }
?>
<!-- Update Team members start -->
<?php
if(isset($_POST['member_id'])){
  include('DBConnection.php');
  if (isset($_FILES['team_mermber_img'])) {
    $file = $_FILES['team_mermber_img'];
    $uniqueFileName = time() . uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $targetDir = 'uploads/';
    $targetFilePath = $targetDir . $uniqueFileName;

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
      echo "Image successfully uploaded with unique name: " . $uniqueFileName;
    } else {
      echo "Failed to upload the image.";
    }
  } else {
    echo "Image file not found in the form data.";
  }
  $member_id = $_POST['member_id'];
  $full_name = $_POST['fullName'];
  $fa_acc = $_POST['fa_acc'];
  $mob= $_POST['mob'];
  $member_skills = $_POST['team_member_skills'];
  
  try{
    $sqlUpadateTeamMembers = "UPDATE `team_members` SET `team_member_fullName` = '$full_name',
     `team_member_fa_acc` = '$fa_acc',
      `team_member_mob` = '$mob', 
      `team_member_skills` = ' $member_skills ', 
      `isDelete` = '0', 
      `team_member_create_date` = '2023-08-16 00:00:00',
      `team_member_img` = '$targetFilePath'
     WHERE `team_members`.`team_member_id` ='$member_id';";

    if(!$conn->query($sqlUpadateTeamMembers )){
      echo 'can not update team members';
    }
  }catch(Exception $e){
    echo $e;
  }


}
?>
<!-- update team member end -->

<!-- update pages Headers  -->
<?php 
if(isset($_POST['page_header_id'])){
  try{
    include('DBConnection.php');
    
    $header_title = $_POST['header_title'];
    $header_text = $_POST['header_text'];
    $page = $_POST['page'];
    $page_header_id = $_POST['page_header_id'];
    if (isset($_FILES['header_img'])) {
      $file = $_FILES['header_img'];
      $uniqueFileName = time() . uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
      $targetDir = 'uploads/';
      $targetFilePath = $targetDir . $uniqueFileName;
  
      if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        echo "Image successfully uploaded with unique name kdfhjkdh: " . $uniqueFileName;
      } else {
        echo "Failed to upload the image.";
      }
    } else {
      echo "Image file not found in the form data.";
    }
    $sqlUpdatePagesHeader ="UPDATE `pagesheader` SET `page_header_title` = '$header_title', `page_header_text` = '$header_text', `page_header_img` = '$targetFilePath', `page_name` = '$page', `user_id` = '8', `page_header_create_data` = '2023-08-24 00:00:00', `isDelete` = '0' WHERE `pagesheader`.`page_header_id` = '$page_header_id';";
    if(!$conn->query($sqlUpdatePagesHeader)){
      echo 'Can not update page header'.$page_header_id;
    }
  }catch(Exception $e){
    echo $e;
  }

}
?>
<!-- update pages Header end -->