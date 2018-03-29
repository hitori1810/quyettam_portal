$(function(){
    // Init validation
    var rules = {
        'subject': {
            required: true,
        },
        'contents': {
            required: true,
            minlength: 100,
        },
    };
    
    var messages = {
        'subject': {
            required: Lang.ticket_add.subject_empty_error_msg,
        },
        'contents': {
            required: Lang.ticket_add.content_empty_error_msg,
            minlength: Lang.ticket_add.content_too_short_error_msg,
        },
    };
    
    App.initValidation('form-add-ticket', rules, messages);    
    
});