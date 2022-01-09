<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

use Session;
use File;

use Illuminate\Support\Str;



class ProductController extends Controller
{
    public function allProduct()
    {
        // return  $user = User::where('status',1)->get();

    
    //  return   $user = User::where('status',1)->limit(1)->get();
        $products = Product::getAllProduct();
        // return $products;
    
        return view('backend.product.index',compact('products'));
    }
    public function addproductForm()
    {
        $brands = Brand::get();
        $categories = Category::where('parent_id',NULL)->get();
        return view('backend.product.create',compact('brands','categories'));
    }
    public function storeproduct(Request $request)
    {
        // return $request->all();
      
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'nullable',
            'size'=>'nullable',
            'stock'=>'required|numeric',
            'cat_id'=>'required|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'

        ]);
       
        $product = new Product();
        $product->title = $request->title;
        $product->summary = $request->summary;
        $product->description = $request->description;
        $size = $request->input('size');
        if($size){
            $product->size = implode(',',$size);
        }
        else{
            $product->size = '';
        }
        $product->stock = $request->stock;
        $product->cat_id = $request->cat_id;
        $product->child_cat_id = $request->child_cat_id;
        $product->brand_id = $request->brand_id;
        $product->is_featured = $request->is_featured;
        $product->status = $request->status;
        $product->condition = $request->condition;
        $product->discount = $request->discount;
        $product->price = $request->price;
        $product->slug = Str::slug($request->title) ;
        if($request->photo){
           
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $name = time().$product->id.'.'.$ext;
            $path = "images/products";
            $file->move($path, $name);
            $product->photo = $name;
            $product->save();
        }
        $product->save();

        $users = User::where('status',1)->get();


        foreach($users as $user){

        $data=$user->toArray();

        Mail::send('admin.mail',['val'=>$data], function($message) use ($data){
            $message->to($data['email']);
            $message->subject('mail');
        });

    }

     


        return redirect()->route('allProduct')->with('success','Product successfull added');




    }
    public function editproduct($id)
    {
        $brand = Brand::get();
        $product = Product::findOrFail($id);
        $category = Category::where('parent_id', NULL)->get();
        $items = Product::where('id', $id)->get();
        //return $items;
        return view('backend.product.edit')->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)->with('items', $items);
    }
    public function updateproduct(Request $request, $id)
    {

        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'nullable',
            'size'=>'nullable',
            'stock'=>'required|numeric',
            'cat_id'=>'required|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'

        ]);
        $product = Product::find($id);

        $product->title = $request->title;
        $product->summary = $request->summary;
        $product->description = $request->description;
        $size = $request->input('size');
        if($size){
            $product->size = implode(',',$size);
        }
        else{
            $product->size = '';
        }
        $product->stock = $request->stock;
        $product->cat_id = $request->cat_id;
        $product->child_cat_id = $request->child_cat_id;
        $product->brand_id = $request->brand_id;
        $product->is_featured = $request->is_featured;
        $product->status = $request->status;
        $product->condition = $request->condition;
        $product->discount = $request->discount;
        $product->price = $request->price;
        $product->slug = Str::slug($request->title) ;
        if($request->photo){
            if(File::exists('images/products/'.$product->photo)){
                File::delete('images/products'.$product->photo);
            }
           
            $file = $request->file('photo');
            $ext = $file->getClientOriginalExtension();
            $name = time().$product->id.'.'.$ext;
            $path = "images/products";
            $file->move($path, $name);
            $product->photo = $name;
            $product->save();
        }
        $product->save();
        return redirect()->route('allProduct')->with('success','Product successfull updated');


    }
    public function deleteproduct($id)
    {
        $product = Product::find($id)->delete();
        Session()->flash('success','Product successfull deleted');
        return redirect()->route('allProduct');
    }

    public function detailsproduct($id)
    {
        $product = Product::find($id);
        
        return view('frontend.pages.detail',compact('product'));

    }

    public function validateAmount(Request $request)
    {
       // $request->all();
        // dd( $request->all());

        $id = $request->has('pid')?$request->get('pid'):'';

        $product_amount = Product::find($id)->stock;

        if($request->has('qty') && $request->get('qty') > $product_amount){
            return json_encode([
                'success'=>true,
                'message'=>'Product must me less than'. $product_amount
            ]);
        }
        else{
            return json_encode([
                'success'=>false
            ]);
        }

    }
}
