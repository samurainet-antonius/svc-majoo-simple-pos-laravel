@extends('layouts.app')
@section('content')
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Majoo Teknologi Indonesia</h1>
        <p class="lead text-muted">majoo, aplikasi wirausaha lengkap yang dapat diandalkan, untuk solusi segala jenis bisnis agar lebih maju.</p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4" id="produk">
        <div class="col">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>

            <div class="card-body">
              <h3 class="card-title text-center">Hello</h3>
              <div class="text-center mt-3 mb-3">
                <span><b>Rp. 2.750.000</b></span>
              </div>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Beli</button>
                </div>
                <small class="text-muted">Paket</small>
              </div>
            </div>
          </div>
        </div>
        
        
      </div>
    </div>
  </div>

  <script>
      $.ajax({
            url:url_api+'produk',
            method:'get',
            data:'page=1&limit=99999',
            success:function(response){
                let data = response.data;
                let row = '';
                $.each(data,(key,value) =>{
                    row += `<div class="col"><div class="card shadow-sm"><img src="/images/produk/${value['foto_produk']}" class="img-responsive"><div class="card-body"><h3 class="card-title text-center">${value['nama_produk']}</h3><div class="text-center mt-3 mb-3"><span><b>${formatRupiah(value['harga_produk'],'Rp. ')}</b></span></div><p class="card-text">${value['deskripsi_produk'].substr(0,200)}...</p><div class="d-flex justify-content-between align-items-center"><div class="btn-group"><button type="button" class="btn btn-sm btn-warning">View</button><button type="button" class="btn btn-sm btn-primary">Beli</button></div><small class="text-muted">${value['nama_kategori']}</small></div></div></div></div>`;
                });
                $("#produk").html(row);


            },error:function(xhr){
                let response = xhr.responseJSON;
                if(response.code == 400){
                    toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                    toastr.options.onHidden = function() { window.location.href = '/'; }
  		            toastr.warning(response.message);
                }
            }
      })

      function formatRupiah(angka, prefix){
            let nominal = parseFloat(angka);
            return prefix+nominal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
	    }
  </script>
@endsection