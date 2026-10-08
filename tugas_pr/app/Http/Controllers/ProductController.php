<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $cart = session()->get('cart', []);
        $totalCartItem = array_sum($cart);

        return view('products.index', compact('products', 'totalCartItem'));
    }
}
