/*
 *  DynamicTable.js
 *  Author: Hieu Nguyen
 *  Date: 21-04-2014
 *  Purpose: Allow to add and remove rows in a table
*/

$(function(){
    
    $('.btnAddRow').live('click', function(){
        var table = $(this).closest('table');
        var template = table.find('tfoot.template');
        var newRow = template.html();
        table.find('tbody').append(newRow);
        var inserted = table.find('tbody').find('tr:last');
    });
    
    $('.btnDelRow').live('click', function(){
        var row = $(this).closest('tr');
        row.remove();
    });

});