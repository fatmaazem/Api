<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
class CartController extends Controller
{
    public function add(Request $request)
    {
       
$product=Product::find($request->productId);
 Cart::add($product->id, $product->name, $request->qty, $product->price);
        return response()->json(Cart::content());
           // 'status' => 'success',
            //'cart'   => Cart::content()->toArray() //
        
    }
}
