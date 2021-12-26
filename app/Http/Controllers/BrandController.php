<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Multipic;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Image;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');       
    }
    
    public function all()
    {

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

        $imageNameGen = hexdec(uniqid()) . '.' . strtolower($brandImage->getClientOriginalExtension());

        $fullImagePath = 'images/brands/' . $imageNameGen;

        Image::make($brandImage)->resize(300, 200)->save($fullImagePath);




        Brand::create([
            'brand_name' => $request->brand_name,
            'brand_image' => $fullImagePath,
        ]);

        return Redirect()->back()->with('success', 'Brand added successfully');
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {

        $currentBrand = Brand::find($id);
        $validatedData = $request->validate(
            [
                'brand_name' => 'required|max:50|unique:brands,brand_name,' . $id,
                'brand_image' => 'mimes:jpg,jpeg,png',
            ],
            [
                'brand_name.required' => 'Please input brand name',
                'brand_name.unique' => 'The brand ' . $request->brand_name . ' already exists',
                'brand_name.max' => 'Max lenght of brand name is 50',
                'brand_image.mimes' => 'Please add image file',
            ]
        );

        $old_image = $request->old_image;

        $brandImage = $request->file('brand_image');

        if ($brandImage) {

            $imageNameGen = hexdec(uniqid());
            $imageExtension = strtolower($brandImage->getClientOriginalExtension());
            $newImageName = $imageNameGen . '.' . $imageExtension;

            $uploadLocation = 'images/brands/';
            $fullImagePath = $uploadLocation . $newImageName;

            $brandImage->move($uploadLocation, $newImageName);

            unlink($old_image);

            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $fullImagePath,
            ]);
        } else {

            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
            ]);
        }

        return Redirect()->back()->with('success', 'Brand updated successfully');
    }

    public function delete($id)
    {

        $brand = Brand::find($id);

        $oldImage = $brand->brand_image;
        unlink($oldImage);

        $brand->delete();

        return Redirect()->back()->with('success', 'Brand have been deleted successfully');
    }

    //Multipic methods

    public function multipic()
    {
        $images = Multipic::all();
        return view('admin.multipic.index', compact('images'));
    }

    public function addMultipic(Request $request)
    {
        $images = $request->file('image');

        foreach ($images as $image) {

            $imageNameGen = hexdec(uniqid()) . '.' . strtolower($image->getClientOriginalExtension());

            $fullImagePath = 'images/multipics/' . $imageNameGen;

            Image::make($image)->resize(300, 300)->save($fullImagePath);


            Multipic::create([
                'image' => $fullImagePath,
            ]);
        }

        return Redirect()->back()->with('success', 'Brand added successfully');
    }
}
