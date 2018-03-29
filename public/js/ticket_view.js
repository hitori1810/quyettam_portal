$(function(){
    // Init validation
    var rules = {
        'message': {
            required: true,
            minlength: 100,
        },
    };
    
    var messages = {
        'message': {
            required: Lang.ticket_view.message_empty_error_msg,
            minlength: Lang.ticket_view.message_too_short_error_msg,
        },
    };
    
    App.initValidation('form-comment', rules, messages);    
    
});