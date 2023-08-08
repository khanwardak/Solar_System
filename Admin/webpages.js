// create post in main page reques start

$(document).ready(function () {
  $('.createPost').click(function (event) {
    event.preventDefault();
    const formp  = $('form.postes')[0];
    if(formp){
      console.log(formp);
    const formDatap = new FormData(formp);
    var postId = formDatap.get('post_id');
    console.log(formDatap);
    $.ajax({
      url: 'posts.php',
      type: 'POST',
      data: formDatap,
      contentType: false,
      processData: false,
      success: function (response) {
        alert(response);
        formDatap === "";
      },
      error: function (error) {
        alert('Please try again.');
      }
    });
  }
  });
});
// create post end here
$(document).ready(function () {
  $('.createService').click(function (event) {
    event.preventDefault();
    const formp  = $('form.hhh')[0];
    console.log(formp);
    if(formp){
      console.log(formp);
    const formDatap = new FormData(formp);
    var postId = formDatap.get('post_id');
    console.log(formDatap);
    $.ajax({
      url: 'posts.php',
      type: 'POST',
      data: formDatap,
      contentType: false,
      processData: false,
      success: function (response) {
        alert(response);
        formDatap === "";
      },
      error: function (error) {
        alert('Please try again.');
      }
    });
  }
  });
});
// Create service here


// delete post from main page start
$(document).ready(function() {
  $('.deletePost').click(function() {
    var post_id = $(this).closest('tr').data('post-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {post_id:post_id},
        success: function(response) {
         location.reload();
        },
        error: function(xhr, status, error) {
          alert('Error deleting the countery: ' + error);
        }
      });
    }
  });
});
// delete post from main page end

// update post start here
$(document).ready(function () {
  $('.editPost').click(function () {
    var postId = $(this).closest('tr').data('post-id');
    var postTitle = $(this).closest('tr').data('post-title');
    var postText = $(this).closest('tr').data('post-text');

    $('input[name="post_id"]').val(postId); // Set the post ID in the hidden input field
    $('input[name="post_titlet"]').val(postTitle);
    $('textarea[name="post_text"]').val(postText);
    $('.updatePost').show();
    $('.createPost').hide();
  });

  $('.updatePost').click(function (event) {
    event.preventDefault();
    var form = $('.postes')[0];
    var formData = new FormData(form);
    var postId = formData.get('post_id');
    console.log(postId);
    $.ajax({
      url: 'update.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        alert('Post updated successfully!');
        location.reload();
      },
      error: function (error) {
        console.error(error);
        alert('Please try again.');
      }
    });
  });
});


// update post end here

// add service here
// Create service here
// $(document).ready(function () {
//   $('from.createService').click(function (event) {
//     event.preventDefault(); // Prevent the default form submission

//     const forms = $('.createServicef')[0];
//     console.log(forms+"ljhkjk")
//     const formDatas = new FormData(forms);
//     console.log(formDatas);

//     $.ajax({
//       url: 'createService.php',
//       type: 'POST',
//       data: formDatas,
//       contentType: false,
//       processData: false,
//       success: function (response) {
//         alert('خدمات اضافه شو');
//        // location.reload();
//        console.log(response);
//       },
//       error: function (error) {
//         alert('Please try again.');
//       }
//     });
//   });
// });

// add service end here

// edit service start
$(document).ready(function () {
  $('.editservice').click(function () {
    var serviceId = $(this).closest('tr').data('service-id');
    var serviceTitle = $(this).closest('tr').data('service-title');
    var serviceText = $(this).closest('tr').data('service-text');

    $('input[name="service_id"]').val(serviceId); // Set the post ID in the hidden input field
    $('input[name="service_titled"]').val(serviceTitle);
    $('textarea[name="service_textd"]').val(serviceText);
    $('.updateService').show();
    $('.createService').hide();
  });

  $('.updateService').click(function (event) {
    event.preventDefault();
    var form = event.target.form; // Get the form element

    var formData = new FormData(form);
    var service_id = formData.get('service_id');
    console.log(service_id);
    $.ajax({
      url: 'update.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        alert('Service updated successfully!');
        location.reload();
      },
      error: function (error) {
        console.error(error);
        alert('Please try again.');
      }
    });
  });
});
// edit service end


// delete service start
$(document).ready(function() {
  $('.deleteservice').click(function() {
    var service_id = $(this).closest('tr').data('service-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {service_id:service_id},
        success: function(response) {
          console.log(service_id);
         location.reload();
        },
        error: function(xhr, status, error) {
          alert('Error deleting the countery: ' + error);
        }
      });
    }
  });
});
//  delet service end

// add team merber start
$(document).ready(function () {
  $('.addTeamMember').click(function (event) {
    event.preventDefault();
    const form  = $('form.addTeam')[0];
    console.log(form);
    if(form){
      console.log(form);
    const formData = new FormData(form);
    console.log(formData);
    $.ajax({
      url: 'posts.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        alert(response);
      },
      error: function (error) {
        alert('Please try again.');
      }
    });
  }
  });
});
// add team member end
// edite Team members start
$(document).ready(function () {
  $('.editTeamMember').click(function () {
    console.log('clicked');
    var member_id = $(this).closest('tr').data('member-id');
    var team_mermber_img= $(this).closest('tr').data('member-image');
    var mob = $(this).closest('tr').data('member-mob');
    var fa_acc= $(this).closest('tr').data('member-fa-acc');
    var team_member_skills=$(this).closest('tr').data('member-skills');
    var memberfullName =$(this).closest('tr').data('member-fullname');
    $('input[name="fullName"]').val(memberfullName);
    $('input[name="member_id"]').val(member_id); // Set the post ID in the hidden input field
    $('input[name="mob"]').val(mob);
    $('input[name="fa_acc"]').val(fa_acc);
    $('textarea[name="team_member_skills"]').val(team_member_skills);
    $('.updateTeamMember').show();
    $('.addTeamMember').hide();
  });
  $('.updateTeamMember').click(function (event) {
    event.preventDefault();
    var form = $('form.addTeam')[0];
    var formData = new FormData(form);
    var member_id = formData.get('member_id');
    console.log(member_id);
    $.ajax({
      url: 'update.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        alert('Post updated successfully!');
        location.reload();
      },
      error: function (error) {
        console.error(error);
        alert('Please try again.');
      }
    });
  });
});
// edite team members end

// delete team members start
$(document).ready(function() {
  $('.deleteMember').click(function() {
    var member_id = $(this).closest('tr').data('member-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {member_id:member_id},
        success: function(response) {
          console.log(member_id);
          console.log(response);
        },
        error: function(xhr, status, error) {
          alert('Error deleting the countery: ' + error);
        }
      });
    }
  });
});

// delete team members end
// add page header start here
$(document).ready(function () {
  $('.addPageHeader').click(function (event) {
    event.preventDefault();
    const form  = $('form.pageHeader')[0];
    console.log(form);
    if(form){
      console.log(form);
    const formData = new FormData(form);
    console.log(formData);
    $.ajax({
      url: 'posts.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        alert(response);
      },
      error: function (error) {
        alert('Please try again.');
      }
    });
  }
  });
});
// add page header end

// edit header start

$(document).ready(function () {
  $('.editPagesHeader').click(function () {
    console.log('clicked');
    var page_name = $(this).closest('tr').data('page-name');
    var page_header_title= $(this).closest('tr').data('pageheader-title');
    var page_header_text = $(this).closest('tr').data('header-text');
    var page_header_id= $(this).closest('tr').data('pageheader-id');
    $('input[name="header_title"]').val(page_header_title);
    $('input[name="page_header_id"]').val(page_header_id);
    $('input[name="page"]').val(page_name);
    $('textarea[name="header_text"]').val(page_header_text);
    $('.updatePageHeader').show();
    $('.addPageHeader').hide();
  });
  $('.updatePageHeader').click(function (event) {
    event.preventDefault();
    var form = $('form.pageHeader')[0];
    var formData = new FormData(form);
    console.log(formData);
    $.ajax({
      url: 'update.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        alert('Post updated successfully!');
       location.reload();
      },
      error: function (error) {
        console.error(error);
        alert('Please try again.');
      }
    });
  });
});
// edit header end

// delete page Header start
$(document).ready(function() {
  $('.deletpageHeader').click(function() {
    var page_header_id = $(this).closest('tr').data('pageheader-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {page_header_id:page_header_id},
        success: function(response) {
          //console.log(member_id);
          console.log(response);
        },
        error: function(xhr, status, error) {
          alert('Error deleting the countery: ' + error);
        }
      });
    }
  });
});
// delete page header end