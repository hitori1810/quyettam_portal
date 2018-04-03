function editPayment(this_tr){
    var url = this_tr.find('.btn_edit').attr("url");
    var record = this_tr.attr("record_id");       
    window.location.href = url + "?id=" + record;
}

function exportPayment(this_tr){
    var record = this_tr.attr("record_id");
    var url = CRM_URL + "/?entryPoint=downloadExportFile&record=" + record;
                                                         
    window.open(url, '_blank'); 
}   