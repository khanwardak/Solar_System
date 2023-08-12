<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Solartech</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
  

 

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/aos/3.0.0-beta.6/aos.js"></script>	

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
 <script>
    AOS.init();
  </script>
<body >
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> -->
    <!-- Spinner End -->


    <!-- Topbar Start -->
  <?php include('header.php') ?>
    <!-- Navbar End -->


    <!-- Carousel Start -->
 
    <div class="container-fluid p-0 pb-5 wow fadeIn" data-wow-delay="0.1s align-items-center ">
        <div class="owl-carousel header-carousel position-relative">
        <?php 
    include('Admin/DBConnection.php');
    $sqlSowSilderInfo="SELECT * FROM post WHERE isDelete = '0' ORDER BY post_id DESC LIMIT 3";
    try{
        $showSilderInfoResult = $conn->query($sqlSowSilderInfo);
        if($showSilderInfoResult -> num_rows>0){
            while($row = $showSilderInfoResult->fetch_assoc()){
               echo 'Admin'.'/'.trim($row['post_img']);
                echo ' <div class="owl-carousel-item position-relative" data-dot="<img src="Admin'.'/'.trim($row['post_img']).'">
                <img class="img-fluid" src=Admin'.'/'.trim($row['post_img']).' alt="" style="max-height: 800px;">
                <div class="owl-carousel-inner">
                    <div class="container">
                        <div class="row justify-content-end" style="text-align: right;">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-2 text-white animated slideInDown"> '.$row["post_title"].'</h1>
                                <p class="text-white animated slideInDown">'.$row['post_text'].'</p>
                                <a href="" class="btn btn-primary rounded-pill py-3 px-5 animated slideInLeft">نور</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            }
               
        }
        else{
            echo "jdhfkjhdfn";
        }
    }catch(Exception $e){
        echo 'Please Try agin'.$e;
    }

    ?>
        
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Feature Start -->
    <div class="container-xxl py-5" style="direction: rtl;">
        <div class="container">
            <div class="row g-5">
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-lg-square bg-primary rounded-circle me-3">
                            <i class="fa fa-users text-white"></i>
                        </div>
                        <h1 class="mb-0" data-toggle="counter-up">3453</h1>
                    </div>
                    <h5 class="mb-3">د مشتریانو رضایت</h5>
                    <span>سولر تیک انرجی</span>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-lg-square bg-primary rounded-circle me-3">
                            <i class="fa fa-check text-white"></i>
                        </div>
                        <h1 class="mb-0" data-toggle="counter-up">4234</h1>
                    </div>
                    <h5 class="mb-3">پروژې</h5>
                    <span>سولر تیک انرجی شوې پروژې</span>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-lg-square bg-primary rounded-circle me-3">
                            <i class="fa fa-award text-white"></i>
                        </div>
                        <h1 class="mb-0" data-toggle="counter-up">3123</h1>
                    </div>
                    <h5 class="mb-3">لاس ته راوړنې</h5>
                    <span>د سولر تیک انرجی شرکت لاس ته راوړنې</span>
                </div>
                <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                    <div class="d-flex align-items-center mb-4">
                        <div class="btn-lg-square bg-primary rounded-circle me-3">
                            <i class="fa fa-users-cog text-white"></i>
                        </div>
                        <h1 class="mb-0" data-toggle="counter-up">1831</h1>
                    </div>
                    <h5 class="mb-3">مسلکی کاروونکی</h5>
                    <span>د سولر  تیک مسلکی کارونه </span>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature end-->

    

    <!-- About Start -->
    <?php include('pagePartation/aboutUsPart.php') ?>
    <!-- About End -->


    <!-- Service Start -->
    <?php include('pagePartation/servicePart.php') ?>
    <!-- Service End -->


    <!-- Feature Start -->
   <?php// include('pagePartation/featurePart.php')?>
    <!-- Feature End -->


    <!-- Projects Start -->
    <?php include('pagePartation/projectPart.php'); ?>
    <!-- Projects End -->


    <!-- Quote Start -->
    
    <!-- Quote End -->

    <?php include('pagePartation/quotePart.php') ?>
    <!-- Team Start -->
    
    <!-- Team End -->


    <!-- Testimonial Start -->
   <?php  include('pagePartation/customerViewPart.php');?>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <?php include('footer.php')?>;
</body>

</html> <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js'></script>
    <script src='lib/wow/wow.min.js'></script>
    <script src='lib/easing/easing.min.js'#></script>
    <script src='lib/waypoints/waypoints.min.js'></script>
    <script src='lib/counterup/counterup.min.js'></script>
    <script src='lib/owlcarousel/owl.carousel.min.js'></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src='lib/lightbox/js/lightbox.min.js'></script>
    <script src='Admin/js/jquery.min.js'></script>

    <!-- Template Javascript -->
    <