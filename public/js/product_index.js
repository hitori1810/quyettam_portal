function editProduct(this_tr){
    var url = this_tr.find('.btn_edit').attr("url");
    var record = this_tr.attr("record_id");       
    window.location.href = url + "?id=" + record;
}