<?php
   include('DBConnection.php');
   use Firebase\JWT\JWT;
   use Firebase\JWT\Key;
   require '../vendor/autoload.php'; // Include the JWT library
$error = '';
if (isset($_POST["login"])) {
  $username = mysqli_real_escape_string($conn, $_POST['user_name']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $sql = "SELECT username, user_id, password, user_type FROM user WHERE username = '$username'";
  $result = $conn->query($sql);
  if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $hashedPassword = $row["password"];
      $role = $row["user_type"];
      $userID = $row["user_id"];
      if (password_verify($password, $hashedPassword)) {
        //  JWT tken generated here
          $token_payload = array(
              "username" => $username,
              "user_id" => $userID,
              "user_type" => $role
          );
          $secret_key = "solar-tech-login-seretekeyLoginKey"; 
          $algorithm = 'HS256';
          $token = JWT::encode($token_payload, $secret_key, $algorithm);
          setcookie("access_token", $token, time() + 86400, "/", "", false, true);
          if ($role == 1) {
              setcookie("userID_admin",$userID, time()+86400,"/","", false,true);
              setcookie("role_admin",$role, time()+86400,"/","", false,true);
              header("Location: admin.php");
              exit();
          } elseif ($role == 2) {
              setcookie("userID_seller",$userID, time()+86400,"/","", false,true);
              setcookie("role_seller",$role, time()+86400,"/","", false,true);
              header("Location: second_goods.php");
              exit();
          } 
      } 
  } else {
      $error = '<div class="alert alert-danger" role="alert" id="alert-danger">
        Invalid Username or Password!
    </div>';
  }
}
  
?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

	</head>
	<body class="img js-fullheight" style="background-image: url(images/login-bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">سولر تیک</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">د لاندې مالوما پربنسټ دخل شی</h3>
		      	<form method="post">
				  <?php echo $error; ?>
		      		<div class="form-group">
		      			<input type="text" class="form-control" placeholder="Username" name="user_name" required style=" text-align: center; ">
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" class="form-control" placeholder="Password" name="password" required style=" text-align: center; ">
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3" name="login">داخل شی</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">ما په یاد ولره
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">پاسورډ مو هیر شوی؟</a>
								</div>
	            </div>
	          </form>
	          <p class="w-100 text-center">&mdash; یا هم داخل شی! &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
	          	<a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>
