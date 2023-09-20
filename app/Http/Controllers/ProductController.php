<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    // 解構fileService
    public function __construct(protected FileService $fileService)
    {
    }
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
            'image' => 'required|string',
        ]);
        // dd($request->all());
        $product=Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'public' => $request->public,
            'desc' => $request->desc,
            'image_path' => $this->fileService->base64Upload($request->image, 'product'),
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
            'formData.image' => 'string',
        ], [
            'formData.name.required' => '名稱必填',
            'formData.price.required' => '價格必填',
            'formData.public.required' => '狀態必填',
            'formData.desc.required' => '描述必填',
        ]);
        // dd($request->formData['image']);
        // 找到哪一筆資料
        $product = Product::find($request->id);
        if ($request->formData['image']) {
            // 刪除原圖片
            $this->fileService->deleteUpload($product->image_path);
            $product->update([
                // formData是array
                'name' => $request->formData['name'],
                'price' => $request->formData['price'],
                'public' => $request->formData['public'],
                'desc' => $request->formData['desc'],
                'image_path' => $this->fileService->base64Upload($request->formData['image'], 'product'),
            ]);
        } else {
            $product->update([
                // formData是array
                'name' => $request->formData['name'],
                'price' => $request->formData['price'],
                'public' => $request->formData['public'],
                'desc' => $request->formData['desc'],
             ]);
        }
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
        // 先取得資料來源
        $product = Product::find($request->id);
        // 刪除圖片檔案(因為有檔案要先刪除，不然資料刪除後找不到圖片路徑)
        $this->fileService->deleteUpload($product->image_path);
        // 刪除資料
        $product->delete();
        // 不渲染只傳資料
        return back()->with(['message' => rtFormat($product)]);
    }
}
