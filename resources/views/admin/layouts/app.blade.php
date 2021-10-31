<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://majoo.id/favicon.png" />
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style-admin.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

     <!-- jQuery CDN - Slim version (=without AJAX) -->
     <script src="{{ mix('js/app.js') }}"></script>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>const url_api = "<?= env('URL_API'); ?>";</script>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>MAJOO INDONESIA</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="#master" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Master</a>
                    <ul class="collapse list-unstyled" id="master">
                        <li>
                            <a href="{{ route('kategori') }}">Kategori</a>
                        </li>
                        <li>
                            <a href="{{ route('produk') }}">Produk</a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan') }}">Pelanggan</a>
                        </li>
                        <li>
                            <a href="{{ route('user') }}">User</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#transaksi" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Transaksi</a>
                    <ul class="collapse list-unstyled" id="transaksi">
                        <li>
                            <a href="#">Pembelian</a>
                        </li>
                        <li>
                            <a href="#">Penjualan</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#laporan" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Laporan</a>
                    <ul class="collapse list-unstyled" id="laporan">
                        <li>
                            <a href="#">Pembelian</a>
                        </li>
                        <li>
                            <a href="#">Penjualan</a>
                        </li>
                        <li>
                            <a href="#">Penjualan per produk</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="#" type="button" onclick="logout()" class="article">Keluar</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
            </nav>

            @yield('content')
        </div>
    </div>

   
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        let tkn = localStorage.getItem('token');
        if(!tkn){
            window.location.href = '/login';
        }
        var tokenAccess = JSON.parse(tkn).token;
    </script>

    <script src="{{ asset('js/style-admin.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>CKEDITOR.replace( 'editor1' );</script>
    <script>
        $('.select2').select2({
            allowClear: true,
            placeholder: 'masukkan nama kategori',
            ajax: {
                dataType: 'json',
                url: url_api+'kategori/search',
                delay: 800,
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function (data, page) {
                    // var grouped = groupBy(data.data, 'project_type');
                    let arrData = data.data;
                    var data1 = [];
                    for (let i = 0;i < arrData.length; i++) {
                        data1.push({"id": arrData[i]['uuid'], "text": arrData[i]['nama_kategori']})
                    } 
                    return {
                        results: data1
                    };
                },
                initSelection: function (element, callback) {
                    console.log(callback);
                    callback($.map(element.val().split(','), function (id) {
                        return { id: id, text: id };
                    }));
                }
            }
        });

        function logout(){
            if (confirm('Apakah anda yakin akan keluar?')){
                $.ajax({
                    url:url_api+'auth/logout',
                    method:'get',
                    beforeSend:function(xhr){
                        xhr.setRequestHeader("Authorization", 'Bearer '+tokenAccess);
                    },
                    success:function(response){
                        localStorage.removeItem('token');
                        toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                        toastr.options.onHidden = function() { window.location.href = '/'; }
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

        function checkToken(tokens){
                $.ajax({
                    url:url_api+'auth/token',
                    method:'get',
                    beforeSend:function(xhr){
                        xhr.setRequestHeader("Authorization", 'Bearer '+tokens);

                    },
                    success:function(response){
                        console.log('login');
                        // toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                        // toastr.options.onHidden = function() { window.location.href = '/login'; }
                        // toastr.warning(response.message);
                    },error:function(xhr){
                        let response = xhr.responseJSON;
                        if(response.code == 400){
                            toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                            toastr.options.onHidden = function() { window.location.href = '/admin/produk'; }
                            toastr.warning(response.message);
                        }

                        if(response.code == 401){
                                localStorage.removeItem('token');
                                toastr.options ={"closeButton" : true,"progressBar" : true,timeOut: 1000,}
                                toastr.options.onHidden = function() { window.location.href = '/login'; }
                                toastr.warning(response.message);
                        }
                    }
                });
            }
        setInterval(checkToken(tokenAccess),100);
    </script>
</body>

</html>