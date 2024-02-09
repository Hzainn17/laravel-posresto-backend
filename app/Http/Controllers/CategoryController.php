<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'image' => 'required | image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('category.index')->with('success', 'Category Successfully Added');
    }

    public function show($id){
        return view('pages.categories.show');
    }

    public function edit($id){
        $category = Category::find($id);
        return view('pages.categories.edit', compact ('category'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            //'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the existing product by ID
        $category = Category::find($id);

        // Update the product attributes
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        // Handle image upload
        if($request->hasFile('image')){
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category Successfully Updated');
    }


    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category Successfully Deleted');
    }
}
