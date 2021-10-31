@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-6">
        <div class="card-box bg-blue">
            <div class="inner">
                <h3 id="kategori"> 13436 </h3>
                <p class="text-white"> Kategori </p>
            </div>
            <div class="icon">
                <i class="fa fa-tags" aria-hidden="true"></i>
            </div>
            <a href="{{ route('kategori') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-sm-6">
        <div class="card-box bg-green">
            <div class="inner">
                <h3 id="produk"> 13436 </h3>
                <p class="text-white"> Produk </p>
            </div>
            <div class="icon">
                <i class="fa fa-cube" aria-hidden="true"></i>
            </div>
            <a href="{{ route('produk') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-sm-6">
        <div class="card-box bg-red">
            <div class="inner">
                <h3 id="pelanggan"> 13436 </h3>
                <p class="text-white"> Pelanggan </p>
            </div>
            <div class="icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <a href="{{ route('produk') }}" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<script>
    let accssToken = localStorage.getItem('token');
    let accessToken = JSON.parse(accssToken).token;
     $.ajax({
            url:url_api+'report',
            method:'get',
            beforeSend:function(xhr){
                xhr.setRequestHeader("Authorization", 'Bearer '+accessToken);

            },
            success:function(response){
                let data = response.data;
                let row = '';
                $.each(data,(key,value) =>{
                    $(`#${key}`).html(value);
                });

            },error:function(xhr){
                let response = xhr.responseJSON;
                if(response.code == 400){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/admin/produk'; }
  		            toastr.warning(response.message);
                }

                if(response.code == 401){
                        toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                        toastr.options.onHidden = function() { window.location.href = '/login'; }
                        toastr.warning(response.message);
                }
            }
        })
</script>
@endsection