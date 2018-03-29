$(function() {
    var calendar = $('#calendar');

    //Generate the Calendar
    calendar.fullCalendar({
        header: {
            right: '',
            center: 'prev, title, next',
            left: ''
        },

        lang: locale,
        theme: true, //Do not remove this as it ruin the design
        selectable: true,
        selectHelper: true,
        editable: false,

        //Add Events
        events: scheduleEvents,
        timeFormat: "H:mm",
        //On Day Select
        select: function(start, end, allDay) {
            // Do nothing
        },  

        eventClick: function(calEvent, jsEvent, view) {
            $(".session_detail .class_name").text(calEvent.class_name);
            $(".session_detail .duration").text(calEvent.duration);
            $(".session_detail .starttime").text(calEvent.starttime);
            $(".session_detail .endtime").text(calEvent.endtime);
            $(".session_detail .teacher_name").text(calEvent.teacher_name);
            // $(".session_detail .room_name").text(calEvent.room_name);
                                                                       
            $(".session_detail .attended").text(calEvent.attended);
            $(".session_detail .homework").text(calEvent.homework);
            $(".session_detail .teacher_comment").text(calEvent.teacher_comment);

            $('#session_detail').modal("show");                 
        }
    });

    // Add Action button with dropdown in Calendar header.
    var actionMenu =  $('#action-menu');
    calendar.find('.fc-toolbar').append(actionMenu);

    //Calendar views
    $('body').on('click', '#fc-actions [data-view]', function(e){
        e.preventDefault();
        var dataView = $(this).attr('data-view');

        $('#fc-actions li').removeClass('active');
        $(this).parent().addClass('active');
        calendar.fullCalendar('changeView', dataView);
    });
});
