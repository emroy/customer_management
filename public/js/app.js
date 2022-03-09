$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


let editC = (id) => {
    data = $(id).data('id');
    $.ajax({
        'type':'post',
        'url':'/customer/single',
        'dataType': 'json',
        'data': {id:data},
        success: (response) => {
            if(response.success){
                $.each(response.success, function(_, i){
                    $(`#editCustomerForm input[name='${_}']`).val(i);
                });
            } else {
                Swal.fire("Warning",response.error,'error');
            }
        }
    });

    $("#editCustomerModal").toggle('modal');
};

let saveEdit = () => {

    let data = $("form#editCustomerForm").serializeArray();
    
    if(!validate("#editCustomerForm")){
        return;
    };
    
    if(!emailOkay(data[1].value)){
        Swal.fire('Please introduce a valid email...','','warning');
        return;
    };

    $.ajax({
        'type':'post',
        'url':'/customer/update',
        'dataType': 'json',
        'data': $("form#editCustomerForm").serialize(),
        success: (response) => {
            if(response.success){
                Swal.fire("All Done",response.success,'success');
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                Swal.fire("Warning",response.error,'error');
            }
        }
    });

};

let saveCustomer = () => {

    let data = $("form#newCustomerForm").serializeArray();
    
    if(!validate("#newCustomerForm")){
        return;
    };
    
    if(!emailOkay(data[0].value)){
        Swal.fire('Please introduce a valid email...','','warning');
        return;
    };

    $.ajax({
        'type':'post',
        'url':'/customer/new',
        'dataType': 'json',
        'data': $("form#newCustomerForm").serialize(),
        success: (response) => {
            if(response.success){
                Swal.fire("All Done",response.success,'success');
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                Swal.fire("Warning",response.error,'error');
            }
        }
    });




};

let validate = (form) => {
            
    let data = $(`${form} input[data-check="true"]`);
    console.log(data);
    
    let vali = true;

    data.each(function(_, item){
        if($(item).val() == ""){
            Swal.fire('Please fill the required fields...','','warning');
            vali = false;
            return
        }
    });

    return vali;

}

let deleteC = (ele) => {
    id = $(ele).data('id');
    element = $(ele);
    Swal.fire({
        title: 'Delete Customer?',
        showDenyButton: true,
        icon:'warning',
        showCancelButton: true,
        confirmButtonText: `Yes`,
        denyButtonText: `Cancel`,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                'type':'post',
                'url':'/customer/delete',
                'dataType': 'json',
                'data': {'id':id},
                success: (response) => {
                    if(response.success){
                        Swal.fire("All Done");
                        element.parent().parent().fadeOut();    
                    } else {
                        Swal.fire(response.error);
                    }
                }
            });
        }
    })
};


let emailOkay = (email) => {
    return String(email).toLowerCase().match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

let newCustomer = () => {
    $("#newCustomerModal").toggle('modal');
};


$(function() {

    $('#example').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "/customer/api",
        },
        "columns": [
            {"data": "email"},
            {"data": "first_name"},
            {"data": "last_name"},
            {"data": "postcode"},
            {
                "orderable": false, 
                "searchable": false,
                "data": "action",
                "name": "action",
            }
        ]});

        $("[data-dismiss]").click(function(e){
            e.preventDefault();
            $($(this).data('dismiss')).toggle('modal');
        });
});