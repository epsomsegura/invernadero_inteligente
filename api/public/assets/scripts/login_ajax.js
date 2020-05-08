function login(){
    var data = {
        "email" : $('#email').val(),
        "password" : $('#password').val()
    };

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    url:   loginRoute,
    data: data,
    type:  'post',
    success:  function (data) {
//        alert(data.data);
        $("#form_message").html("");
        $("#form_message").html(data.data);
        if(data.success == true){            
            window.location.href = homeRoute;
        }           
    }
});
};
