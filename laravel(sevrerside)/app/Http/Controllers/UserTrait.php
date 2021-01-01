<?php


namespace App\Http\Controllers;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait UserTrait
{
    public function UploadImage($file)
    {
        $file_name = Str::random(20) . '-' . $file->getClientOriginalName();
        $file->move('uploads', $file_name);

        return 'uploads/' . $file_name;
    }

    public function ReturnRequestData($request , $file_name , $user=null)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => isset($request->password) ? Hash::make($request->password) : $user->password,
            'img' => $file_name,
        ];
    }

    public function ReturnResponse($status , $message)
    {
        return response()->json(['status' => $status, 'message' => $message] , 200);
    }

    public function CreateAndReturnNewToken($user , $request)
    {
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
}
