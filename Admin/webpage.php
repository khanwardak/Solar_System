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
function showPosts()
{
  include('DBConnection.php');
  $sqlShowPost = "SELECT * FROM `post` WHERE isDelete = '0' ORDER BY post_id DESC LIMIT 9";
  try {
    $showPostResult = $conn->query($sqlShowPost);
    if ($showPostResult->num_rows > 0) {
      while ($row = $showPostResult->fetch_assoc()) {
        echo '<tr data-post-id="' . $row["post_id"] . '" data-post-title="' . $row["post_title"] . '" data-post-text="' . $row["post_text"] . '" data-image="' . $row["post_img"] . '" style="color:black">
       <td style="color:black">' . $row["post_id"] . '</td>
       <td style="color:black">' . $row["post_title"] . '</td>
       <td style="color:black"><a class="fa fa-trash text-decoration-none deletePost" href="javascript:void(0);" style="color:red"></a>
      <a class="fa fa-edit text-decoration-none editPost" href="javascript:void(0);" style="color:blue"></a></td>
       </tr>';

      }
    }
  } catch (Exception $e) {
    echo 'Please Try agin!' . $e;
  }
}

// upade post start here 
?>
<?php
function showService()
{
  try {
    include('DBConnection.php');
    $sqlShowService = "SELECT * FROM `service` WHERE isDelete = '0'";
    $sqlShowServiceResult = $conn->query($sqlShowService);
    if ($sqlShowServiceResult->num_rows > 0) {
      while ($row = $sqlShowServiceResult->fetch_assoc()) {
        echo '<tr data-service-id="' . $row["service_id"] . '" data-service-title="' . $row["service_title"] . '" data-service-text="' . $row["service_text"] . '" data-image="' . $row["service_img"] . '" style="color:black">
        <td style="color:black">' . $row["service_id"] . '</td>
        <td style="color:black">' . $row["service_title"] . '</td>
        <td style="color:black"><a class="fa fa-trash text-decoration-none deleteservice" href="javascript:void(0);" style="color:red"></a>
       <a class="fa fa-edit text-decoration-none editservice" href="javascript:void(0);" style="color:blue"></a></td>
        </tr>';
      }
    }
  } catch (Exception $e) {
    echo $e;
  }
}
?>
<!-- show showTeamMembers start -->
<?php

function showTeamMembers()
{
  include('DBConnection.php');
  try {
    $sqlShowTeamMebers = "SELECT * FROM `team_members` WHERE isDelete =0";
    $showTeamMemberResult = $conn->query($sqlShowTeamMebers);
    if ($showTeamMemberResult->num_rows > 0) {
      while ($row = $showTeamMemberResult->fetch_assoc()) {
        echo '<tr data-member-id ="' . $row['team_member_id'] . '" 
                  data-member-fullname="' . $row['team_member_fullName'] . '"
                  data-member-mob="' . $row['team_member_mob'] . '"
                  data-member-skills ="' . $row['team_member_skills'] . '"
                  data-member-fa-acc ="' . $row['team_member_fa_acc'] . '"
                  data-member-image ="' . $row['team_member_img'] . '"
                style="color:black">
                <td style="color:black">' . $row['team_member_id'] . '</td>
                <td style="color:black">' . $row['team_member_fullName'] . '</td>
                <td style="color:black"><a class="fa fa-trash text-decoration-none deleteMember" href="javascript:void(0);" style="color:red"></a>
                <a class="fa fa-edit text-decoration-none editTeamMember" href="javascript:void(0);" style="color:blue"></a></td>          
              </tr>';
      }
    }
  } catch (Exception $e) {

  }
}
?>
<!-- showTeamMembers end -->

<!-- show pages headers start -->
<?php
function showPageHeaders()
{
  try {
    include('DBConnection.php');
    $sqlShowPageHeaders = "SELECT * FROM `pagesheader` WHERE isDelete ='0' ORDER BY `page_header_id`  DESC LIMIT 10";
    $showPageResult = $conn->query($sqlShowPageHeaders);
    if ($showPageResult->num_rows > 0) {
      while ($row = $showPageResult->fetch_assoc()) {
        echo
          '<tr
            data-page-name ="'.$row['page_name'].'"
            data-pageheader-title="'.$row['page_header_title'].'"
            data-header-text="'.$row['page_header_text'].'"
            data-pageheader-id = "'.$row['page_header_id'].'"
          >
              <td>'.$row['page_header_title'].'</td>
              <td>'.$row['page_name'].'</td>
              <td style="color:black"><a class="fa fa-trash text-decoration-none deletpageHeader" href="javascript:void(0);" style="color:red"></a>
                <a class="fa fa-edit text-decoration-none editPagesHeader" href="javascript:void(0);" style="color:blue"></a></td>
            </tr>';
      }
    }
  } catch (Exception $e) {
    echo $e;
  }
}
?>
<!-- show pages header end -->
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
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="admin.css?verssion=10">
  <link rel="stylesheet" type="text/css" href="webpage.css?verssion=10">
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
  <script src='webpages.js'></script>
  <script src="createService.js"></script>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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

    <div class="row">

      <main class="col-lg-9 col-md-8 col-sm-3 overflow-auto h-100">
        <!-- web page contents start -->
        <div class="container-fluid" style=" direction:rtl" style="background-color:#fff">
          <div class="row">

            <div class="icon-tab col-xs-12 col-sm-2 ">
              <span class="glyphicon glyphicon-edit"></span>
              <span class="icon-label">پوسټ</span>
            </div>
            <div class="icon-tab col-xs-12 col-sm-2">
              <span class="glyphicon glyphicon-user"></span>
              <span class="icon-label">د ټیم غړی</span>
            </div>
            <div class="icon-tab col-xs-12 col-sm-2">
              <span class="glyphicon glyphicon-gift"></span>
              <span class="icon-label">خدمات</span>
            </div>
            <div class="icon-tab col-xs-12 col-sm-2">
              <span class="fa fa-diagram-project"></span>
              <span class="icon-label">پروژې</span>
            </div>
            <div class="icon-tab col-xs-12 col-sm-2">
              <span class="fa fa-diagram-project"></span>
              <span class="icon-label">د صفحاتو هیډ</span>
            </div>
            <div class="icon-tab col-xs-12 col-sm-2">
              <span class="fa fa-diagram-project"></span>
              <span class="icon-label">د صفحاتو هیډ</span>
            </div>
          </div>
        </div>

        <!-- Your elements -->
        <div class="item col-sm-10 col-sm-offset-1 bg-light" style=" direction:rtl;background-color:red">
          <div class="panel panel-default" style=" direction:rtl; text-align:right;background-color:#fff">

            <div class="panel-body" style="background-color:#fff">

              <!-- Add the collapsible content -->

              <div class="row">
                <div class="col" style="">
                  <div class="">
                    <form id="post" class="postes" method="post" style="background-color:#fff; width:98%"
                      enctype="multipart/form-data">

                      <div class="form-group mt-8 bg-light">
                        <label>عنوان: </label>
                        <input type="text" name="post_titlet" class="form-control bg-light"
                          placeholder="عنوان دلته ولیکئ" required style="border solide 1px black">
                      </div>
                      <div class="form-group mt-8">
                        <label>متن: </label>
                        <textarea class="form-controle" name="post_text" id="" cols="58" rows="10"
                          placeholder="متن دلته ولیکئ " required>

                          </textarea>
                      </div>

                      <div class="input-group">
                        <input type="file" class="form-control" required placeholder="" name="image">
                        <input type="hidden" name="post_id" value="">

                        <span class="input-group-text">انځور</span>
                      </div>
                      <button class="btn btn-success createPost">پوسټ</button>
                      <button class="btn btn-primary  updatePost" style=" display:none">Update</button>
                    </form>

                  </div>

                </div>
                <div class="col" style="width:background-color:#ff">
                  <form class="mt-2 search" style="width:98%">
                    <label>پلټڼه</label>
                    <input type="text" placeholder="search" class="form-control">

                  </form>
                  <div class="table-responsice mt-2">
                    <table class="table table-hover mt-">
                      <thead class="table" style="background-color:#36566e">
                        <tr style="background-color:#36566e;color:#fff">
                          <td>عنوان</td>
                          <td>متن</td>
                          <td>عملیات</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php echo showPosts(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- add team members start -->
        <div class="item col-sm-10 col-sm-offset-1" style=" direction:rtl; text-align:right">
          <div class="panel panel-default" style=" direction:rtl">

            <div class="panel-body">
              <div class="row">
                <div class="col">
                  <form class="addTeam" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                      <label for="name" class="form-label">مکمل نوم</label>
                      <input type="text" class="form-control" id="name" name="fullName">

                    </div>
                    <div class="mb-3">
                      <label for="skills" class="form-label">مهارتونه</label>
                      <textarea name="team_member_skills" class="form-control" name="team_member_skills" id="skills"
                        cols="30" rows="10">

                      </textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="fa_acc">فسبوک اکاونټ لینک</label>
                      <input type="text" class="form-control" id="fa_acc" name="fa_acc">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="mob">موبایل شمره</label>
                      <input type="text" class="form-control" id="mob" name="mob">
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="img">انځور</label>
                      <input type="file" class="form-control" id="img" name="team_mermber_img">
                    </div>
                    <input class="hidden" name="member_id">
                    <button class="btn btn-success addTeamMember" name="addTeamMember">ثبتول</button>
                    <button class="btn btn-primary updateTeamMember" name="addTeamMember"
                      style="display:none">تغیرول</button>
                  </form>
                </div>
                <div class="col">
                  <table class="table table-hover">
                    <thead style="background-color:#36566e">
                      <tr style="background-color:#36566e">
                        <td>نمبر</td>
                        <td>نوم</td>
                        <td>عملیات</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php echo showTeamMembers(); ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- add team members end -->
        <div class="item col-sm-10 col-sm-offset-1" style=" direction:rtl; text-align:right">
          <div class="panel panel-default" style=" direction:rtl">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col" style="">
                  <form method="post" enctype="multipart/form-data" id="service" class="hhh"
                    style="background-color:#fff; width:98%">
                    <div class="form-group mt-8 bg-light">
                      <label>عنوان: </label>
                      <input type="text" name="service_titled" class="form-control bg-light"
                        placeholder="عنوان دلته ولیکئ" required style="border solide 1px black">
                    </div>
                    <div class="form-group mt-8">
                      <label>متن: </label>
                      <textarea class="form-control" name="service_textd" id="" cols="58" rows="10"
                        placeholder="متن دلته ولیکئ" required></textarea>
                    </div>
                    <div class="input-group mt-2">
                      <input type="file" class="form-control" required placeholder="" name="service_imaged">
                      <input type="hidden" name="service_id" value="">
                      <span class="input-group-text">انځور</span>
                    </div>
                    <button class="btn btn-success createService">خدمات ثبت کړی</button>
                    <button class="btn btn-primary updateService" style=" display:none">تغیرول</button>
                  </form>

                </div>
                <div class="col" style="width:background-color:#ff">
                  <form class="mt-2 serviceSearch" style="width:98%">
                    <label>پلټڼه</label>
                    <input type="text" placeholder="search" class="form-control">

                  </form>
                  <div class="table-responsice mt-2">
                    <table class="table table-hover mt-">
                      <thead class="table" style="background-color:#36566e">
                        <tr style="background-color:#36566e;color:#fff">
                          <td>عنوان</td>
                          <td>متن</td>
                          <td>عملیات</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php echo showService(); ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="item col-sm-10 col-sm-offset-1" style=" direction:rtl; text-align:right">
          project
        </div>
        <div class="item col-sm-10 col-sm-offset-1" style=" direction:rtl; text-align:right">
          <div class="row">
            <div class="col">
              <form class="pageHeader" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="header_title" class="form-label">هیډر عنوان</label>
                  <input type="text" class="form-control" id="header_title" name="header_title">

                </div>
                <div class="mb-3">
                  <label for="header_tex" class="form-label">هیډر متن</label>
                  <textarea name="header_text" class="form-control"  id="header_tex" cols="30" rows="10">

                      </textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="page">صفحه انتخاب کړی</label>
                  <select name="page" id="page" class="form-control">
                    <option value="1">خدمات</option>
                    <option value="2">ټیم</option>
                    <option value="3">پروژې</option>
                    <option value="4">ځانګړتیاوې</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="header_img">انځور</label>
                  <input type="file" class="form-control" id="header_img" name="header_img">
                </div>
                <input class="hidden" name="page_header_id">
                <button class="btn btn-success addPageHeader" name="addPageHeader">ثبتول</button>
                <button class="btn btn-primary updatePageHeader" name="updataddPageHeader"
                  style="display:none">تغیرول</button>
              </form>
            </div>
            <div class="col">
              <table class="table table-hover mt-">
                <thead class="table" style="background-color:#36566e">
                  <tr style="background-color:#36566e;color:#fff">
                    <td>عنوان</td>
                    <td>صفحه</td>
                    <td>عملیات</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                     echo showPageHeaders()

                    ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="item col-sm-10 col-sm-offset-1" style=" direction:rtl; text-align:right">
          pageHeaders1
        </div>
        <!-- tab-contents end -->
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
  <script>
    $(function () {
      $('div.icon-tab').click(function () {
        $(this).addClass('active').siblings().removeClass('active');
        setDisplay(450);
      });

      function setDisplay(time) {
        $('div.icon-tab').each(function (rang) {
          $('.item').eq(rang).css('display', 'none');

          if ($(this).hasClass('active')) {
            $('.item').eq(rang).fadeIn(time);
          }
        });
      }

      //Disable the animation on page load
      setDisplay(0);
    });
  </script>
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