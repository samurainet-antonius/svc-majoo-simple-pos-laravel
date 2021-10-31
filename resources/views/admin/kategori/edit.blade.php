@extends('admin.layouts.app')
@section('content')

<h1>Edit Kategori</h1>
<hr/>
<form method="post">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" class="form-control" name="nama_kategori" id="title">
        <p class="text-danger" id="nama_kategori"></p>
    </div>

    <div class="form-group">
        <label>URL Kategori</label>
        <input type="text" class="form-control" name="url_kategori" readonly id="seotitle">
        <p class="text-danger" id="url_kategori"></p>
    </div>

    <button class="btn btn-primary btn-sm">Simpan</button>
</form>

<script>
    let accssToken = localStorage.getItem('token');
    let accessToken = JSON.parse(accssToken).token;

        $.ajax({
            url: url_api+'kategori/<?= last(explode('/',Request::path())); ?>',
            method: 'get',
            beforeSend:function(xhr){
                xhr.setRequestHeader("Authorization", 'Bearer '+accessToken);

            },success:function(response){
                  
                $("#title").val(response.data.nama_kategori);
                $("#seotitle").val(response.data.url_kategori);

            },error:function(xhr){
                let response = xhr.responseJSON;
                if(response.code == 400){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/admin/kategori/add'; }
  		            toastr.warning(response.message);
                }

                if(response.code == 401){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/login'; }
  		            toastr.warning(response.message);
                }
                
                if(response.code == 422){
                    let errors = response.errors;
                
                    if($.isEmptyObject(errors) === false){
                        $.each(errors,(key,value) =>{
                            $(`#${key}`)
                                .append(`<i class='help-block'>*${value[0]}</i>`)
                        })
                    }
                }
            }
        });

        $("form").submit(function(event){
        event.preventDefault();

        let form = $(this);

        $.ajax({
            url: url_api+'kategori/edit/<?= last(explode('/',Request::path())); ?>',
            method: 'PUT',
            data: form.serialize(),
            beforeSend:function(xhr){
                xhr.setRequestHeader("Authorization", 'Bearer '+accessToken);
                form.find('.help-block').detach();

            },success:function(response){
                toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                toastr.options.onHidden = function() { window.location.href = '/admin/kategori'; }
  		        toastr.success(response.message);
                  

            },error:function(xhr){
                let response = xhr.responseJSON;
                if(response.code == 400){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/admin/kategori/add'; }
  		            toastr.warning(response.message);
                }

                if(response.code == 401){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/login'; }
  		            toastr.warning(response.message);
                }
                
                if(response.code == 422){
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