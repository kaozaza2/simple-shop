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

    public function index()
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
        $cart = collect($request->session()->pull('cart'));
        if ($cart->contains('product.id', $product->id)) {
            $cart->transform(function ($item) use ($product, $amount) {
                if ($item->product->id == $product->id) {
                    $item->amount += $amount;
                }
                return $item;
            });
        } else {
            $cart->push(Cart::addNew($product, $amount));
        }
        $request->session()->put('cart', $cart);
        $request->session()->put('message', "{$product->name} $amount ชิ้น ถูกเพิ่มลงตะกร้า");
        return redirect()->route('index');
    }

    public function cart(Request $request)
    {
        $items = collect($request->session()->get('cart'));
        $total = $items->sum(function ($item) {
            return $item->product->price * $item->amount;
        });
        return view('cart')->with('items', $items)->with('total', $total);
    }
}
