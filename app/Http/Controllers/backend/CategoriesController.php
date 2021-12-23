<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Category;
use File;

class CategoriesController extends Controller
{
    public function allCategory()
    {
        $parent_cat = Category::where('id',2)->first();
        // dd($parent_cat->parent->title);
        $categories = Category::all();
        return view('backend.category.index',compact('categories'));
    }
    public function addCategoryForm()
    {
        $parent_categories = Category::where('parent_id',NULL)->orderBy('title','ASC')->get();
        
        return view('backend.category.create',compact('parent_categories'));
    }
    public function storeCategory(Request $request)
    {
       
        $request->validate([
            'title'=>'required',
            'image'=>'required',

        ]);
       
        $category = new Category();
     

      
        //  if($request->image){
        //      $file = $request->file('image');
        //      $extension = $file->getClientOriginalExtension();
        //      $name = time().'.'.$extension;
        //      $location = "images/category";
        //      $file->move($location.$name);
        //  }
        if ($request->image) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = time() . '-' . $category->id . '.' . $ext;
            $path = "images/category";
            $file->move($path, $name);
            
        }
         
         
        $category->title = $request->title;
        $category->slug = Str::slug($request->title);
        $category->summary = $request->summary;
        $category->photo = $name;
        $category->status = $request->status;
        $category->parent_id = $request->parent_id;
        $category->save();
        return back();

    }
    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        return back();

    }
    public function editCategory($id)
    {
        $parent_categories = Category::where('parent_id',NULL)->orderBy('title','ASC')->get();

        $category = Category::find($id);
       return view('backend.category.edit',compact('category','parent_categories'));
    }
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'title'=>'required',

        ]);
       
        $category = Category::find($id);
        $category->title = $request->title;
        $category->slug = Str::slug($request->title);
        $category->summary = $request->summary;
        $category->status = $request->status;
        $category->parent_id = $request->parent_id;
     
        if ($request->image) {
            if(File::exists('images/category/'.$category->image)){
                File::delete('images/category/'.$category->image);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = time() . '-' . $category->id . '.' . $ext;
            $path = "images/category";
            $file->move($path, $name);
            $category->photo = $name;

            
        }        
     
       
        $category->save();
        return redirect()->route('allCategory');
    }
      
}
