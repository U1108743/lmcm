
//Event listener to check password fields match on add user form page
$('input').blur(function() {
    var pass = $('input[name=user_password]').val();
    var repass = $('input[name=user_password_retype]').val();
    if (pass != repass) {
        $('#match_msg').show();
        $(':input[type="submit"]').prop('disabled', true);
    }
    else {
        $('#match_msg').hide();
        $(':input[type="submit"]').prop('disabled', false);
    }
});


//Event listener to check password fields match on reset user password form page
$('input').blur(function() {
    var pass = $('input[name=user_password]').val();
    var repass = $('input[name=user_password_retype]').val();

    if (pass.length != 0 || repass.length != 0) {
        if (pass != repass || pass.length < 8) {
            $('#match_msg').show();
            $('#reset_password').prop('disabled', true);
        }
        else {
            $('#match_msg').hide();
            $('#reset_password').prop('disabled', false);
        }
    }

});

//Allow user to be edited on admin modify user form
function editUser() {
    $(".input_container :input").not(':first').prop("disabled", false);

    //Hide edit user button and show cancel changes button
    $("#edit_user").hide();
    $("#cancel_changes").show();

    //colour cancel changes, update user buttons
    $("#cancel_changes").css("background-color", "red");
    $("#update_user").css("background-color", "green");
    $("#update_user").css("color", "white");
}

function resetPassword() {

    //Hide edit user button and show cancel changes button
    $("#reset_password").hide();
    $("#cancel_changes").show();
    $("#confirm_reset").show();

    //colour cancel changes, update user buttons
    $("#cancel_changes").css("background-color", "red");
    $("#confirm_reset").css("background-color", "green");
    $("#confirm_reset").css("color", "white");
}