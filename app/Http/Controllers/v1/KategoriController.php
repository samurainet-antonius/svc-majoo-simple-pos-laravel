<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use DB;
use App\Utils\FuncValidation;
use App\Utils\FuncUUID;

class KategoriController extends Controller
{
    use FuncValidation, FuncUUID;

    
    public function show(Request $request){
        try{

            $page = ($request->has('page')) ? $request->page : '';
            $limit = ($request->has('limit')) ? $request->limit : '10';

            $page = ($page > 1) ? ($page * $limit) - $limit : 0;

            $kategori = Kategori::orderBy('created_at','DESC')->offset($page)->limit($limit)->get();
            $kategoriAll = Kategori::get();

            $total = $kategoriAll->count();
            $pages = ceil($total/$limit); 


            return response()->json([
                'code' => 200,
                'total_page' => $pages,
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'data' => $kategori
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

    public function search(Request $request){
        try{

            $search = ($request->has('search')) ? $request->search : '';
            if(!empty($search)){
                $kategori = Kategori::select('nama_kategori','uuid')->where('nama_kategori','like','%'.$search.'%')->orderBy('created_at','DESC')->get();
            }else{
                $kategori = Kategori::select('nama_kategori','uuid')->orderBy('created_at','DESC')->get();
            }


            return response()->json([
                'code' => 200,
                'data' => $kategori
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
            $kategori = Kategori::findByUUID($uuid);


            return response()->json([
                'code' => 200,
                'data' => $kategori
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
            'nama_kategori' => 'required|unique:kategori',
            'url_kategori' => 'required|unique:kategori',
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

            $data['nama_kategori'] = $request->nama_kategori;
            $data['url_kategori'] = $request->url_kategori;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['uuid'] = $this->uuid();
            $data['id'] = $this->uuid_short();
            
            $create = Kategori::firstOrNew($data);
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
                    'nama_kategori' => $request->nama_kategori,
                    'url_kategori' => $request->url_kategori,
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

        $kategori = Kategori::findByUUID($uuid);
        
        $uniqueUrl = ($kategori->url_kategori == $request->url_kategori) ? '' : '|unique:kategori';
        $uniqueNama = ($kategori->nama_kategori == $request->nama_kategori) ? '' : '|unique:kategori';


        $rules = [
            'nama_kategori' => 'required'.$uniqueNama,
            'url_kategori' => 'required'.$uniqueUrl,
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

            $data['nama_kategori'] = $request->nama_kategori;
            $data['url_kategori'] = $request->url_kategori;
            $data['updated_at'] = date("Y-m-d H:i:s");
            
            $update = $kategori->fill($data);
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

            $kategori = Kategori::findByUUID($uuid);
            $produk = Produk::where('kategori_id',$kategori->id)->get();

            if($produk->count() > 0){
                return response()->json([
                    'code' => 400,
                    'message' => 'Gagal menghapus data, terdapat data produk yang terhubung.',
                ],400);
            }

            $delete          = $kategori->delete();

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
