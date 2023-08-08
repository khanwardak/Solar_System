<div class="container-xxl py-5" style="direction: rtl;">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="text-primary">د ټیم غړی</h6>
                <h1 class="mb-4">با تجربه مسلکی غړي</h1>
            </div>
            <div class="row g-4">
             <?php 
             include('Admin/DBConnection.php');
             try{
                $sqlShowTeamMembers ="SELECT * FROM `team_members` WHERE isDelete ='0' ORDER BY team_member_id DESC LIMIT 6";
                $ShowMemberResult = $conn->query($sqlShowTeamMembers);
                if($ShowMemberResult -> num_rows > 0){
                    while($row = $ShowMemberResult->fetch_assoc()){
                        echo
                     '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="d-flex">
                                <img class="img-fluid w-75" src="Admin'.'/'.trim($row['team_member_img']).'" alt="">
                                <div class="team-social w-25">
                                    <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href="'.$row['team_member_fa_acc'].'"><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-lg-square btn-outline-primary rounded-circle mt-3" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="p-4">
                                <h5>مکمل نوم</h5>
                                <span>'.$row['team_member_fullName'].'</span>
                            </div>
                        </div>
                    </div>';
                    }
                }
             }catch(Exception $e){
                echo $e;
             }
             ?>
            

            </div>
        </div>
    </div>