<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    //
    public function index() {
        return Inertia::render('Backend/Product/Index');
    }
    public function create() {
        return Inertia::render('Backend/Product/Create');
    }
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
}
