<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Produk;

class ReportController extends Controller
{
    public function show(){
        try{

            $kategori = Kategori::get()->count();
            $produk = Produk::get()->count();
            $pelanggan = Pelanggan::get()->count();


            return response()->json([
                'code' => 200,
                'data' => array(
                    'kategori' => $kategori,
                    'produk' => $produk,
                    'pelanggan' => $pelanggan
                )
            ],200);

        }catch(Exception $e){
            
            // save to Log


            // return json error
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.'
            ],500);
        }
    }
}
