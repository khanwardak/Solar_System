<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require '../vendor/autoload.php';
include('DBConnection.php');

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

include('jdf.php');
define("DATE", jdate('l / j / p / y / i : g a'));


?>
<?php

function recentlly()
{
  $lint = 1;
  if (isset($_GET['view'])) {
    $lint = $_GET['view'];


  }
  $sql = "SELECT category.categ_name, country.count_name,customers_bys_goods.buy_date, company.comp_name, customers_bys_goods.price, currency.currency_name, 
            unit.unit_name, customers_bys_goods.unit_amount, person.person_name FROM customers_bys_goods, 
            currency, category, country, unit, person, company
            WHERE customers_bys_goods.currency_id = currency.currency_id AND 
            customers_bys_goods.categ_id = category.categ_id AND customers_bys_goods.count_id = country.count_id
            AND person.person_id = customers_bys_goods.person_id  AND
            company.comp_id = customers_bys_goods.comp_id ORDER BY customers_bys_goods.buy_date DESC LIMIT " . $lint;
  include('DBConnection.php');

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

      echo ' <tr class="">
                     <td>' . $row["categ_name"] . '</td>

                     <td> ' . $row["price"] . '</td>
                     <td>' . $row["buy_date"] . '</td>
                     <td><a style="color:#fff" href="admin.php?customer=' . $row["person_name"] . '">' . $row["person_name"] . '</a></td>
                     <td> <ul class="action-list" style="color:#fff">
                     <li><a href="#" data-tip="edit" ><i class="fa fa-edit"></i></a></li>
                     <li><a href="#" data-tip="delete"><i class="fa fa-trash"></i></a></li>
                      </ul>
                      </td>

                 </tr>';
    }
  }
}


?>

<?php
if (isset($_POST["provID"])) {
  require_once('DBConnection.php');
  $sql = "SELECT * FROM `district` WHERE province_id=" . $_POST["provID"];
  $outpot = '';
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $i = 0;
    echo '<option value="">selext</option>';
    while ($row = $result->fetch_assoc()) {
      echo '<option value="' . $row["district_id"] . '">' . $row["district_name"] . '</option>';

    }
    //echo $outpot;
  } else {
    echo "<option> no select a</option>";
  }
}
function addcustomer()
{
  // echo  $filename = $_FILES["uploadfile"]["name"];
  $name = $_POST['customoer_name'];
  $fname = $_POST['customerfname'];
  $email = $_POST['customer_email'];
  $location = $_POST['location'];
  require_once('DBConnection.php');


  // $sqll="SET FOREIGN_KEY_CHECKS = 0;";
// $conn->query($sqll);
  $location = $_POST['location'];
  $dist = $_POST['dist'];
  $province = $_POST['province'];
  $sql2 = "INSERT INTO `address` (`adress_vilage`, `address_province`, `address_district`) VALUES ( '$location', '$province', '$dist');";
  if (!$conn->query($sql2)) {
    echo "opps!";
  }

  // set the customer address
  $sql3 = "SELECT address_id FROM `address` ORDER BY `address_id` DESC LIMIT 1";
  $result = $conn->query($sql3);
  $id = $result->fetch_assoc();
  $locationid = $id["address_id"];
  //$conn->query($sql2);
// select image and uploaded it as customer profile image
  $uniquesavename = time() . uniqid(rand());
  $date = DATE;
  $sql7 = "INSERT INTO `person` (`person_id`, `person_name`, `person_f_name`, `person_fathe_name`,`person_address`,`created_date`) VALUES (NULL, '$name', '$fname', '$email','$locationid','$date')";
  if (!$conn->query($sql7)) {
    echo "opps some wrong";
  } else {
    success();
  }
  // add mobile numbers
  $sql4 = "SELECT person_id FROM `person` ORDER BY `person_id` DESC LIMIT 1";
  $result = $conn->query($sql4);
  $id = $result->fetch_assoc();
  $mobile = $id["person_id"];
  $mobileNO = $_POST['mobile'];
  $sql5 = "INSERT INTO `mobile_numbers` (`mobile_numbers`, `person_id`) VALUES ('$mobileNO', '$mobile');";
  $conn->query($sql5);

  $mobileNO1 = $_POST['mobile1'];
  $sql5 = "INSERT INTO `mobile_numbers` (`mobile_numbers`, `person_id`) VALUES ('$mobileNO1', '$mobile');";
  $conn->query($sql5);

  $mobileNO2 = $_POST['mobile2'];
  $sql5 = "INSERT INTO `mobile_numbers` (`mobile_numbers`, `person_id`) VALUES ('$mobileNO2', '$mobile');";
  $conn->query($sql5);
  //header( "Location: admin.php" );


}
if (isset($_POST['submit'])) {
  // setaddress();
  addcustomer();

}
// Add category
function addcate()
{
  try {
    include('DBConnection.php');
    $catename = $_POST['category_name'];
    $sql = "INSERT INTO `category` (`categ_name`) VALUES ('$catename');";
    if (!$conn->query($sql)) {
      echo 'opps!';
    } else {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "د کټګوری معلومات اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    }

  } catch (Exception $e) {
    echo 'Some thing went woring kindly check line 152 on addmin' . $e->getMessage();
  }

}
// start of update category funtion
function updateCategory()
{
  try {
    include('DBConnection.php');
    $catid = $_POST['update_categ_id']; // Assuming you have a hidden field for category_id in your HTML form
    $catename = $_POST['update_category_name'];
    $sql = "UPDATE `category` SET `categ_name`='$catename' WHERE `categ_id`='$catid';";
    if (!$conn->query($sql)) {
      echo 'opps!';
    } else {
      echo ' <script LANGUAGE="JavaScript">
                 swal("په بریالی توګه !", "د محضول مغلومات تازه شول!", "success");
                 setTimeout(function() {
                  window.location.href = "admin.php";
                }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    }

  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
// end of update category function



// editing unit function start here

function updateUnit()
{
  try {
    $unit_id = $_POST['update_unit_id']; // Assuming you have a form field with the unit ID
    $unit_name = $_POST['update_unit_name'];

    include('DBConnection.php');

    // Prepare the SQL update query
    $sql = "UPDATE `unit` SET `unit_name` = '$unit_name' WHERE `unit_id` = $unit_id";

    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
                 swal("په بریالی توګه !", "د محضول معلومات تازه شول!", "success");
                 setTimeout(function() {
                  window.location.href = "admin.php";
                }, 2000); // 2000 milliseconds (2 seconds)
                
               </script>;';
    } else {
      echo ' <script LANGUAGE="JavaScript">
                 window.alert("Opps: ' . $conn->error . '");
                 
               </script>";';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo $e->getMessage();
  }
}

// editing unit function end here



// add company function
function addco()
{
  try {
    $coname = $_POST['company_name'];
    include('DBConnection.php');
    $sql = "INSERT INTO `company` (`comp_name`) VALUES ('$coname');";
    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "د کمپنۍ معلومات اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo ' ("<script LANGUAGE="JavaScript">
                 window.alert("Opps");
                 window.location.href="admin.php";
               </script>");';
    }
  } catch (Exception $e) {

  }

}
// adding company end here

// updating company start here
function updateCompany()
{
  try {
    $comp_id = $_POST['update_company_id']; // Assuming you have a form field with the company ID
    $coname = $_POST['update_company_name'];

    include('DBConnection.php');

    // Prepare the SQL update query
    $sql = "UPDATE `company` SET `comp_name` = '$coname' WHERE `comp_id` = $comp_id";

    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
                 swal("په بریالی توګه !", "د محضول معلومات تازه شول!", "success");
                 setTimeout(function() {
                  window.location.href = "admin.php";
                }, 2000); // 2000 milliseconds (2 seconds)
                 
               </script>;';
    } else {
      throw new Exception('Database update error: ' . $conn->error);
    }
  } catch (Exception $e) {
    // Handle the exception here
    echo ' ("<script LANGUAGE="JavaScript">
             window.alert("Opps: ' . $e->getMessage() . '");
             window.location.href="admin.php";
           </script>");';
  }
}

// updating company end here
// AddOurLoan start 
function addOurLoan()
{
  try {
    include('DBConnection.php');
    $ourloanfirm = $_POST['ourloanfirm'];
    $ourloancurency_id = $_POST['ourloancurrency_id'];
    $ourloanamount = $_POST['ourloanamount'];

    $sqluser = "INSERT INTO `ourloan`(`loan_amount`, `loan_paid`, `firm_id`, `currency_id`) 
    VALUES ('$ourloanamount', 0, '$ourloanfirm', $ourloancurency_id)";

    if ($conn->query($sqluser)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "د قرضې معلومات اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo '<script LANGUAGE="JavaScript">
             window.alert("Opps:");
           </script>';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo "Error: " . $e->getMessage();
  }
}

// end of AddOurLoan
// start of updateourloan function
function updateOurLoan()
{
  try {
    include('DBConnection.php');
    $ourloan_id = $_POST['update_ourloan_id']; // Added to get the ourloan_id of the loan to be updated
    $ourloanfirm = $_POST['update_ourloan_firm_name'];
    $ourloancurency_id = $_POST['update_ourloan_currency_id'];
    $ourloanamount = $_POST['update_ourloan_amount'];

    $sqluser = "UPDATE `ourloan` SET `loan_amount`='$ourloanamount', `firm_id`='$ourloanfirm', `currency_id`='$ourloancurency_id' WHERE `ourloan_id`='$ourloan_id'";

    if ($conn->query($sqluser)) {
      echo '<script LANGUAGE="JavaScript">
        swal("په بریالی توګه !", "د قرضې معلومات تازه شو!", "success");
        setTimeout(function() {
          window.location.href = "admin.php";
        }, 2000); // 2000 milliseconds (2 seconds)
      </script>';
    } else {
      echo '<script LANGUAGE="JavaScript">
        window.alert("Opps:");
      </script>';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo "Error: " . $e->getMessage();
  }
}
// end of edit ourLoan

// strat of adding Users
function addUsers()
{
  try {
    include('DBConnection.php');
    $name = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $username = $_POST['user_name'];
    $userpassword = $_POST['user_password'];
    $usertype = $_POST['userType'];
    $useremails = $_POST['user_email'];

    // Hash the password
    $hashedPassword = password_hash($userpassword, PASSWORD_BCRYPT);

    $sqluser = "INSERT INTO `user` (user_id, `username`, `password`, `name`, `last_name`,  `email`, `user_type`) 
                VALUES (NULL, '$username', '$hashedPassword', '$name', '$lastname', '$useremails', '$usertype')";

    if ($conn->query($sqluser)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "د یوزر معلومات اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo '<script LANGUAGE="JavaScript">
             window.alert("Opps: ' . $conn->error . '");
           </script>';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo "Error: " . $e->getMessage();
  }
}

// end of user adding function

// start of user edit function
function EditUsers()
{
  try {
    include('DBConnection.php');
    $userId = $_POST['ed_user_id']; // Assuming you have a form field with the user_id

    // Get the updated values from the form fields
    $name = $_POST['ed_first_name'];
    $lastname = $_POST['ed_last_name'];
    $username = $_POST['ed_user_name'];
    $userpassword = $_POST['ed_user_password'];
    $usertype = $_POST['userType'];
    $useremails = $_POST['ed_user_email'];

    // Hash the password
    $hashedPassword = password_hash($userpassword, PASSWORD_BCRYPT);

    // Prepare the SQL update query
    $sqluser = "UPDATE `user` SET 
                `username` = '$username', 
                `password` = '$hashedPassword', 
                `name` = '$name', 
                `last_name` = '$lastname',  
                `email` = '$useremails', 
                `user_type` = '$usertype' 
                WHERE `user_id` = $userId";

    if ($conn->query($sqluser)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "د شرکت معلومات اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo '<script LANGUAGE="JavaScript">
             window.alert("Opps: ' . $conn->error . '");
           </script>';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo "Error: " . $e->getMessage();
  }
}


// end of user edit funtion

// start of addingfirm function
function addFirm()
{
  try {
    include('DBConnection.php');
    $location = $_POST['location_name'];
    $dist = $_POST['district'];
    $province = $_POST['address'];

    // Insert address first
    $sql2 = "INSERT INTO `address` (`adress_vilage`, `address_province`, `address_district`) 
             VALUES ('$location', '$province', '$dist')";

    if (!$conn->query($sql2)) {
      echo "Opps!";
    }

    // Get the inserted address_id
    $sql = "SELECT * FROM `address` ORDER BY address_id DESC LIMIT 1";
    $id = $conn->query($sql);
    $addressId = "";
    while ($row = $id->fetch_assoc()) {
      $addressId = $row["address_id"];
    }

    $store_name = $_POST['firm_name'];
    $sqlfirm = "INSERT INTO `firm` (`firm_id`, `firm_name`, `address_id`) 
                VALUES (NULL, '$store_name', '$addressId')";

    if ($conn->query($sqlfirm)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "د شرکت معلومات اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo '<script LANGUAGE="JavaScript">
             window.alert("Opps: ' . $conn->error . '");
           </script>';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo "Error in adding firm: " . $e->getMessage();
  }
}

// end of addingfirm function

// edit firm start 
function updateFirm()
{
    try {
        include('DBConnection.php');
        $firm_id = $_POST['firm_id']; // Assuming you have a hidden input field named 'firm_id' to store the firm ID.
        $location = $_POST['location_name'];
        $dist = $_POST['district'];
        $province = $_POST['address'];

        // First, update the address
        $sql_update_address = "UPDATE `address` SET `adress_vilage`='$location', `address_province`='$province', `address_district`='$dist' WHERE `address_id`='$firm_id'";

        if ($conn->query($sql_update_address)) {
            // Address update successful, now update other firm-specific information if needed
            // ...

            echo '<script LANGUAGE="JavaScript">
                swal("په بریالی توګه !", "معلومات تازه شو!", "success");
                setTimeout(function() {
                    window.location.href = "admin.php";
                }, 2000); // 2000 milliseconds (2 seconds)
            </script>';
        } else {
            echo "Opps!";
        }
    } catch (Exception $e) {
        // Handle any exceptions here
        echo "Error: " . $e->getMessage();
    }
}

// add countery
function addcounter()
{
  try {
    include('DBConnection.php');
    $countery_name = $_POST['countery_name'];
    $sql = "INSERT INTO `country` (`count_name`) VALUES (' $countery_name');";
    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "د هیواد معلومات اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo ' <script LANGUAGE="JavaScript">
                 window.alert("Opps");
                 window.location.href="admin.php";
               </script>"';
    }

  } catch (Exception $e) {
    echo $e->getMessage();
  }

}
// end of adding country function 

// update country function start here

function updateCountry()
{
  try {
    $count_id = $_POST['update_country_id']; // Assuming you have a form field with the country ID
    $countery_name = $_POST['update_country_name'];

    include('DBConnection.php');

    // Prepare the SQL update query
    $sql = "UPDATE `country` SET `count_name` = '$countery_name' WHERE `count_id` = $count_id";

    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
                 swal("په بریالی توګه !", "د محضول معلومات تازه شول!", "success");
                 setTimeout(function() {
                  window.location.href = "admin.php";
                }, 2000); // 2000 milliseconds (2 seconds)
              
               </script>;';
    } else {
      echo ' <script LANGUAGE="JavaScript">
                 window.alert("Opps: ' . $conn->error . '");
                 window.location.href="admin.php";
               </script>"';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo $e->getMessage();
  }
}

// update country function end here

// add currency function start here
try {
  function addCurrency()
  {
    include('DBConnection.php');
    $countery_name = $_POST['currency_name'];
    $currency_sign = $_POST['currency_sign'];
    $sql = "INSERT INTO `currency` (`currency_id`, `currency_name`, `currency_symbol`) VALUES (NULL, '$countery_name', '$currency_sign');";
    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "پولی واحد اضافه شو!!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo ' ("<script LANGUAGE="JavaScript">
                     window.alert("Opps");

                   </script>");';
    }
  }
} catch (Exception $e) {
  echo $e->getMessage();
}
// end of adding currency function 


// editing currency function start here

function updateCurrency()
{
  try {
    $currency_id = $_POST['update_currency_id']; // Assuming you have a form field with the currency ID
    $currency_name = $_POST['update_currency_name'];
    $currency_sign = $_POST['update_currency_sign'];

    include('DBConnection.php');

    // Prepare the SQL update query
    $sql = "UPDATE `currency` SET `currency_name` = '$currency_name', `currency_symbol` = '$currency_sign' WHERE `currency_id` = $currency_id";

    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
                 swal("په بریالی توګه !", "د محضول معلومات تازه شول!", "success");
                 setTimeout(function() {
                  window.location.href = "admin.php";
                }, 2000); // 2000 milliseconds (2 seconds)
                
               </script>;';
    } else {
      echo ' <script LANGUAGE="JavaScript">
                 window.alert("Opps: ' . $conn->error . '");
                 window.location.href="admin.php";
               </script>";';
    }
  } catch (Exception $e) {
    // Handle any exceptions here
    echo $e->getMessage();
  }
}
// edit currency function start here

// adding unit function start here
function addUnit()
{
  try {
    include('DBConnection.php');
    $unit_name = $_POST['unit_name'];
    $sql = "INSERT INTO `unit` (`unit_id`, `unit_name`) VALUES (NULL, '$unit_name');";
    if ($conn->query($sql)) {
      echo ' <script LANGUAGE="JavaScript">
      swal("په بریالی توګه !", "واحد اضافه شول!", "success");
      setTimeout(function() {
      window.location.href = "admin.php";
      }, 2000); // 2000 milliseconds (2 seconds)
               </script>;';
    } else {
      echo ' ("<script LANGUAGE="JavaScript">
                     window.alert("Opps");

                   </script>");';
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }

}

// Dashboaerd -----------------------------------------------------------------------------------------------------------------//

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
  <title>Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="admin.css?verssion=6">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.32/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="pdfmake/build/pdfmake.min.js"></script>
  <script src="pdfmake/build/vfs_fonts.js"></script>
  <script src="jsPDF/dist/jspdf.es.min.js"></script>
  <script src="jsPDF/dist/jspdf.umd.min.js"></script>
  <script src="jsPDF/src/jspdf.js"></script>
  <script src="jsPDF/jsPDFAutoTable/dist/jspdf.plugin.autotable.js"></script>
  <script src="jsPDF/html2canvas/html2canvas.js"></script>
  <script src="jsPDF/html2canvas/html2canvas.min.js"></script>
  <link href="../style.css?verssion=4" rel="stylesheet">

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

        <div class="bg-light border rounded-3 p-3">
          <div class="row">
            <div class="col-xxl-4 col-md-4" style="direction:rtl; text-align: right; background-color: ">
              <div class="card info-card revenue-card" style="background-color:#089f6d;">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>پلټنه</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">نن</a></li>
                    <li><a class="dropdown-item" href="#">میاشت</a></li>
                    <li><a class="dropdown-item" href="#">کال</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title" style="color:#fff">ګټه <span  style="color:#fff">| میاشت</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3" style="color:#fff">
                      <h6 style="color:#fff">$3,264</h6>
                      <span class="small pt-1 fw-bold" style="color:#fff">8%</span> <span
                        class="small pt-2 ps-1" style="color:#fff">کمه شوی</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <div class="col-xxl-4 col-md-4 " style="direction: rtl; text-align: right;">
              <div class="card info-card sales-card ss "style="background-color:#1353a2;">


                <div class="filter" style="direction: rtl; text-align: right; background-color:;">
                  <a class="dropdown-item" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow uu">
                    <li class="dropdown-header text-start">
                      <h6>پلټنه</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">نن</a></li>
                    <li><a class="dropdown-item" href="#">میاشت</a></li>
                    <li><a class="dropdown-item" href="#">کال</a></li>
                  </ul>
                </div>

                <div class="card-body" style="direction:rtl; background-color:;">
                  <h5 class="card-title" style="color:#fff">خرڅ شوی <span  style="color:#fff">| نن</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6  style="color:#fff">145</h6>
                      <span class=" small pt-1 fw-bold" style="color:#fff">12%</span> <span
                        class=" small pt-2 ps-1" style="color:#fff">ریات شوی</span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- Customers Card -->
            <div class="col-xxl-4 col-md-4" style="direction:rtl; text-align: right;">

              <div class="card info-card customers-card"  style="background-color:#ce5e13">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots" style="background-color:#ce5e13"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>پلټنه</h6>
                    </li>
                    <li> <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addcustomer"
                        style="text-align:right;">
                        نوی مشتری <i class="bi-plus"></i>
                      </a></li>
                    <li><a class="dropdown-item" href="#" style="text-align:right;">نن</a></li>
                    <li><a class="dropdown-item" href="#" style="text-align:right;">میاشت</a></li>
                    <li><a class="dropdown-item" href="#" style="text-align:right;">کال</a></li>
                    <li> <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#customerHistory"
                        style="text-align:right;">
                        تاریخچه<i class="bi-plu"></i>
                      </a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title" style="color:#fff">مشتریان <span style="color:#fff">| کال</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <?php

                      try {

                        include('DBConnection.php');
                        $sql2 = "SELECT COUNT(person.person_id) AS NumberOfcustomer FROM person;";
                        $result = $conn->query($sql2);
                        if ($result->num_rows > 0) {

                          $row = $result->fetch_assoc();
                          echo '<h6 style="color:#fff">' . $row['NumberOfcustomer'] . '</h6>';
                        }

                      } catch (Exception $e) {
                      }
                      ?>

                      <span class="text-white small pt-1 fw-bold" >12%</span> <span
                        class="text-white small pt-2 ps-1">ریات شوی</span>

                    </div>
                  </div>

                </div>

              </div>

              <!--  add new customer modal start here------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
              <!-- edite and delete customer profiles -->

              <?php
              try {
                $name = '';
                $fname = '';
                $email = '';

                if (isset($_GET['editeprofiles'])) {
                  $id = $_GET['editeprofiles'];
                  echo '<script>
                    $(document).ready(function(){
                            $("#addcustomer").modal("show");
                        });
                 </script>';
                  $sql = "SELECT * FROM `person` INNER JOIN address ON person.person_address = address.adress_id INNER JOIN district ON address.address_district= district.district_id INNER JOIN province ON district.province_id = province.province_id WHERE person_id='$id';";
                  include('DBConnection.php');
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    $sql2 = "SELECT * FROM `mobile_numbers` WHERE person_id ='$id'";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows > 0) {

                    }
                    while ($row = $result->fetch_assoc()) {
                      $name = $row["person_name"];
                      $fname = $row["person_f_name"];
                      $email = $row["person_fathe_name"];
                    }
                  }
                }

              } catch (Exception $e) {

              }
              ?>
              <div class="modal fade" id="addcustomer" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                      <div class="px-4 py-5">
                        <h5 class="card-title"><span>د مشتری معلومات د ننه کړي!</span></h5>

                        <form method="post" class="row g-3 needs-validation" novalidate style="text-align:right;"
                          enctype="multipart/form-data">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="customoer_name" class="form-control" id="" required value=<?php echo $name; ?>>
                            <div class="invalid-feedback">Please fill the feld!</div>
                          </div>

                          <div class="col-12">
                            <label for="yourEmail" class="form-label">پلار نوم</label>
                            <input type="tex" name="  customerfname" class="form-control" id="" required value=<?php echo $fname; ?>>
                            <div class="invalid-feedback">Please enter number!</div>
                          </div>
                          <div class="col-12">
                            <label for="yourEmail" class="form-label">اد پلار نوم</label>
                            <input type="email" name="customer_email" class="form-control" id="" required value=<?php echo $email; ?>>
                            <div class="invalid-feedback">Please enter price!</div>
                          </div>
                          <label for="for add" class="form-label">ادرس</label>
                          <div class="col-12 input-group">


                            <div class="invalid-feedback">Please enter price!</div>

                            <label for="for add" class="form-label">ولایت</label>
                            <select id="province" name="province" onchange="province(this.value)">
                              <?php
                              try {
                                require_once('DBConnection.php');

                                $sql = "SELECT * FROM `province`";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {

                                  while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["province_id"] . '">' . $row["province_name"] . '</option>';
                                  }

                                }
                              } catch (Exception $e) {

                              }

                              ?>
                            </select>
                            <script type="text/javascript">
                              $(document).ready(function () {
                                $('#province').on('change', function () {
                                  var pro_id = $(this).val();
                                  $.ajax({
                                    url: 'ajax.php',
                                    method: 'POST',
                                    data: { proID: pro_id },
                                    dataType: "text",
                                    success: function (html) {
                                      $('#dist').html(html);
                                    }
                                  });
                                });
                              });
                            </script>
                            <label for="for add" class="form-label">ولسوالی</label>
                            <select id="dist" name="dist">
                              <option value="">ولسوالی</option>
                            </select>
                            <label for="for add" class="form-label">کلی</label>
                            <input class="form-control" id="locationd" name="location">
                            <div class="invalid-feedback">Please enter price!</div>
                          </div>
                          <div class="form-label">د اړیکو شمرې</div>
                          <div class="col-12">
                            <label for="for add" class="form-label">1. موبایل نمبر</label>
                            <input type="text" name="mobile" class="form-control" id="" required>
                            <div class="invalid-feedback">Please enter price!</div>
                            <label for="for add" class="form-label">2. موبایل نمبر</label>
                            <input type="text" name="mobile1" class="form-control" id="" required>
                            <div class="invalid-feedback">Please enter price!</div>
                            <label for="for add" class="form-label">3.موبایل نمبر</label>
                            <input type="text" name="mobile2" class="form-control" id="" required>
                            <div class="invalid-feedback">Please enter price!</div>
                            <div class="col-12">
                              <label for="for file" class="form-label">انځور</label>
                              <input class="form-control" type="file" name="image" value="" />
                              <div class="invalid-feedback">Please enter price!</div>
                            </div>
                          </div>


                          <div class="text-center mt-5">

                            <input type="submit" name="submit" class="btn btn-primary btn-submit">
                            <?php

                            function success()
                            {
                              //
                              echo '<script>  alert ("Data submite successfully");  </script
                                        window.location.href="admin.php";
                                    ';

                            }
                            ?>
                          </div>

                      </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <!-- End Customers --------------------------------------------------------------------------------------------------------------------------------------------------Card -->
            <!-- customer History modal -->
            <div class="modal left fade" id="customerHistory" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body card ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>د مشتری تاریچه</span></h5>
                      <div class="col-lg-12 col-6 d_flex justify-content-center">
                        <form action="">
                          <div class="input-group" style="height:100%">
                            <input type="text" class="form-control customerHistory" placeholder="">
                            <div class="input-group-append ">
                              <span class=" form-control bg-transparent text-warning">
                                <i class="fa fa-search "></i>
                              </span>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="px-4 py-5">

                        <table class="table table-borderless align-middle mb-0 bg-white table-hover "
                          style="direction:rtl" class="card">
                          <thead>
                            <tr class="cusomerHistory" id="customerhistory">
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                      <div id="laoninfo"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script type="text/javascript">
              $(document).ready(function () {
                $('.customerHistory').keyup(function () {
                  var customerhistory = $(this).val();
                  // alert(customerhistory);
                  $.ajax({
                    url: "ajax.php",
                    method: "POST",
                    data: { customerhistory: customerhistory },
                    success: function (data) {
                      $("#customerhistory").html(data);
                      // alert(customerhistory);
                    }
                  });
                });
              });
            </script>
            <!-- customer history modal end -->
            <!-- category modal start here ==============================================================================================================================================================================================================================================================================================-->

            <div class="modal left fade" id="catagory" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog ">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>کټګوری اضافه کړي!</span></h5>
                      <div class="px-4 py-5">
                        <form method="post" class="row g-3 needs-validation" novalidate style="text-align:right;">

                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="category_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">

                              <button class="btn btn-primary btn-submit" type="submit" name="addcate">ثبتول</button>

                            </div>
                          </div>

                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>کټګوری نوم</th>
                              <th>عملیات</th>

                            </tr>
                          </thead>
                          <tbody>

                          <?php
try {
  require_once('DBConnection.php');
  $sql = "SELECT * FROM `category` ORDER BY categ_id DESC LIMIT 10";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo '<tr data-category-id="' . $row["categ_id"] . '" data-category-name="' . $row["categ_name"] . '">';
      echo '<td>' . $row["categ_name"] . '</td>';
      echo '<td>
              <a class="fa fa-edit text-decoration-none editButtonCategory" href="javascript:void(0);"></a>
            </td>';
      echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
      echo '</tr>';
    }
  }
} catch (Exception $e) {
  // Handle the exception here
}
?>

                                    </td>
                                     <td><a class="fa fa-trash text-decoration-none" href=""></a></td>
                                      </tr>
                            
                          </tbody>
                        </table>



                          </tbody>
                        </table>

                        <script>
 $(document).ready(function() {
  // Handle click event for the editButton using event delegation
  $(document).on('click', '.editButtonCategory', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

    // Find the parent table row and get the category_id and category_name from the data attributes
    var row = $(this).closest('tr');
    var categ_id = row.data('category-id');
    var categ_name = row.data('category-name');
    $('#update_Category_modal').modal('show');
    $('#catagory').modal('hide');
    $('#update_Category_modal input[name="update_categ_id"]').val(categ_id);
    $('#update_Category_modal input[name="update_category_name"]').val(categ_name);
  });
});

</script>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php

            if (isset($_POST['addcate'])) {
              addcate();
            }
            ?>
          
            <!-- Category modal end here ==========================================================================================================================================================================================================================================================================-->
            
            
            
            <!-- start of edit category modal -->


            <div class="modal left fade" id="update_Category_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog ">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>کټګوري تغیر کړئ</span></h5>
                      <div class="px-4 py-5">
                        <form method="post" class="row g-3 needs-validation" novalidate style="text-align:right;">

                          <div class="col-12">
                             <label for="yourName" class="form-label">آیدي</label>
                            <input type="text" name="update_categ_id" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="update_category_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">

                              <button class="btn btn-primary btn-submit" type="submit" name="update_category">تغیر کول</button>

                            </div>
                          </div>

                        </form>
                      
                      </div>


                    </div>
                  </div>



                </div>
              </div>
            </div>
            <?php

            if (isset($_POST['update_category'])) {
              updateCategory();
            }
            ?>




            <!-- end of edit category modal -->


            <!-- Company modal start here ========================================================================================================================================================================-->

            <div class="modal left fade" id="company" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>! کمپنی اضافه کړی</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">

                          <div class="col-12">
                            <label for="yourName" class="form-label">د کمپنی نوم</label>
                            <input type="text" name="company_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="text-center mt-5">

                            <button class="btn btn-primary btn-submit" type="submit" name="addco">ثبتول</button>

                          </div>
                        </form>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د کمپنی نوم</th>
                              <th>عملیات</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            try {
                              require_once('DBConnection.php');
                              $sql = "SELECT * FROM `company`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                               
                                  echo '<tr data-company-id="' . $row["comp_id"] . '" data-company-name="' . $row["comp_name"] . '">';
                                  echo '<td>' . $row["comp_name"] . '</td>';
                                  echo '<td>
                                          <a class="fa fa-edit text-decoration-none editButtonCompany" href="javascript:void(0);"></a>
                                        </td>';
                                  echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
                                  echo '</tr>';
                                }
                              }
                            } catch (Exception $e) {

                            }

                            ?>
                          </tbody>
                        </table>
                        <script>
 $(document).ready(function() {
  // Handle click event for the editButton using event delegation
  $(document).on('click', '.editButtonCompany', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

    // Find the parent table row and get the category_id and category_name from the data attributes
    var row = $(this).closest('tr');
    var comp_id = row.data('company-id');
    var comp_name = row.data('company-name');
    $('#update_Company_Modal').modal('show');
    $('#company').modal('hide');
    $('#update_Company_Modal input[name="update_company_id"]').val(comp_id);
    $('#update_Company_Modal input[name="update_company_name"]').val(comp_name);
  });
});

</script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['addco'])) {
              addco();
            }
            ?>
            <!-- Company modle end here ====================================================================================================================================================================================================-->
            <!-- edit company modal start here -->

            <div class="modal left fade" id="update_Company_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>! کمپني نوم تغیر کړئ</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">

                          <div class="col-12">
                          <label for="yourName" class="form-label">آیدي</label>
                            <input type="text" name="update_company_id" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">د کمپنی نوم</label>
                            <input type="text" name="update_company_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="text-center mt-5">

                            <button class="btn btn-primary btn-submit" type="submit" name="updatecompany">ثبتول</button>

                          </div>
                        </form>
                      
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['updatecompany'])) {
              updateCompany();
            }
            ?>

            <!-- edit company modal end here -->





            <!-- Company Loan profile start here ========================================================================================================================================================================-->

            <div class="modal left fade" id="loan" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body  card " style="direction:rtl">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <form method="post">
                        <div class="mb-3 mt-3">
                          <label for="email">مشتری</label>
                          <select name="store" id="store" class="form-select form-select-sm">
                            <?php
                            try {
                              $sql = "SELECT person_id,person_name FROM `person`";
                              include('DBConnection.php');
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {

                              } else {
                                echo 'No Customer Information Find';
                              }
                              while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['person_id'] . '">' . $row['person_name'] . '</option>';
                              }
                              //loaned customer id
                              if (isset($_POST['selecte'])) {
                                echo $_POST['selecte'];
                                $_SESSION['selecte'] = $_POST['selecte'];

                              }
                            } catch (Exception $e) {

                            }

                            ?>
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="pwd">مقدار</label>
                          <input type="text" class="form-control" id="loan_quantity" placeholder="" name="loan_quantity"
                            required>
                        </div>
                        <div class="mb-3">
                          <label for="loan_quantity">اداینه</label>
                          <input type="text" class="form-control" id="paid_quantity" placeholder="" name="paid_quantity"
                            required>
                        </div>
                        <div class="mb-3">
                          <label for="paid_quantity">ټوټل</label>
                          <input type="text" class="form-control" id="total_paid" placeholder="" name="total_paid"
                            required>
                        </div>

                        <input type="submit" class="btn btn-success form-control " name="loan" value="Save">
                      </form>

                    </div>
                  </div>
                  <script type="text/javascript">
                    $(document).ready(function () {
                      $('#store').on('change', function () {
                        var selecte = this.value;
                        $.ajax({
                          url: 'admin.php',
                          type: 'post',
                          data: { selecte: selecte },
                          success: function (response) {
                            //alert(selecte);s
                          }
                        });
                      })
                    });
                  </script>
                </div>
              </div>
            </div>

            <?php
            // if (isset($_POST['loan'])) {
            //   laon();
            // }
            ?>
            <!-- Loan profile modle end here ====================================================================================================================================================================================================-->


            <!-- Company bill generation  profile start here ========================================================================================================================================================================-->

            <div class="modal left fade" id="bill" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body  card " style="direction:rtl">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>


                      <form action="">
                        <div class="input-group">
                          <input type="text" class="form-control bill" placeholder="" style="width:90%">
                          <div class="input-group-append ">
                            <span class=" form-control bg-transparent text-warning">
                              <i class="fa fa-search "></i>
                            </span>
                          </div>
                        </div>
                      </form>
                      <div id="billedcustoemr">
                        <div class="row">
                          <div class="col d-flex justify-center">
                            <img src="img/logo.jpg" alt="logo">
                          </div>
                          <div class="col">
                            <p>مسولر تیک ټریډنګ کمپنۍ</p>
                          </div>
                        </div>
                        <div class="billedcustoemr mt-2">

                          <section class="intro mt-2">
                            <div class="bg-image h-100" style="background-color: #f5f7fa;">
                              <div class="mask d-flex align-items-center h-100">
                                <div class="container">
                                  <div class="row justify-content-center">
                                    <div class="col-12">
                                      <div class="card">
                                        <div class="card-body p-0">
                                          <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true"
                                            style="position: relative; height: 700px">
                                            <table class="table table-striped mb-0">
                                             <h1>Nothing to show </h1>

                                            </table>
                                          </div>

                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                              </div>

                            </div>
                          </section>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-primary" id="print" onclick="printDivContents()">Print</button>

                  </div>
                  <style>
                    #billedcustoemr {
                      font-family: Arial, sans-serif;
                    }
                  </style>
                  <script type="text/javascript">
                    window.jsPDF = window.jspdf.jsPDF;
                    function printDivContents(data) {
                      var table = document.getElementById('billedcustoemr');

                      html2canvas(table, {
                        scale: 2, // Increase the scale factor for better image quality
                        dpi: 600, // Increase the DPI for higher resolution
                      }).then(function (canvas) {
                        var imgData = canvas.toDataURL('image/png');
                        var pdf = new jsPDF();
                        var imgProps = pdf.getImageProperties(imgData);
                        var pdfWidth = pdf.internal.pageSize.getWidth();
                        var pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                        pdf.save('downloaded_table.pdf');
                      });
                    }

                  </script>

                  <script type="text/javascript">
                    $(document).ready(function () {

                      $('.bill').keyup(function () {
                        var bill = $(this).val();
                        if (bill != "") {
                          $.ajax({
                            url: "ajax.php",
                            method: "POST",
                            data: { bill: bill },
                            success: function (data) {
                              $(".billedcustoemr").html(data);
                              //alert(bill);
                            }
                          });
                        }
                      });

                    });
                  </script>
                </div>
              </div>
            </div>

            <?php
            // if (isset($_POST['loan'])) {
            //    laon();
            // }
            ?>
            <!-- bill generation profile modle end here ====================================================================================================================================================================================================-->

             <!-- countery modal start here ===============================================================================================================================================================================================================================================-->

             <div class="modal" id="countryModal" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="countery_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="text-center mt-5">

                            <button class="btn btn-primary btn-submit" type="submit" name="addcountery">ثبتول</button>

                          </div>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د هیواد نوم</th>
                              <th>عملیات</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            try {
                              require_once('DBConnection.php');
                              $sql = "SELECT * FROM `country`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                               
                                  echo '<tr data-country-id="' . $row["count_id"] . '" data-country-name="' . $row["count_name"] . '">';
                                  echo '<td>' . $row["count_name"] . '</td>';
                                  echo '<td>
                                          <a class="fa fa-edit text-decoration-none editButtonCountry" href="javascript:void(0);"></a>
                                        </td>';
                                  echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
                                  echo '</tr>';
                                }
                              }
                            } catch (Exception $e) {

                            }

                            ?>
                          </tbody>
                        </table>
                        <script>
 $(document).ready(function() {
  // Handle click event for the editButton using event delegation
  $(document).on('click', '.editButtonCountry', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

    // Find the parent table row and get the category_id and category_name from the data attributes
    var row = $(this).closest('tr');
    var comp_id = row.data('country-id');
    var comp_name = row.data('country-name');
    $('#update_Country_Modal').modal('show');
    $('#country').modal('hide');
    $('#update_Country_Modal input[name="update_country_id"]').val(comp_id);
    $('#update_Country_Modal input[name="update_country_name"]').val(comp_name);
  });
});

</script>


                      </div>


                    </div>
                  </div>


                </div>
              </div>
            </div>

            <?php
            if (isset($_POST['addcountery'])) {
              addcounter();
            }
            ?>

            <!-- adding country modal end here -->

            <!-- edit country modal start here -->

            <div class="modal" id="update_Country_Modal" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                          <label for="yourName" class="form-label">آیدي</label>
                            <input type="text" name="update_country_id" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="update_country_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="text-center mt-5">

                            <button class="btn btn-primary btn-submit" type="submit" name="updatecountry">ثبتول</button>

                          </div>
                        </form>
                        


                      </div>


                    </div>
                  </div>


                </div>
              </div>
            </div>

            <?php
            if (isset($_POST['updatecountry'])) {
              updateCountry();
            }
            ?>

            <!-- edit country modal end here -->

            <!-- edit country modal end here -->

<!-- start of firm model -->
        <div class="modal left fade" id="firm" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Add firm</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="firm_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">ولایت</label>
                            <select class="form-control" id="address" name="address" onchange="address(this.value)">
                              <?php
                              require_once('DBConnection.php');

                              $sql = "SELECT * FROM `province`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                  echo '<option value="' . $row["province_id"] . '">' . $row["province_name"] . '</option>';
                                }

                              }

                              ?>
                            </select>
                            <script type="text/javascript">
                              $(document).ready(function () {
                                $('#address').on('change', function () {
                                  var prov_id = $(this).val();
                                  $.ajax({
                                    url: 'store.php',
                                    method: 'POST',
                                    data: { provID: prov_id },
                                    dataType: "text",
                                    success: function (html) {
                                      $('#district').html(html);
                                    }
                                  });
                                });
                              });
                            </script>
                            <label for="for add" class="form-label">ولسوالی</label>
                            <select id="district" name="district" class="form-control">
                              <option value="">ولسوالی</option>
                            </select>
                            <label for="yourName" class="form-label">کلی</label>
                            <input type="text" name="location_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>

                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="addFirm">ثبتول</button>
                            </div>
                          </div>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د شرکت نوم</th>
                              <th>ولایت</th>
                              <th>ولسوالي</th>
                              <th>کلی/ګذر</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            require_once('DBConnection.php');
                            $sql = "SELECT firm.firm_id,province.province_name,district.district_name,firm.firm_name,address.adress_vilage FROM firm,province,address,district WHERE firm.address_id=address.address_id and address.address_province=province.province_id and address.address_district=district.district_id;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                echo '<tr data-firm-id="' . $row["firm_id"] . '" data-firm-name="' . $row["firm_name"] . '" data-province-name="' . $row["province_name"] . '" data-district-name="' . $row["district_name"] . '" data-village-name="' . $row["adress_vilage"] . '">';
                                echo '<td>' . $row["firm_name"] . '</td>';
                                echo '<td>' . $row["province_name"] . '</td>';
                                echo '<td>' . $row["district_name"] . '</td>';
                                echo '<td>' . $row["adress_vilage"] . '</td>';
                                echo '<td>
                                        <a class="fa fa-edit text-decoration-none editButtonFirm" href="javascript:void(0);"></a>
                                      </td>';
                                echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
                                echo '</tr>';
                              }
                            }
                            ?>
                          </tbody>
                        </table>

                        <script>
 $(document).ready(function() {
  // Handle click event for the editButton using event delegation
  $(document).on('click', '.editButtonFirm', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

    // Find the parent table row and get the category_id and category_name from the data attributes
    var row = $(this).closest('tr');
    var firm_id = row.data('firm-id');
    var province_name = row.data('province-name');
    var firm_name = row.data('firm-name');
    var district_name = row.data('district-name');
    var vilage_name = row.data('village-name');
    $('#update_Firm_Modal').modal('show');
    $('#firm').modal('hide');
    $('#update_Firm_Modal input[name="update_firm_id"]').val(firm_id);
    $('#update_Firm_Modal input[name="update_firm_name"]').val(firm_name);
    $('#update_Firm_Modal input[name="update_firm_address"]').val(province_name);
    $('#update_Firm_Modal input[name="update_firm_district_name"]').val(district_name);
    $('#update_Firm_Modal input[name="update_firm_location_name"]').val(vilage_name);
  });
});

</script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['addUsers'])) {
              addUsers();
            }
            ?>

        <!-- end of firm model -->

        <!-- start of firm udating modal -->
        <div class="modal left fade" id="update_Firm_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>د شرکت تغیرول</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                          <input type="hidden" name="update_firm_id" id="update_firm_id">

                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="update_firm_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">ولایت</label>
                            <select class="form-control" id="update_firm_address" name="update_firm_address" onchange="address(this.value)">
                              <?php
                              require_once('DBConnection.php');

                              $sql = "SELECT * FROM `province`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                  echo '<option value="' . $row["province_id"] . '">' . $row["province_name"] . '</option>';
                                }

                              }

                              ?>
                            </select>
                            <script type="text/javascript">
                              $(document).ready(function () {
                                $('#address').on('change', function () {
                                  var prov_id = $(this).val();
                                  $.ajax({
                                    url: 'store.php',
                                    method: 'POST',
                                    data: { provID: prov_id },
                                    dataType: "text",
                                    success: function (html) {
                                      $('#district').html(html);
                                    }
                                  });
                                });
                              });
                            </script>
                            <label for="for add" class="form-label">ولسوالی</label>
                            <select id="district" name="update_firm_district" class="form-control">
                              <option value="">ولسوالی</option>
                            </select>
                            <label for="yourName" class="form-label">کلی</label>
                            <input type="text" name="update_firm_location_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>

                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="updateFirm">ثبتول</button>
                            </div>
                          </div>
                        </form>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['updateFirm'])) {
              updateFirm();
            }
            ?>




        <!-- end of firm updating modal -->

        <!-- start of users model -->

        <div class="modal left fade" id="users" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Add User</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="first_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">تخلص</label>
                            <input type="text" name="last_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">ایمیل</label>
                            <input type="text" name="user_email" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>

                            <label for="yourName" class="form-label">يوزر نوم</label>
                            <input type="text" name="user_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>

                            <label for="yourName" class="form-label">پاسورد</label>
                            <input type="Password" name="user_password" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">یوزر ټایپ</label>
                            <select class="form-control" id="userType" name="userType" onchange="userType(this.value)">
                              <?php
                              require_once('DBConnection.php');

                              $sql = "SELECT * FROM `user_type`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                  echo '<option value="' . $row["type_id"] . '">' . $row["type_flag"] . '</option>';
                                }

                              }


                              ?>
                              </select>
                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="addUsers">ثبتول</button>
                            </div>
                          </div>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                           
                              <th>نوم</th>
                              <th>صلاحیت</th>

                            </tr>
                          </thead>
                          <tbody>

                          <?php
                          require_once('DBConnection.php');
                          $sql = "SELECT user_id, name, type_flag FROM user INNER JOIN user_type ON user.user_type = user_type.type_id";
                          $result = $conn->query($sql);
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              echo '<tr data-user-id="' . $row["user_id"] . '">';
                              echo '<td>' . $row["name"] . '</td>';
                              echo '<td>' . $row["type_flag"] . '</td>';
                              echo '<td><a class="fa fa-edit text-decoration-none editButton" href="#"></a></td>';
                              echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
                              echo '</tr>';
                            }
                          }
                          ?>

                          </tbody>
                        </table>
                        <script>
  $(document).ready(function() {
    // Handle click event for the editButton using event delegation
    $(document).on('click', '.editButton', function(e) {
      e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

      // Find the parent table row and get the user_id from the data attribute
      var row = $(this).closest('tr');
      var userId = row.data('user-id');

      // Send an AJAX request to fetch the complete user information based on the user_id
      $.ajax({
        url: 'get_user_info.php', // Replace with the PHP script that fetches user info
        method: 'POST',
        data: { user_id: userId },
        dataType: 'json',
        success: function(data) {
          // Now you have the complete user information in the 'data' variable
          // Pre-populate the form in the edit modal with the fetched data
          $('#ed_users').modal('show');
          $('#users').modal('hide');

          // Example: Pre-populate the form fields in the edit modal with the extracted data
          $('#ed_users input[name="ed_user_id"]').val(data.user_id);
          $('#ed_users input[name="ed_first_name"]').val(data.name);
          $('#ed_users input[name="ed_last_name"]').val(data.last_name);
          $('#ed_users input[name="ed_user_email"]').val(data.email);
          $('#ed_users input[name="ed_user_name"]').val(data.username);
          $('#ed_users input[name="ed_user_password"]').val(data.password);
          $('#ed_users select[name="ed_userType"]').val(data.user_type);
        },
        error: function() {
          alert('Error fetching user information.');
        }
      });
    });
  });
</script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['addUsers'])) {
              addUsers();
            }
            ?>
        <!-- end of user model -->



        <!-- start of user editing function -->
        <div class="modal left fade" id="ed_users" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Edit User</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                          <label for="yourName" class="form-label">آیدی</label>
                            <input type="text" name="ed_user_id" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="ed_first_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">تخلص</label>
                            <input type="text" name="ed_last_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">ایمیل</label>
                            <input type="text" name="ed_user_email" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>

                            <label for="yourName" class="form-label">يوزر نوم</label>
                            <input type="text" name="ed_user_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>

                            <label for="yourName" class="form-label">پاسورد</label>
                            <input type="Password" name="ed_user_password" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">یوزر ټایپ</label>
                            <select class="form-control" id="userType" name="userType" onchange="userType(this.value)">
                              <?php
                              require_once('DBConnection.php');

                              $sql = "SELECT * FROM `user_type`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                  echo '<option value="' . $row["type_id"] . '">' . $row["type_flag"] . '</option>';
                                }

                              }


                              ?>
                              </select>
                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="EditUsers">ثبتول</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['EditUsers'])) {
              EditUsers();
            }
            ?>

        <!-- end of editing user form -->


        <!-- start of ourloan model -->
      <div class="modal left fade" id="ourloan" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Add Our Loan</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                          <div class="input-group mt-2">

                          <select class="form-select form-control" name="ourloanfirm">
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
                      <span class="input-group-text">د شرکت نوم</span>
                    </div>

                      <div class="input-group mt-2">
                      <select class="form-select form-control " required name="ourloancurrency_id">
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
                            <label for="yourName" class="form-label">اندازه</label>
                            <input type="text" name="ourloanamount" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="addOurLoan">ثبتول</button>
                            </div>
                          </div>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د شرکت نوم</th>
                              <th>پولي واحد</th>
                              <th>اندازه </th>
                              <th>عمليې</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            try {
                              require_once('DBConnection.php');
                              $sql = "SELECT ourloan.ourloan_id,firm.firm_name,ourloan.loan_amount,currency.currency_name from ourloan,firm,currency where ourloan.firm_id=firm.firm_id and ourloan.currency_id=currency.currency_id;";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                  echo '<tr data-ourloan-id="' . $row["ourloan_id"] . '" data-ourloan-firm-name="' . $row["firm_name"] . '" data-ourloan-currency-name="' . $row["currency_name"] . '" data-ourloan-amount="' . $row["loan_amount"] . '">';
                                  echo '<td>' . $row["firm_name"] . '</td>';
                                  echo '<td>' . $row["currency_name"] . '</td>';
                                  echo '<td>' . $row["loan_amount"] . '</td>';
                                 
                                  echo '<td>
                                          <a class="fa fa-edit text-decoration-none editButtonOurloan" href="javascript:void(0);"></a>
                                        </td>';
                                  echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
                                  echo '</tr>';
                                }
                              }
                              
                            } catch (Exception $e) {

                            }

                            ?>
                          </tbody>
                        </table>
                        <script>
  $(document).ready(function() {
    // Handle click event for the editButton using event delegation
    $(document).on('click', '.editButtonOurloan', function(e) {
      e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

      // Find the parent table row and get the ourloan_id, firm_name, currency_name, and loan_amount from the data attributes
      var row = $(this).closest('tr');
      var ourloan_id = row.data('ourloan-id');
      var firm_name = row.data('ourloan-firm-name');
      var currency_name = row.data('ourloan-currency-name');
      var loan_amount = row.data('ourloan-amount'); // Corrected data attribute name
      
      $('#update_Ourloan_Modal').modal('show');
      $('#ourloan').modal('hide');
      
      $('#update_Ourloan_Modal input[name="update_ourloan_id"]').val(ourloan_id);
      $('#update_Ourloan_Modal input[name="update_ourloan_firm_name"]').val(firm_name);
      $('#update_Ourloan_Modal input[name="update_ourloan_currency_name"]').val(currency_name);
      $('#update_Ourloan_Modal input[name="update_ourloan_amount"]').val(loan_amount);
    });
  });
</script>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['addOurLoan'])) {
              addOurLoan();
            }
            ?>
        <!-- end of ourloan model -->


        <!-- start of edit ourloan modal -->

        <div class="modal left fade" id="update_Ourloan_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>زموږ د قرض تغیر کول</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                          <input type="hidden" name="update_ourloan_id" id="update_ourloan_id">

                          <div class="input-group mt-2">
                         
          

                          <select class="form-select form-control" name="update_ourloan_firm_name">
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
                      <span class="input-group-text">د شرکت نوم</span>
                    </div>

                      <div class="input-group mt-2">
                      <select class="form-select form-control " required name="update_ourloan_currency_id">
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
                            <label for="yourName" class="form-label">اندازه</label>
                            <input type="text" name="update_ourloan_amount" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="updateOurLoan">ثبتول</button>
                            </div>
                          </div>
                        </form>
                    
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['updateOurLoan'])) {
              updateOurLoan();
            }
            ?>


        <!-- end of edit ourloan modal -->


            <!-- start of firm model -->
        <div class="modal left fade" id="firm" data-backdrop="static" data-keyboard="false" tabindex="-1">
              <role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Add firm</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="firm_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">ولایت</label>
                            <select class="form-control" id="address" name="address" onchange="address(this.value)">
                              <?php
                              require_once('DBConnection.php');

                              $sql = "SELECT * FROM `province`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                  echo '<option value="' . $row["province_id"] . '">' . $row["province_name"] . '</option>';
                                }

                              }

                              ?>
                            </select>
                            <script type="text/javascript">
                              $(document).ready(function () {
                                $('#address').on('change', function () {
                                  var prov_id = $(this).val();
                                  $.ajax({
                                    url: 'store.php',
                                    method: 'POST',
                                    data: { provID: prov_id },
                                    dataType: "text",
                                    success: function (html) {
                                      $('#district').html(html);
                                    }
                                  });
                                });
                              });
                            </script>
                            <label for="for add" class="form-label">ولسوالی</label>
                            <select id="district" name="district" class="form-control">
                              <option value="">ولسوالی</option>
                            </select>
                            <label for="yourName" class="form-label">کلی</label>
                            <input type="text" name="location_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="addFirm">ثبتول</button>
                            </div>
                          </div>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د شرکت نوم</th>
                              <th>عملیات</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            require_once('DBConnection.php');
                            $sql = "SELECT * FROM `firm`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                echo '   <tr><td>' . $row["firm_name"] . '</td>
                                    <td><a class="fa fa-edit text-decoration-none" href=""></a>

                                    </td>
                                     <td><a class="fa fa-trash text-decoration-none" href=""></a></td>
                                      </tr>
                                    ';
                              }
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['addFirm'])) {
              addFirm();
            }
            ?>
            <!-- end of firm model ============================================== -->
            <!-- currencey modal start here ============-===================================================================================================================================================================================================================================-->

            <div class="modal left fade" id="currency" data-backdrop="statc" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="currency_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="col-12">
                            <label for="yourName" class="form-label">سمبول</label>
                            <input type="text" name="currency_sign" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="text-center mt-5">

                            <button class="btn btn-primary btn-submit" type="submit" name="addCurrency">ثبتول</button>

                          </div>
                        </form>

                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د پولي واحد نوم</th>
                              <th>د پولي واحد سمبول</th>
                              <th>عملیات</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            try {
                              require_once('DBConnection.php');
                              $sql = "SELECT * FROM `currency`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                  echo '<tr data-currency-id="' . $row["currency_id"] . '" data-currency-name="' . $row["currency_name"] . '" data-currency-symbol="' . $row["currency_symbol"] . '">';
                                  echo '<td>' . $row["currency_name"] . '</td>';
                                  echo '<td>' . $row["currency_symbol"] . '</td>';
                                  echo '<td>
                                          <a class="fa fa-edit text-decoration-none editButtonCurrency" href="javascript:void(0);"></a>
                                        </td>';
                                  echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
                                  echo '</tr>';
                                }
                              }
                              
                            } catch (Exception $e) {

                            }

                            ?>
                          </tbody>
                        </table>
                        <script>
 $(document).ready(function() {
  // Handle click event for the editButton using event delegation
  $(document).on('click', '.editButtonCurrency', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

    // Find the parent table row and get the category_id and category_name from the data attributes
    var row = $(this).closest('tr');
    var currency_id = row.data('currency-id');
    var currency_name = row.data('currency-name');
    var currency_symbol = row.data('currency-symbol');
    $('#update_Currency_Modal').modal('show');
    $('#currency').modal('hide');
    $('#update_Currency_Modal input[name="update_currency_id"]').val(currency_id);
    $('#update_Currency_Modal input[name="update_currency_name"]').val(currency_name);
    $('#update_Currency_Modal input[name="update_currency_sign"]').val(currency_symbol);
  });
});

</script>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['addCurrency'])) {
              addCurrency();
            }

            ?>
            <!-- currency modal end here -->

            <!-- edit currency modal start here -->

            <div class="modal left fade" id="update_Currency_Modal" data-backdrop="statc" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">

                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                          <label for="yourName" class="form-label">آيدي</label>
                            <input type="text" name="update_currency_id" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="update_currency_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="col-12">
                            <label for="yourName" class="form-label">سمبول</label>
                            <input type="text" name="update_currency_sign" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                          </div>
                          <div class="text-center mt-5">

                            <button class="btn btn-primary btn-submit" type="submit" name="updateCurrency">ثبتول</button>

                          </div>
                        </form>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['updateCurrency'])) {
              updateCurrency();
            }

            ?>



            <!-- edit currency modal end here -->

            <!---------------------------------------------------  customers modal start here -------------------------------------------------------------->
            <div class="modal left fade" id="showcustomers" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Customer Profiles</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="unit_name" class="form-control customers" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">

                            </div>
                          </div>
                        </form>
                        <!-- <div id="cc" class="ccc">cddd</div>   -->
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead id="cc">
                            <tr>


                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            try {
                              require_once('DBConnection.php');
                              $sql = "SELECT * FROM `person` ORDER BY person_id DESC LIMIT 10;";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                }
                              }
                            } catch (Exception $e) {

                            }

                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <script type="text/javascript">
              // Live sarch with
              $(document).ready(function () {
                $('.customers').keyup(function () {
                  var customers = $(this).val();
                  $.ajax({
                    url: 'ajax.php',
                    method: 'POST',
                    data: { customers: customers },
                    success: function (data) {
                      //  alert(customers);
                      $('#cc').html(data);
                    }
                  });
                });
              });
            </script>
            <!---------------------------------------------------  customers modal end here -------------------------------------------------------------->

            <!-- adding  unit modal start  here ==================================================================================================================================================================================================================================================-->

            <div class="modal left fade" id="unit" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Add Unit</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="unit_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="addUnit">ثبتول</button>
                            </div>
                          </div>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د کمپنی نوم</th>
                              <th>عملیات</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            require_once('DBConnection.php');
                            $sql = "SELECT * FROM `unit`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                echo '<tr data-unit-id="' . $row["unit_id"] . '" data-unit-name="' . $row["unit_name"] . '">';
                                echo '<td>' . $row["unit_name"] . '</td>';
                                echo '<td>
                                        <a class="fa fa-edit text-decoration-none editButtonUnit" href="javascript:void(0);"></a>
                                      </td>';
                                echo '<td><a class="fa fa-trash text-decoration-none" href=""></a></td>';
                                echo '</tr>';
                              }
                            }
                            ?>
                          </tbody>
                        </table>
                        <script>
 $(document).ready(function() {
  // Handle click event for the editButton using event delegation
  $(document).on('click', '.editButtonUnit', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)

    // Find the parent table row and get the category_id and category_name from the data attributes
    var row = $(this).closest('tr');
    var unit_id = row.data('unit-id');
    var unit_name = row.data('unit-name');
    $('#update_Unit_Modal').modal('show');
    $('#unit').modal('hide');
    $('#update_Unit_Modal input[name="update_unit_id"]').val(unit_id);
    $('#update_Unit_Modal input[name="update_unit_name"]').val(unit_name);
  });
});

</script>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['addUnit'])) {
              addUnit();
            }
            ?>
            <!-- adding unit modal end here=================================================================================================================================================================================================================================================== -->
 
            <!-- updating unit modal start here -->
            <div class="modal left fade" id="update_Unit_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>د یونت تغیرول</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                          <label for="yourName" class="form-label">آیدي</label>
                            <input type="text" name="update_unit_id" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="update_unit_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="updateUnit">ثبتول</button>
                            </div>
                          </div>
                        </form>
                     
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
            <?php
            if (isset($_POST['updateUnit'])) {
              updateUnit();
            }
            ?>

            <!-- updating unit modal end here -->




            <!-- store here ==================================================================================================================================================================================================================================================-->

            <div class="modal left fade" id="store" data-backdrop="static" data-keyboard="false" tabindex="-1"
              role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="col">
                    <div class="modal-body ">
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      <h5 class="card-title text-center"><span>Add Store</span></h5>
                      <div class="px-4 py-5">
                        <form class="row g-3 needs-validation" novalidate style="text-align:right;" method="post">
                          <div class="col-12">
                            <label for="yourName" class="form-label">نوم</label>
                            <input type="text" name="store_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>
                            <label for="yourName" class="form-label">سټور ادرس</label>
                            <select class="form-control" id="address" name="address" onchange="address(this.value)">
                              <?php
                              require_once('DBConnection.php');

                              $sql = "SELECT * FROM `province`";
                              $result = $conn->query($sql);
                              if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                  echo '<option value="' . $row["province_id"] . '">' . $row["province_name"] . '</option>';
                                }

                              }

                              ?>
                            </select>
                            <script type="text/javascript">
                              $(document).ready(function () {
                                $('#address').on('change', function () {
                                  var prov_id = $(this).val();
                                  $.ajax({
                                    url: 'store.php',
                                    method: 'POST',
                                    data: { provID: prov_id },
                                    dataType: "text",
                                    success: function (html) {
                                      $('#district').html(html);
                                    }
                                  });
                                });
                              });
                            </script>
                            <label for="for add" class="form-label">ولسوالی</label>
                            <select id="district" name="district" class="form-control">
                              <option value="">ولسوالی</option>
                            </select>
                            <label for="yourName" class="form-label">کلی</label>
                            <input type="text" name="location_name" class="form-control" id="" required>
                            <div class="invalid-feedback">Please,bill id!</div>

                            <div class="text-center mt-5">
                              <button class="btn btn-primary btn-submit" type="submit" name="addStore">ثبتول</button>
                            </div>
                          </div>
                        </form>
                        <table class="table table-borderless align-middle mb-0 bg-white table-hover mt-2"
                          style="direction:rtl" class="card">
                          <thead>
                            <tr>
                              <th>د کمپنی نوم</th>
                              <th>عملیات</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php
                            // require_once('DBConnection.php');
                            // $sql = "SELECT * FROM `store`";
                            // $result = $conn->query($sql);
                            // if ($result->num_rows > 0) {
                            //   while ($row = $result->fetch_assoc()) {
                            //     echo '   <tr><td>' . $row["store_name"] . '</td>
                            //         <td><a class="fa fa-edit text-decoration-none" href=""></a>
                            
                            //         </td>
                            //          <td><a class="fa fa-trash text-decoration-none" href=""></a></td>
                            //           </tr>
                            //         ';
                            //   }
                            // }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
            <?php
            // if (isset($_POST['addStore'])) {
            //   addStore();
            // }
            ?>
            <div class="col d-flex justify-content-end">

              <div class="btn-group  d-flex justify-content-center">
                <button type="button" class="bi- btn btn-sm  dropdown-toggle" data-toggle="dropdown" id="viewbtn" style="border: 2px solid #f5bf42; margin-right:10px;">ښکاره
                  کول</button>
                <div class="dropdown-menu dropdown-menu-right" id="view">
                  <a class="dropdown-item" href="admin.php?view=1">1</a>
                  <a class="dropdown-item" href="admin.php?view=5">5</a>
                  <a class="dropdown-item" href="admin.php?view=10">10</a>
                  <a class="dropdown-item" href="admin.php?view=20">20</a>
                  <a class="dropdown-item" href="admin.php?view=30">30</a>
                </div>
              </div>
              <script type="text/javascript">
                $(document).ready(function () {
                  $('#view').change(function () {
                    var quantity = $('#view :selected').text();
                    alert(quantity);
                  });

                });
              </script>
              <div class="btn-group  d-flex justify-content-center">
                <button type="button" class="btn btn-sm  dropdown-toggle" data-toggle="dropdown" style="border: 2px solid #f5bf42;">ترتیبول</button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="#">وروستی مخصولات</a>
                  <a class="dropdown-item" href="#">نوی مخصولات </a>
                  <a class="dropdown-item" href="#">تحفیف شوی محصولات</a>
                </div>
              </div>
            </div>
            <div class="row" style="text-align: right;">
              <div class="col-lg-6 card " style="text-align: right;">
                <table class="table table-bordered border-primary text-center" style="text-align:center">
                  <thead class="overflow-auto h-100">
                    <h5 class="card-title">تر ټول ډیر خرڅ شوی <span>| نن</span></h5>
                    <tr class="">
                      <th>کتګوري</th>
                      <th>هیواد</th>
                      <th>کمپنی</th>
                      <th>قدرت</th>
                      <th>واحد</th>
                      <th>ټوټل</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    try {
                      $lint = 1;
                      if (isset($_GET['view'])) {
                        $lint = $_GET['view'];
                      }
                      $sql = "SELECT category.categ_name, country.count_name,company.comp_name,customers_bys_goods.unit_amount,unit.unit_name,SUM(customers_bys_goods.quantity) as totalsaled from customers_bys_goods,category,country,company,currency,person,unit WHERE customers_bys_goods.categ_id=category.categ_id and country.count_id=customers_bys_goods.count_id and customers_bys_goods.comp_id=company.comp_id and customers_bys_goods.currency_id=currency.currency_id and customers_bys_goods.unit_id=unit.unit_id and customers_bys_goods.person_id=person.person_id GROUP BY categ_name,comp_name,count_name ORDER BY totalsaled DESC LIMIT 3;";
                      include('DBConnection.php');
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          echo '  <tr>
                                                    <td>' . $row["categ_name"] . '</td>
                                                    <td>' . $row["count_name"] . '</td>
                                                    <td>' . $row["comp_name"] . '</td>
                                                    <td>' . $row["unit_amount"] . '</td>
                                                    <td>' . $row["unit_name"] . '</td>
                                                    <td>' . $row["totalsaled"] . '</td>
                                                 </tr>';
                        }
                      }
                    } catch (Exception $e) {


                    }
                    ?>
                  </tbody>
                </table>
                
              </div>
              <div class="col-lg-6 card" style="direction:rtl; text-align: right;">
                <h5 class="card-title">وروستی خرڅ شوی مخصولات<span>| نن</span></h5>
    
            <div class="panel">
                <div class="panel-heading">
                    <div class="row" style=" background: ;">
                        
                        <div class="col-sm-9 col-xs-12 text-right" style=" background: #2980b9;">
                            <div class="btn_group">
                                <input type="text" class="form-control" placeholder="Search" id="searchOnrecent">
                                <button class="btn btn-default" title="Reload"><i class="fa fa-refresh"></i></button>
                                <!-- <button class="btn btn-default" title="Pdf"><i class="fa fa-file-pdf"></i></button>
                                <button class="btn btn-default" title="Excel"><i class="fas fa-file-excel"></i></button> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body table-responsive" style="max-height: 200px; overflow-y: auto;">
                    <table class="table">
                        <thead>
                        <tr class="">
                            <th>نوم</th>
                            <th>د خرځ بیه</th>
                            <th>تاریخ</th>
                            <th>دمشتری آیدی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody id="recentTableBody">
                            <tr>
                            <?php recentlly(); ?>
                            </tr>     
                        </tbody>
                    </table>
                </div>
                <script type="text/javascript">
              $(document).ready(function () {
                $('#searchOnrecent').keyup(function () {
                  var search_term = $(this).val();
                  // alert(customerhistory);
                  $.ajax({
                    url: "recentllySellItems.php",
                    method: "GET",
                    data: { search_term: search_term },
                    success: function (data) {
                      $("#recentTableBody").empty();
                      $("#recentTableBody").append(data);
                    
                      
                    }
                  });
                });
              });
            </script>
                <div class="panel-footer">
                   
                        
                        <!-- <div class="col-sm-6 col-xs-6" style="background-color:#2980b9">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                       
                    </div> -->
                </div>
            </div>
        </div>
    </div>

          

              <!-- ================================================================================================================================================chart start here -->
              <div class="col-lg-6 card">
                <canvas id="product" style="width:100%;max-width:600px; lis"></canvas>
                <?php
                $sql = "select category.categ_name,sum(customers_bys_goods.quantity) from category,customers_bys_goods WHERE category.categ_id=customers_bys_goods.categ_id GROUP BY category.categ_name;";
                include('DBConnection.php');
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                  $data = array();
                  foreach ($result as $value) {
                    $ydata[] = $value["sum(customers_bys_goods.quantity)"];
                    $xcate_name[] = $value["categ_name"];
                  }
                }
                ?>
                <script>
                  var xValues = <?php echo json_encode($xcate_name) ?>;
                  var yValues = <?php echo json_encode($ydata); ?>;
                  var barColors = ["red", "green", "blue", "orange", "brown"];

                  new Chart("product", {
                    type: "bar",
                    data: {
                      labels: xValues,
                      datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                      }]
                    },
                    options: {
                      legend: { display: false },
                      title: {
                        display: true,
                        text: "تول خرڅ شوی مخصولات"
                      }
                    }
                  });
                </script>
              </div>
              <div class="col-lg-6 card">
                <canvas id="exsitedproduct" style="width:100%;max-width:600px"></canvas>
                <?php
                try {
                  include('DBConnection.php');
                  $sql = "select category.categ_name,sum(customers_bys_goods.quantity) from category,customers_bys_goods WHERE category.categ_id=customers_bys_goods.categ_id GROUP BY category.categ_name;";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $data = array();
                    foreach ($result as $value) {
                      $data[] = $value["sum(customers_bys_goods.quantity)"];
                      $cate_name[] = $value["categ_name"];
                    }
                  } else {
                    echo "no data found";
                  }
                } catch (Exception $e) {

                }

                ?>

                <script>

                  var xValues = <?php echo json_encode($cate_name) ?>;
                  var yValues = <?php echo json_encode($data); ?>;
                  var barColors = [
                    "#b91d49",
                    "#256D85",
                    "#231955",
                    "1363DF",
                    "#D61C4E",
                    "#277BC0",
                    "#38E54D",
                    "#B73E3E",
                    "#00aba9",
                    "#2b5797",
                    "#e8c3b9",
                    "#FFFF00",
                    "#1e7145",
                    "#1B2430"
                  ];

                  new Chart("exsitedproduct", {
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
                        text: "موجود محصولات"
                      }
                    }
                  });
                </script>
              </div>

            </div>

          </div>
          <!-- chart=================================================================================================================================strat-->
          <div class="modal fade" id="product">
            <div class="modal-dialog ">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="text-align: right;">
                  <h4 class="modal-title text-center w-100 ">ْنوی محلول اضافه کړی</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>


                <div class="modal-body">
                  <div class="card">
                    <form class="">


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
                        <select class="form-select form-control " required name="category_id">
                          <option>....</option>
                          <option>افغانی</option>
                          <option>دالر</option>
                          <option>کلدار</option>

                        </select>
                        <span class="input-group-text">کټګوری</span>
                      </div>

                      <div class="input-group mt-2">
                        <select class="form-select form-control " required name="country_id">
                          <option>....</option>
                          <option>افغانی</option>
                          <option>دالر</option>
                          <option>کلدار</option>

                        </select>
                        <span class="input-group-text">هیواد</span>
                      </div>

                      <div class="input-group mt-2">
                        <select class="form-select form-control " required name="company_id">
                          <option>....</option>
                          <option>افغانی</option>
                          <option>دالر</option>
                          <option>کلدار</option>

                        </select>
                        <span class="input-group-text">کمپنی</span>
                      </div>
                      <div class="input-group mt-2">
                        <select class="form-select form-control " required name="company_id">
                          <option>....</option>
                          <option>افغانی</option>
                          <option>دالر</option>
                          <option>کلدار</option>

                        </select>
                        <span class="input-group-text">یونټ</span>
                      </div>

                      <div class="input-group mt-2">
                        <input type="file" class="form-control" required placeholder="" name="buy_price">
                        <span class="input-group-text">انځور</span>
                      </div>

                      <div class="input-group mt-2">
                        <button class="form-control btn btn-success" name="submit">ثیتول</button>
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
          <!-- product modal =================================== end============================================================================= -->
      </main>
      <aside class="col-sm-3 flex-grow-sm-1 flex-shrink-1 flex-grow-0 sticky-top pb-sm-0 pb-3"
        style="text-align:right; z-index: 1;">
        <div class="rounded-3 p-1 h-100 sticky-top" style="height: 100%; ">
          <ul class="nav nav-pills flex-sm-column flex-row mb-auto justify-content-between "
            style="background-color:#07264a; color:#ffffff">

            <li  style="color:#ff;">
              <a href="#" class="nav-link px-2 " style="color:#fff;">
                <span class="d-none d-sm-inline">Dashboard</span>
                <i class="bi bi-speedometer fs-5"></i>

              </a>
            </li>
            <li>
              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#catagory"
                style="text-align:righ; color:#c8c8d2">
                <span class="d-none d-sm-inline">Catagory</span>
                <i class="bi bi-diagram-3" style="font-size:22px;"></i>
              </a>
            </li>
            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#company"
                style="text-align:righ;color:#c8c8d2">
                <span class="d-none d-sm-inline">Company</span>
                <i class="bi bi-c-square-fill" style="font-size:22px;"></i>
              </a>
            </li>
            <li>

              <a href="admin/" class=" nav-link px-2 text-truncate" data-bs-toggle="modal"
                data-bs-target="#countryModal" style="text-align:righ;color:#c8c8d2">
                <span class="d-none d-sm-inline">Country</span>
                <i class="bi bi-bricks fs-5"></i>
              </a>
            </li>
            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#currency"
                style="text-align:righ; color:#c8c8d2">
                <span class="d-none d-sm-inline">currency</span>
                <i class="fa fa-money" style="font-size:22px;"></i>
              </a>
            </li>
            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#unit"
                style="text-align:righ;color:#c8c8d2">
                <span class="d-none d-sm-inline">unit</span>
                <i class="bi bi-bricks fs-5"></i>
              </a>
            </li>
            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#ourloan"
                style="text-align:righ;color:#c8c8d2">
                <span class="d-none d-sm-inline">OurLoan</span>
                <i class="bi bi-shop fs-5"></i>
              </a>
            </li>


            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#users"
                style="text-align:righ;color:#c8c8d2">
                <span class="d-none d-sm-inline">Users</span>
                <i class="bi bi-shop fs-5"></i>
              </a>
            </li>


            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#firm"
                style="text-align:righ;color:#c8c8d2">
                <span class="d-none d-sm-inline">Firm</span>
                <i class="bi bi-shop fs-5"></i>
              </a>
            </li>

            <li>
              <a href="goods.php" class="nav-link px-2 text-truncate" style="color:#c8c8d2">
                <span class="d-none d-sm-inline">Products</span>
                <i class="bi bi-cart-plus fs-5" style=""></i>
              </a>
            </li>

            <li>
              <a href="#" class="nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#bill" style="color:#c8c8d2">
                <span class="d-none d-sm-inline">Bill</span>
                <i class="bi bi-receipt fs-5"></i>
              </a>
            </li>
            <li>
            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#loan"
                style="text-align:righ; color:#c8c8d2">
                <span class="d-none d-sm-inline">Loan</span>
                <i class="bi bi-shop fs-5"></i>
              </a>
            </li>
            <li>

              <a href="#" class=" nav-link px-2 text-truncate" data-bs-toggle="modal" data-bs-target="#showcustomers"
                style="text-align:righ;color:#c8c8d2">
                <span class="d-none d-sm-inline">Customers</span>
                <i class="fa fa-user fs-5"></i>
              </a>
            </li>
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

    </div>
    <!-- Shop Sidebar End -->
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
  <script src="js/edit.js"></script>

  // edit.js



</body>

</html>