<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::where('status',active)->get();
        return $categories;
        return view('backend.category.index');
    }
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        return back();

    }
    public function editBrand($id)
    {
        $category = Category::find($id);
       return view('backend.brand.edit',compact('brand'));
    }
    public function updateBrand(Request $request, $id)
    {
        $category = Category::find($id);
        $this->validate($request,[
            'title'=>'string|required|unique:brands',
        ]);
        $data = $request->all();
        $status = $category->fill($data)->save();
        return redirect()->route('allBrand');
    }
      
}
