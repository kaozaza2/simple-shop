<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
class MainController extends Controller
{
    public function __construct()
    {
        // TODO: empty constructor
    }

    public function index(Request $request)
    {
        $products = Product::all();
        return view('index')->with('products', $products);
    }

    public function product($productId)
    {
        $product = Product::find($productId);
        return view('product', compact('product'));
    }

    public function addcart(Request $request)
    {
        $amount = $request->input('amount');
        $product = Product::find($request->input('product'));
        $cart = $request->session()->pull('cart');
        if ($cart == null) {
            $cart = [];
        }
        $found = false;
        foreach ($cart as &$cartItem) {
            if ($cartItem->product->id == $product->id) {
                $cartItem->amount += $amount;
                $found = true;
                break;
            }
        }
        if (!$found) {
           $cart[] = Cart::addNew($product, $amount);
        }
        $request->session()->put('cart', $cart);
        $request->session()->put('message', "$amount ชิ้น ถูกเพิ่มลงตะกร้า");
        return redirect()->route('index');
    }

    public function cart(Request $request)
    {
        $items = $request->session()->get('cart', []);
        $total = 0;
        foreach ($items as $item) {
            $total += $item->product->price * $item->amount;
        }
        return view('cart')->with('items', $items)->with('total', $total);
    }
}
