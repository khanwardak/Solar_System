<?php
session_start();
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require '../vendor/autoload.php';
include('DBConnection.php');
include('jdf.php');
define("DATE", jdate('l / j / p / y / i : g a'));
if (!isset($_COOKIE['access_token']) || empty($_COOKIE['access_token'] || $_COOKIE['role_admin'] != 1)) {
  header("Location: login.php");
  exit();
} elseif (!isset($_COOKIE['role_admin']) || $_COOKIE['role_admin'] != 1) {
  header("Location: login.php");
  exit();
}
$secret_key = "solar-tech-login-seretekeyLoginKey";
$token = $_COOKIE['access_token'];

try {
  $decoded_token = JWT::decode($token, new Key($secret_key, 'HS256'));
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <b style="color:#fff">
          <?php echo DATE; ?>
        </b>
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

        <div class="bg-light border rounded-3 p-3">


          <div class="col d-flex justify-content-end">

            <div class="btn-group  d-flex justify-content-center">
              <button type="button" class="bi- btn btn-sm  dropdown-toggle" data-toggle="dropdown">ښکاره کول</button>
              <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#BillModal"
                style="text-align:right;">بېل چکول</button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">10</a>
                <a class="dropdown-item" href="#">20</a>
                <a class="dropdown-item" href="#">30</a>
              </div>
              <div class="sellButton">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sold"
                  style="text-align:right;">خرڅول</button>
              </div>
              <div class="sellButton">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#goodsViewModal"
                  style="text-align:right;">د جنس تغیرول</button>
              </div>
            </div>
            <div class="btn-group  d-flex justify-content-center">
              <button type="button" class="btn btn-sm  dropdown-toggle" data-toggle="dropdown">ترتیبول</button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">وروستی محصولات</a>
                <a class="dropdown-item" href="#">نوی محصولات </a>
                <a class="dropdown-item" href="#">تحفیف شوی محصولات</a>
              </div>
            </div>
            <a class=" d-flex justify-content-end text-decoration-none" data-bs-toggle="modal"
              data-bs-target="#productffff" style="text-align:right; color: blue;">
              Add new product <i class="bi-plus"></i>
            </a>

          </div>
          <div class="card table-responsive">
            <div class="text-center mt-4 mb-3">
              <h2>Total Product</h2>
            </div>
            <table id="sells" class="table mt-2 table-ligh table table-hover  " style="direction:rtl">
              <thead class="overflow-auto h-100">
                <tr class="">
                  <th>ګټګوری</th>
                  <th>کمپنی</th>
                  <th> هیواد</th>
                  <th>اندازه</th>
                  <th>یونېټ</th>
                  <th>مقدار</th>
                </tr>
              </thead>
              <tbody>
                <?php
                require_once('DBConnection.php');
                $sql = "
                SELECT 
    categ_name,
    comp_name,
    count_name,
    unit_name,
    unit_amount,
    SUM(quantity) - SUM(customer_quantity) AS total_left
FROM
    (
    SELECT 
        category.categ_name,
        company.comp_name,
        country.count_name,
        unit.unit_name,
        goods.unit_amount,
        IFNULL(SUM(goods.goods_qunatity), 0) AS quantity,
        0 AS customer_quantity
    FROM 
        goods
    LEFT JOIN 
        category ON category.categ_id = goods.categ_id
    LEFT JOIN 
        unit ON goods.unit_id = unit.unit_id
    LEFT JOIN 
        currency ON goods.currency_id = currency.currency_id
    LEFT JOIN 
        company ON goods.comp_id = company.comp_id
    LEFT JOIN 
        country ON goods.count_id = country.count_id
    GROUP BY 
        category.categ_name,
        company.comp_name,
        country.count_name,
        unit.unit_name,
        goods.unit_amount

    UNION ALL

    SELECT 
        category.categ_name,
        company.comp_name,
        country.count_name,
        unit.unit_name,
        customers_bys_goods.unit_amount,
        0 AS quantity,
        IFNULL(SUM(customers_bys_goods.quantity), 0) AS customer_quantity
    FROM 
        customers_bys_goods
    LEFT JOIN 
        category ON category.categ_id = customers_bys_goods.categ_id
    LEFT JOIN 
        unit ON customers_bys_goods.unit_id = unit.unit_id
    LEFT JOIN 
        currency ON customers_bys_goods.currency_id = currency.currency_id
    LEFT JOIN 
        company ON customers_bys_goods.comp_id = company.comp_id
    LEFT JOIN 
        country ON customers_bys_goods.count_id = country.count_id
    GROUP BY 
        category.categ_name,
        company.comp_name,
        country.count_name,
        unit.unit_name,
        customers_bys_goods.unit_amount
    ) AS combined_data
GROUP BY
    categ_name,
    comp_name,
    count_name,
    unit_name,
    unit_amount;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {

                  while ($row = $result->fetch_assoc()) {


                    echo '<tr>
                                        
                                          
                                          <td>' . $row["categ_name"] . '</td>
                                          <td>' . $row["comp_name"] . '</td>
                                          <td>' . $row["count_name"] . '</td>
                                          <td>' . $row["unit_amount"] . '</td>
                                           <td>' . $row["unit_name"] . '</td>
                                           <td id="q">' . $row["total_left"] . '</td>

                                         
                                       </tr>';


                    echo '<script>

                                              </script>';
                  }

                }
                ?>
              </tbody>
            </table>
          </div>

          <!-- end of   available stock modal  -->


          <!-- start of goods view modal -->

          <div class="modal left fade" id="goodsViewModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title text-center">د جنس تغیرول</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2 table-responsive"
                    style="direction: rtl;">
                    <thead>
                      <tr>
                        <th style="width: 15%;">نوم</th>
                        <th style="width: 15%;">تخلص</th>
                        <th style="width: 15%;">پلار نوم</th>
                        <th style="width: 15%;">ولایت</th>
                        <th style="width: 15%;">ولسوالي</th>
                        <th style="width: 15%;">کلی</th>
                        <th style="width: 10%;">عملیات</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Table body content goes here -->


                      <?php
                      require_once('DBConnection.php');
                      $sql = "SELECT firm.address_id,firm.firm_id,province.province_name,district.district_name,firm.firm_name,address.adress_vilage FROM firm,province,address,district WHERE firm.address_id=address.address_id and address.address_province=province.province_id and address.address_district=district.district_id and firm.status='0';";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '<tr data-firm-id="' . $row["firm_id"] . '" data-firm-name="' . $row["firm_name"] . '" data-firm-address-id="' . $row["address_id"] . '" data-province-name="' . $row["province_name"] . '" data-district-name="' . $row["district_name"] . '" data-village-name="' . $row["adress_vilage"] . '">
                                <td>' . $row["firm_name"] . '</td>
                                 <td>' . $row["province_name"] . '</td>
                                <td>' . $row["district_name"] . '</td>
                                <td>' . $row["adress_vilage"] . '</td>
                                 <td>
                               <td style="color:red"> <a class="fa fa-edit text-decoration-none editgoods" href="javascript:void(0);" style="color:red"></a></td>
                               <td style="color:red"> <a class="fa fa-trash text-decoration-none editgoods" href="javascript:void(0);" style="color:blue"></a></td>
                              </td>';


                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>




          <script type="text/javascript">
            $(document).ready(function () {
              $('.userinfo').click(function () {
                var userid = $(this).data('id');
                $.ajax({
                  url: 'ajax.php',
                  type: 'post',
                  data: { userid: userid },
                  success: function (response) {
                    $('.modal-body').html(response);
                    $('#showAndSell').modal('show');
                    $('#userifo').hide();
                  }
                });

              });
            });
          </script>
        </div>
        <!-- sold modle start -->
        <div class="modal fade" id="sold">
          <div class="modal-dialog ">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header" style="text-align: right;">

                <h4 class="modal-title text-center w-100 ">ْجنس خرڅول</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="card">
                  <form class="post" method="post" enctype="multipart/form-data">
                    <?php
                    include('DBConnection.php');
                    $sellerID = null;
                    if (isset($_COOKIE["userID_admin"])) {
                      $sellerID = $_COOKIE["userID_admin"];
                    }
                    $findUserId = "SELECT user_id FROM user WHERE user_id='$sellerID';";
                    $result = $conn->query($findUserId);
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $sellerID = $row["user_id"];
                        echo '<input class="d-none" value="' . $sellerID . '" name="sellerAdmin">';
                      }
                    } else {
                      echo 'user id not fond';
                    }
                    ?>
                    <div class="input-group mt-2">
                      <select class="form-select form-control " required name="sold_category_id">
                        <?php

                        include('DBConnection.php');
                        $sqlcate = "SELECT * FROM `category`";
                        $resultCate = $conn->query($sqlcate);
                        if ($resultCate->num_rows > 0) {

                          while ($row1 = $resultCate->fetch_assoc()) {
                            echo '<option value="' . $row1["categ_id"] . '">' . $row1["categ_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">کټګوری</span>
                    </div>

                    <div class="input-group mt-2">
                      <select class="form-select form-control " required name="sold_company_id">
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `company`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["comp_id"] . '">' . $row["comp_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">کمپنی</span>
                    </div>


                    <div class="input-group mt-2">
                      <select class="form-select form-control " required name="sold_country_id">
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `country`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["count_id"] . '">' . $row["count_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">هیواد</span>

                    </div>


                    <div class="input-group mt-2">

                      <select class="form-select form-control " required name="sold_currency_id">

                        <?php
                        //  $sql="SELECT * FROM `currency`";
                        include('DBConnection.php');
                        $sql = "SELECT * FROM `currency`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["currency_id"] . '">' . $row["currency_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>


                      </select>
                      <span class="input-group-text">پولی واحد</span>
                    </div>


                    <div class="input-group mt-2">
                      <input type="text" class="form-control" required placeholder="" name="sold_quantity">
                      <span class="input-group-text">مقدار </span>
                    </div>


                    <div class="input-group mt-2">
                      <select class="form-select form-control " required name="sold_unit_id">
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `unit`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["unit_id"] . '">' . $row["unit_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">یونټ</span>
                    </div>

                    <div class="input-group mt-2">
                      <input type="text" class="form-control" required placeholder="" name="sold_unit_quantity">
                      <span class="input-group-text">مقدار یونټ</span>
                    </div>

                    <div class="input-group ">
                      <input type="text" class="form-control" required name="sold_goods_name">
                      <span class="input-group-text">د محصول نوم</span>
                    </div>

                    <div class="input-group mt-2">
                      <select name="sold_person_id" id="" class="form-control">
                        <option value="">No body</option>
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `person`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["person_id"] . '">' . $row["person_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>
                      </select>
                      <span class="input-group-text">دمشتری نوم</span>


                    </div>

                    <div class="input-group mt-2">
                      <input type="text" class="form-control" required name="sold_price">
                      <span class="input-group-text">قمت فی دانه</span>
                    </div>

                    <div class="input-group mt-2">
                      <button class="form-control btn btn-success soldandbuy" name="soldandbuy">اضافه کول</button>
                    </div>

                  </form>

                </div>
                <?php
                $queryBillNo = "SELECT bill_number FROM `bill` ORDER by bill_number DESC LIMIT 1";
                $billNoResult = $conn->query($queryBillNo);
                if ($billNoResult->num_rows > 0) {
                  while ($sold_bill_NO = $billNoResult->fetch_assoc()) {
                    echo $bill_number = $sold_bill_NO["bill_number"] + 1;
                  }
                }
                ?>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-danger  " name="close" id="soldandbuy">بندول</button>
                <button type="submit" class="btn btn-success" style="border: 2px solid green" id="printBill">بېل جوړول
                  بیل</button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#BillModal"
                  style="text-align:right;"></button>
              </div>

            </div>
          </div>
        </div>
        <!-- sell form validation -->
        <script>
          function validateGender() {
            const quantity = document.getElementsByName('sold_price'[9];)
            alert(quantity);
          }
        </script>
        <!-- sell form validation -->
        <script>

          $(document).ready(function () {
            $('#printBill').click(function (event) {
              event.preventDefault();
              var session = "unset";
              $.ajax({
                url: 'person_buy_goods.php',
                type: 'GET',
                data: { session: session },
                success: function (response) {

                  alert("بیل جوړ شو!");
                  window.location.replace('goods.php');
                },
                error: function (error) {

                  alert('Please try again.');
                }
              });
            });
          });
        </script>
        <!-- //sole modle end here -->
        <?php
        //  if(isset($_POST['soldandbuy'])){
        //   echo "clicked";
        //  }
        ?>
        <script>

          $(document).ready(function () {
            $('.soldandbuy').click(function (event) {
              event.preventDefault();

              $.ajax({
                url: 'person_buy_goods.php',
                type: 'POST',
                data: $('.post').serialize(),
                success: function (response) {

                  alert(response);
                },
                error: function (error) {

                  alert('Please try again.');
                }
              });
            });
          });
        </script>


        <!-- sold model end -->
        <!-- add product modal =================================================================================================================================strat-->
        <div class="modal fade" id="productffff">
          <div class="modal-dialog ">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header" style="text-align: right;">
                <h4 class="modal-title text-center w-100 ">نوی محصول اضافه کړئ!</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="card">
                  <form class="post" method="post" enctype="multipart/form-data">
                    <div class="input-group ">
                      <input type="text" class="form-control" required placeholder="" name="goods_name">
                      <span class="input-group-text">د حصول نوم</span>
                    </div>

                    <div class="input-group mt-2">
                      <input type="text" class="form-control" required placeholder="" name="goods_discription">
                      <span class="input-group-text"> جزیات</span>
                    </div>

                    <div class="input-group mt-2">
                      <input type="text" class="form-control" required placeholder="" name="buy_price">
                      <span class="input-group-text">د اخستلو بیه</span>
                    </div>
                    <div class="input-group mt-2">
                      <input type="text" class="form-control" required placeholder="" name="quantity">
                      <span class="input-group-text">مقدار</span>
                    </div>
                    <div class="input-group mt-2">

                      <select class="form-select form-control " required name="currency_id">

                        <?php
                        //  $sql="SELECT * FROM `currency`";
                        include('DBConnection.php');
                        $sql = "SELECT * FROM `currency`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["currency_id"] . '">' . $row["currency_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>


                      </select>
                      <span class="input-group-text">پولی واحد</span>
                    </div>
                    <div class="input-group mt-2">
                      <select class=" form-select form-control" name="categoryt_id">
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `category`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["categ_id"] . '">' . $row["categ_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">کټګوری</span>
                    </div>

                    <div class="input-group mt-2">
                      <select class="form-select form-control " required name="country_id">
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `country`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["count_id"] . '">' . $row["count_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">هیواد</span>

                      <select class="form-select form-control" name="firm">
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `firm`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["firm_id"] . '">' . $row["firm_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>
                      </select>
                      <span class="input-group-text">شرکت</span>
                    </div>

                    <div class="input-group mt-2">
                      <select class="form-select form-control " required name="company_id">
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `company`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["comp_id"] . '">' . $row["comp_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">کمپنی</span>
                    </div>
                    <div class="input-group mt-2">
                      <span class="input-group-text">یونټ مقدار</span>

                      <input type="text" class="form-control" name="unit_quantity" required>

                      <select class="form-select form-control " name="unit_id" required>
                        <?php

                        include('DBConnection.php');
                        $sql = "SELECT * FROM `unit`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {

                          while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row["unit_id"] . '">' . $row["unit_name"] . '</option>';
                          }

                        } else
                          "no record found";

                        ?>

                      </select>
                      <span class="input-group-text">یونټ</span>
                    </div>

                    <div class="input-group mt-2">
                      <input type="file" class="form-control" required placeholder="" name="image">
                      <span class="input-group-text">انځور</span>
                    </div>

                    <div class="input-group mt-2">
                      <button class="form-control btn btn-success" name="addproduct">ثبتول</button>
                    </div>

                  </form>

                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">بندول</button>
              </div>

            </div>
          </div>
        </div>

        <?php
        if (isset($_POST['addproduct'])) {
          echo addproduct();
        }
        ?>
        <!-- add product modal  =================================== end================================================== -->
        <!-- print and check bill Modal start -->
        <div class="modal fade" id="BillModal" style="direction:rtl">
          <div class="modal-dialog modal-xl">
            <div class="modal-content" style=" background-color: #fff; ">
              <!-- Modal Header -->
              <div class="modal-header" style="text-align: right;">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <h4 class="modal-title text-center w-100 "> د بېل مالومات</h4>
              </div>
              <div class="modal-body" style=" background-color: #fff;">

                <div class="col" id="billedcustoemr" style=" background-color: #fff; ">
                  <div class="row" style="text-align: right; ">

                    <div class="receipt-main col" style="text-align: right; height: 1200px;background-color:#fff">
                      <div class="row" style="color:#fff">

                        <div class="col-lg-8 justify-content-start text-align"
                          style="text-align: right;background-color:#fff">
                          <div class="receipt-left">
                            <img class="img-responsive" alt="solar-tech-logo" src="img/solar tech logo.png">
                          </div>
                          <div class="receipt-right" style="text-align: right;">
                            <h5 style="color:black">Solar Tech</h5>
                            <p>0778885555 <i class="fa fa-phone"></i></p>
                            <p>solar-tech@solar-tech.energy <i class="fa fa-envelope-o"></i></p>
                            <p>Kabul, Afghanistan <i class="fa fa-location-arrow"></i></p>
                          </div>
                        </div>
                        <div class="col-lg-4 text-right  justify-content-end"
                          style="text-align: right;background-color:#fff">
                          <div class="receipt-right" style="text-align: right;">
                            <h5 style="color:black">دمشتر نوم:

                              <?php
                              if (isset($_SESSION["username"])) {
                                echo $_SESSION["username"];
                              } else {
                                echo '<div class="alert alert-danger">
                                  <strong>Danger!</strong> مهربانی وکړی لوموړی بیل جوړ کړی!
                                </div>';
                              }
                              ?>
                            </h5>

                            <h3 style="">Bill NO : #
                              <?php
                              if (isset($_SESSION["billNumber"])) {
                                echo $_SESSION["billNumber"];
                              }
                              ?>
                            </h3>
                          </div>
                        </div>

                        <div>
                          <table class="table table-bordered" style=" background-color: #fff;">
                            <thead>
                              <tr>
                                <th>کتګوری</th>
                                <th>هیواد</th>
                                <th>کمپنی</th>
                                <th>واحد</th>
                                <th>واحد اندازه</th>
                                <th>مقدار</th>
                                <th>قمت</th>
                                <th>ټوټل قمت</th>
                                <th>پولی واحد</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php
                              $bill_generate = $bill_number - 1;
                              include('DBConnection.php');
                              // echo  $sellerID;
                              $checkBill = "SELECT category.categ_name, customers_bys_goods.bill_number,country.count_name,company.comp_name,customers_bys_goods.unit_amount,unit.unit_name,customers_bys_goods.price,customers_bys_goods.quantity,person.person_name,currency.currency_name,currency.currency_symbol,currency.currency_price 
                                  from customers_bys_goods,category,country,company,currency,person,unit 
                                  WHERE customers_bys_goods.categ_id=category.categ_id 
                                  and country.count_id=customers_bys_goods.count_id 
                                  and customers_bys_goods.comp_id=company.comp_id 
                                  and customers_bys_goods.currency_id=currency.currency_id 
                                  and customers_bys_goods.unit_id=unit.unit_id 
                                  and customers_bys_goods.person_id=person.person_id 
                                  and customers_bys_goods.bill_number='$bill_generate'and customers_bys_goods.seller_id='$sellerID'";
                              $showbillResult = $conn->query($checkBill);
                              $totalPrice = 0;
                              $subTotal = 0;
                              $dolor = 0;
                              $eruo = 0;
                              $afghani = 0;
                              $rate = null;
                              $totabaseonCreency = 0;
                              $totalAfghani = 0;
                              $totalDolor = 0;
                              $totalPaidAfghani = 0;
                              $totalPaidPK = 0;
                              $totalPaidDolor = 0;
                              $totalPaidToman = 0;
                              $sql_exchange_reate = "select * from currency";
                              $currencyRateResult = $conn->query($sql_exchange_reate);
                              if ($currencyRateResult->num_rows > 0) {
                                while ($row = $currencyRateResult->fetch_assoc()) {
                                  if ($row['currency_symbol'] == '$') {
                                    $dolor = $row['currency_price'];

                                  }
                                  if ($row['currency_symbol'] == '؋') {
                                    $afghani = $row['currency_price'];
                                  }
                                  if ($row['currency_symbol'] == '#') {
                                    $eruo = $row['currency_price'];
                                  }
                                }

                              }
                              if ($showbillResult->num_rows > 0) {
                                while ($row = $showbillResult->fetch_assoc()) {
                                  $totabaseonCreency = 0;
                                  if ($row['currency_symbol'] == '؋') {
                                    $rate = $row['price'] / $dolor;
                                    $totabaseonCreency += $rate * $row['quantity'];

                                  } elseif ($row['currency_symbol'] == '$') {
                                    $rate = $row['price'] * $dolor;
                                    $totabaseonCreency += $rate * $row['quantity'];

                                  } elseif ($row['currency_symbol'] == '#') {
                                    $rate = $row['price'] * $eruo;
                                    $totabaseonCreency += $rate * $row['quantity'];
                                    // $totalAfghani =($rate + $rate) * $row['quantity'];
                                  }


                                  $subTotal = $row["quantity"] * $row["price"];
                                  echo '<tr><td>' . $row["categ_name"] . '</td>
                                  <td>' . $row["count_name"] . '</td>
                                  <td>' . $row["comp_name"] . '</td>
                                  <td>' . $row["unit_name"] . '</td>
                                  <td>' . $row["unit_amount"] . '</td>
                                  <td>' . $row["quantity"] . '</td>
                                  <td>' . $row["price"] . '/' . $rate . '</td>
                                  <td>' . $subTotal . '/' . $totabaseonCreency . '
                                  <td>' . $row["currency_name"] . '</td>
                                  
                                
                                </tr>';

                                  //  echo $row['currency_symbol'];
                                  //echo $subTotal =+$subTotal;  
                              
                                  $totalPrice += $subTotal;
                                  $_SESSION["username"] = $row["person_name"];
                                  $_SESSION["billNumber"] = $bill_generate;
                                }
                                $totabaseonCreency = "SELECT cbg.currency_id, c.currency_name, c.currency_price, c.currency_symbol, SUM(cbg.price * cbg.quantity) AS total_price FROM customers_bys_goods cbg INNER JOIN currency c ON cbg.currency_id = c.currency_id WHERE cbg.bill_number ='$bill_generate' GROUP BY cbg.currency_id, c.currency_name, c.currency_price, c.currency_symbol";
                                $totabaseonCreencyResult = $conn->query($totabaseonCreency);
                                $mustBePaidDolor = 0;
                                $mustBePaidAfghani = 0;
                                if ($totabaseonCreencyResult->num_rows > 0) {
                                  while ($row = $totabaseonCreencyResult->fetch_assoc()) {

                                    if ($row['currency_symbol'] == '$') {

                                      $totalPaidDolor += $row['total_price'] * $dolor;

                                    }
                                    //echo $totalPaidDolor
                                    if ($row['currency_symbol'] == '؋') {
                                      $totalPaidAfghani += $row['total_price'];
                                    }

                                    $mustBePaidDolor = ($totalPaidDolor + $totalPaidAfghani) / $dolor;
                                    $mustBePaidAfghani = ($totalPaidDolor + $totalPaidAfghani);
                                    //  echo $row['total_price'].'<br>';
                                  }
                                  //echo $totalPaidAfghani;
                                }

                              }
                              ?>
                              <tr>
                                <td class="text-right">
                                  <h2><strong>ټوټل ډالر: </strong></h2>
                                </td>

                                <td class="text-right">
                                  <h2><strong>ټوټل افغانی: </strong></h2>
                                </td>
                              </tr>
                              <tr>
                                <td class="text-left text-danger">
                                  <strong><i class="fa fa-inr"></i>
                                    <?php echo $mustBePaidDolor; ?>
                                  </strong>
                                </td>
                                <td class="text-left text-danger">
                                  <strong><i class="fa fa-inr"></i>
                                    <?php echo $mustBePaidAfghani; ?>
                                  </strong>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="row" style="background-color:#fff">
                          <div class="receipt-header receipt-header-mid receipt-footer" style="background-color:#fff">
                            <div class="col-xs-8 col-sm-8 col-md-8 text-left" style="background-color:#fff">
                              <div class="receipt-right">
                                <p><b>Date & Time :</b>
                                  <?php
                                  // Set the timezone to your desired timezone
                                  date_default_timezone_set('Asia/Kabul');

                                  // Get the current date and time in your desired format
                                  $currentDateTime = date('Y-m-d H:i:s');

                                  echo $currentDateTime;
                                  ?>
                                </p>
                                <h5 style="color: rgb(140, 140, 140);">مننه چې سولر تیک مو غوره کړ!</h5>
                              </div>
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4" style="background-color:#fff">
                              <div class="receipt-left">
                                <h1>امضا</h1>

                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" style=" margin: bottom 10px;">

                          <div class="col" style="background-color:#fff">
                            <ul style=" list-style-type: none;">
                              <li style=" color: #1e7155;"> ادرس: قوای مرکز، کابل افغانستان سولر تیک</li>
                              <li style=" color: #1e7155;"> وېب سایټ:www.solar-tech.energy</li>
                            </ul>
                          </div>
                          <div class="col" style="background-color:#fff">
                            <ul style=" list-style-type: none;">
                              <li style=" color: #1e7155;">موبایل: 0778822525</li>
                              <li style=" color: #1e7155;">برښنالیک: info@solar-tech.energy</li>
                            </ul>
                          </div>
                        </div>
                      </div>

                    </div>

                  </div>

                </div>
                <div class="spinner-border text-success " id="spinnerContainer" style="display: none;"></div>
              </div>
              <button class="btn btn-success" onclick="generatePDF();">Print</button>
            </div>
            <div>

              <!-- check bill modal end here -->

              <!-- //<div class="circle-progress" id="progress-bar"></div> -->

              <script type="text/javascript">
                window.jsPDF = window.jspdf.jsPDF;

                function showSpinner() {
                  const spinnerContainer = document.getElementById("spinnerContainer");
                  spinnerContainer.style.display = "block";
                }

                function hideSpinner() {
                  const spinnerContainer = document.getElementById("spinnerContainer");
                  spinnerContainer.style.display = "none";
                }

                function generatePDF() {
                  var table = document.getElementById("billedcustoemr");
                  showSpinner(); // Show the Bootstrap spinner

                  var pdf = new jsPDF("p", "pt", "a4");

                  html2canvas(table, {
                    scale: 2,
                    dpi: 100,
                  }).then(function (canvas) {
                    var imgData = canvas.toDataURL("image/JPEG");
                    var imgProps = pdf.getImageProperties(imgData);
                    var pdfWidth = pdf.internal.pageSize.getWidth();
                    var pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    pdf.addImage(imgData, "JPEG", 0, 0, pdfWidth, pdfHeight);
                    pdf.save("downloaded_table.pdf");

                    // Hide the Bootstrap spinner once the PDF is generated
                    hideSpinner();
                  });
                }
                $(document).ready(function () {

                  $('.loan_quantity').keyup(function () {
                    var loan_quantity = $(this).val();
                    if (loan_quantity != "") {
                      $.ajax({
                        url: "liveSearch.php",
                        method: "POST",
                        data: { loan_quantity: loan_quantity },
                        success: function (data) {
                          // $(".insput").html(data);
                          // alert(loan_quantity);
                        }
                      });
                    }
                  });

                });
              </script>

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
  <script>
    var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
    var yValues = [55, 49, 44, 24, 15];
    var barColors = [
      "#b91d47",
      "#00aba9",
      "#2b5797",
      "#e8c3b9",
      "#1e7145"
    ];

    new Chart("myChart", {
      type: "doughnut",
      data: {
        labels: xValues,
        datasets: [{
          backgroundColor: barColors,
          data: yValues
        }]
      },
      options: {
        title: {
          display: true,
          text: "World Wide Wine Production 2018"
        }
      }
    });
  </script>
  <div id="progressContainer" style="display: none;">
    <div id="progress" style="width: 0%; background-color: #4CAF50; height: 30px;"></div>
  </div>
  <style>
    .circle-progress {
      width: 100px;
      height: 100px;
      background-color: #f1f1f1;
      border-radius: 50%;
      position: relative;
    }

    .progress-fill {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      background-color: #007bff;
      clip: rect(0, 50px, 100px, 0);
      /* Initial clip is 0% */
    }
  </style>


</body>

</html>