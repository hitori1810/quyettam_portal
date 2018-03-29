$(function(){
    // Init validation
    var rules = {
        'subject': {
            required: true,
        },
        'contents': {
            required: true,            
        },
    };
    
    var messages = {
        'subject': {
            required: Lang.feedback_add.subject_empty_error_msg,
        },
        'contents': {
            required: Lang.feedback_add.content_empty_error_msg,           
        },
    };
    
    App.initValidation('form-add-feedback', rules, messages);    
    
});