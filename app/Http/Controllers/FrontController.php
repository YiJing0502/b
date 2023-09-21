<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class FrontController extends Controller
{
    //
    public function home() {
        $product = Product::orderBy('id', 'desc')->where('public', 1)->get();

        return Inertia::render('Frontend/Index', [
            'response' => rtFormat($product),
        ]);
    }
    public function product () {
        $product = Product::orderBy('id', 'desc')->where('public', 1)->get();
        return Inertia::render('Frontend/Product', [
            'response' => rtFormat($product),
        ]);
    }
    public function addCart(Request $request) {
        $request->validate([
            'id' => 'required|exists:products,id',
            'qty' => 'required|numeric|min:1',
        ]);
        // 找到符合使用者、產品的這一筆資料儲存在 $cart
        // dd($request->all());
        $cart = Cart::where('product_id', $request->id)->where('user_id', $request->user()->id)->first();
        if($cart) {
            $cart->update([
                // 原本的數量加上新增的數量
                'qty' => $cart->qty + $request->qty,
            ]);
        } else {
            // $cart在外面原本是null，但在這邊重新賦值給它
            $cart = Cart::create([
               'product_id' => $request->id,
               'user_id' => $request->user_id,
               'qty' => $request->qty,
            ]);
        }
        return back()->with(['message' => rtFormat($cart->id)]);
    }
}
