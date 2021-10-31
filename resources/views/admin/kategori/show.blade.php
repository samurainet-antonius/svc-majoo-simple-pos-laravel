@extends('admin.layouts.app')
@section('content')

<h1>Kategori</h1>
<hr/>
<div class="row">
    <div class="col-md-1">
        <select name="filter" id="filter" class="form-control">
            <option value="2" selected>2</option>
            <option value="5">5</option>
            <option value="10">10</option>
        </select>
    </div>
    <div class="col-md-11">
        <a href="{{ route('add-kategori') }}" class="float-right btn btn-primary mb-3">Tambah</a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>URL</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="kategori"></tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination" id="pagination"></ul>
    </nav>
</div>

<script>
    let accssToken = localStorage.getItem('token');
    let accessToken = JSON.parse(accssToken).token;
    function getCategories(page=0,limit=1){

        $.ajax({
            url:url_api+'kategori',
            method:'get',
            data:'page='+page+'&limit='+limit,
            success:function(response){
                let data = response.data;
                let total_page = response.total_page;
                let row = '';
                let page = '';
                $.each(data,(key,value) =>{
                    row += `<tr><td>${value['nama_kategori']}</td><td>${value['url_kategori']}</td><td>
                    <a href='/admin/kategori/edit/${value['uuid']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='#' type="button" onclick="hapus('${value['uuid']}')" class='btn btn-danger btn-sm'>Hapus</a></td></tr>`;
                });
                $("#kategori").html(row);

                for(let i = 1; i<= total_page; i++){
                    page += `<li class="page-item"><a class="page-link" onclick="paginate(${i},${limit})" href="#">${i}</a></li>`;
                }
                $("#pagination").html(page);


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
    }

    var limit = $("#filter").val();
    getCategories(0,limit);

    function paginate(page,limit){
        getCategories(page,limit);    
    }

    $("#filter").on('change',function(){
       var limit = $(this).val();
        getCategories(1,limit);    
   })

    function hapus(uuid){
        if (confirm('Apakah anda yakin akan menghapus data ini?')){
            $.ajax({
                url:url_api+'kategori/delete/'+uuid,
                method:'DELETE',
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", 'Bearer '+accessToken);
                },
                success:function(response){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/admin/kategori'; }
                    toastr.success(response.message);
                },error:function(xhr){
                    let response = xhr.responseJSON;
                    if(response.code == 400){
                        toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                        toastr.options.onHidden = function() { window.location.href = '/admin/kategori'; }
                        toastr.warning(response.message);
                    }

                    if(response.code == 401){
                        toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                        toastr.options.onHidden = function() { window.location.href = '/login'; }
                        toastr.warning(response.message);
                    }
                }
            })
        }
    }

</script>
@endsection