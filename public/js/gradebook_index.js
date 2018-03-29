var loading = new Spinner();
var detail;
$(document).ready(function(){

    $("#class_id").select2({
        'language' : locale,    
    });

    $(".container").on("change",'#class_id',function(){
        getGradebookContent()
    });
    function getGradebookContent() {

        loading.show("Processing...");
        var _this = $("#class_id");
        if(_this.val() == '') {
            $('.gradebook_content').html("");
            $('.gradebook_result').html("");
            loading.hide();
            return;
        }
        jQuery.ajax({ 
            url: "getGradebookDetail", 
            type: "POST", 
            async: true,
            data:{   
                class_id: _this.val(),                                                     
            }, 
            success: function(data){       
                //console.log(data) ;  
                data = $.parseJSON(data);
                $('.gradebook_content').html(data.html);
                $('.gradebook_result').html(data.total_result);
                detail =  data.detail;
                loading.hide();
            },
            error: function(){                    
                $('.gradebook_content').html("");
                $('.gradebook_result').html("");
                loading.hide();
            },
        }); 
    }
    getGradebookContent();

    $(".container").on("click",".btn_detail", function(){
        var _this = $(this);
        var data = _this.attr('data');
        $("#gradebook_detail .modal-body").html(detail[data]);
        $('#gradebook_detail').modal("show");        
    });
    
});