<?php
session_start();
include('DBConnection.php');

if (!isset($_SESSION['login_user']) && $_SESSION['login_user']['role'] != 2) {
  if (!isset($_SESSION['login_user']) || (isset($_SESSION['role']) && $_SESSION['role'] != 2)) {
    header("Location: Login.php");
    exit;
  }
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
  <link rel="stylesheet" type="text/css" href="admin.css?verssion=8">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="../style.css?verssion=4" rel="stylesheet">
</head>

<body>
  <header class="py-3 mb-4 border-bottom shadow">
    <div class="container-fluid align-items-center d-flex">

      <div class="col-lg-4 d-flex justify-content-start ">

        <a href="" class="text-decoration-none">
          <span class="h1 text-uppercase text-warning bg-dark px-2">SOLAR</span>
          <span class="h1 text-uppercase text-dark bg-warning px-2 ml-n1">SYSTEM</span>
        </a>
      </div>
      <div class="flex-grow-1 d-flex align-items-center">
        <form class="w-100 me-3">
          <input type="search" class="form-control" placeholder="Search...">
        </form>
        <div class="flex-shrink-0 dropdown">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
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
    <div class="id"> </div>
    <div class="row ">

      <main class="col-lg-9 col-md-8 col-sm-3 overflow-auto h-100">

        <div class="bg-light border rounded-3 p-3">


          <div class="col d-flex justify-content-end">

            <div class="btn-group  d-flex justify-content-center">
              <button type="button" class="bi- btn btn-sm  dropdown-toggle" data-toggle="dropdown">ښکاره کول</button>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">10</a>
                <a class="dropdown-item" href="#">20</a>
                <a class="dropdown-item" href="#">30</a>
              </div>
              <div class="sellButton">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sold"
                  style="text-align:right;">خرڅول</button>
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
            <a class=" d-flex justify-content-end text-decoration-none" data-bs-toggle="modal" data-bs-target="#product"
              style="text-align:right;">
              Add new product <i class="bi-plus"></i>
            </a>

          </div>
          <div class="card table-responsive">
            <table id="sells" class="table mt-2 table-ligh table table-hover  " style="direction:rtl">
              <thead class="overflow-auto h-100">

                <tr class="">


                  <th>ګټګوری</th>
                  <th>کمپنی</th>
                  <th> هیواد</th>
                  <th>پولی واحد</th>
                  <th>یونېټ</th>
                  <th>اندازه</th>
                </tr>

              </thead>
              <tbody>
                <?php
                require_once('DBConnection.php');
                $sql = "
                SELECT category.categ_name, MIN(company.comp_name) AS comp_name, 
                MIN(country.count_name) AS count_name, unit.unit_name,goods.unit_amount,
                 IFNULL(SUM(goods_qunatity), 0) AS Quantity FROM goods JOIN category 
                ON category.categ_id = goods.categ_id JOIN unit ON goods.unit_id = unit.unit_id JOIN currency
                 ON goods.currency_id = currency.currency_id JOIN company ON goods.comp_id = company.comp_id JOIN country
                 ON goods.count_id = country.count_id GROUP BY category.categ_name, unit.unit_name,
                country.count_name,company.comp_name,goods.unit_amount;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {

                  while ($row = $result->fetch_assoc()) {


                    echo '<tr>
                                        
                                          
                                          <td>' . $row["categ_name"] . '</td>
                                          <td>' . $row["comp_name"] . '</td>
                                          <td>' . $row["count_name"] . '</td>
                                          <td>' . $row["unit_amount"] . '</td>
                                           <td>' . $row["unit_name"] . '</td>
                                           <td id="q">' . $row["Quantity"] . '</td>

                                         
                                       </tr>';


                    echo '<script>

                                              </script>';
                  }

                }
                ?>
              </tbody>
            </table>
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
                $queryBillNo ="SELECT bill_number FROM `bill` ORDER by bill_number DESC LIMIT 1";
                $billNoResult = $conn->query($queryBillNo);
                if($billNoResult ->num_rows>0){
                    while($sold_bill_NO = $billNoResult->fetch_assoc()){
                   echo $bill_number =$sold_bill_NO ["bill_number"]+1;
                    }
                  }
                ?>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-danger  " name="close" id="soldandbuy">بندول</button>
                <button type="submit" class="btn btn-success" style="border: 2px solid green" id="printBill">پرنېټ بیل</button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#BillModal"
                  style="text-align:right;">بیل چکول</button>
              </div>

            </div>
          </div>
        </div>
      <!-- print bill modal start -->
        <div class="modal fade" id="BillModal">
          <div class="modal-dialog ">
            <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header" style="text-align: right;">
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <h4 class="modal-title text-center w-100 ">ْجنس خرڅول</h4>
               
              </div>


              <div class="modal-body">
                    <?php 
                      // include('DBConnection.php');
                      // $checkBill ="SELECT * FROM `customers_bys_goods` WHERE bill_number='$bill_number'";
                      // $showbillResult = $conn->query($checkBill);
                      // if($showbillResult -> num_rows>0){
                      //   while($row = $showbillResult->fetch_assoc()){
                      //     echo $row["bill_number"];
                      //   }
                      // }
                    ?>
              </div>
            </div>
          </div>
          <div>
          <!-- print bill modle end  -->
        <script>

          $(document).ready(function () {
            $('#printBill').click(function (event) {
              event.preventDefault();
              var session = "unset";
              $.ajax({
                url: 'person_buy_goods.php',
                type: 'GET',
                data: {session:session},
                success: function (response) {

                  alert("Bill Created");
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
        <div class="modal fade" id="product">
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
                        $sql = "SELECT * FROM `firm`;                        ";
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

                      <input type="text" class="form-control" name="unit_quantity">

                      <select class="form-select form-control " name="unit_id">
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
        <!-- add product modal  =================================== end============================================================================= -->

        <!--   Sell product s modle ================================================================================================================= -->



        <div class="modal fade" id="showAndSell">

          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel" style="text-align:center">Sell And Show</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-6">.col-md-4</div>
                    <div class="col-md-6 ms-auto">.col-md-4 .ms-auto</div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 ms-auto">.col-md-3 .ms-auto</div>
                    <div class="col-md-2 ms-auto">.col-md-2 .ms-auto</div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 ms-auto">.col-md-6 .ms-auto</div>
                  </div>
                  <div class="row">
                    <div class="col-sm-9">

                      <div class="row">
                        <div class="col-8 col-sm-6">
                          Level 2: .col-8 .col-sm-6
                        </div>
                        <div class="col-4 col-sm-6">
                          Level 2: .col-4 .col-sm-6
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <div class="user"></div>

              <form method="post">
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <a href="liveSearch.php" type="submit" class="btn btn-primary" name="confirm" value="confirm"></a>
                </div>
              </form>

            </div>
          </div>
        </div>

        <!--   Sell product s modle ================================================================================================================= -->
      </main>
      <aside class="col-sm-3 flex-grow-sm-1 flex-shrink-1 flex-grow-0 sticky-top pb-sm-0 pb-3"
        style="text-align:right;">
        <div class="bg-light border rounded-3 p-1 h-100 sticky-top">
          <ul class="nav nav-pills flex-sm-column flex-row mb-auto justify-content-between text-truncate">

            <li>
              <a href="admin.php" class="nav-link px-2 text-truncate">
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
                <label class="custom-control-label" for="size-all">ټول مخصولات</label>
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
          <!-- category -->

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

</body>

</html>