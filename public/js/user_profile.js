$(function(){
    // Init validation
    var rules = {
        'first_name': {
            required: true,
        },
        'last_name': {
            required: true,
        },
        'email': {
            required: true,
            email: true,
        }
    };
    
    var messages = {
        'first_name': {
            required: Lang.user_profile.first_name_empty_error_msg,
        },
        'last_name': {
            required: Lang.user_profile.last_name_empty_error_msg,
        },
        'mobile_phone': {
            required: Lang.user_profile.mobile_phone_empty_error_msg,
        },
        'email': {
            required: Lang.user_profile.email_empty_error_msg,
            email: Lang.user_profile.email_invalid_error_msg,
        }
    };
    
    App.initValidation('form-profile', rules, messages);    
    
});