<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FashionProductMaterial;
use App\Models\JollofPointSetting;
use App\Models\LayawaySetting;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $layaway = LayawaySetting::first();
        $jollofpoint = JollofPointSetting::first();
        return view('admin.fashioncategories.index',compact('layaway','jollofpoint'));
    }
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        // return $categories;
        return view('admin.fashioncategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd());
        if(is_numeric($request->subvariant) && is_numeric($request->subvariant) && is_numeric($request->subvariant))
        {
            return redirect()->back()->with('error', 'Category can not be created Because category already exist');
        }
        // dd($request->all());
        dd(gettype($request->subvariant));
        // if($request->category_id)
        $this->validate($request, [
            'category_id' => 'required',
            'subcategory' => 'required',
            'subvariant' => 'required',
        ]);
        // dd($request->all());

        $slug = strtolower(preg_replace('/\s+/', '-', $request->subvariant)); // replace space with -
        // dd($slug);

        $category = Category::create([
            'business_type_id' => null,
            'name' => $request->subvariant,
            'slug' => $slug,
            'parent_id' => $request->subcategory,
        ]);
        if(!$category){
            return redirect()->back()->with([
                'message', 'Category failed to create',
                'alert-type', 'error',
            ]);
        }
        return redirect()->back()->with([
            'message', 'Category failed to create',
            'alert-type', 'success',
        ]);


    }

    public function  getSubCategory($categoryID){
        return Category::where('parent_id', $categoryID)->with('childrenCategories')->get();
    }

    public function addMainCategory(Request $request)
    {
        $this->validate($request, [
            'category' => 'required',
        ]);
        $slug = strtolower(preg_replace('/\s+/', '-', $request->category)); // replace space with -
        $category = Category::create([
            'business_type_id' => 2,
            'name' => $request->category,
            'slug' => $slug,
            'parent_id' => null,
        ]);

        if(!$category){
            return redirect()->back()->with([
                'message', 'Category failed to create',
                'alert-type', 'error',
            ]);
        }
        return redirect()->back()->with([
            'message', 'Category created successfully',
            'alert-type', 'success',
        ]);
    }

    public function addSubCategory(Request $request)
    {
        $this->validate($request, [
            'category' => 'required',
            'subcategory' => 'required',
        ]);
        $slug = strtolower(preg_replace('/\s+/', '-', $request->subcategory)); // replace space with -
        $category = Category::create([
            'business_type_id' => null,
            'name' => $request->subcategory,
            'slug' => $slug,
            'parent_id' => $request->category,
        ]);
        if(!$category){
            return redirect()->back()->with([
                'message', 'Category failed to create',
                'alert-type', 'error',
            ]);
        }
        return redirect()->back()->with([
            'message', 'Category failed to create',
            'alert-type', 'success',
        ]);
        
    }

    public function addSubVariant(Request $request)
    {
        $this->validate($request, [
            'subcategory' => 'required',
            'subvariant' => 'required',
        ]);
        $slug = strtolower(preg_replace('/\s+/', '-', $request->subvariant)); // replace space with -
        $category = Category::create([
            'business_type_id' => null,
            'name' => $request->subvariant,
            'slug' => $slug,
            'parent_id' => $request->subcategory,
        ]);
        if(!$category){
            return redirect()->back()->with([
                'message', 'Category failed to create',
                'alert-type', 'error',
            ]);
        }
        return redirect()->back()->with([
            'message', 'Category failed to create',
            'alert-type', 'success',
        ]);
    }

    public function addMaterial(Request $request)
    {
        $this->validate($request, ['material' => 'required']);
        // check if material already exists
        $material = FashionProductMaterial::where(['name' => $request->material]);
        if(!$material)
        {
            $addMaterial = new FashionProductMaterial();
            $addMaterial->name = $request->material;
            $addMaterial->save();
            return redirect()->back()->with([
                'message', 'Material added successfully',
                'alert-type', 'success',
            ]);
        }
        else {
            return redirect()->back()->with([
                'message', 'Material already exists',
                'alert-type', 'error',
            ]);
        }


        
    }
}
