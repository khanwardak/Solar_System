<?php
session_start();
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require '../vendor/autoload.php'; 
include('DBConnection.php');
include('jdf.php');
define("DATE", jdate('l / j / p / y / i : g a'));
if (!isset($_COOKIE['access_token']) || empty($_COOKIE['access_token'] || $_COOKIE['role_admin']!=1)) {
    header("Location: login.php");
    exit();
}

elseif(!isset($_COOKIE['role_admin']) || $_COOKIE['role_admin']!=1){
  header("Location: login.php");
  exit();
}
$secret_key = "solar-tech-login-seretekeyLoginKey";
$token = $_COOKIE['access_token'];

try {
    $decoded_token = JWT::decode($token,new Key($secret_key,'HS256'));
} catch (Exception $e) {
    
    header("Location: login.php");
    echo $e;
    exit();
}
?>

<?php

function addproduct()
{
  include('DBConnection.php');
  $goods_name = $_POST['goods_name'];
  $goods_discription = $_POST['goods_discription'];
  $category_id = $_POST['categoryt_id'];
  $company_id = $_POST['company_id'];
  $country_id = $_POST['country_id'];
  $unit_id = $_POST['unit_id'];
  $currency_id = $_POST['currency_id'];
  $company_id = $_POST['company_id'];
  $firm = $_POST['firm'];
  $quantity = $_POST['quantity'];
  $buy_price = $_POST['buy_price'];
  $unit_quantity = $_POST['unit_quantity'];
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
  $sqll = "SET FOREIGN_KEY_CHECKS = 0;";
  $conn->query($sqll);
  $sql2 = "INSERT INTO `goods` (`goods_name`, `goods_description`, `categ_id`, `comp_id`, `count_id`, `unit_id`, `entry_date`, `image`, `currency_id`, `firm_id`, `goods_qunatity`, `goods_price`, `unit_amount`) 
  VALUES ('$goods_name', '$goods_discription', '$category_id', ' $company_id', '$country_id', '$unit_id', NOW(), '$targetFilePath', '$currency_id', '$firm', '$quantity', '$buy_price', '$unit_quantity');";
  if ($conn->query($sql2)) {
    echo ' <script LANGUAGE="JavaScript">
                 swal("په بریالی توګه !", "د محصول معلومات اضافه شول!", "success");
                    setTimeout(function() {
                    window.location.href = "goods.php";
                    }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
  } else {
    echo ' ("<script LANGUAGE="JavaScript">
                 window.alert("Opps!");
                 window.location.href="admin.php";
               </script>");';
  }

}

?>
<!DOCTYPE html>
<html>

<head>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
    crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="admin.css?verssion=9">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="../style.css?verssion=4" rel="stylesheet">
  <script src="pdfmake/build/pdfmake.min.js"></script>
  <script src="pdfmake/build/vfs_fonts.js"></script>
  <script src="jsPDF/dist/jspdf.es.min.js"></script>
  <script src="jsPDF/dist/jspdf.umd.min.js"></script>
  <script src="jsPDF/src/jspdf.js"></script>
  <script src="jsPDF/jsPDFAutoTable/dist/jspdf.plugin.autotable.js"></script>
  <script src="jsPDF/html2canvas/html2canvas.js"></script>
  <script src="jsPDF/html2canvas/html2canvas.min.js"></script>
</head>

<body>
<header class="py-3 mb-4 border-bottom shadow" style="background-color:#122834">
    <div class="container-fluid align-items-center d-flex">

      <div class="col-lg-4 d-flex justify-content-start ">

        <a href="" class="text-decoration-none">
          <span class="h1 text-uppercase text-warning bg-dark px-2">SOLAR</span>
          <span class="h1 text-uppercase text-dark bg-warning px-2 ml-n1">TECH</span>
        </a>
      </div>
      <div class="col-lg-4 d-flex justify-content-start ">
        <b style="color:#fff"><?php echo DATE; ?></b>
      </div>
      <div class="flex-grow-1 d-flex align-items-center">
        <form class="w-100 me-3">
          <!-- <input type="search" class="form-control" placeholder="Search..."> -->
        </form>
        <div class="flex-shrink-0 dropdown">
          <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser2"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://via.placeholder.com/28?text=!" alt="user" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser2" style="">

            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <div class="container-fluid ">

    <div class="row ">

      <main class="col-lg-9 col-md-8 col-sm-3 overflow-auto h-100">

       
      </main>
      <aside class="col-sm-3 flex-grow-sm-1 flex-shrink-1 flex-grow-0 sticky-top pb-sm-0 pb-3"
        style="text-align:right; z-index: 1;">
        <div class="bg-light border rounded-3 p-1 h-100 sticky-top">
          <ul class="nav nav-pills flex-sm-column flex-row mb-auto justify-content-between text-truncate"
            style="background-color:#07264a;">
            <li>
              <a href="admin.php" class="nav-link px-2" style="color:#fff">
                <span class="d-none d-sm-inline">Dashboard</span>
                <i class="bi bi-speedometer fs-5"></i>
              </a>
            </li>
          </ul>
          <!-- category search Start -->
          <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">د کټکوری پر
              اساس پلټڼه</span></h5>
          <div class="bg-light p-4 mb-30">
            <form>
              <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                <input type="checkbox" class="custom-control-input" checked id="size-all">
                <label class="custom-control-label" for="size-all">ټول محصولات</label>
                <span class="badge border font-weight-normal" style="color:black;">1000</span>
              </div>
              <?php
              try {
                include('DBConnection.php');
                $sql = "SELECT SUM(goods.goods_qunatity) as quantity, category.categ_name FROM goods,category WHERE goods.categ_id = category.categ_id GROUP bY category.categ_name";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="size-1">
                        <label class="custom-control-label" for="size-1">' . $row["categ_name"] . '</label>
                        <span class="badge border font-weight-normal" style="color:black;">' . $row["quantity"] . '</span>
                      </div>
                        ';
                  }
                } else {
                  echo "No data found";
                }
              } catch (Exception $e) {
                echo $e . "some things wrong search by category";
              }

              ?>

            </form>
          </div>
          <!-- category  end-->
        </div>
      </aside>

    </div>
  </div>
  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Contact Javascript File -->
  <script src="mail/jqBootstrapValidation.min.js"></script>
  <script src="mail/contact.js"></script>

  <!-- Template Javascript -->
  <script src="js/main.js"></script>
 


</body>

</html>