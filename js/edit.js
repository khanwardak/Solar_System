// edit.js

$(document).ready(function() {
    // Handle click event for the editButton
    $('#editButton').click(function(e) {
      e.preventDefault(); // Prevent the default behavior of the anchor tag (navigating to the href)
  
      // Show the modal with the specified ID
      $('#ed_users').modal('show');
    });
  });
  