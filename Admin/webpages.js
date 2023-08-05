
  $(document).ready(function () {
    $('.createPost').click(function (event) {
      event.preventDefault();

      $.ajax({
        url: 'posts.php',
        type: 'POST',
        data: $('.postes').serialize(),
        success: function (response) {

          alert(response);
        },
        error: function (error) {

          alert('Please try again.');
        }
      });
    });
  });