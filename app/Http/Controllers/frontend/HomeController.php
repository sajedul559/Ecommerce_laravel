<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function shop(){
        return view('frontend.pages.shop');
    }
    public function cart(){
        return view('frontend.pages.cart');
    }
    public function contact(){
        return view('frontend.pages.contact');
    }
    public function checkout()
    {
        return view('frontend.pages.checkout');
    }
    public function about()
    {
        return view('frontend.pages.about');
    }
    public function detail()
    {
        return view('frontend.pages.detail');
    }
}
