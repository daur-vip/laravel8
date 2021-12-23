<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class BrandController extends Controller
{
    public function all(){

        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function add(Request $request)
    {
        $validatedData = $request->validate(
            [
                'brand_name' => 'required|unique:brands|max:50',
                'brand_image' => 'required|mimes:jpg,jpeg,png',
            ],
            [
                'brand_name.required' => 'Please input brand name',
                'brand_name.max' => 'Max lenght of brand name is 50',
                'brand_image.required' => 'Brand image is necessary',
                'brand_image.mimes' => 'Please add image file',
            ]
        );

        $brandImage = $request->file('brand_image');
        
        $imageNameGen = hexdec(uniqid());
        $imageExtension = strtolower($brandImage->getClientOriginalExtension());
        $newImageName = $imageNameGen.'.'.$imageExtension;

        $uploadLocation = 'images/brands/';
        $fullImagePath = $uploadLocation.$newImageName;

        $brandImage->move($uploadLocation, $newImageName);

        Brand::create([
            'brand_name' => $request->brand_name,
            'brand_image' => $fullImagePath,
        ]);

        return Redirect()->back()->with('success', 'Brand added successfully');

    }
}
