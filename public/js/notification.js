/*
*   Notification
*   Author: Hieu Nguyen
*   Date: 2016-03-16
*   Purpose: To handle notification
*   Depenencies: bootstrap-growl.min.js
*/

var Notification = {
    
    notify: function(message, type, url, icon){
        $.growl({
            icon: icon,
            message: message,
            url: url
        },
        {
            element: 'body',
            type: type || 'success',
            allow_dismiss: true,
            offset: {
                x: 20,
                y: 85
            },
            spacing: 10,
            z_index: 1031,
            delay: 2500,
            timer: 1000,
            url_target: '_blank',
            mouse_over: false,
            animate: {
                enter: 'animated bounceInRight',
                exit: 'animated bounceOutRight'
            },
            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
                '<button type="button" class="close" data-growl="dismiss">' +
                    '<span aria-hidden="true">&times;</span>' +
                    '<span class="sr-only">Close</span>' +
                '</button>' +
                '<span data-growl="icon"></span>' +
                '<span data-growl="title"></span>' +
                '<span data-growl="message"></span>' +
                '<a href="#" data-growl="url"></a>' +
            '</div>'
        });
    }    
};