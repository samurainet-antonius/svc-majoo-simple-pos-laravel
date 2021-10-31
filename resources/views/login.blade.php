@extends('layouts.app')
@section('content')
<style>
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
<div class="form-signin mt-5">
    <form method="POST" action="{{ env('URL_API') }}auth/login" class="needs-validation" novalidate>
        @csrf
        <div class="text-center">
            <img class="mb-4" src="https://majoo.id/assets/img/main-logo.png" alt="">
        </div>

        <p class="text-center mb-3 fw-normal">Silahkan login untuk mengakses akun anda.</p>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email" placeholder="name@example.com">
            <label for="email">Email address</label>
            <p id="email" class="text-danger"></p>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <label for="password">Password</label>
            <p id="password" class="text-danger"></p>
        </div>

        <button class="mt-3 w-100 btn btn-lg btn-primary" type="submit">Login</button>
    </form>
</div>
<script>

    // check login
    let token = localStorage.getItem('token');
    if(token){
        window.location.href = '/admin/home';
    }

    $("form").submit(function(event){
        event.preventDefault();

        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: 'post',
            data: form.serialize(),
            beforeSend:function(xhr){
                form.find('.help-block').detach();

            },success:function(response){
                let accessToken = JSON.stringify(response);
                localStorage.setItem('token',accessToken);
                toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,"positionClass": "toast-bottom-right"}
                toastr.options.onHidden = function() { window.location.href = '/admin/home'; }
  		        toastr.success("Anda berhasil login.");
                  

            },error:function(xhr){
                let response = xhr.responseJSON;
                if(response.code == 400){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,"positionClass": "toast-bottom-right"}
                    toastr.options.onHidden = function() { window.location.href = '/login'; }
  		            toastr.warning(response.message);
                }else{
                    let errors = response.errors;
                
                    if($.isEmptyObject(errors) === false){
                        $.each(errors,(key,value) =>{
                            $(`#${key}`)
                                .append(`<i class='help-block'>*${value[0]}</i>`)
                        })
                    }
                }
            }
        })
    });
</script>
@endsection