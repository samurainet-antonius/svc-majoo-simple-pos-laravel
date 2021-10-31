<?php

namespace App\Utils;
use DB;

trait FuncUUID
{
    function uuid_short(){
        try{
            $uuid_short = DB::select("SELECT UUID_SHORT() as uuidShort")[0]->uuidShort;
            return $uuid_short;
        }catch(Exception $e){
            return response()->json([
                'code' => 400,
                'message' => 'Terjadi kesalahan pada server.'
            ],400);
        }
        
    }

    function uuid(){
        try{
            $uuid = DB::select("SELECT UUID() as uuid")[0]->uuid;
            return $uuid;
        }catch(Exception $e){
            dd($e->getMessage());
            return response()->json([
                'code' => 400,
                'message' => 'Terjadi kesalahan pada server.'
            ],400);
        }
    }
}