<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
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
                return response()->json(['status'=>" Alreade Added to cart"]);

               }
               else
               {
                $cartItem = new Cart();
                $cartItem->product_id = $product_id;
                $cartItem->user_id = Auth::id();
                $cartItem->quantity = $product_qty;
                $cartItem->save();
                return response()->json(['status'=>"Added to cart"]);
               }
           }
       }
       else{
           return response()->json(['status' => "login to continue"]);
       }
        return $request->all();
    }

//    public function addToCart(Request $request){
//          dd($request->all());
//         if (empty($request->slug)) {
//             request()->session()->flash('error','Invalid Products');
//             return back();
//         }        
//         $product = Product::where('slug', $request->slug)->first();
//         // return $product;
//         if (empty($product)) {
//             request()->session()->flash('error','Invalid Products');
//             return back();
//         }

//         $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();
//         // return $already_cart;
//         if($already_cart) {
//             // dd($already_cart);
//             $already_cart->quantity = $already_cart->quantity + 1;
//             $already_cart->amount = $product->price+ $already_cart->amount;
//             // return $already_cart->quantity;
//             if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
//             $already_cart->save();
            
//         }else{
            
//             $cart = new Cart;
//             $cart->user_id = auth()->user()->id;
//             $cart->product_id = $product->id;
//             $cart->price = ($product->price-($product->price*$product->discount)/100);
//             $cart->quantity = 1;
//             $cart->amount=$cart->price*$cart->quantity;
//             if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
//             $cart->save();
//             $wishlist=Wishlist::where('user_id',auth()->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);
//         }
//         // request()->session()->flash('success','Product successfully added to cart');
//         // return back();
//         return response()->json($cart);       
//     }  
}
