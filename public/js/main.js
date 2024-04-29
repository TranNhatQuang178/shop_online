$(document).ready(function(){
    $("#form-register-customer").submit(function(e){
        e.preventDefault();
        var urlRequest = $(this).attr('data');
       var element = $(this);
        $.ajax({
            headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: urlRequest,
            method: "POST",
            data: element.serializeArray(),
            typeData: 'Json',
            success: function(response){
                if(response.errors && response.status === 500){
                    var error = response.errors;
                    if(error.name){
                        $("#name").addClass('is-invalid').next().addClass('invalid-feedback').text(error.name);
                    }else{
                        $("#name").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                    if(error.phone){
                        $("#phone").addClass('is-invalid').next().addClass('invalid-feedback').text(error.phone);
                    }else{
                        $("#phone").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                    if(error.email){
                        $("#email").addClass('is-invalid').next().addClass('invalid-feedback').text(error.email);
                    }else{
                        $("#email").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                    if(error.password){
                        $("#password").addClass('is-invalid').next().addClass('invalid-feedback').text(error.password);
                    }else{
                        $("#password").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                    if(error.confirm_password){
                        $("#cpassword").addClass('is-invalid').next().addClass('invalid-feedback').text(error.confirm_password);
                    }else{
                        $("#cpassword").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                }
                if(response.status == 200){
                    $("#name").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    $("#phone").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    $("#email").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    $("#password").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    $("#cpassword").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    $(".alert_register_success").text('Successfully registered account. Please check your email.');
                    setTimeout(() => {
                        window.location.href = response.location
                    }, 1500);
                }
            },
        });
    });
    $("#form-edit-account").submit(function(e){
        e.preventDefault();
        var urlRequest = $(this).attr('data');
        var dataView = $(this).attr('data-view');
       var element = $(this);
        $.ajax({
            headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: urlRequest,
            method: "POST",
            data: element.serializeArray(),
            typeData: 'Json',
            success: function(response){
                if(response.errors){
                    var error = response.errors;
                    if(error.name){
                        $("#name").addClass('is-invalid').next().addClass('invalid-feedback').text(error.name);
                    }else{
                        $("#name").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                    if(error.phone){
                        $("#phone").addClass('is-invalid').next().addClass('invalid-feedback').text(error.phone);
                    }else{
                        $("#phone").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                }
                if(response.status == 200){
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Edit Personal Infomation Successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function(){
                        window.location.href = dataView;
                    }, 1500)
                }
            },
        });
    });

    $("#form-chang-password-account").submit(function(e){
        e.preventDefault();
        var urlRequest = $(this).attr('data');
        var dataView = $(this).attr('data-view');
       var element = $(this);
        $.ajax({
            headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
            url: urlRequest,
            method: "POST",
            data: element.serializeArray(),
            typeData: 'Json',
            success: function(response){
                if(response.errors){
                    var error = response.errors;
                    if(error.old_password){
                        $("#old_password").addClass('is-invalid').next().addClass('invalid-feedback').text(error.old_password);
                    }else{
                        $("#old_password").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                    if(error.new_password){
                        $("#new_password").addClass('is-invalid').next().addClass('invalid-feedback').text(error.new_password);
                    }else{
                        $("#new_password").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                    if(error.confirm_password){
                        $("#confirm_password").addClass('is-invalid').next().addClass('invalid-feedback').text(error.confirm_password);
                    }else{
                        $("#confirm_password").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                }
                if(response.error){
                        $("#old_password").addClass('is-invalid').next().addClass('invalid-feedback').text(response.error);
                    }else{
                        $("#old_password").removeClass('is-invalid').next().removeClass('invalid-feedback').text('');
                    }
                if(response.status == 200){
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Change Password Successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function(){
                        window.location.href = dataView;
                    }, 1500)
                }
            },
        });
    });

});