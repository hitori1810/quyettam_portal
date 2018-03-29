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
            required: Lang.complaint_add.subject_empty_error_msg,
        },
        'contents': {
            required: Lang.complaint_add.content_empty_error_msg,
            minlength: Lang.complaint_add.content_too_short_error_msg,
        },
    };
    
    App.initValidation('form-add-complaint', rules, messages);    
    
});