@extends('admin.layouts.app')
@section('content')

<h1>Produk</h1>
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
        <a href="{{ route('add-produk') }}" class="float-right btn btn-primary mb-3">Tambah</a>
    </div>
</div> 
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Produk</th>
                <th>Deskripsi</th>
                <th>Harga (Rp)</th>
                <th>Gambar</th>
                <th>URL</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="produk"></tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination" id="pagination"></ul>
    </nav>
</div>

<script>
    let accssToken = localStorage.getItem('token');
    let accessToken = JSON.parse(accssToken).token;
    function getProducts(page=0,limit=2){

        $.ajax({
            url:url_api+'produk',
            method:'get',
            data:'page='+page+'&limit='+limit,
            success:function(response){
                let data = response.data;
                let total_page = response.total_page;
                let row = '';
                let page = '';
                $.each(data,(key,value) =>{
                    row += `<tr><td>${value['nama_kategori']}</td><td>${value['nama_produk']}</td><td>${value['deskripsi_produk'].substr(0,200)}</td><td>${formatRupiah(value['harga_produk'],'Rp. ')}</td><td>
                    <img src="/images/produk/${value['foto_produk']}" width="200">
                    </td><td>${value['url_produk']}</td><td nowrap>
                    <a href='/admin/produk/edit/${value['uuid']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='#' type="button" onclick="hapus('${value['uuid']}')" class='btn btn-danger btn-sm'>Hapus</a></td></tr>`;
                });
                $("#produk").html(row);

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
    getProducts(0,limit);

    function paginate(page,limit){
        getProducts(page,limit);    
    }

   $("#filter").on('change',function(){
       var limit = $(this).val();
        getProducts(1,limit);    
   })

    function hapus(uuid){
        if (confirm('Apakah anda yakin akan menghapus data ini?')){
            $.ajax({
                url:url_api+'produk/delete/'+uuid,
                method:'DELETE',
                beforeSend: function(request) {
                    request.setRequestHeader("Authorization", 'Bearer '+accessToken);
                },
                success:function(response){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/admin/produk'; }
                    toastr.success(response.message);
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
    }

    function formatRupiah(angka, prefix){
            let nominal = parseFloat(angka);
            return prefix+nominal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
	}

</script>
@endsection