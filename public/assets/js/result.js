function addResult() {
    var room = parseInt(document.getElementById("totalRow").value);

    if($('#service_charge_limit_break_down_discount_'+room).val() ==''){
        alert('Please enter discount..');
        $('#service_charge_limit_break_down_discount_'+room).focus();
        return false;
    }

    if($('#service_charge_limit_break_down_commission_'+room).val() ==''){
        alert('Please enter commission..');
        $('#service_charge_limit_break_down_commission_'+room).focus();
        return false;
    }

    room = room+1;
    $("#serviceChargeLimitBreakDownContent").append('' +
        '<div class="col-lg-12" id="myServiceChargeLimitBreakDownContent'+room+'">' +
        '<div class="form-group row">' +
        '<div class="col-lg-2">' +
        '<div class="kt-input-icon">' +
        '<input type="text" id="service_charge_limit_break_down_lower_'+room+'" class="form-control"' +
        'name="service_charge_limit_break_down_lower_'+room+'" placeholder="Please Enter Lower Limit"' +
        'required autofocus autocomplete="off" value="" >' +
        '</div>' +
        '</div>' +
        '<div class="col-lg-2">' +
        '<div class="kt-input-icon">' +
        '<input type="text" id="service_charge_limit_break_down_higher_'+room+'" class="form-control"' +
        'name="service_charge_limit_break_down_higher_'+room+'" placeholder="Please Enter Higher Limit"' +
        'required autofocus autocomplete="off" value="" >' +
        '</div>' +
        '</div>' +
        '<div class="col-lg-2">' +
        '<div class="kt-input-icon">' +
        '<input type="text" id="service_charge_limit_break_down_charge_'+room+'" class="form-control"' +
        'name="service_charge_limit_break_down_charge_'+room+'" placeholder="Please Enter Charge"' +
        'required autofocus autocomplete="off" value="" >' +
        '</div>' +
        '</div>' +
        '<div class="col-lg-2">' +
        '<div class="kt-input-icon">' +
        '<input type="text" id="service_charge_limit_break_down_discount_'+room+'" class="form-control"' +
        'name="service_charge_limit_break_down_discount_'+room+'" placeholder="Please Enter Discount"' +
        'required autofocus autocomplete="off" value="" >' +
        '</div>' +
        '</div>' +
        '<div class="col-lg-2">' +
        '<div class="kt-input-icon">' +
        '<input type="text" id="service_charge_limit_break_down_commission_'+room+'" class="form-control"' +
        'name="service_charge_limit_break_down_commission_'+room+'" placeholder="Please Enter Commission"' +
        'required autofocus autocomplete="off" value="" >' +
        '</div>' +
        '</div>' +
        '<div class="col-lg-2">' +
        '<button type="button" class="btn btn-primary plusBtnServiceChargeLimitBreakDown'+room+'" onclick="addServiceChargeLimitBreakDowns();">' +
        '<i class="fa fa-plus"></i>' +
        '</button>' +
        '<button type="button" class="btn btn-danger minusBtnServiceChargeLimitBreakDown'+room+'" onclick="removeServiceChargeLimitBreakDowns();">' +
        '<i class="fa fa-minus"></i>' +
        '</button>' +
        '</div>' +
        '</div>' +
        '</div>'
    );
    document.getElementById("totalRow").value=room;

    $('.plusBtnServiceChargeLimitBreakDown'+(room-1)+'').hide();
    //$('.minusBtnBankBranch'+(room-1)+'').hide();
}

function removeResult(){
    room = document.getElementById("totalRow").value;
    if(room>1){
        var parent = document.getElementById('serviceChargeLimitBreakDownContent');
        room = room-1;
        document.getElementById("totalRow").value=room;
        $('.plusBtnServiceChargeLimitBreakDown'+(room)).show();
        $('.minusBtnServiceChargeLimitBreakDown'+(room)).show();
    }else{
        alert(' 1 row should be present in table');
    }
}
