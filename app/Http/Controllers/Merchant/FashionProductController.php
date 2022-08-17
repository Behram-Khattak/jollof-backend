<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\BusinessTypeEnum;
use App\Enums\MediaCollectionNames;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFashionProductRequest;
use App\Models\Business;
use App\Models\Category;
use App\Models\FashionProduct;
use App\Models\FashionProductColor;
use App\Models\FashionProductMaterial;
use App\Models\FashionProductSizeType;
use App\Models\FashionProductSizeValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FashionProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Business $business
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Business $business)
    {
        $products = FashionProduct::with('owner')
            ->where('business_id', $business->id)
            ->latest()
            ->get();

        return view('merchant.fashion.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Business $business
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Business $business)
    {
        $business->load('type');

        if($business->status !== 'approved'){
            return redirect(route('merchant.fashion.index', request()->route('business')))->with([
                'message'    => 'Fashion business has not been approved',
                'alert-type' => 'error',
            ]);
        }

        abort_if($business->type->name !== BusinessTypeEnum::FASHION, 403);

        return view('merchant.fashion.create', [
            'product'    => [],
            'categories' => Category::whereNull('parent_id')->with('childrenCategories')->get(),
            'business'   => $business,
            'materials'  => FashionProductMaterial::all(['id', 'name']),
            // 'colors'     => FashionProductColor::all(['id', 'name']),
            'sizeTypes'  => FashionProductSizeType::all(['id', 'name']),
            // 'sizes'      => FashionProductSizeValue::orderBy('name', 'desc')->get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFashionProductRequest $request
     * @param Business                   $business
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Business $business, StoreFashionProductRequest $request)
    {
        $color = json_encode($request->color);
        $size_value = json_encode(explode(',', $request->size_value_id));
        $schedule = explode(" - ", $request->input('discountSchedule'));
        $product = FashionProduct::create([
            'business_id'  => $business->id,
            'category_id'  => $request->input('category_id'),
            'subcategory_id'  => $request->input('subcategory'),
            'variant_id'  => $request->input('variant'),
            'material_id'  => $request->input('material_id'),
            'color_id'     => $color,
            'size_type_id' => $request->input('size_type_id'),
            'size_value_id'=> $size_value,
            'name'         => $request->input('name'),
            'description'  => $request->input('description'),
            'quantity'     => $request->input('quantity'),
            'price'        => $request->input('price'),
            'sales_price'  => $request->input('sales_price'),
            'weight'       => $request->input('weight'),
            'state'        => $request->input('state'),
            'is_available' => $request->input('quantity') > 0 ? true : false,
            'is_layaway'   => $request->input('is_layaway'),
            'sales_start'  => $request->filled('discountSchedule') ? Carbon::parse($schedule[0]) : null,
            'sales_end'    => $request->filled('discountSchedule') ? Carbon::parse($schedule[1]) : null,
        ]);

        if (!empty($request->input('product_image'))) {
            $loop = 1;
            foreach ($request->input('product_image') as $file) {
                $src = explode(":", $file);
                $base64 = $src[1];

                if($loop == 1){
                    $this->uploadImage($product, $base64, 'featured-image');
                }
                else{
                    $this->uploadImage($product, $base64, 'product-images');
                }

                $loop++;
            }
        }
        return redirect()->route('merchant.fashion.index', $business)->with([
            'alert-type' => 'success',
            'message'    => 'Product Uploaded successfully!!!',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Business                   $business
     * @param \App\Models\FashionProduct $fashionProduct
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Business $business, FashionProduct $fashionProduct)
    {
        $fashionProduct->load('category.parentCategory.parentCategory', 'material', 'color', 'sizeType', 'sizeValue');
        $sizes = (json_decode($fashionProduct->size_value_id) == null) ? $fashionProduct->size_value_id : json_decode($fashionProduct->size_value_id);
        // $colors = (json_decode($fashionProduct->color_id) == null) ? explode(' ', $fashionProduct->color_id) : json_decode($fashionProduct->color_id);
        $colors = [];
        if($fashionProduct->color_id !== null) {
            if(gettype($fashionProduct->color_id) == 'string') 
            {
                $color = json_decode($fashionProduct->color_id);
                if($color == null){
                    $colors = explode(' ', $fashionProduct->color_id);
                }
                else {
                    $colors = $color;
                }
            }
        }
        return view('merchant.fashion.edit', [
            'product'    => $fashionProduct,
            'categories' => Category::whereNull('parent_id')->with('childrenCategories')->get(),
            'business'   => $business,
            'materials'  => FashionProductMaterial::all(['id', 'name']),
            'colors'     => $colors,
            'sizeTypes'  => FashionProductSizeType::all(['id', 'name']),
            'sizes'      => (gettype($sizes) == 'array') ? implode(',',$sizes) : $sizes ?? FashionProductSizeValue::orderBy('name', 'desc')->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreFashionProductRequest $request
     * @param Business                   $business
     * @param \App\Models\FashionProduct $fashionProduct
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreFashionProductRequest $request, Business $business, FashionProduct $fashionProduct)
    {
        $schedule = explode(" - ", $request->input('discountSchedule'));
        $size_value = json_encode(explode(',', $request->size_value_id));
        $color = json_encode($request->color);
        $fashionProduct->update([
            'business_id'  => $business->id,
            'category_id'  => $request->input('category_id'),
            'subcategory_id'  => $request->input('subcategory'),
            'variant_id'  => $request->input('variant'),
            'material_id'  => $request->input('material_id'),
            'color_id'     => $color,
            'size_type_id' => $request->input('size_type_id'),
            'size_value_id'=> $size_value,
            'name'         => $request->input('name'),
            'description'  => $request->input('description'),
            'quantity'     => $request->input('quantity'),
            'price'        => $request->input('price'),
            'sales_price'  => $request->input('sales_price'),
            'weight'       => $request->input('weight'),
            'state'        => $request->input('state'),
            'is_available' => $request->input('quantity') > 0 ? true : false,
            'sales_start'  => $request->filled('discountSchedule') ? Carbon::parse($schedule[0]) : null,
            'sales_end'    => $request->filled('discountSchedule') ? Carbon::parse($schedule[1]) : null,
        ]);


        $fashionProduct->clearMediaCollection(MediaCollectionNames::FEATURED_IMAGE);

        $fashionProduct->clearMediaCollection(MediaCollectionNames::PRODUCT_IMAGES);

        if (!empty($request->input('product_image'))) {
            $loop = 1;
            foreach ($request->input('product_image') as $file) {
                $src = explode(":", $file);
                $base64 = $src[1];

                if($loop == 1){
                    $this->uploadImage($fashionProduct, $base64, 'featured-image');
                }
                else{
                    $this->uploadImage($fashionProduct, $base64, 'product-images');
                }

                $loop++;
            }
        }

        // if (!empty($request->input('product_images'))) {
        //     foreach ($request->input('product_images') as $file) {
        //         $this->uploadImage($fashionProduct, $file, 'product-images');
        //     }
        // }
        notify()->success('Product has been updated successfully','Product Upload');
        return redirect()->route('merchant.fashion.edit', ['business'=> $business, 'fashionProduct' => $fashionProduct]);
        // return response()->json(['message' => 'Product updated successfully', 'product' => $fashionProduct], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\FashionProduct $fashionProduct
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(FashionProduct $fashionProduct)
    {
    }

    /**
     * @param FashionProduct $model
     * @param                $input
     * @param                $collection
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data
     */
    protected function uploadImage(FashionProduct $model, $input, $collection)
    {
        // $model->addMediaFromUrl($input)
        $model->addMediaFromBase64($input)
            ->usingFileName($this->generateFileName($input))
            ->usingName(Str::random())
            ->toMediaCollection($collection);
    }

    protected function generateFileName($data)
    {
        $image = explode(',', $data);
        $type = explode(';', substr($image[0], 11));

        return md5(Str::random() . microtime()) . '.' . $type[0];
    }

    public function  getSubCategory($categoryID){
        return Category::where('parent_id', $categoryID)->with('childrenCategories')->get();
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim(md5($file->getClientOriginalName()));

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


    protected function base64Convert($image){
        $path   = $image->getPath();
        $data   = file_get_contents($path);
        return 'data:' . $image->mime_type . ';base64,' . base64_encode($data);
    }


    public function getMedia($id){
        $product = FashionProduct::findorfail($id);
        $mediaItems = [];
        $featured = $product->getMedia('featured-image');
        $others = $product->getMedia('product-images');

        $mediaItems[] = [
            'url'=> $featured[0]->getFullUrl(),
            'size'=>$featured[0]->size,
            'name'=>$featured[0]->name,
            'base64'=>$this->base64Convert($featured[0]),
        ];

        foreach($others as $other){

            $mediaItems[] = [
                'url'=> $other->getFullUrl(),
                'size'=>$other->size,
                'name'=>$other->name,
                'base64'=>$this->base64Convert($other),
            ];
        }

        return response()->json($mediaItems);
    }

    public function delete($id)
    {
        $product = FashionProduct::find($id);
        if($product != null) 
        {   
            if($product->delete())
            {
                return redirect()->back()->with([
                    'alert-type' => 'success',
                    'message'    => 'Product deleted successfully',
                ]);
            }
        }
        else 
        {
            return redirect()->back()->with([
                'alert-type' => 'error',
                'message'    => 'Product Not Found'
            ]);;
        }
    }
}
