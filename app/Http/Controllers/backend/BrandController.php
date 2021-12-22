<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function allBrand()
    {
        $brands = Brand::all();
        return view('backend.brand.index',compact('brands'));
    }
    public function storeBrand(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required|unique:brands',
        ]);
      $data = $request->all();
      $slug = Str::slug($request->title);
      $count = Brand::where('slug',$slug)->count();
      if($count > 0){
          $slug = $slug.'-'.date('ymdis').'-'.rand(0.999);
      }
      $data['slug']= $slug;
      $status = Brand::create($data);
      if($status){
          request()->session()->flash('success','Brand successfully created');

      }
      else{
          request()->session()->flash('error','Error Please try again');
      }
      return redirect()->route('allBrand');

    }
    public function deleteBrand($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return back();

    }
    public function editBrand($id)
    {
        $brand = Brand::find($id);
       return view('backend.brand.edit',compact('brand'));
    }
    public function updateBrand(Request $request, $id)
    {
        $brand = Brand::find($id);
        $this->validate($request,[
            'title'=>'string|required|unique:brands',
        ]);
        $data = $request->all();
        $status = $brand->fill($data)->save();
        return redirect()->route('allBrand');
    }
      
}
