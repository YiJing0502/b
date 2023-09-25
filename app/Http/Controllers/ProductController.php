<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
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
        $product = Product::orderBy('id', 'desc')->with(['productImage:product_id,image_path,sort'])->get()->map(function ($item) {
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
            'otherImage.*.image_path' => 'string',
        ]);
        // dd($request->otherImage);

        $product=Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'public' => $request->public,
            'desc' => $request->desc,
            'image_path' => $this->fileService->base64Upload($request->image, 'product'),
        ]);
        foreach ($request->otherImage ?? [] as $index => $value) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $this->fileService->base64Upload($value['image_path'], 'otherProduct'),
                'sort' => $index + 1,
            ]);
        }

        return back()->with(['message' => rtFormat($product)]);
    }
    // 後台＿編輯產品頁
    public function edit($id) {
        // 找到特定一支產品
        $product = Product::with('productImage')->find($id);
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
            'formData.image' => 'required|string',
            'otherImage.*.image_path' => 'required|string',
        ], [
            'formData.name.required' => '名稱必填',
            'formData.price.required' => '價格必填',
            'formData.public.required' => '狀態必填',
            'formData.desc.required' => '描述必填',
        ]);
        // 找到哪一筆資料
        $product = Product::find($request->id);
        // dd($request->formData['otherImage'], $product);
        if ($request->formData['image'] && $request->formData['image'] !== $product->image_path) {
            // 刪除主圖片
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
        // 從資料庫中取得與當前產品相關的其他產品圖片資料
        // 並將它們存儲在 $otherProductImage 中
        $otherProductImage = ProductImage::where('product_id', $product->id)->get();
        // 檢查是否有提交其他產品圖片資料
        if ($request->formData['otherImage']) {
            // 遍歷每一張「已經存在」的其他產品圖片
            foreach ($otherProductImage as $existingImage) {
                // 假設圖片「未在新提交的圖片中」找到（$found 為 false）
                $found = false;
                // 遍歷「新提交」的圖片數據
                foreach ($request->formData['otherImage'] ?? [] as $index => $value) {
                    // 檢查是否有相同的圖片路徑
                    if ($existingImage->image_path === $value['image_path']) {
                        // 如果在「新提交的圖片中」找到了「相同的圖片路徑」，將 $found 設置為 true，並且跳出循環。
                        $found = true;
                        break;
                    }
                }
                // 如果在「新提交的圖片中」未找到「相同的圖片路徑」（$found 為 false），則表示這張圖片需要「被刪除」
                if (!$found) {
                    // 刪除該圖片的文件，並且從資料庫中刪除該圖片記錄
                    $this->fileService->deleteUpload($existingImage->image_path);
                    $existingImage->delete();
                }
            }
            // 遍歷每一張「新提交」的其他產品圖片
            foreach ($request->formData['otherImage'] ?? [] as $index => $value) {
                // 假設圖片「未在已經存在的其他產品圖片中」找到（$found 為 false）。
                $found = false;
                // 遍歷「已經存在」的其他產品圖片，檢查是否有相同的圖片路徑
                foreach ($otherProductImage as $existingImage) {
                    // 如果在「已經存在」的其他產品圖片中找到了相同的圖片路徑，將 $found 設置為 true，並且跳出循環
                    if ($existingImage->image_path === $value['image_path']) {
                        $found = true;
                        break;
                    }
                }
                // 如果在「已經存在」的其他產品圖片中未找到相同的圖片路徑（$found 為 false），則表示這是一個新的圖片。
                if (!$found) {
                    // 創建一個新的圖片記錄，將圖片路徑添加到資料庫，並根據索引（$index + 1）設置其排序。
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $this->fileService->base64Upload($value['image_path'], 'otherProduct'),
                        'sort' => $index + 1,
                    ]);
                }
            }
        } else {
            // 如果沒有提交其他產品圖片資料，遍歷現有的每一張圖片
            foreach ($otherProductImage as $existingImage) {
                // 刪除該圖片的文件，並且從資料庫中刪除該圖片記錄
                $this->fileService->deleteUpload($existingImage->image_path);
                $existingImage->delete();
            }
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
        // 刪除多圖的圖片、資料
        if ($product) {
            foreach ($product->productImage ?? [] as $value) {
                $this->fileService->deleteUpload($value->image_path);
                $value->delete();
            }
        }
        // 刪除主要圖片檔案(因為有檔案要先刪除，不然資料刪除後找不到圖片路徑)
        $this->fileService->deleteUpload($product->image_path);
        // 刪除主資料
        $product->delete();
        // 不渲染只傳資料
        return back()->with(['message' => rtFormat($product)]);
    }
}
