<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Category;
use App\Models\FashionProduct;
use Arr;
use Illuminate\Http\Request;

class FashionHomepageController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with('childrenCategories')->get();

        $newArrivals = FashionProduct::with('media')->where('is_layaway',false)->latest()->paginate(12);
        $recommended = FashionProduct::with('media')->latest()->take(4)->get();

        return view('user.fashion.index', [
            'categories'  => $categories,
            'newArrivals' => $newArrivals,
            'recommended' => $recommended,
        ]);
    }

    public function allProducts()
    {
        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();

        $products = FashionProduct::with('media')
        ->where('is_layaway',false)
        ->paginate(30);

        return view('user.fashion.all-products', [
            'categories' => $categories,
            'products'   => $products,
        ]);
    }

    public function newArrivals()
    {
        $newArrivals = FashionProduct::with('media')->latest()->take(28)->get();

        return view('user.fashion.new-arrivals', [
            'products' => $newArrivals,
        ]);
    }

    /**
     * Display search result.
     */
    public function search(Request $request)
    {
        $fashionProduct = [];

        $searchName = $request->input('fashion');
        $category = $request->input('category');

        if ($category > 0) {
            $products = FashionProduct::with('media')->where('category_id', $category)
            ->Where('name', 'LIKE', "%{$searchName}%")
            ->where('is_layaway',false)
            ->paginate(15);
        } else {
            // $products = FashionProduct::with('media')->paginate(30);
            $products = FashionProduct::with('media')
            ->Where('name', 'LIKE', "%{$searchName}%")
            ->where('is_layaway',false)
            ->paginate(15);
        }
        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();

        //$products = FashionProduct::with('media')->paginate(30);

        return view('user.fashion.search', [
            'categories' => $categories,
            'products'   => $products,
            'term'   => $searchName,
            'cat'   => $category,
        ]);
    }

    public function searchfilters(Request $request)
    {
        $searchName = $request->input('term');
        $category = $request->input('cat');
        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();
        // $business = 

        if ($category > 0) {
            $products = FashionProduct::with('media')->where('category_id', $category)
            ->Where('name', 'LIKE', "%{$searchName}%")
            ->where('is_layaway',false)
            ->get();
        } else {
            // $products = FashionProduct::with('media')->paginate(30);
            $products = FashionProduct::with('media')
            ->Where('name', 'LIKE', "%{$searchName}%")
            ->where('is_layaway',false)
            ->get();
        }
        if(isset($request->price))
        {
            for($i = 0; $i < count($products); $i++){
                if($request->price < $products[$i]->price){
                    unset($products[$i]);
                }
            }
            // dd($products);
        }
        if(isset($request->discount))
        {
            for($i = 0; $i < count($products); $i++){
                if(isset($products[$i]->sales_price)){
                    // calculate percentage of sales price
                    $percentage = (($products[$i]->sales_price/ $products[$i]->price)*100);
                    if( $percentage > $request->discount){
                        unset($products[$i]);
                    }
                }
            }
        } 
        return view('user.fashion.search', [
            'categories' => $categories,
            'products'   => $products,
            'term'   => $searchName,
            'cat'   => $category,
        ]);
    }

    public function allStores()
    {
        $businesses = Business::with('locations')->whereStatus('approved')->where('business_type_id', 2)->paginate(30);
        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();

        return view('user.fashion.all-stores', [
            'stores' => $businesses,
            'categories' => $categories,
        ]);
    }


    public function fashionStore(Business $business)
    {
        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();

        $business->load(['locations', 'media', 'fashionProducts']);

        return view('user.fashion.fashion-store', [
            'categories' => $categories,
            'business'   => $business,
            'products'   => $business->fashionProducts,
        ]);
    }

    /**
     * Display search result.
     */
    public function searchStore(Request $request)
    {

        if (!$request->missing('store')) {
            $searchName = $request->validate([
                'store' => 'required'
            ]);

            if ($searchName['store'] == "0") {
                $businesses = Business::with('locations')->where('business_type_id', 2)->where('status', 'approved')->paginate(30);
            } else {
                $businesses = Business::with('locations')->where('name', 'like', '%' . $searchName['store'] . '%')->where('business_type_id', 2)->where('status', 'approved')->paginate(30);
            }
        } else {

            $input = $request->validate([
                'city' => 'required',
                'state' => 'required'
            ]);

            $cityArray = explode('-', $input['city']);
            $city = trim($cityArray[0]);
            $state = $input['state'];

            $businesses = Business::with(['locations' =>  function ($query) use ($state, $city) {
                $query->where('state', $state)->where('city', $city);
            }])
                ->where('business_type_id', 2)
                ->where('status', 'approved')
                ->paginate(30);
        }

        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();

        return view('user.fashion.all-stores', [
            'stores' => $businesses,
            'categories' => $categories,
        ]);
    }
}
