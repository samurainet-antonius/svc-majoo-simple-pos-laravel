<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'id',
        'kategori_id',
        'nama_produk',
        'harga_produk',
        'deskripsi_produk',
        'foto_produk',
        'url_produk',
        'created_at',
        'updated_at',
        'uuid'
    ];

    protected $hidden = [
        'id',
        'kategori_id',
    ];

    public function findByUUID($uuid){
        return (new static)->select('produk.*','kategori.nama_kategori','kategori.uuid as kategori_uuid')
                        ->join('kategori','produk.kategori_id','kategori.id')
                        ->where('produk.uuid', $uuid)
                        ->first();
    }
}
