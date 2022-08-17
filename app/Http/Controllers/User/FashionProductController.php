<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Category;
use App\Models\FashionProduct;
use App\Models\FashionProductSizeValue;
use App\Models\OrderItems;
use App\Models\Review;
use Auth;
use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use ourcodeworld\NameThatColor\ColorInterpreter;

class FashionProductController extends Controller
{
    public function show(FashionProduct $fashionProduct)
    {
        $colors = json_decode($fashionProduct->color_id) ?? str_split($fashionProduct->color_id,7);
        $color_by_name = [];
        foreach($colors as $color)
        {
            $instance = new ColorInterpreter();
            $result = $instance->name($color);
            $color_by_name[] = $result['name'];
        }
        $fashionProduct->color_id = $colors;
        // dd(gettype(json_decode($fashionProduct->size_value_id)));
        $decodedSize = json_decode($fashionProduct->size_value_id);
        if(gettype($decodedSize) == 'integer')
        {
            $size =FashionProductSizeValue::whereid($fashionProduct->size_value_id)->pluck('name')->toArray();
            // dd('Integer');
        }
        elseif(gettype($decodedSize) == 'array')
        {
            $size = $decodedSize;
        }
        $fashionProduct->load(['owner', 'category', 'material', 'sizeType', 'media']);

        $similar = FashionProduct::with('media')
            ->where('id', '!=', $fashionProduct->id)
            ->where(function ($query) use ($fashionProduct) {
                return $query->where('category_id', $fashionProduct->category_id)
                    ->orWhere('category_id', $fashionProduct->category->parent_id);
            })
            ->take(4)
            ->get();
        $categories = Category::with('childrenCategories')->whereNull('parent_id')->get();
        $business = Business::with('media')->where('id', $fashionProduct->owner->id)->first();
        $reviews = Review::with('user')->where('model_type', 'fashion')->where('model_id', $fashionProduct->id)->where('status', 1)->paginate(4);
        $hasreview = Review::with('user')->where('model_type', 'fashion')->where('model_id', $fashionProduct->id)->where('user_id', Auth::id())->where('status', 1)->get();
        $hasordered = []; //OrderItems::hasOrdered($business->id, Auth::id())->get()->count();
        return view('user.fashion.product.show', [
            'product'         => $fashionProduct,
            'categories'      => $categories,
            'similarProducts' => $similar,
            'business'        => $business,
            'reviews'         => $reviews,
            'hasreview'       => $hasreview,
            'hasordered'      => $hasordered,
            'sizes'            => $size,
            'color_name'        => $color_by_name,
        ]);
    }

    /**
     * Add cart.
     *
     * @param mixed $id
     * @param mixed $microsite
     */
    public function postCart(Request $request)
    {
        if($request->size == null) {
            return redirect(url()->previous())->with('error', "Please select item size.");
        }
        $data = $request->input();
        $product_id = $data['productID'];
        $quantity = (isset($data['quantity'])) ? $data['quantity'] : 1;
        $microsite = $data['microsite'];
        unset($data['_token'], $data['productID'], $data['microsite']);


        //get product details
        $product = FashionProduct::findorfail($product_id);
        //get business details
        $business = Business::findorfail($product->business_id);

        $today = Carbon::today();
        $start_sales = Carbon::parse($product->sales_start);
        $end_sales = Carbon::parse($product->sales_end);
        if($product->sales_price > 0)
            $price = (now()->between(now()->parse($start_sales), now()->parse($end_sales))) ? $product->sales_price : $product->price;
        else {
            $price = $product->price;
        }
        $total_price = $price;
        $cart  = Cart::add([
            'id'         => $product->sku,
            'name'       => $product->name,
            'price'      => $total_price,
            'quantity'   => $quantity,
            'attributes' => [
                'imgurl'        => $product->getFirstMediaUrl('featured-image'),
                'size'      => $request->size,
                'business_id'   => $product->business_id,
                'merchant'      => $business->name,
                'description'   => $product->description,
                'main_price'    => $total_price,
                'microsite'     => $microsite,
                'main_price'    => $total_price,
                'inventory'     => $product->quantity,
                'product_id'    => $product->id,
            ],
        ]);

        return redirect(url()->previous())->with('success', "Item added to cart successfully.");
    }
}
