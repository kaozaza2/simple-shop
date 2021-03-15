<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $amount = $request->amount;
        $product = Product::find($request->product);
        $cart = collect($request->session()->get('cart', []));
        if ($item = $cart->firstWhere('product.id', $product->id)) {
            $item->amount += $amount;
        } else {
            $cart->push(Cart::createItem($product, $amount));
        }
        $request->session()->put('cart', $cart);
        $request->session()->put('message', "{$product->name} $amount ชิ้น ถูกเพิ่มลงตะกร้า");
        return redirect()->route('index');
    }

    public function updateCart(Request $request)
    {
        $amount = $request->amount;
        $product = Product::find($request->product);
        $cart = collect($request->session()->get('cart', []));
        if ($item = $cart->firstWhere('product.id', $product->id)) {
            if ($request->mode == 'force') {
                $item->amount = intval($amount);
            } else {
                $item->amount += $amount;
            }
            if ($item->amount <= 0) {
                $key = $cart->search(function ($i) use ($item) {
                    return $i->product->id == $item->product->id;
                });
                $cart->forget($key);
                $item = null;
            }
            $request->session()->put('cart', $cart);
            if (count($cart) == 0) {
                return response()->json(null, 201);
            } else {
                $total = $cart->sum(function ($i) {
                    return $i->product->price * $i->amount;
                });
                return response()->json(['data' => $item, 'total' => $total]);
            }
        }
        return response()->json(null, 404);
    }

    public function cart(Request $request)
    {
        $items = collect($request->session()->get('cart', []));
        $total = $items->sum(function ($i) {
            return $i->product->price * $i->amount;
        });
        return view('cart')->with('items', $items)->with('total', $total);
    }

    private function array_deep_search($value, $key, $array) {
        $skey = explode('.', $key);
        $count = empty($key) ? 0 : count($skey);
        foreach ($array as $inkey => $invalue) {
            $subvalue = $invalue;
            for ($i = 0; $i < $count; $i++) {
                $subvalue = $subvalue[$skey[$i]];
            }
            if ($subvalue == $value) {
                return $inkey;
            }
        }
        return false;
    }
}
