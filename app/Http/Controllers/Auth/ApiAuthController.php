<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{

    //register
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = \App\Models\User::create($request->toArray());
        $token = $user->createToken($user->name)->accessToken;
        $response = ['token' => $token];
        return response($response, 200);
    }

    // login
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
        {
            $response =[
                "status" => "error",
                "message" => "Something went to wrong! at all",
                'errors'=>$validator->errors()->all()
            ];
            return response($response, 401);
        }

        $user = \App\Models\User::where('email', $request->email)->with('role')->first();
        dd($user);

        if ($user) {
            if ($user->status == 'Active'){
                $data = [
                    'email' => $request->email,
                    'password' => $request->password
                ];

                if (auth()->attempt($data)) {
//                    $token = auth()->user()->createToken($user->name)->accessToken;
                    $token = $user->createToken($user->name)->accessToken;
                    $response = [
                        'status' => 'success ! at all',
                        'token' => $token,
                        'role' => $user->role->name,
                        'user' => Auth::user()
                    ];
                    return response($response, 200);

                }
                else {
                    $response = [
                        "status" => "error",
                        "message" => "Password mismatch ! at all"
                    ];
                    return response($response, 422);
                }

            }
            else {
                $response = [
                    "status" => "error",
                    "message" => "Your account is deactivated. please contact with admin."
                ];
                return response($response, 422);
            }

        }

        else {
            $response = [
                "status" => "error",
                "message" =>'User does not exist ! at all'
            ];

            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = [
            "status" => "success",
            'message' => 'You have been successfully logged out!'
        ];
        return response($response, 200);
    }
}
