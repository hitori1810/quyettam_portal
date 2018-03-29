$(function() {
    //  Show warining message when user ticked the remember me checkbox 
    $('#remember_me').click(function() {
        if($(this).is(':checked')) {
            Dialog.alert(Lang.user_login.remember_me_warning_msg, 'warning');
        }
    });
});
