$(function() {
 setInterval(function() {
  update_last_activity();
  update_notifications();
  fetch_user();
  update_chat_history_data();
 }, 5000);
});

function fetch_user() {
 $.ajax({
  url: 'fetch_user.php',
  method: 'POST',
  success: function(data) {
   $('#user_details').html(data);
  }
 });
}

function update_notifications() {
 $.ajax({
  url: 'fetch_all_notifications.php',
  method: 'POST',
  success: function(data) {
   $('.all_unseen_messages').html(data);
  },
  complete: function(data) {}
 });
}

function update_last_activity() {
 $.ajax({
  url: 'update_last_activity.php',
  success: function() {}
 });
}

function update_chat_history_data() {
 $('.chat_history').each(function() {
  var to_user_id = $(this).data('touserid');
  fetch_user_chat_history(to_user_id);
 });
}

function fetch_user() {
 $.ajax({
  url: 'fetch_user.php',
  method: 'POST',
  success: function(data) {
   $('#user_details').html(data);
  }
 });
}

fetch_user();

function load_images() {
 $.ajax({
  url: 'get_images.php',
  method: 'GET',
  success: function(data) {
   $('#display_images').html(data);
  }
 });
}

load_images();

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
