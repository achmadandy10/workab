<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUser()
    {
        $data = User::where('role', 'User')
            ->get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Show User!',
                ],
                'data' => [
                    'user' => $data
                ],
            ]
        );
    }

    public function showProfileUser($id)
    {
        $data = User::where('id', $id)
            ->first();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User Profile - ' . $data->name,
                ],
                'data' => [
                    'user' => $data
                ],
            ]
        );
    }

    public function addUser(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'nik' => [
                    'required'
                ],
                'name' => [
                    'required'
                ],
                'email' => [
                    'required'
                ],
                'username' => [
                    'required'
                ],
                'password' => [
                    'required'
                ],
                'gender' => [
                    'required',
                ],
            ]
        );

        if ($validate->fails()) {
            return response()->json(
                [
                    'meta' => [
                        'status' => 'error',
                        'message' => 'Validation Error',
                    ],
                    'data' => [
                        'validation_errors' => $validate->errors()
                    ],
                ]
            );
        } else {
            if ($request->photo == null) {
                $photo = 'https://ui-avatars.com/api/?name=' . $request->name . '&color=7F9CF5&background=EBF4FF';
            } else {
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension();
                $file_name = $request->username . '_' . 'AVATAR' . '.' . $extension;
                $file->move('avatar/', $file_name);

                $photo = env('FILE_URL') . 'avatar/' . $file_name;
            }

            $data = User::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => $request->password,
                'gender' => $request->gender,
                'photo' => $photo,
            ]);

            return response()->json(
                [
                    'meta' => [
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'User ' . $data->name . ' Success Create!',
                    ],
                    'data' => [
                        'user' => $data
                    ],
                ]
            );
        }
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where('id', $id)
            ->first();

        $request->nik == null ? $nik = $user->nik : $nik = $request->nik;
        $request->name == null ? $name = $user->name : $name = $request->name;
        $request->email == null ? $email = $user->email : $email = $request->email;
        $request->username == null ? $username = $user->username : $username = $request->username;

        if ($request->password == null) {
            $password = $user->password;
        } else {
            $hash_password = bcrypt($request->password);
            $password = $hash_password;
        }

        $request->gender == null ? $gender = $user->gender : $gender = $request->gender;

        if ($request->photo == null) {
            $photo = 'https://ui-avatars.com/api/?name=' . $name . '&color=7F9CF5&background=EBF4FF';
        } else {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $file_name = $username . '_' . 'AVATAR' . '.' . $extension;
            $file->move('avatar/', $file_name);

            $photo = env('FILE_URL') . 'avatar/' . $file_name;
        }

        User::where('id', $id)
            ->update([
                'nik' => $nik,
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'gender' => $gender,
                'photo' => $photo,
            ]);

        $data = User::where('id', $id)
            ->first();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User ' . $data->name . ' Success Update!',
                ],
                'data' => [
                    'user' => $data
                ],
            ]
        );
    }

    public function deleteUser($id)
    {
        $data = User::where('id', $id)
            ->first()
            ->delete();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User Success Delete!',
                ],
                'data' => [
                    'message' => 'User delete success!'
                ],
            ]
        );
    }

    public function profile()
    {
        $data = User::where('id', auth()->user()->id)
            ->first();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User Profile',
                ],
                'data' => [
                    'user' => $data
                ],
            ]
        );
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('id', auth()->user()->id)
            ->first();

        $request->nik == null ? $nik = $user->nik : $request->nik;
        $request->name == null ? $name = $user->name : $request->name;
        $request->email == null ? $email = $user->email : $request->email;
        $request->username == null ? $username = $user->username : $request->username;

        if ($request->password == null) {
            $password = $user->password;
        } else {
            $hash_password = bcrypt($request->password);
            $password = $hash_password;
        }

        $request->gender == null ? $gender = $user->gender : $gender = $request->gender;

        if ($request->photo == null) {
            $photo = 'https://ui-avatars.com/api/?name=' . $name . '&color=7F9CF5&background=EBF4FF';
        } else {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $file_name = $username . '_' . 'AVATAR' . '.' . $extension;
            $file->move('avatar/', $file_name);

            $photo = env('FILE_URL') . 'avatar/' . $file_name;
        }

        User::where('id', auth()->user()->id)
            ->update([
                'nik' => $nik,
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => $password,
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
                    'message' => 'User Success Update Profile',
                ],
                'data' => [
                    'user' => $data
                ],
            ]
        );
    }
}
