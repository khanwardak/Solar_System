<?php
// get_user_info.php
if (isset($_POST['user_id'])) {
  $userId = $_POST['user_id'];
  
  // Replace the following with your database query to fetch user info based on the user_id
  require_once('DBConnection.php');
  $sql = "SELECT * FROM user WHERE user_id = $userId";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $userInfo = $result->fetch_assoc();
    echo json_encode($userInfo);
  } else {
    echo json_encode(['error' => 'User not found.']);
  }
}
?>
