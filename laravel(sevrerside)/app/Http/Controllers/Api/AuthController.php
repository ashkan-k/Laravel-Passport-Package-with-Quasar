<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Passport;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    use UserTrait;

    public function CheckLogin(Request $request)
    {
        return response()->json(['login_status' => \auth('api')->check()]);
    }

    public function signup(Request $request)
    {
        $validators = Validator::make($request->all() , [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'img' => 'required|mimes:jpg,jpeg,png'
        ]);

        if ($this->CheckValidations($validators))
        {
            return $this->ReturnErrorsResponse($validators);
        }

        $file = $request->img;
        $file_name = Str::random(20) . '-' . $file->getClientOriginalName();
        $file->move('uploads', $file_name);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'img' => 'uploads/' . $file_name,
        ]);

        return $this->ReturnResponse('OK' , 'Successfully created user!');
    }

    public function login(Request $request)
    {
        $validators = Validator::make($request->all() , [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if ($this->CheckValidations($validators))
        {
            return $this->ReturnErrorsResponse($validators);
        }

        if (!Auth::attempt(request(['email', 'password'])))
            return response()->json([
                'errors' => 'Unauthorized'
            ], 200);
        $user = $request->user();

        return $this->CreateAndReturnNewToken($user , $request);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return $this->ReturnResponse('OK' , 'Successfully logged out');

        } catch (\Exception $exception) {
            return $this->ReturnResponse('FAIL' , 'error while trying logout!!');
        }
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $request->user()->token()->revoke();
        return $this->CreateAndReturnNewToken($user , $request);
    }

    public function user()
    {
        return response()->json(\auth('api')->user());
    }
}
