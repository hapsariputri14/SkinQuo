<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk (catalog).
     */
    public function index()
    {
        $products = Product::paginate(12);

        return view('pages.catalog', compact('products'));
    }

    /**
     * Tampilkan detail produk.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('pages.product-detail', compact('product'));
    }
}
