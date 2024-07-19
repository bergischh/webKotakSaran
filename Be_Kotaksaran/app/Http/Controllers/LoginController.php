<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;


class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login'] ]);
    }

    public function login(Request $request)
    {
        // $credentials = $request->only('name', 'password');

        // $admin = DB::table('user')->where('name', $credentials['name'])->first();

        // if ($admin && Hash::check($credentials['password'], $admin->password)) {
        //     // Admin diotentikasi, Anda bisa menyimpan sesi atau melakukan tindakan lainnya
        //     return response()->json(['message' => 'Login successful'], 200);
        // } else {
        //     return response()->json(['error' => 'gagal Login' ], 400);
        // }
        $this->validate($request, [
            'email' => 'required|email',
            'password'  => 'required',
        ]);

        $input = $request->only('email', 'password');
        if ( ! $authorized = Auth::attempt($input)) {
            $code = 401;
            $data =[
                'status' => false,
                'data' => $code            
            ];
        }else {
            $code = 201;
            $token = $this->respondWithToken($authorized);
            $data =[
                'status' => true,
                'data' => $code,
                'token' => $token
            ];
        }

        return response()->json($data, $code);
    }  
    
    public function me() {
        return response()->json( $this->guard()->user() );
    }

    public function guard() {
        return Auth::guard();
    }
    
    public function refresh() {
        return $this->respondWithToken( $this->guard()->refresh());
    }


    public function logout()
    {
        // Tidak ada tindakan logout yang dilakukan dalam konteks stateless
        $this->guard()->logout();
        return response()->json(['message' => 'Berhasil keluar']);
    }
}
