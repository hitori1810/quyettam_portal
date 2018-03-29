/*
*   app.js
*   Author: Hieu Nguyen
*   Date: 2016-03-16
*   Purpose: To handle application level logic
*/

var App = {
    initDatatables: function() {
        // Set the defaults option for Datatables
        $.extend(true, $.fn.dataTable.defaults, {
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sLengthMenu": Lang.app.datatable_length_menu,
                "sSearch": Lang.app.datatable_search,
                "sZeroRecords": Lang.app.datatable_zero_records,
                "sInfo": Lang.app.datatable_footer_info,
                "sInfoFiltered": Lang.app.datatable_footer_info_filtered,
                "sInfoEmpty": Lang.app.datatable_footer_info_empty,
            },
            "oClasses": {
                "sLength": "dataTables_length",
                "sLengthSelect": "form-control length-select input-rounded ml-sm",
                "sFilter": "dataTables_filter pull-right",
                "sFilterInput": "form-control filter-input input-rounded ml-sm"
            },
        });
        
        // Default class modification for Datatables
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sWrapper": "dataTables_wrapper form-inline"
        });

        // Custom sort functions
        $.extend($.fn.dataTableExt.oSort, {
            'number-asc': function (a, b) {
                a = parseFloat(a);
                if(isNaN(a))
                    a = 0;

                b = parseFloat(b);
                if(isNaN(b))
                    b = 0;

                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            'number-desc': function (a, b) {
                a = parseFloat(a);
                if(isNaN(a))
                    a = 0;

                b = parseFloat(b);
                if(isNaN(b))
                    b = 0;

                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });

        $.extend($.fn.dataTableExt.oSort, {
            'timestamp-asc': function (a, b) {
                a = new Date(a);
                if(a == 'Invalid Date')
                    a = new Date('1970-01-01');

                b = new Date(b);
                if(b == 'Invalid Date')
                    b = new Date('1970-01-01');

                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            'timestamp-desc': function (a, b) {
                a = new Date(a);
                if(a == 'Invalid Date')
                    a = new Date('1970-01-01');

                b = new Date(b);
                if(b == 'Invalid Date')
                    b = new Date('1970-01-01');

                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });

        // API method to get paging information
        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
            return {
                "iStart":         oSettings._iDisplayStart,
                "iEnd":           oSettings.fnDisplayEnd(),
                "iLength":        oSettings._iDisplayLength,
                "iTotal":         oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage":          oSettings._iDisplayLength === -1 ? 0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages":    oSettings._iDisplayLength === -1 ? 0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        // Bootstrap style pagination control
        $.extend($.fn.dataTableExt.oPagination, {
            "bootstrap": {
                "fnInit": function(oSettings, nPaging, fnDraw) {
                    var oLang = oSettings.oLanguage.oPaginate;
                    var fnClickHandler = function (e) {
                        e.preventDefault();
                        if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
                            fnDraw(oSettings);
                        }
                    };

                    $(nPaging).append(
                        '<ul class="pagination no-margin pull-right">' +
                        '<li class="prev disabled"><a href="#"><i class="zmdi zmdi-more-horiz"></i></a></li>' +
                        '<li class="next disabled"><a href="#"><i class="zmdi zmdi-more-horiz"></i></a></li>' +
                        '</ul>'
                    );
                    
                    var els = $('a', nPaging);
                    $(els[0]).bind('click.DT', {action: "previous"}, fnClickHandler);
                    $(els[1]).bind('click.DT', {action: "next"}, fnClickHandler);
                },

                "fnUpdate": function (oSettings, fnDraw) {
                    var iListLength = 5;
                    var oPaging = oSettings.oInstance.fnPagingInfo();
                    var an = oSettings.aanFeatures.p;
                    var i, ien, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);

                    if (oPaging.iTotalPages < iListLength) {
                        iStart = 1;
                        iEnd = oPaging.iTotalPages;
                    }
                    else if (oPaging.iPage <= iHalf) {
                        iStart = 1;
                        iEnd = iListLength;
                    } else if (oPaging.iPage >= (oPaging.iTotalPages-iHalf)) {
                        iStart = oPaging.iTotalPages - iListLength + 1;
                        iEnd = oPaging.iTotalPages;
                    } else {
                        iStart = oPaging.iPage - iHalf + 1;
                        iEnd = iStart + iListLength - 1;
                    }

                    for (i = 0, ien = an.length ; i< ien; i++) {
                        // Remove the middle elements
                        $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                        // Add the new list items and their event handlers
                        for (j = iStart; j <= iEnd; j++) {
                            sClass = (j == oPaging.iPage + 1) ? 'class="active"' : '';
                            $('<li '+ sClass +'><a href="#">'+ j +'</a></li>')
                                .insertBefore( $('li:last', an[i])[0])
                                .bind('click', function (e) {
                                    e.preventDefault();
                                    oSettings._iDisplayStart = (parseInt($('a', this).text(), 10) - 1) * oPaging.iLength;
                                    fnDraw(oSettings);
                                });
                        }

                        // Add / remove disabled classes from the static elements
                        if (oPaging.iPage === 0) {
                            $('li:first', an[i]).addClass('disabled');
                        } else {
                            $('li:first', an[i]).removeClass('disabled');
                        }

                        if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0) {
                            $('li:last', an[i]).addClass('disabled');
                        } else {
                            $('li:last', an[i]).removeClass('disabled');
                        }
                    }
                }
            }
        } );
        
        // Init datatables by default
        $('.datatable').not('.datatable-manual').each(function() {
            var columns = [];

            $(this).find('thead th').each(function(){
                var column = {};

                if ($(this).attr('data-sortable') == 'false') {
                    column.bSortable = false;
                } else {
                    column.bSortable = true;
                }

                if ($(this).attr('data-type') == null) {
                    column.sType = $(this).attr('data-type');
                }

                columns.push(column);
            });

            $(this).dataTable({
                "aoColumns": columns,
                "retrieve": true
            });
        });
    },
    
    // Util function to init validation
    initValidation: function(formId, rules, messages) {
        $('#' + formId).validate({
            rules: rules,
            messages: messages,
            errorPlacement: function(error, element) {
                // Move error message outside the fg line
                var fgLine = element.closest('.fg-line');
                
                if(fgLine[0] != null){
                    error.insertAfter(fgLine);
                }
            },
            // On on error
            highlight: function (element, errorClass) {
                var formGroup = $(element).closest('.form-group');
                
                formGroup.addClass('has-error');
                formGroup.removeClass('has-success');
            },
            // On success
            success: function(errors, element) {
                var formGroup = $(element).closest('.form-group');
                
                formGroup.removeClass('has-error');
                formGroup.addClass('has-success');
            }
        });
    },
};

$(function() {
    // Ask the user if they really want to log out or not
    $('#menu-logout').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        
        Dialog.confirm(Lang.app.logout_confirm_title, Lang.app.logout_confirm_msg,Lang.app.logout_confirm_oklabel, Lang.app.logout_confirm_cancellabel, function() {
            location.href = url;    
        });
    }); 
});