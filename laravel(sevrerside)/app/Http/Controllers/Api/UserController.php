<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use UserTrait;

    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'img' => 'required|mimes:jpg,png,jpeg'
        ]);

        if ($this->CheckValidations($validators))
        {
            return $this->ReturnErrorsResponse($validators);
        }

        $file_name = $this->UploadImage($request->img);

        User::create($this->ReturnRequestData($request , $file_name));
        return $this->ReturnResponse('OK' , 'User Created Successfully!');
    }

    public function edit($id)
    {
        try {
            return User::query()->find($id);
        } catch (\Exception $exception) {
            return $this->ReturnResponse('FAIL' , '!!User Not Found');
        }
    }

    public function update(User $user, Request $request)
    {
        $validators = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'confirmed',
            'img' => 'mimes:jpg,png,jpeg',
        ]);

        if ($this->CheckValidations($validators))
        {
            return $this->ReturnErrorsResponse($validators);
        }

        $file_name =  $request->file('img')  ?  $this->UploadImage($request->file('img'))  :  $request->lastImage;

        $user->update($this->ReturnRequestData($request , $file_name , $user));

        return $this->ReturnResponse('OK' , '.User Updated Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->ReturnResponse('OK' , 'User Deleted Successfully!!');
    }
}
