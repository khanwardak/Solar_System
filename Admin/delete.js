// delete category start
  $(document).ready(function() {
    $('.deletCatagory').click(function() {
      var categoryId = $(this).closest('tr').data('category-id');
      if (confirm("آیا غوړای حذب شی?")) {
        $.ajax({
          url: 'delete.php',
          method: 'GET',
          data: { categoryId: categoryId },
          success: function(response) {
            location.reload();
          },
          error: function(xhr, status, error) {
            alert('په بښنې سره: ' + error);
          }
        });
      }
    });
  });
  // delete category end

  // delete comp start

$(document).ready(function() {
  $('.deleteComp').click(function() {
    var companyId = $(this).closest('tr').data('company-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method: 'GET',
        data: { companyId: companyId },
        success: function(response) {
          location.reload();
        },
        error: function(xhr, status, error) {
          alert('Error deleting the company: ' + error);
        }
      });
    }
  });
});
 // delete end start

 // delete countery start
 $(document).ready(function() {
  $('.deleteConut').click(function() {
    var countId = $(this).closest('tr').data('country-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {countId:countId},
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
 // delete countery end

//  delete currency start
$(document).ready(function() {
  $('.deleteCurrency').click(function() {
    var currency_id = $(this).closest('tr').data('currency-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {currency_id:currency_id},
        success: function(response) {
         location.reload();
         $('#currency').show();
        },
        error: function(xhr, status, error) {
          alert('Error deleting the countery: ' + error);
        }
      });
    }
  });
});
// delete currency end 

// delete unit script start

$(document).ready(function() {
  $('.deleteUnit').click(function() {
    var unit_id = $(this).closest('tr').data('unit-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {unit_id:unit_id },
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
// delete unit script end

// delete Our loan start
$(document).ready(function() {
  $('.deleteOurLoan').click(function() {
    var ourloan_id = $(this).closest('tr').data('ourloan-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {ourloan_id:ourloan_id},
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
// delete out loan end
// delete user start

$(document).ready(function() {
  $('.deleteUser').click(function() {
    var user_id = $(this).closest('tr').data('user-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'POST',
        data: {user_id:user_id},
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
// delete user end

// delete firm start
$(document).ready(function() {
  $('.deleteFirm').click(function() {
    var firm_id = $(this).closest('tr').data('firm-id');
    if (confirm("آیا غواړی حذب شی?")) {
      $.ajax({
        url: 'delete.php',
        method:'GET',
        data: {firm_id:firm_id},
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
// delete frim end

// delete goods start

// delete goods start