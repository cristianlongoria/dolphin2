<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Http\Requests\category\CategoryCreateRequest;
use App\Http\Requests\category\CategoryUpdateRequest;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::get();
        return view('backend.category.index', compact('categories', $categories));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function store(CategoryCreateRequest $request)
    {
        $exists = $this->searchCreateCategory($request->input('name'));
        if(!empty($request->input('name')) && $exists == false){
            $category = new Category;
            $category->name = $request->input('name');
            if(!empty($request->file('image'))){
                $file = $request->file('image');
                $name = Carbon::now()->timestamp.$file->getClientOriginalName();
                \Storage::disk('categorystore')->put($name, \File::get($file));
                $category->path_image = $name;
            }
            //$category->path_image = $request->input('image');
            $category->save();
            return redirect()->route('panel.category.index')->with('message', 'Category Saved');
        } elseif($exists){
            return redirect()->route('panel.category.create')->with('error', 'la categoria existe');
        }
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('backend.category.update', compact('category', $category));
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::find($id);

        if(!empty($request->input('name')) && !empty($category)){
            $exists = $this->searchUpdateCategory($request->input('name'), $category->id);
            if($exists == 'no existe' || $exists == 'pertenece a categoria'){
                $category->name = $request->input('name');
                if(!empty($request->file('image'))){
                    if($category->path_image != 'demoCategory.png'){
                        $this->deleteImage($category->path_image);
                    }
                    $file = $request->file('image');
                    $name = Carbon::now()->timestamp.$file->getClientOriginalName();
                    \Storage::disk('categorystore')->put($name, \File::get($file));
                    $category->path_image = $name;
                }
                $category->save();
                return redirect()->route('panel.category.index')->with('message', 'Category Updated');
            } elseif( $exists == 'existe'){
                return redirect()->route('panel.category.edit', $id)->with('error', 'la categoria existe');
            }

        }
    }

    public function destroy($id)
    {
        //
    }

    private function deleteImage($image)
    {
        if(\File::exists(public_path('images/category/'.$image))){
            \File::delete(public_path('images/category/'.$image));
        }
    }

    private function searchUpdateCategory($name, $id)
    {
        $category = Category::where('name', $name)->first();
        if(empty($category)){
            return 'no existe';
        } elseif($category->name == $name && $category->id == $id) {
            return 'pertenece a categoria';
        } elseif($name == $category->name && $id != $category->id) {
            return 'existe';
        }
    }

    private function searchCreateCategory($name)
    {
        $category = Category::where('name', $name)->first();
        if(empty($category)){
            return false;
        } else{
            return true;
        }
    }
}
