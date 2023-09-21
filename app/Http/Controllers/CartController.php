<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Cart;

class CartController extends Controller
{
    //
    public function shopCart (Request $request)
    {
        // 找到使用者
        $user = $request->user();
        // 用關聯去拿到使用者購物車的資料
        // $carts = $user->cart;
        // 從Models去拿
        $carts = Cart::select('id','product_id','qty','user_id')->where('user_id', $user->id)->with(['product:id,image_path,desc,name,price'])->get();

        return Inertia::render('Frontend/Mycart/ShopCart', ['response' => rtFormat($carts)]);
    }
}
