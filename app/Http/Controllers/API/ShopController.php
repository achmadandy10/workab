<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Generator;

class ShopController extends Controller
{
    public function shop()
    {
        $data = Shop::get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Show All Shop!',
                ],
                'data' => [
                    'shop' => $data,
                ],
            ]
        );
    }

    public function addShop(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required'
                ],
                'address' => [
                    'required',
                ],
                'lat' => [
                    'required',
                ],
                'long' => [
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
            $uniq_code = Str::random(60);
            $generator = new Generator;
            $qrcode = $generator->size(500)->generate($uniq_code);

            $data = Shop::create([
                'name' => $request->name,
                'address' => $request->address,
                'lat' => $request->lat,
                'long' => $request->long,
                'barcode' => $uniq_code,
                'barcode' => htmlspecialchars($qrcode),
            ]);

            return response()->json(
                [
                    'meta' => [
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Shop Success Create!',
                    ],
                    'data' => [
                        'shop' => $data
                    ],
                ]
            );
        }
    }

    public function showShop($id)
    {
        $data = Shop::where('id', $id)
            ->first();

        return response()->json([
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Show Shop - ' . $data->name,
                ],
                'data' => [
                    'shop' => $data
                ],
            ]
        ]);
    }

    public function updateShop(Request $request, $id)
    {
        $shop = Shop::where('id', $id)
            ->first();

        $request->name == null ? $name = $shop->name : $name = $request->name;
        $request->address == null ? $address = $shop->address : $address = $request->address;
        $request->lat == null ? $lat = $shop->lat : $lat = $request->lat;
        $request->long == null ? $long = $shop->long : $long = $request->long;

        Shop::where('id', $id)
            ->update([
                'name' => $name,
                'address' => $address,
                'lat' => $lat,
                'long' => $long,
            ]);

        $data = Shop::where('id', $id)
            ->first();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Shop Success Update!',
                ],
                'data' => [
                    'shop' => $data
                ],
            ]
        );
    }

    public function deleteShop($id)
    {
        $data = Shop::where('id', $id)
            ->first()
            ->delete();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Shop Success Delete!',
                ],
                'data' => [
                    'message' => 'Shop delete Success'
                ],
            ]
        );
    }
}
