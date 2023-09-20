<?php

namespace App\Http\Controllers;

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
}
