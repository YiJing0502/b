<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    // 後台＿產品列表頁
    public function index() {
        $product = Product::orderBy('id', 'desc')->get()->map(function ($item) {
            // 資料多塞 timeFormat
            $item->timeFormat = $item->created_at->format('Y/m/d');
            return $item;
        });
        return Inertia::render('Backend/Product/Index', ['response' => rtFormat($product)]);
    }
    // 後台＿新增產品頁
    public function create() {
        return Inertia::render('Backend/Product/Create');
    }
    // 後台＿新增產品頁＿儲存新增
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|min:0',
            'public' => 'required|numeric',
            'desc' => 'required|max:255',
        ]);
        // dd($request->all());
        $product=Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'public' => $request->public,
            'desc' => $request->desc,
        ]);

        return back()->with(['message' => rtFormat($product)]);
    }
    // 後台＿編輯產品頁
    public function edit($id) {
        // 找到特定一支產品
        $product = Product::find($id);
        // 如果找不到
        if(!$product) {
            return redirect(route('product.list'))->with(['message' => rtFormat($id, 0, '查無資料')]);
        }
        // 回傳頁面、產品資訊用Inertia
        return Inertia::render('Backend/Product/Edit', ['response' => rtFormat($product)]);
        // $product後不寫會傳預設值
    }
    // 後台＿編輯產品頁_儲存編輯
    public function update(Request $request) {
        // 驗證
        // 帶兩包的寫法
        $request->validate([
            'formData.name' => 'required|max:255',
            'formData.price' => 'required|min:0',
            'formData.public' => 'required|numeric',
            'formData.desc' => 'required|max:255',
            'id' => 'required|exists:products,id',
        ]);
        $product = Product::find($request->id);
        // dd($request->formData['name']);
        // formData是array

        $product->update([
            'name' => $request->formData['name'],
            'price' => $request->formData['price'],
            'public' => $request->formData['public'],
            'desc' => $request->formData['desc'],
         ]);
        //  back誰發送的請求，送回去
        // with->laravel session flash
         return back()->with(['message'=> rtFormat($product)]);
    }
    // 後台＿刪除產品
    public function delete(Request $request) {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);
        // dd($request->all());
        $product = Product::find($request->id)->delete();
        // 不渲染只傳資料
        return back()->with(['message' => rtFormat($product)]);
    }
}
