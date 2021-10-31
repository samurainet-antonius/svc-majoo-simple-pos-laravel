<?php

namespace App\Utils;

use Illuminate\Support\Facades\Validator;

trait FuncValidation
{
    public function validation ($request,$rules,$lang = null){
        $messageId = array(
            'array' => ':attribute hanya boleh berupa array',
            'alpha' => ':attribute hanya boleh berupa huruf',
            'alpha_num' => ':attribute hanya boleh berupa huruf atau angka',
            'date_format' => ':attribute format tidak sesuai',
            'email' => 'format :attribute tidak sesuai',
            'in'    => ':attribute hanya boleh diisi dengan nilai-nilai berikut: :values',
            'integer' => ':attribute hanya boleh berupa angka',
            'max' => ':attribute tidak boleh lebih dari :max karakter',
            'min' => ':attribute tidak boleh kurang dari :min karakter',
            'numeric' => ':attribute hanya boleh berupa angka',
            'required'    => ':attribute wajib diisi',
            'string' => ':attribute hanya boleh berupa huruf',
            'unique' => 'hanya boleh menggunakan :attribute yang belum ada',
            'image' => ':attribute harus berupa gambar',
            'mimes' => ':attribute harus berupa file tipe: :values'
        );
        switch ($lang){
            case "en" :
                $messages = array();
                break;
            default :
                $messages = $messageId;
        }

        $validator = Validator::make($request, $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $result = $errors;
        }else{
            $result = [];
        }
        return $result;
    }
}