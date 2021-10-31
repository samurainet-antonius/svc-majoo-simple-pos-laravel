<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use DB;
use App\Utils\FuncValidation;
use App\Utils\FuncUUID;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    use FuncValidation, FuncUUID;

    public function show(Request $request){
        try{

            $page = ($request->has('page')) ? $request->page : '';
            $limit = ($request->has('limit')) ? $request->limit : '10';

            $page = ($page > 1) ? ($page * $limit) - $limit : 0;

            $produk = Produk::select('produk.*','kategori.nama_kategori')
                            ->join('kategori','produk.kategori_id','kategori.id')
                            ->orderBy('created_at','DESC')
                            ->offset($page)
                            ->limit($limit)->get();
            $produkAll = Produk::get();

            $total = $produkAll->count();
            $pages = ceil($total/$limit); 


            return response()->json([
                'code' => 200,
                'total_page' => $pages,
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'data' => $produk
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

    public function detail($uuid){
        try{
            $produk = Produk::findByUUID($uuid);


            return response()->json([
                'code' => 200,
                'data' => $produk
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

    public function add(Request $request){

        $rules = [
            'kategori' => 'required',
            'nama_produk' => 'required|unique:produk',
            'harga_produk' => 'required',
            'deskripsi_produk' => 'required',
            'foto_produk' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'url_produk' => 'required|unique:produk',
        ];

        $errors = $this->validation($request->all(), $rules);
        if($errors != null){
            return response()->json([
                'code' => 422,
                'errors' => $errors
            ],422);
        }
        
        DB::beginTransaction();
        try{

            $kategori = Kategori::findByUUID($request->kategori);

            $imageName = time().'.'.$request->foto_produk->extension();  
     
            $request->foto_produk->move(public_path('images/produk'), $imageName);

            $data['kategori_id'] = $kategori->id;
            $data['nama_produk'] = $request->nama_produk;
            $data['harga_produk'] = $request->harga_produk;
            $data['deskripsi_produk'] = $request->deskripsi_produk;
            $data['foto_produk'] = $imageName;
            $data['url_produk'] = $request->url_produk;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['uuid'] = $this->uuid();
            $data['id'] = $this->uuid_short();


            
            $create = Produk::firstOrNew($data);
            DB::commit();
            if(!$create->save()){
                return response()->json([
                    'code' => 400,
                    'message' => 'Gagal menyimpan data.'
                ],400);
            }

            return response()->json([
                'code' => 201,
                'message' => 'Berhasil menambahkan data.',
                'data' => array(
                    'kategori' => $kategori->nama_kategori,
                    'nama_produk' => $request->nama_produk,
                    'harga_produk' => $request->harga_produk,
                    'deskripsi_produk' => $request->deskripsi_produk,
                    'foto_produk' => $imageName,
                    'url_produk' => $request->url_produk
                )
            ],201);

        }catch(Exception $e){
            DB::rollback();
            // save to Log


            // return json error
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.'
            ],500);
        }
    }

    public function edit(Request $request,$uuid){

        $produk = Produk::findByUUID($uuid);

        $uniqueNama = ($request->nama_produk == $produk->nama_produk) ? '' : '|unique:produk';
        $uniqueUrl = ($request->url_produk == $produk->url_produk) ? '' : '|unique:produk';

        $validationFotoProduk = ($request->hasFile('foto_produk')) ? 'required|image|mimes:jpeg,png,jpg,gif,svg' : '';

        $rules = [
            'kategori' => 'required',
            'nama_produk' => 'required'.$uniqueNama,
            'harga_produk' => 'required',
            'deskripsi_produk' => 'required',
            'foto_produk' => $validationFotoProduk,
            'url_produk' => 'required'.$uniqueUrl,
        ];

        $errors = $this->validation($request->all(), $rules);
        if($errors != null){
            return response()->json([
                'code' => 422,
                'errors' => $errors
            ],422);
        }
        
        DB::beginTransaction();
        try{

            $kategori = Kategori::findByUUID($request->kategori);

            if($request->hasFile('foto_produk')){

                // delete file
                File::delete('./images/produk/'.$produk->foto_produk);

                $imageName = time().'.'.$request->foto_produk->extension();  
                $request->foto_produk->move(public_path('images/produk'), $imageName);
                $data['foto_produk'] = $imageName;
            }

            $data['kategori_id'] = $kategori->id;
            $data['nama_produk'] = $request->nama_produk;
            $data['harga_produk'] = $request->harga_produk;
            $data['deskripsi_produk'] = $request->deskripsi_produk;
            $data['url_produk'] = $request->url_produk;
            $data['updated_at'] = date("Y-m-d H:i:s");
            
            $update = $produk->fill($data);
            DB::commit();
            if($update->isClean()){
                return response()->json([
                    'code' => 400,
                    'message' => 'Data tidak ada yang berubah.'
                ],400);
            }


            if(!$update->save()){
                return response()->json([
                    'code' => 400,
                    'message' => 'Gagal mengubah data.'
                ],400);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil mengubah data.'
            ],200);

        }catch(Exception $e){
            DB::rollback();
            // save to Log


            // return json error
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.'
            ],500);
        }
    }

    public function delete($uuid){

        try{

            $produk = Produk::findByUUID($uuid);
            File::delete('./images/produk/'.$produk->foto_produk);
            $delete          = $produk->delete();

            if(!$delete){
                return response()->json([
                    'code' => 400,
                    'message' => 'Gagal menghapus data.',
                ],400);
            }

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil menghapus data.',
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
