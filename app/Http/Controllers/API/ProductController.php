<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product($id)
    {
        $shop = Shop::where('id', $id)
            ->first();

        $data = Product::where('shop_id', $id)
            ->get();


        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Shop ' . $shop->name . ' - ' . 'Product Detail',
                ],
                'data' => [
                    'product' => $data
                ],
            ]
        );
    }

    public function addProduct(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required'
                ],
                'stock' => [
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
            $data = Product::create([
                'shop_id' => $id,
                'name' => $request->name,
                'stock' => $request->stock,
            ]);

            return response()->json(
                [
                    'meta' => [
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Shop ' . $id . ' - ' . 'Product Add',
                    ],
                    'data' => [
                        'product' => $data
                    ],
                ]
            );
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('id', $id)
            ->first();

        $request->name == null ? $name = $product->name : $name = $request->name;
        $request->stock == null ? $stock = $product->stock : $stock = $request->stock;


        Product::where('shop_id', $id)
            ->update([
                'name' => $name,
                'stock' => $stock,
            ]);

        $data = Product::where('id', $id)
            ->first();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Product ' . $product->name . ' - ' . 'Success Update!',
                ],
                'data' => [
                    'product' => $data
                ],
            ]
        );
    }

    public function deleteProduct($id)
    {
        $data = Product::where('id', $id)
            ->first()
            ->delete();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Product  Success Delete!',
                ],
                'data' => [
                    'message' => 'Product delete success!'
                ],
            ]
        );
    }
}
