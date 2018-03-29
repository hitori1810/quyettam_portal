$(function() {
    // Init datatables
    App.initDatatables();
});

jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    'timedate-asc': function (a, b) {
        var datef = cal_date_format.replace('Y','yyyy').replace('m','M');
        var timef = cal_time_format.replace('a','tt').replace('A','tt').replace('H','hh').replace('i','mm').replace('s','ss');

        var aDate = Date.parseExact(a, datef + ' ' + timef);
        var bDate = Date.parseExact(b, datef + ' ' + timef);
        /*  if(aDate && !bDate) return 1;
        else if(!aDate && bDate) return -1;
        else if(!aDate && !bDate ) return 0;*/
        return ((aDate < bDate) ? -1 : ((aDate > bDate) ? 1 : 0));  
    },
    'timedate-desc': function (a, b) {
        var datef = cal_date_format.replace('Y','yyyy').replace('m','M');
        var timef = cal_time_format.replace('a','tt').replace('A','tt').replace('H','hh').replace('i','mm').replace('s','ss');

        var aDate = Date.parseExact(a, datef + ' ' + timef);
        var bDate = Date.parseExact(b, datef + ' ' + timef);
        /*  if(aDate && !bDate) return 1;
        else if(!aDate && bDate) return -1;
        else if(!aDate && !bDate ) return 0;*/
        return ((aDate < bDate) ? 1 : ((aDate > bDate) ? -1 : 0)); 
    }
});