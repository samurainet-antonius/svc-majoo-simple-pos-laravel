<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
use App\Models\User;
use App\Utils\FuncValidation;
use App\Utils\FuncUUID;

class AuthController extends Controller
{
    use FuncValidation, FuncUUID;

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $errors = $this->validation($request->all(), $rules);
        if($errors != null){
            return response()->json([
                'code' => 422,
                'errors' => $errors
            ],422);
        }

        $credentials = $request->only('email', 'password');

        try {

            $user = User::where([
                ['email',$request->email],
                ['role', $request->role]
            ])->first();


            if(!$user){
                return response()->json([
                    'code' => 400,
                    'message' => 'Email atau password tidak sesuai.'
                ], 400);
            }

            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Email atau password tidak sesuai.'
                ], 400);
            }
        } catch (JWTException $e) {

            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.'
            ],500);
        }

        return response()->json([
            'code' => 200,
            'token' => $token,
            'expired' => 3600
        ],200);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Pengguna tidak ditemukan.'
                ],401);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'code' => 400,
                'message' => 'Token login sudah kadaluwarsa.'
            ],400);

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'code' => 400,
                'message' => 'Token login tidak sesuai.'
            ],400);

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.'
            ],500);

        }

        return response()->json(compact('user'));
    }

    public function logout(){
        try{
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'code' => 200,
                'message' => 'Berhasil keluar dari sistem.'
            ],200);
        }catch(Exception $e){
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.'
            ],500);
        }
    }
}
