<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'id',
        'nama',
        'email',
        'jenis_kelamin',
        'alamat',
        'created_at',
        'updated_at',
        'uuid'
    ];

    protected $hidden = [
        'id',
    ];

    public function findByUUID($uuid){
        return (new static)->where('uuid', $uuid)->first();
    }
}
