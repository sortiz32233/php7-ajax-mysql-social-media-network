//  if (
//   /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
//    navigator.userAgent
//   )
//  ) {
//  }

$(function() {
 $('[data-toggle="tooltip"]').tooltip();
 $('#dashboard_post_content').focus();
});

$('#newPassword, #newPasswordConfirm').on('click keyup', function() {
 $('.error').remove();
 $('#newPassword, #newPasswordConfirm').css('border', '1px solid lightgrey');
});

$('#currentPassword').on('click keydown', function() {
 $('.incorrect-password-error').remove();
 $('#updatePasswordBtn').prop('disabled', false);
 $('#currentPassword').css('border', '1px solid lightgrey');
});

$('#updatePasswordBtn').click(function() {
 var new_password = $('#newPassword').val(),
  confirm_new_password = $('#newPasswordConfirm').val(),
  current_password = $('#currentPassword').val();
 if (
  new_password == '' &&
  confirm_new_password == '' &&
  current_password == ''
 ) {
  $('#currentPassword').css('border', '1px solid red');
  $('#newPassword').css('border', '1px solid red');
  $('#newPasswordConfirm').css('border', '1px solid red');

  $('#update_password_message').html(
   '<small class="error">Please fill out the form.</small>'
  );
 } else if (current_password == new_password) {
  $('#currentPassword').css('border', '1px solid red');
  $('#newPassword').css('border', '1px solid red');
  $('#newPasswordConfirm').css('border', '1px solid red');

  $('#update_password_message').html(
   '<small class="error">Current password is the same as the new password.</small>'
  );
 } else if (new_password.length < 8) {
  $('#update_password_message').html(
   '<small class="error">Password must be at least 7 characters long.</small>'
  );
  $('#newPassword').css('border', '1px solid red');
  $('#newPasswordConfirm').css('border', '1px solid red');
 } else if (confirm_new_password != new_password) {
  $('#update_password_message').html(
   '<small class="error">Passwords do not match</small>'
  );
  $('#newPassword').css('border', '1px solid red');
  $('#newPasswordConfirm').css('border', '1px solid red');
 } else {
  $.ajax({
   url: 'update_info.php',
   method: 'POST',
   data: {
    updatePassword: 1,
    new_password: new_password,
    current_password: current_password
   },
   success: function(response) {
    if (response === 'success') {
     $('#update_password_message').html(
      '<small class="text-success position-absolute password-update-success">Your password has successfully been updated</small>'
     );
     setTimeout(() => {
      $('.password-update-success').remove();
     }, 1500);
    } else {
     $('#update_password_message').html(
      '<small class="incorrect-password-error text-danger">Incorrect current password</small>'
     );
     $('#currentPassword').css('border', '1px solid red');
     $('#updatePasswordBtn').prop('disabled', true);
     $('#error').fadeOut(1000);
    }
   },
   error: function() {
    alert('server error');
   },
   complete: function() {
    $('#update_password_form')[0].reset();
   }
  });
 }
});

// AJAX => update_info.php
$('.settings_form').on('submit', function(event) {
 event.preventDefault();
 var phone = $('#updatePhone').val();
 var carrier = $('#updateCarrier').val();
 var location = $('#updateLocation').val();
 var bio = $('#updateBio').val();
 var about = $('#updateAbout').val();
 var relationship_status = $('#updateRelationshipStatus').val();
 var occupation = $('#updateOccupation').val();
 var hometown = $('#updateHometown').val();
 var alma_mater = $('#updateAlmaMater').val();
 var hero = $('#updateHero').val();
 var hero_quote = $('#updateHeroQuote').val();
 $.ajax({
  url: 'update_info.php',
  method: 'POST',
  data: {
   update: 1,
   phone: phone,
   carrier: carrier,
   location: location,
   bio: bio,
   about: about,
   relationship_status: relationship_status,
   occupation: occupation,
   hometown: hometown,
   alma_mater: alma_mater,
   hero: hero,
   hero_quote: hero_quote,
   returning_user: 1
  },
  success: function(response) {
   if (response === 'error') {
    alert('error');
   } else {
    window.location = 'dashboard.php';
   }
  }
 });
});

// On Reply Click

$(document).on('click', '.reply', function() {
 var post_id = $(this).attr('id');
 $('#post_id').val(post_id);
});

$('#register_form').submit(function(event) {
 event.preventDefault();
 var strongPassword = new RegExp(
  '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{7,})'
 );
 var name = $('#name').val(),
  email = $('#email').val(),
  password = $('#password').val(),
  confirm_password = $('#confirm_password').val();

 if (name == '' || email == '' || password == '' || confirm_password == '') {
  $('#register_message')
   .hide()
   .fadeIn(1000);
  $('#register_message').html(
   "<span class='text-danger'>Please fill out all fields.</span>"
  );
  $('#email').select();
  setTimeout(() => {
   $('#register_message').fadeOut(500);
  }, 1000);
  setTimeout(() => {
   $('#register_message').fadeIn(500);
   $('#register_message').html(
    '<span class="text-white"><sup><i class="fas fa-lock"></i></sup> password must include 1 uppercase character, 1 lowercase character, 1 number, 1 special character, and be 7 characters long</span>'
   );
  }, 1500);
 } else if (
  confirm_password.length >= 7 &&
  strongPassword.test(confirm_password) &&
  password.length >= 7 &&
  strongPassword.test(password) &&
  confirm_password === password
 ) {
  $.ajax({
   url: 'register.php',
   method: 'POST',
   data: {
    register: 1,
    name: name,
    email: email,
    password: password
   },
   success: function(response) {
    if (response === 'userExists') {
     $('#register_message').html(
      '<span class="text-danger">Please use a different email address</span>'
     );
     $('#register_message')
      .hide()
      .fadeIn(1000);

     setTimeout(() => {
      $('#register_message').fadeOut(500);
     }, 1000);
     setTimeout(() => {
      $('#register_message').fadeIn(500);
      $('#register_message').html(
       '<span class="text-white"><sup><i class="fas fa-lock"></i></sup> password must include 1 uppercase character, 1 lowercase character, 1 number, 1 special character, and be 7 characters long</span>'
      );
     }, 1500);
     $('#email').select();
    } else {
     $('#register_message')
      .hide()
      .fadeIn(1000);
     $('#register_message').html(
      "<span class='text-success'>Account created successfully! Redirecting you now...</span>"
     );
     $('#register_form')[0].reset();
     setTimeout(() => {
      window.location = 'index.php';
     }, 1500);
    }
   },
   error: function() {
    $('#register_message').html(
     "<span class='text-danger'>Error: Please try again</span>"
    );
   }
  });
 } else {
  $('#register_message')
   .hide()
   .fadeIn(1000);
  $('#register_message').html(
   '<span class="text-danger">Password doesn\'t meet standards</span>'
  );
  setTimeout(() => {
   $('#register_message').fadeOut(500);
  }, 1000);
  setTimeout(() => {
   $('#register_message').fadeIn(500);
   $('#register_message').html(
    '<span class="text-white"><sup><i class="fas fa-lock"></i></sup> password must include 1 uppercase character, 1 lowercase character, 1 number, 1 special character, and be 7 characters long</span>'
   );
  }, 1500);
 }
});

$('#login_form').submit(function(event) {
 event.preventDefault();
 var email = $('#login_email').val();
 var password = $('#login_password').val();

 if (email == '' || password == '') {
  $('#login_message')
   .hide()
   .fadeIn(500);
  $('#login_message').html(
   "<span class='text-danger'>Please fill out both fields.</span>"
  );
  setTimeout(() => {
   $('#login_message').fadeOut(1000);
  }, 1500);
 } else {
  $.ajax({
   url: 'login.php',
   method: 'POST',
   data: {
    login: 1,
    email: email,
    password: password
   },
   success: function(result) {
    if (result === 'success') {
     $('#login_message')
      .hide()
      .fadeIn(250);
     $('#login_message').html(
      "<span class='text-success'>Sending two factor authorization code. One second, please.</span>"
     );
     setTimeout(() => {
      $('#login_message').fadeOut(2000);
      $('#twoFactorModal').modal('show');
     }, 2000);
    } else if (result === 'successExpress') {
     $('#login_message')
      .hide()
      .show();
     $('#login_message').html(
      '<div class="spinner-border mx-auto text-light" role="status"></div>'
     );
     setTimeout(() => {
      $('#login_message').fadeOut(1000);
     }, 1000);
     $.get('fetch_returning_user.php', function(data) {
      if (data == 1) {
       window.location = 'dashboard.php';
      } else {
       window.location = 'setup.php';
      }
     });
    } else if (result === 'error') {
     $('#login_message')
      .hide()
      .fadeIn(500);
     $('#login_message').html(
      "<span class='text-danger'>Invalid credentials.</span>"
     );
     setTimeout(() => {
      $('#login_message').fadeOut(1000);
     }, 1500);
    }
   },
   complete: function() {
    $('#login_form')[0].reset();
   }
  });
 }
});

$('#logout').click(function() {
 $.ajax({
  url: 'logout.php',
  method: 'POST',
  data: {
   logout: 1
  },
  success: function(response) {
   if (response == 'success') {
    window.location = 'index.php';
   } else {
    alert('Unkown error');
   }
  }
 });
});

// 2FA

// Force modal open
// $(document).ready(function(){
// 	$("#twoFactorModal").modal('show');
// });
//

// Focuses input when the modal is shown
$('#twoFactorModal').on('shown.bs.modal', function() {
 $('.two-factor-input:first').focus();
});

$('#two-factor-form').submit(function(event) {
 event.preventDefault();
 var two_factor_token = $('#two-factor-token').val();
 alert('ajax run');
 $.ajax({
  url: 'secure.php',
  method: 'POST',
  data: {
   secure: 1,
   two_factor_token: two_factor_token
  },
  success: function(response) {
   if (response === 'success') {
    alert('success');
    location.reload();
   } else if (response === 'badPassword') {
    alert('bad password');
   }
  },
  error: function() {
   alert('server error');
  },
  complete: function() {
   alert('complete');
  }
 });
});

$('.two-factor-input').on('click focus', function() {
 $(this).select();
});

$('.two-factor-input').on('keyup', function() {
 if ($(this).val() !== '') {
  var input = $('.two-factor-input');
  var output = '';
  $.each(input, function(i, val) {
   output += val.value;
  });
  $('#two-factor-token').val(output);
  $('#two-factor-verify').focus();
 }
});

$('#two-factor-verify').keyup(function(event) {
 if (event.keyCode == 8) {
  $('.two-factor-input:last-child').focus();
 }
});

$('.two-factor-input').keydown(function(event) {
 if (event.keyCode >= 48 && event.keyCode <= 57) {
  $('.two-factor-input').on('keyup', function() {
   if ($(this).val() !== '') {
    $(this)
     .next()
     .select();
   }
  });
 }
});

// 2FA Arrows

$('.two-factor-input').keydown(function(event) {
 if (event.keyCode == 37) {
  $('.two-factor-input').on('keyup', function() {
   $(this)
    .prev()
    .select();
  });
 } else if (event.keyCode == 39)
  $('.two-factor-input').on('keyup', function() {
   $(this)
    .next()
    .select();
  });
});

// 2FA Delete Input

$('.two-factor-input').keyup(function(event) {
 if (event.keyCode == 8 && $(this).val() == '') {
  $(this)
   .prev()
   .select();
 }
});

//SET CURSOR POSITION
$.fn.setCursorPosition = function(pos) {
 this.each(function(index, elem) {
  if (elem.setSelectionRange) {
   elem.setSelectionRange(pos, pos);
  } else if (elem.createTextRange) {
   var range = elem.createTextRange();
   range.collapse(true);
   range.moveEnd('character', pos);
   range.moveStart('character', pos);
   range.select();
  }
 });
 return this;
};

var $inputs = $('.two-factor-input');
var intRegex = /^\d+$/;

// Prevents user from manually entering non-digits.
$inputs.on('input.fromManual', function(event) {
 if (!intRegex.test($(this).val())) {
  $(this).val('');
 }
});

// Prevents pasting non-digits and if value is 6 characters long will parse each character into an individual box.
$inputs.on('paste', function() {
 var $this = $(this);
 var originalValue = $this.val();

 $this.val('');

 $this.one('input.fromPaste', function() {
  $currentInputBox = $(this);

  var pastedValue = $currentInputBox.val();

  if (pastedValue.length == 6 && intRegex.test(pastedValue)) {
   pasteValues(pastedValue);
  } else {
   $this.val(originalValue);
  }

  $inputs.attr('maxlength', 1);
 });

 $inputs.attr('maxlength', 6);
});

// Parses the individual digits into the individual boxes.
function pasteValues(element) {
 var values = element.split('');

 $(values).each(function(index) {
  var $inputBox = $('.two-factor-input[name="chars[' + (index + 1) + ']"]');
  $inputBox.val(values[index]);
 });
}

// Resend 2FA code

$('#resend').click(function() {
 $.ajax({
  url: 'login.php',
  method: 'POST',
  data: {
   resend: 1
  },
  success: function() {}
 });
});

$('#eye').click(function() {
 if ($(this).attr('class') == 'fas fa-eye') {
  $(this)
   .toggleClass('fa-eye')
   .toggleClass('fa-eye-slash');
  $('#login_password').attr('type', 'text');
 } else {
  $(this)
   .toggleClass('fa-eye')
   .toggleClass('fa-eye-slash');
  $('#login_password').attr('type', 'password');
 }
});

// Phone number plugin

const isNumericInput = event => {
 const key = event.keyCode;
 return (
  (key >= 48 && key <= 57) || // Allow number line
  (key >= 96 && key <= 105) // Allow number pad
 );
};

const isModifierKey = event => {
 const key = event.keyCode;
 return (
  key === 35 ||
  key === 36 || // Home, End
  key === 8 ||
  key === 9 ||
  key === 13 ||
  key === 46 || // Allow Backspace, Tab, Enter, Delete
  (key > 36 && key < 41) || // Allow left, up, right, down
  // Allow Ctrl/Command + A,C,V,X,Z
  ((event.ctrlKey === true || event.metaKey === true) &&
   (key === 65 || key === 67 || key === 86 || key === 88 || key === 90))
 );
};

const enforceFormat = event => {
 // Input must be of a valid number format or a modifier key, and not longer than ten digits
 if (!isNumericInput(event) && !isModifierKey(event)) {
  event.preventDefault();
 }
};

const formatToPhone = event => {
 if (isModifierKey(event)) {
  return;
 }

 // I am lazy and don't like to type things more than once
 const target = event.target;
 const input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
 const zip = input.substring(0, 3);
 const middle = input.substring(3, 6);
 const last = input.substring(6, 10);

 if (input.length > 6) {
  target.value = `(${zip}) ${middle}-${last}`;
 } else if (input.length > 3) {
  target.value = `(${zip}) ${middle}`;
 } else if (input.length > 0) {
  target.value = `(${zip}`;
 }
};

$('#two-factor').on('click', function() {
 if ($(this).prop('checked') == true) {
  $('#two-factor-label').removeClass('text-muted');
  $('#two-factor-label').addClass('text-primary');
  $('.two-factor-container').removeClass('d-none');
  $('.two-factor-container').addClass('d-block');
 } else {
  $('#two-factor-label').removeClass('text-primary');
  $('#two-factor-label').addClass('text-muted');
  $('.two-factor-container').removeClass('d-block');
  $('.two-factor-container').addClass('d-none');
 }
});

function load_posts() {
 $.ajax({
  url: 'get_posts.php',
  method: 'GET',
  success: function(data) {
   $('#display_posts').html(data);
  }
 });
}

function load_profile_posts() {
 $.ajax({
  url: 'get_profile_posts.php',
  method: 'GET',
  beforeSend: function() {
   $('.wrapper').show();
  },
  success: function(data) {
   $('.wrapper').hide();
   $('#display_profile_posts').html(data);
  }
 });
}

$('#two-factor').on('change', function(event) {
 event.preventDefault();
 if ($(this).prop('checked')) {
  var two_factor_auth = 1;

  $.ajax({
   url: 'dashboard.php',
   method: 'POST',
   data: {
    two_factor: 1,
    two_factor_auth: two_factor_auth
   },
   error: function() {
    alert('Server error');
   }
  });
 } else {
  var two_factor_auth = 0;
  $.ajax({
   url: 'dashboard.php',
   method: 'POST',
   data: {
    two_factor: 1,
    two_factor_auth: two_factor_auth
   },
   error: function() {
    alert('Server error');
   }
  });
 }
});

$('.change-profile').click(function() {
 $('#profile').click();
});
$('#profile').on('change', function() {
 if ($('#profile').val() !== '') {
  $('#upload-profile-picture').click();
 } else {
  return false;
 }
});

$('#search').on('keyup', function() {
 var value = $(this)
  .val()
  .toLowerCase();
 $('.user-list').filter(function() {
  $(this).toggle(
   $(this)
    .text()
    .toLowerCase()
    .indexOf(value) > -1
  );
 });
});

// $(document).ready(function() {
//  load_data();
//  function load_data(page) {
//   $.ajax({
//    url: 'pagination.php',
//    method: 'POST',
//    data: { page: page },
//    success: function(data) {
//     $('#pagination_data').html(data);
//    }
//   });
//  }
//  $(document).on('click', '.pagination_link', function() {
//   var page = $(this).attr('id');
//   load_data(page);
//  });
// });

// CHAT

$(document).ready(function() {
 $(document).on('show.bs.modal', '.modal-chat', function() {
  $('.scroll-container').animate(
   { scrollTop: $('.scroll-container')[0].scrollHeight + 9999999 },
   1000
  );
 });

 function make_chat_dialog_box(to_user_id, to_user_name) {
  var modal_content =
   '<div id="modal_' +
   to_user_id +
   '" class="modal modal-chat" tabindex="-1" title="' +
   to_user_name +
   '"><div class="modal-dialog modal-dialog-centered" role="document">';
  modal_content +=
   '<div class="modal-content" style="background: rgba(255,255,255,.9)"><div class="scroll-container mt-3"><div class="chat_history" data-touserid="' +
   to_user_id +
   '" id="chat_history_' +
   to_user_id +
   '">';
  modal_content += fetch_user_chat_history(to_user_id);
  modal_content += '</div></div>';
  modal_content += '<div class="modal-body">';
  modal_content +=
   '<textarea name="chat_message_' +
   to_user_id +
   '" id="chat_message_' +
   to_user_id +
   '" class="form-control chat_message" style="resize:none"></textarea>';
  modal_content +=
   '</div><div class="text-danger position-absolute" style="bottom: 2rem; left: 1.25rem" id="chat_feedback_' +
   to_user_id +
   '"></div><div class="modal-footer" align="right">';
  modal_content +=
   '<button type="button" name="send_chat" id="' +
   to_user_id +
   '" class="btn btn-primary text-white send_chat"><i class="fas fa-paper-plane"></i></button></div></div></div>';
  $('#user_model_details').html(modal_content);
  var canChat = 1;

  $(document).on('keydown', '.chat_message', function(event) {
   if (!canChat) {
    return false;
   } else {
    if (event.keyCode === 13) {
     event.preventDefault();

     var chat_message = $.trim($('#chat_message_' + to_user_id).val());
     if (chat_message != '') {
      $.ajax({
       url: 'insert_chat.php',
       method: 'POST',
       data: { to_user_id: to_user_id, chat_message: chat_message },
       beforeSend: function() {
        canChat = 0;
       },
       success: function(data) {
        $('#chat_message_' + to_user_id).val('');
        $('#chat_history_' + to_user_id).html(data);
        $('.scroll-container').animate(
         { scrollTop: $('.scroll-container')[0].scrollHeight },
         1000
        );
       },
       complete: function() {
        canChat = 1;
        $('#chat_message_' + to_user_id).val('');
       }
      });
     } else {
      event.preventDefault();
      $('#chat_message_' + to_user_id).css('border', '1px solid red');
      setTimeout(() => {
       $('#chat_message_' + to_user_id).css('border', '1px solid lightgrey');
      }, 1900);
      $('#chat_feedback_' + to_user_id)
       .html('Please enter a message')
       .show()
       .delay(1000)
       .fadeOut(1000);
     }
    }
   }
  });
 }

 $(document).on('click', '.start_chat', function() {
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  make_chat_dialog_box(to_user_id, to_user_name);
  $('#modal_' + to_user_id).modal('show');
  $('#chat_history_' + to_user_id).html(
   '<div class="spinner-border text-muted mx-auto" style="position: relative; margin-top: 30%; display: block; height: 10rem; width: 10rem; border-width: .5rem"></div>'
  );
  $('#chat_message_' + to_user_id).focus();
 });

 $(document).on('click', '.send_chat', function() {
  var to_user_id = $(this).attr('id');
  var chat_message = $.trim($('#chat_message_' + to_user_id).val());
  if (chat_message != '') {
   $.ajax({
    url: 'insert_chat.php',
    method: 'POST',
    data: { to_user_id: to_user_id, chat_message: chat_message },
    success: function(data) {
     $('#chat_message_' + to_user_id).val('');
     $('#chat_history_' + to_user_id).html(data);
     $('.scroll-container').animate(
      { scrollTop: $('.scroll-container')[0].scrollHeight },
      1000
     );
    }
   });
  } else {
   event.preventDefault();
   $('#chat_message_' + to_user_id).css('border', '1px solid red');
   setTimeout(() => {
    $('#chat_message_' + to_user_id).css('border', '1px solid lightgrey');
   }, 1900);
   $('#chat_feedback_' + to_user_id)
    .html('Please enter a message')
    .show()
    .delay(1000)
    .fadeOut(1000);
  }
 });

 function fetch_user_chat_history(to_user_id) {
  $.ajax({
   url: 'fetch_user_chat_history.php',
   method: 'POST',
   data: { to_user_id: to_user_id },
   success: function(data) {
    $('#chat_history_' + to_user_id).html(data);
   }
  });
 }

 $(document).on('focus', '.chat_message', function() {
  var is_type = 'yes';
  $.ajax({
   url: 'update_is_type_status.php',
   method: 'POST',
   data: { is_type: is_type },
   success: function() {}
  });
 });

 $(document).on('blur', '.chat_message', function() {
  var is_type = 'no';
  $.ajax({
   url: 'update_is_type_status.php',
   method: 'POST',
   data: { is_type: is_type },
   success: function() {}
  });
 });
});
// END CHAT

$('#dashboard_post_content').keydown(function(event) {
 //fixthis
 if (event.keyCode === 13) {
  event.preventDefault();
  $('#dashboard_post_form').submit();
 }
});

$('.remove-image-preview').click(function() {
 $('#image-preview').attr('src', '');
 $('#file-input').val('');
 $('.remove-image-preview').hide();
 $('.image-preview-container').hide();
});

$('#post-status').click(function() {
 $('.custom-file-label').css('border', '1px solid lightgrey');
});

var canSubmit = 1;

$('#dashboard_post_form').submit(function(e) {
 if (!canSubmit) {
  return false;
 } else {
  e.preventDefault();
  formData = new FormData(this);
  formData.append('post', 1);

  if (
   $('#dashboard_post_content').val() == '' &&
   $('#file-input').val() == ''
  ) {
   $('#dashboard_post_content').css('border', '1px solid red');
   setTimeout(() => {
    $('#dashboard_post_content').css('border', '1px solid lightgrey');
   }, 1900);
   $('#dashboard_post_message')
    .html('Please post a status or image')
    .show()
    .delay(1000)
    .fadeOut(1000);
  } else {
   $.ajax({
    url: 'create_post.php',
    type: 'POST',
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
     canSubmit = 0;
     $('.post-container').after(
      '<div class="spinner-border mt-2 text-primary post-loader" role="status"></div>'
     );
    },
    success: function() {
     $('.form-control').val('');
     $('#image-preview').attr('src', '');
     $('.image-preview-container').hide();
     $('#file-input').val('');
     load_posts();
     load_profile_posts();
     load_images();
    },
    error: function() {
     alert('ERROR');
    },
    complete: function() {
     canSubmit = 1;
     $('.post-loader').remove();
    }
   });
  }
 }
});

// POST IMAGE

$('.image-preview-container').hide();

$('#file-input').on('change', function() {
 $('.remove-image-preview').show();
 $('.image-preview-container').show();

 var fileName = $(this)
  .val()
  .split('\\')
  .pop();
 $(this)
  .siblings('.custom-file-label')
  .addClass('selected')
  .html(fileName);
});

$('.remove-image-preview').click(function() {
 $('#image-preview').attr('src', '');
 $('#file-input').val('');
 $('.remove-image-preview').hide();
 $('.image-preview-container').hide();
});

$('#post-status').click(function() {
 $('.custom-file-label').css('border', '1px solid lightgrey');
});

$('.image_upload_button').click(function() {
 $('#file-input').click();
});

$('#comment_post_form').submit(function(e) {
 e.preventDefault();
 if ($('#comment_post_content').val() == '' && $('#file-input').val() == '') {
  $('#comment_post_content').css('border', '1px solid red');
  setTimeout(() => {
   $('#comment_post_content').css('border', '1px solid lightgrey');
  }, 1900);
  $('#comment_post_message')
   .html(
    "<span style='bottom:-.25rem' class='text-danger font-weight-light position-absolute'>please enter a comment</span>"
   )
   .show()
   .delay(1000)
   .fadeOut(1000);
 } else {
  $.ajax({
   url: 'create_comment.php',
   type: 'POST',
   data: new FormData(this),
   contentType: false,
   cache: false,
   processData: false,
   success: function() {
    load_posts();
   },
   error: function() {
    alert('ERROR');
   },
   complete: function() {
    $('.form-control').val('');
    $('.modal').modal('hide');
   }
  });
 }
});

$('.change-profile').hide();
$('.change-cover').hide();

$('.card-header').mouseenter(function() {
 $(this)
  .children('i')
  .fadeIn(1000);
});

$('.card-header').mouseleave(function() {
 $(this)
  .children('i')
  .fadeOut(1000);
});

$('.cover-wrapper').mouseenter(function() {
 $('.change-cover').fadeIn(1000);
 $('.cover-photo').css('opacity', '.9');
});

$('.cover-wrapper').mouseleave(function() {
 $('.change-cover').fadeOut(1000);
 $('.cover-photo').css('opacity', '1');
});

$('.profile-photo-container').mouseenter(function() {
 $('.change-profile').fadeIn(1000);
 $('.change-cover').fadeOut(1000);
 $('.profile-photo').css('opacity', '.9');
});

$('.profile-photo-container').mouseleave(function() {
 $('.change-profile').fadeOut(1000);
 $('.change-cover').fadeIn(1000);
 $('.profile-photo').css('opacity', '1');
});

$('#uploadHeroBtn').mouseenter(function() {
 $('#edit_hero').hide();
});

$('#hero-image-container').mouseenter(function() {
 $('#edit_hero').hide();
 $('#uploadHeroBtn').fadeIn(1000);
});

$('#hero-image-container').mouseleave(function() {
 $('#edit_hero').fadeIn(1000);
 $('#uploadHeroBtn').hide();
});

$('#hero_section').mouseenter(function() {
 $('#edit_hero').fadeIn(1000);
});

$('#hero_section').mouseleave(function() {
 $('#edit_hero').fadeOut(1000);
});

$('#uploadHeroBtn').click(function() {
 $('#hero').click();
});

$('#hero').on('change', function() {
 if ($('#hero').val() !== '') {
  $('#upload-hero-picture').click();
 } else {
  return false;
 }
});

$('#hero_pic_upload_form').submit(function(event) {
 event.preventDefault();
 var formData = new FormData(this);
 formData.append('setHeroProfile', 1);
 $.ajax({
  type: 'POST',
  url: 'upload_hero.php',
  data: formData,
  cache: false,
  contentType: false,
  processData: false,
  success: function() {
   $.get('get_hero.php', function(data) {
    $('#hero-image').attr('src', 'heros/' + data);
    $('#hero-image').show();
   });
  },
  error: function() {
   alert('Error');
  },
  complete: function() {}
 });
});

$('#profile_post_form').submit(function(event) {
 event.preventDefault();
 var formData = new FormData(this);
 $.ajax({
  type: 'POST',
  url: 'upload.php',
  data: formData,
  cache: false,
  contentType: false,
  processData: false,
  success: function() {
   $.get('get_profiles.php', function(data) {
    $('#profile-preview').attr('src', 'profile_pics/' + data);
    $('#profile-preview').show();
   });
  },
  error: function() {
   console.log('Error: ' + error);
  },
  complete: function() {
   $('#profile-input').val('');
  }
 });
});

$('#profile_upload_button').click(function() {
 $('#profile-input').click();
});

$('.settings_profile_upload_button').click(function() {
 $('#settings-profile-input').click();
});

$('#settings-profile-input').on('change', function() {
 $('#remove-profile-preview').show();
 $('#profile_post_form').submit();
});

$('#cover_post_form').submit(function(event) {
 event.preventDefault();
 var formData = new FormData(this);
 $.ajax({
  type: 'POST',
  url: 'upload_cover.php',
  data: formData,
  cache: false,
  contentType: false,
  processData: false,
  success: function() {
   $.get('get_covers.php', function(data) {
    $('#cover-preview').attr('src', 'covers/' + data);
    $('#cover-preview').show();
   });
  },
  error: function() {
   console.log('Error: ' + error);
  },
  complete: function() {
   $('#cover-input').val('');
   $('.loader').hide();
  }
 });
});

$('#cover_upload_button').click(function() {
 $('#cover-input').click();
});

$('#cover-input').on('change', function() {
 $('#remove-cover-preview').show();
 $('#cover_post_form').submit();
});

$('#hero_post_form').submit(function(event) {
 event.preventDefault();
 var formData = new FormData(this);
 $.ajax({
  type: 'POST',
  url: 'upload_hero.php',
  data: formData,
  cache: false,
  contentType: false,
  processData: false,
  success: function() {
   $.get('get_hero.php', function(data) {
    $('#hero-preview').attr('src', 'heros/' + data);
    $('#hero-preview').show();
   });
  },
  error: function() {
   console.log('Error: ' + error);
  },
  complete: function() {
   $('#hero-input').val('');
  }
 });
});

$('#hero_upload_button').click(function() {
 $('#hero-input').click();
});

$('#hero-input').on('change', function() {
 $('#remove-hero-preview').show();
 $('#hero_post_form').submit();
});

$('#privacy').on('click', function() {
 if ($(this).prop('checked') == true) {
  var privacy = 1;
  $('#privacy-label').removeClass('text-muted');
  $('#privacy-label').addClass('text-primary');
  $('#privacy-label').html(
   'your profile is now public&ensp;<i class="fas fa-globe"></i>'
  );
 } else {
  var privacy = 0;
  $('#privacy-label').removeClass('text-primary');
  $('#privacy-label').addClass('text-muted');
  $('#privacy-label').html('your profile is currently set to private');
 }

 $.ajax({
  url: 'update_info.php',
  method: 'POST',
  data: {
   privacyUpdate: 1,
   privacy: privacy
  },
  success: function() {},
  error: function() {
   alert('Server error');
  }
 });
});

$('#final_submit').hide();

function bootstrapTabControl() {
 var i,
  items = $('.nav-link'),
  pane = $('.tab-pane');
 // next

 $('.nexttab').on('click', function() {
  for (i = 0; i < items.length; i++) {
   if ($(items[2]).hasClass('active') == true) {
    $('.nexttab').addClass('d-none');
    $('#final_submit').show();
   }

   if ($(items[i]).hasClass('active') == true) {
    break;
   }
  }
  if (i < items.length - 1) {
   // for tab
   $('.prevtab').removeClass('d-none');
   $(items[i]).removeClass('active');
   $(items[i + 1]).addClass('active');
   // for pane
   $(pane[i]).removeClass('show active');
   $(pane[i + 1]).addClass('show active');
  }
 });
 // Prev
 $('.prevtab').on('click', function() {
  for (i = 0; i < items.length; i++) {
   $('.nexttab').removeClass('d-none');
   $('#final_submit').hide();

   if ($(items[1]).hasClass('active') == true) {
    $('.prevtab').addClass('d-none');
   }

   if ($(items[i]).hasClass('active') == true) {
    break;
   }
  }
  if (i != 0) {
   // for tab
   $(items[i]).removeClass('active');
   $(items[i - 1]).addClass('active');

   // for pane
   $(pane[i]).removeClass('show active');
   $(pane[i - 1]).addClass('show active');
  }
 });
}

bootstrapTabControl();

$('#reset_profile_pic').click(function() {
 $.ajax({
  url: 'reset_pic.php',
  method: 'POST',
  data: {
   resetProfile: 1
  },
  success: function(response) {
   if (response == 'success') {
    $.get('get_profiles.php', function(data) {
     $('#profile-preview').attr('src', 'profile_pics/' + data);
    });
   }
  }
 });
});

$('#reset_cover').click(function() {
 $.ajax({
  url: 'reset_pic.php',
  method: 'POST',
  data: {
   resetCover: 1
  },
  success: function(response) {
   if (response == 'success') {
    $.get('get_covers.php', function(data) {
     $('#cover-preview').attr('src', 'covers/' + data);
    });
   }
  }
 });
});

$('#reset_hero').click(function() {
 $.ajax({
  url: 'reset_pic.php',
  method: 'POST',
  data: {
   resetHero: 1
  },
  success: function(response) {
   if (response == 'success') {
    $.get('get_hero.php', function(data) {
     $('#hero-preview').attr('src', 'heros/' + data);
    });
   }
  }
 });
});

var reader = new FileReader();
reader.onload = function(event) {
 $('#image-preview').attr('src', event.target.result);
};

function readURL(input) {
 if (input.files && input.files[0]) {
  reader.readAsDataURL(input.files[0]);
 }
}

$('#profile').change(function() {
 readURL(this);
});

$(document).on('keydown', function(e) {
 if ($('#deleteModal').is(':visible')) {
  if (e.keyCode == 13) {
   $('#btn-delete').click();
  }
 }
});

$(document).on('keydown', function(e) {
 if ($('#image-preview').attr('src') != '') {
  if (e.keyCode == 13) {
   $('#dashboard_post_form').submit();
  }
 }
});

$(document).on('keydown', function(e) {
 var comment_post_content = $('#comment_post_content').val();
 if ($('#postModal').is(':visible')) {
  if (e.keyCode == 13 && comment_post_content.length == 0) {
   $('#postBtn').click();
   e.preventDefault();
  } else if (e.keyCode == 13 && comment_post_content.length > 0) {
   $('#postBtn').click();
  }
 }
});
