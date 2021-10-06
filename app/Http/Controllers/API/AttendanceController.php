<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function showAttendance()
    {
        $data = Attendance::orderBy('id', 'DESC')
            ->get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Show Attendance!',
                ],
                'data' => [
                    'attendace' => $data
                ],
            ]
        );
    }

    public function showUserAttendance($id)
    {
        $data = Attendance::where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Show User Attendance!',
                ],
                'data' => [
                    'attendace' => $data
                ],
            ]
        );
    }

    public function clockIn(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'time' => [
                    'required'
                ],
                'lat' => [
                    'required'
                ],
                'long' => [
                    'required'
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
            $data = Attendance::create([
                'user_id' => auth()->user()->id,
                'type' => 'In',
                'time' => $request->time,
                'lat' => $request->lat,
                'long' => $request->long,
            ]);

            return response()->json(
                [
                    'meta' => [
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Success Attendance In!',
                    ],
                    'data' => [
                        'attendance' => $data
                    ],
                ]
            );
        }
    }

    public function clockOut(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'time' => [
                    'required'
                ],
                'lat' => [
                    'required'
                ],
                'long' => [
                    'required'
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
            $data = Attendance::create([
                'user_id' => auth()->user()->id,
                'type' => 'Out',
                'time' => $request->time,
                'lat' => $request->lat,
                'long' => $request->long,
            ]);

            return response()->json(
                [
                    'meta' => [
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Success Attendance Out!',
                    ],
                    'data' => [
                        'attendance' => $data
                    ],
                ]
            );
        }
    }

    public function historyAttendace()
    {
        $data = Attendance::where('id', auth()->user()->id)
            ->get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Attendance History!',
                ],
                'data' => [
                    'attendance' => $data
                ],
            ]
        );
    }
}
