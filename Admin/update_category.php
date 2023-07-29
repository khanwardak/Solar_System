<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Assuming you have included DBConnection.php here
  require_once('DBConnection.php');

  // Get the category ID and new category name from the POST data
  $category_id = $_POST['category_id'];
  $new_category_name = $_POST['new_category_name'];

  try {
    // Update the category in the database
    $sql = "UPDATE `category` SET `categ_name` = '$new_category_name' WHERE `categ_id` = '$category_id';";
    $conn->query($sql);

    // Prepare the response data (if needed)
    $response = array(
      'category_id' => $category_id,
      'new_category_name' => $new_category_name,
      'message' => 'Category updated successfully.'
    );

    // Send the response back as JSON (optional)
    header('Content-Type: application/json');
    echo json_encode($response);
  } catch (Exception $e) {
    // Handle the exception here and send back an error response (if needed)
    $response = array(
      'error' => 'Failed to update category: ' . $e->getMessage()
    );

    // Send the error response back as JSON (optional)
    header('Content-Type: application/json');
    echo json_encode($response);
  }
} else {
  // Handle other HTTP methods (if needed)
  header('HTTP/1.1 405 Method Not Allowed');
  header('Allow: POST');
  echo '405 Method Not Allowed';
}
?>
