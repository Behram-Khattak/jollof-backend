<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FashionProduct;

class FashionCategoryController extends Controller
{
    public function index(Category $category)
    {
        $category->load('childrenCategories', 'parents');

        $childrenCategories = $category->childrenCategories->flattenTree('childrenCategories');

        $categoryIds = collect([$category->id, collect($childrenCategories)->pluck('id')])->flatten();

        $products = FashionProduct::with('media')
            ->whereIn('category_id', $categoryIds)
            ->paginate(30);

        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();

        return view('user.fashion.category.index', [
            'categories' => $categories,
            'category'   => $category,
            'products'   => $products,
        ]);
    }

    public function show($categorySlug, $subcategorySlug = null)
    {
        $total_categoryies = Category::whereNotNull('business_type_id')->count();

        if($subcategorySlug == 1){
            $category = Category::where('slug', $categorySlug)->firstOrFail();
            $category->childrenCategory = Category::where('parent_id', $category->id)->get();
            $products = FashionProduct::with('media', 'owner')
            ->where('category_id', $category->id)
            ->paginate(15);
        }
        else{
            $category = Category::with('parents')->where('slug', $subcategorySlug)->firstOrFail();
            $category->childrenCategory = Category::where('parent_id', $category->id)->get();
            $products = FashionProduct::with('media', 'owner')
            ->where('subcategory_id', $category->id)
            ->orwhere('variant_id', $category->id)
            ->paginate(15);
            // $category = Category::with('parents')
            //     ->whereHas('parentCategory', function ($query) use ($categorySlug) {
            //         $query->where('slug', $categorySlug);
            //     })
            //     ->where('slug', $subcategorySlug)
            //     ->firstOrFail();
        }
        // $product = FashionProduct::with('owner')
        //     ->where('category_id', $category->id)
        //     ->first();

        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();

        return view('user.fashion.category.show', [
            'categories' => $categories,
            'category'   => $category,
            'products'   => $products,
            // 'product'   => $product,
        ]);
    }
}
