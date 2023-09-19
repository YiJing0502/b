<?php

namespace App\Http\Controllers;

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
}
