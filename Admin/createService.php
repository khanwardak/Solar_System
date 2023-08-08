<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
  echo "opps somethings woring";
}




?>