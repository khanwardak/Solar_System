<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_titled'])) {
    include('DBConnection.php');

    $service_title = $_POST['service_titled'];
    $service_text = $_POST['service_textd'];

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

    try {
        $sqlCreateService = "INSERT INTO `service` (`service_id`, `service_title`, `service_text`, `isDelete`, `service_img`, `user_id`)
                             VALUES (NULL, '$service_title', '$service_text', '0', '$targetFilePath', '7');";
        if (!$conn->query($sqlCreateService)) {
            echo "Error creating service: " . $conn->error;
        }
    } catch (Exception $e) {
        echo 'Can not create service: ' . $e;
    }
} else {
    //echo "Oops, something's wrong.";
}
?>
<?php

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//   include('DBConnection.php');

//   $service_title = $_POST['service_titled'];
//   $service_text = $_POST['service_textd'];

//   if (isset($_FILES['service_imaged'])) {
//     $file = $_FILES['service_imaged'];
//     $uniqueFileName = time() . uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
//     $targetDir = 'uploads/';
//     $targetFilePath = $targetDir . $uniqueFileName;

//     if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
//       echo "Image successfully uploaded with unique name: " . $uniqueFileName;
//     } else {
//       echo "Failed to upload the image.";
//     }
//   } else {
//     echo "Image file not found in the form data.";
//   }

//   try {
//     $sqlCreateService = "INSERT INTO `service` (`service_id`, `service_title`, `service_text`, `isDelete`, `service_img`, `user_id`)
//                          VALUES (NULL, '$service_title', '$service_text', '0', '$targetFilePath', '7');";
//     if (!$conn->query($sqlCreateService)) {
//       echo "Error creating service: " . $conn->error;
//     }
//   } catch (Exception $e) {
//     echo 'Can not create service: ' . $e;
//   }

// } else {
//   echo "opps somethings woring";
// }



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    include('DBConnection.php');
    $post_title =$_POST['post_titlet'];
    $post_text = $_POST['post_text'];
  

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
    $sqlAddPosts = "INSERT INTO `post` (`post_id`, `post_title`, `post_text`, `user_id`, `post_img`, `isDelete`)
     VALUES (NULL, '$post_title', '$post_text', '12', '$targetFilePath', '0');";
     try{
        if(!$conn->query($sqlAddPosts)){
            echo 'Can not Create Post Please Try agin';
        }
     }catch(Exception $e){
        echo 'some thing went wrong'.$e;
     }
}
?>
<!-- add team members -->
<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fullName'])) {
    include('DBConnection.php');
    $full_name = $_POST['fullName'];
    $team_members_skills = $_POST['team_member_skills'];
    $fa_acc = $_POST['fa_acc'];
    $mob = $_POST['mob'];
    if (isset($_FILES['team_mermber_img'])) {
        $file = $_FILES['team_mermber_img'];
        $uniqueFileName = time() . uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetDir = 'uploads/';
        $targetFilePath = $targetDir . $uniqueFileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            //echo "Image successfully uploaded with unique name: " . $uniqueFileName;
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        echo "Image file not found in the form data.";
    }
    try{
      $sqlAddTeamMember = "INSERT INTO `team_members` (`team_member_id`, `team_member_fullName`, `team_member_fa_acc`, `team_member_mob`, `team_member_skills`, `isDelete`, `team_member_create_date`, `user_id`, `team_member_img`) 
                           VALUES (NULL, '$full_name', '$fa_acc', '$mob', '$team_members_skills', '0', 'NOW()', '7', '$targetFilePath');";
      if(!$conn->query($sqlAddTeamMember)){
        echo 'can not add team member';
      }
      else{
       echo 'د ټیم غړی اضافه شو';
      }
    }catch(Exception $e){
        echo $e;
    }
}
else{
    echo 'opps! some thing went wrong';
}
?>
<!-- add team members end -->
<!-- add pages header start -->
<?php 
if(isset($_POST['page_header_id'])){
    include('DBConnection.php');
    $header_title = $_POST['header_title'];
    $header_text = $_POST['header_text'];
    $page = $_POST['page'];
    if (isset($_FILES['header_img'])) {
        $file = $_FILES['header_img'];
        $uniqueFileName = time() . uniqid(rand(), true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetDir = 'uploads/';
        $targetFilePath = $targetDir . $uniqueFileName;

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            //echo "Image successfully uploaded with unique name: " . $uniqueFileName;
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        echo "Image file not found in the form data.";
    }
    try{
        $sqlAddPageHeader ="INSERT INTO `pagesheader` (`page_header_id`, `page_header_title`, `page_header_text`, `page_header_img`, `page_name`, `user_id`, `page_header_create_data`, `isDelete`) 
        VALUES (NULL,
         '$header_title',
         '$header_text',
         '$targetFilePath',
         '$page',
         '7',
         '2023-08-30 00:00:00',
         '0');";
        if(!$conn->query($sqlAddPageHeader)){
            echo 'Can not add page header';
        }
    }catch(Exception $e){
        echo $e;
    }
}
?>
<!-- add pages header end -->
