<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function allCategory()
    {

        // $categories = DB::table('categories')
        //     ->join('users', 'categories.user_id', 'users.id')
        //     ->select('categories.*', 'users.name')
        //     ->latest()->paginate(5);

   
        $categories = Category::latest()->paginate(5);
        $trashCategories = Category::onlyTrashed()->latest()->paginate(5);

        return view('admin.category.index', compact('categories', 'trashCategories'));
    }

    public function addCategory(Request $request)
    {
        $validatedData = $request->validate(
            [
                'category_name' => 'required|unique:categories|max:50',
            ],
            [
                'category_name.required' => 'Please input category name',
                'category_name.max' => 'Max lenght of category is 50',
            ]
        );

        Category::insert([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->save();

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category inserted successfully');
    }

    public function editCategory($id)
    {

        //Query Builder
        $category = DB::table('categories')->where('id', $id)->first();
        
        //Eloquent ORM
        //$category = Category::find($id);

        return view('admin.category.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        // $update = Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        // ]);

        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        DB::table('categories')->where('id', $id)->update($data);

        return Redirect()->route('all.category')->with('success', 'Category updated successfully');
    }

    public function softDeleteCategory($id)
    {
        Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category moved to trash');
    }
}
