<!-- create post start here -->
<?php 
include('DBConnection.php');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $post_title = $_POST["post_titlet"];
    $post_text = $_POST["post_text"];
    $uniquesavename = time() . uniqid(rand());
    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $uniquesavename . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
  
    if (in_array($fileType, $allowTypes)) {
      // Upload file to server
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
      } else {
        $statusMsg = "Sorry, there was an error uploading your file.";
      }
  
    }
   
    $sqlCreatPost ="INSERT INTO `post` (`post_id`, `post_title`, `post_text`, `user_id`, `post_img`) VALUES (NULL, '$post_title ', '$post_text', '120', '$targetFilePath');";
    if(!$conn->query($sqlCreatPost)){
        echo 'Some thisng wrong';
    }
    else{

    }
}
?>
<!-- <create post end here -->