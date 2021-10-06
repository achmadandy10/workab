<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Visiting;
use Illuminate\Http\Request;

class VisitingController extends Controller
{
    public function showVisiting()
    {
        $data = Visiting::orderBy('id', 'DESC')
            ->get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Show Visiting!',
                ],
                'data' => [
                    'visiting' => $data
                ],
            ]
        );
    }

    public function showShopVisiting($id)
    {
        $shop = Shop::where('id', $id)
            ->first();

        $data = Visiting::where('shop_id', $id)
            ->get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Shop ' . $shop->id . ' - ' . 'Visiting',
                ],
                'data' => [
                    'visiting' => $data
                ],
            ]
        );
    }

    public function shopVisiting(Request $request, $qrcode)
    {
        $shop = Shop::where('barcode', $qrcode)
            ->first();

        $data = Visiting::create([
            'user_id' => auth()->user()->id,
            'shop_id' => $shop->id,
            'lat' => $request->lat,
            'long' => $request->long,
        ]);

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Success Visiting Shop ' . $shop->name,
                ],
                'data' => [
                    'visiting' => $data
                ],
            ]
        );
    }

    public function updateStockVisiting(Request $request, $id)
    {
        $product_name = $request->name;
        $product_stock = $request->stock;

        $lengt_product = count($product_name);

        $data = [];

        for ($i = 0; $i < $lengt_product; $i++) {
            $check_product = Product::where('shop_id', $id)
                ->where('name', $product_name[$i])
                ->first();

            if ($check_product != null) {
                dd($check_product);
                $product = Product::where('shop_id', $id)
                    ->where('name', $product_name[$i])
                    ->update([
                        'name' => $product_name[$i],
                        'stock' => $product_stock[$i],
                    ]);

                array_push($data, $product);
            }
        }

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Update Stock Success!',
                ],
                'data' => [
                    'visiting' => $data
                ],
            ]
        );
    }

    public function historyVisiting()
    {
        $data = Visiting::where('user_id', auth()->user()->id)
            ->get();

        return response()->json(
            [
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Show History Visiting!',
                ],
                'data' => [
                    'visiting' => $data
                ],
            ]
        );
    }
}
