<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function allCategory() {

        $categories = Category::latest()->paginate(5);

        //$categories = DB::table('categories')->latest()->paginate(5);

        return view('admin.category.index', compact('categories'));
    }

    public function addCategory(Request $request) {
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:50',
        ],
        [
           'category_name.required' => 'Please input category name',
           'category_name.max' => 'Max lenght of category is 50', 
        ]);

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

}
