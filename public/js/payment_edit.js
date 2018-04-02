$(document).ready(function(){  
//    generateTable($("#payment_detail_json").val());
})

function generateTable(str){
    var obj = JSON.parse(str);  
    $.each(obj,function(key, value){  
        $(".btnAddRow").trigger("click");    
        inserted = $("#tblPayDetail").find('tbody').find('tr:last');        
        inserted.find(".quantity").val(value.quantity);   
        inserted.find(".unit_cost").val(value.unit_cost); 
        inserted.find(".product").val(value.product);   
        inserted.find(".product").trigger("change"); 
    });  
}

function addRow(thisElement){ 
    var table = $(thisElement).closest('table');
    var template = table.find('tfoot.template');
    var newRow = template.html();
    table.find('tbody').append(newRow);
    var inserted = table.find('tbody').find('tr:last');     
}

function delRow(thisElement){
    var row = $(thisElement).closest('tr');
    row.remove(); 
}

function changeProduct(this_row){
    var unit = this_row.find(".product option:selected").attr("unit");
    var unit_cost = this_row.find(".product option:selected").attr("unit_cost");

    this_row.find(".unit_cost").val(unit_cost);
    this_row.find(".unit_cost").trigger("change");

    this_row.find(".lbl_unit").text(unit);         
    this_row.find(".unit").val(unit);         
}

function calculatePayDetailAmount(this_row){
    var quantity = this_row.find(".quantity").val();
    var unit_cost = this_row.find(".unit_cost").val();

    var amount = unit_cost * quantity;
    this_row.find(".pay_detail_amount").val(amount);
    this_row.find(".lbl_pay_detail_amount").text(amount);   
    calculatePaymentAmount();
}

function calculatePaymentAmount(){
    var total_amount = 0;

    $("#tblPayDetail tbody").find(".pay_detail_amount").each(function(){
        total_amount += parseInt($(this).val());    
    });

    $("#lbl_payment_amount").text(Lang.payment_edit.total_amount + ": " + total_amount);
    $("#payment_amount").val(total_amount);
}