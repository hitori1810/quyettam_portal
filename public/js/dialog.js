/*
*   Dialog
*   Author: Hieu Nguyen
*   Date: 2016-03-16
*   Purpose: To handle dialogs
*   Dependencies: sweet-alert.js
*   Modify: Trung Nguyen 2016.07.08
*/ 

var Dialog = {
    // Show alert message with message type: '', info, success, error, warning
    alert: function(messsage, type) {
        var title = (type == 'warning') ? 'Warning' : 'Info';
        swal(title, messsage, type);
    },
    
    // Show confirm message
    confirm: function(title, messsage, confirmlable, cancellabel, callback) {
        swal({   
            title: title,   
            text: messsage,   
            type: 'warning',   
            showCancelButton: true,   
            confirmButtonColor: '#f44336',   
            confirmButtonText: confirmlable,   
            cancelButtonText: cancellabel,   
            closeOnConfirm: true 
        }, function(){   
            callback(); 
        });
    }
};