$(function(){
    // Init validation
    var rules = {
        'current_password': {
            required: true,
        },
        'new_password': {
            required: true,
        },
        'confirm_password': {
            equalTo: '#new_password',
        }
    };
    
    var messages = {
        'current_password': {
            required: Lang.user_change_password.current_password_empty_error_msg,
        },
        'new_password': {
            required: Lang.user_change_password.new_password_empty_error_msg,
        },
        'confirm_password': {
            equalTo: Lang.user_change_password.confirm_password_not_matched_error_msg,
        }
    };
    
    App.initValidation('form-change-password', rules, messages);    
    
});