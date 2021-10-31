@extends('admin.layouts.app')
@section('content')

<h1>Edit Produk</h1>
<hr/>
<form method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Kategori</label>
        <select name="kategori" id="nama_kategori" class="form-control select2" height="100"></select>
        <p class="text-danger" id="kategori"></p>
    </div>

    <div class="form-group">
        <label>Produk</label>
        <input type="text" class="form-control" name="nama_produk" id="title">
        <p class="text-danger" id="nama_produk"></p>
    </div>

    <div class="form-group">
        <label>URL</label>
        <input type="text" class="form-control" name="url_produk" readonly id="seotitle">
        <p class="text-danger" id="url_produk"></p>
    </div>

    <div class="form-group">
        <label>Deskripsi</label>
        <textarea class="form-control ckeditor" name="deskripsi_produk"></textarea>
        <p class="text-danger" id="deskripsi_produk"></p>
    </div>

    <div class="form-group">
        <label>Harga</label>
        <input type="text" class="form-control" name="harga_produk">
        <p class="text-danger" id="harga_produk"></p>
    </div>

    <div class="form-group">
        <label>Gambar</label>
        <br/>
        <img id="gambar" width="200" class="mb-3">
        <input type="file" id="foto" class="form-control" name="foto_produk">
        <p class="text-danger" id="foto_produk"></p>
    </div>

    <div id="progress-wrp">
        <div class="progress-bar"></div >
        <div class="status">0%</div>
    </div>

    <button id="simpan" class="btn btn-primary btn-sm">Simpan</button>
</form>

<script>
    let accssToken = localStorage.getItem('token');
    let accessToken = JSON.parse(accssToken).token;

    $.ajax({
            url: url_api+'produk/<?= last(explode('/',Request::path())); ?>',
            method: 'get',
            beforeSend:function(xhr){
                xhr.setRequestHeader("Authorization", 'Bearer '+accessToken);

            },success:function(response){
                  
                $("input[name=nama_produk]").val(response.data.nama_produk);
                $("input[name=url_produk]").val(response.data.url_produk);
                $("input[name=harga_produk]").val(response.data.harga_produk);
                CKEDITOR.instances['deskripsi_produk'].setData(response.data.deskripsi_produk);
                $("#gambar").attr("src",`/images/produk/${response.data.foto_produk}`);

            },error:function(xhr){
                let response = xhr.responseJSON;
                if(response.code == 400){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/admin/produk/edit/<?= last(explode('/',Request::path())); ?>'; }
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
    
    $("#simpan").click(function(event){
        event.preventDefault();

        let formdata = new FormData();
        let form = $(this);

        var fileUpload = $('#foto').get(0).files;
        var file = fileUpload[0];
        if(file){
            formdata.append("foto_produk", file);
        }
        
        var kategori = ($("select[name=kategori]").val() == null) ? '' : $("select[name=kategori]").val();

        formdata.append("kategori", kategori);
        formdata.append("nama_produk", $("input[name=nama_produk]").val());
        formdata.append("url_produk", $("input[name=url_produk]").val());
        formdata.append("deskripsi_produk", CKEDITOR.instances['deskripsi_produk'].getData());
        formdata.append("harga_produk", $("input[name=harga_produk]").val());
        formdata.append("_method", 'PUT');
        formdata.append("_token", $("input[name=_token]"));

        console.log(formdata);

        $.ajax({
            url: url_api+'produk/edit/<?= last(explode('/',Request::path())); ?>',
            enctype:'multipart/form-data',
            method: 'POST',
            data: formdata,
            processData: false,
            contentType: false,
            xhr: function(){
                //upload Progress
                var xhr = $.ajaxSettings.xhr();
                if(file){
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(event) {

                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable){
                                percent = Math.ceil(position / total * 100);
                            }
                            //update progressbar
                            $(".progress-bar").css("width", + percent +"%");
                            $(".status").text(percent +"%");
                        }, true);
                    }
                }
                return xhr;
            },beforeSend:function(xhr){
                xhr.setRequestHeader("Authorization", 'Bearer '+accessToken);
                form.find('.help-block').detach();
                $(".progress-bar").css("width", "0%");

            },success:function(response){
                toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                toastr.options.onHidden = function() { window.location.href = '/admin/produk'; }
  		        toastr.success("Data berhasil disimpan.");
                  

            },error:function(xhr){
                let response = xhr.responseJSON;
                if(response.code == 400){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/admin/produk/add'; }
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