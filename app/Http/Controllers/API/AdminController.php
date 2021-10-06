<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function profile()
    {
        $data = User::where('id', auth()->user()->id)
            ->first();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Admin Profile',
                ],
                'data' => [
                    'admin' => $data,
                ],
            ]
        );
    }

    public function updateProfile(Request $request)
    {
        $profile = User::where('id', auth()->user()->id)
            ->first();

        $request->nik == null ? $nik = $profile->nik : $nik = $request->nik;
        $request->name == null ? $name = $profile->name : $name = $request->name;
        $request->email == null ? $email = $profile->email : $email = $request->email;
        $request->username == null ? $username = $profile->username : $username = $request->username;
        $request->gender == null ? $gender = $profile->gender : $gender = $request->gender;
        $request->photo == null ? $photo = $profile->photo : $photo = $request->photo;

        User::where('id', auth()->user()->id)
            ->update([
                'nik' => $nik,
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'gender' => $gender,
                'photo' => $photo,
            ]);

        $data = User::where('id', auth()->user()->id)
            ->first();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Admin Profile Update',
                ],
                'data' => [
                    'admin' => $data,
                ],
            ]
        );
    }
}
