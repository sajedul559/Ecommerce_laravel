<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){

       $product_id = $request->pro_id;
       $product_qty = $request->quantity;
       if(Auth::check())
       {
           $prod_check = Product::where('id',$product_id)->first();
           if($prod_check)
           {
               if(Cart::where('product_id',$product_id)->where('user_id',Auth::id())->exists())
               {
                return response()->json(['status'=>" Product already added to cart"]);

               }
               else
               {
                $cartItem = new Cart();
                $cartItem->product_id = $product_id;
                $cartItem->user_id = Auth::id();
                $cartItem->quantity = $product_qty;
                $cartItem->save();
                return response()->json(['status'=>"Product added to cart"]);
               }
           }
       }
       else{
           return response()->json(['status' => "login to continue"]);
       }
        return $request->all();
    }
    public function shoppingCart()
    {
       // $user = Auth::user();
    
       $user_carts = Cart::where('user_id',Auth::id())->get();
      $cart_count =   $user_carts->count();
      $message = "Your Cart is empty";
        //return $user_carts;
        return view('frontend.pages.cart',compact('user_carts','message'));
    }
    public function checkout()
    {
        return view('frontend.pages.checkout');
    }

  
}
