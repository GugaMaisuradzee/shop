<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductInCart(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => $request->user()->getKey()],
        );

        if ($cart->products()->where('id', '=' ,$product->getKey())->exists())
        {
            $pivotProduct = $cart->products()->where('id', '=' ,$product->getKey())->first();
            $cart->products()->updateExistingPivot($product->getKey(), ['quantity' => $pivotProduct->pivot->quantity+1]);
        }else{
            $cart->products()->attach($product->getKey(), ['quantity' => 1]);
        }



         return redirect()->back();
    }

    public function removeProductFromCart(Request $request, Product $product)
    {
        $cart = Cart::where(
            'user_id', '=', $request->user()->getKey()
        );

        $cart->products()->detach($product);

        return redirect()->back();

    }

    public function setCartProductQuantity(Request $request, Product $product, int $quantity)
    {
        $cart = Cart::where(
            'user_id', '=', $request->user()->getKey()
        );

        $cart->products()->updateExistingPivot($product->getKey(), ['quantity' => $quantity]);
    }

    public function getUserCart()
    {

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->getKey())->with('products')->first();

        return View::make('cart', compact('cart'));
    }

}
