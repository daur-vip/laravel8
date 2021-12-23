<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function all()
    {

        // $categories = DB::table('categories')
        //     ->join('users', 'categories.user_id', 'users.id')
        //     ->select('categories.*', 'users.name')
        //     ->latest()->paginate(5);


        $categories = Category::latest()->paginate(5);
        $trashCategories = Category::onlyTrashed()->latest()->paginate(5);

        return view('admin.category.index', compact('categories', 'trashCategories'));
    }

    public function add(Request $request)
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

        Category::create([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
            // 'created_at' => Carbon::now(),
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

    public function edit($id)
    {

        //Query Builder
        $category = DB::table('categories')->where('id', $id)->first();

        //Eloquent ORM
        //$category = Category::find($id);

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
        ]);

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->where('id', $id)->update($data);

        return Redirect()->route('all.category')->with('success', 'Category updated successfully');
    }

    public function softDelete($id)
    {
        Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category moved to trash');
    }

    public function restore($id)
    {
        Category::onlyTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category restored successfully');
    }


    public function delete($id)
    {
        Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category deleted successfully');
    }
}
