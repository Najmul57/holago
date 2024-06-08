<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Rules\FileTypeValidate;
use App\Http\Traits\FileUploadTrait;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductStocks;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use FileUploadTrait;
    protected $setting;
    protected $template;
    protected $templateAssets;

    public function __construct()
    {
        $this->setting = Setting::first();
        $this->template = 'templates.' . $this->setting->template . '.';
        $this->templateAssets = 'assets/' . $this->setting->template . '/';
    }

    public function index()
    {
        $data['products'] = Product::orderBy('id', 'desc')->paginate(20);
        return view('admin.product.index', $data);
    }
    public function create()
    {
        $data['categories'] = Category::where('status', 1)->orderBy('id', 'desc')->get();
        $data['sub_categories'] = SubCategory::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.product.create', $data);
    }

    // export
    public function export()
    {
        $products = Product::latest()->get();
        $filename = 'products.csv';
        $fp = fopen($filename, "w+");
        fputcsv($fp, array('id', 'Title', 'Image Link', 'Price', 'Description', 'Stokes'));

        foreach ($products as $product) {
            $imageLink = url('/assets/classicmart/images/products/' . $product->image);

            $stockQuantity = 0;

            // Check if stocks relationship is loaded
            if ($product->stocks->isNotEmpty()) {
                // Sum up the quantities from all stocks
                $stockQuantity = $product->stocks->sum('quantity');
            }
            // dd($stockQuantity);
            $descriptionWithoutTags = strip_tags(preg_replace('/(<[^>]+) style=".*?"/i', '$1', $product->description));
            fputcsv($fp, array($product->id, $product->name, $imageLink, $product->regular_price, $descriptionWithoutTags, $stockQuantity));
        }
        fclose(($fp));
        $headers = array('Content-Type' => 'text/csv');

        return response()->download($filename, 'products.csv', $headers);
    } //end

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'nullable|unique:products,slug,',
            'sku' => 'nullable|unique:products,sku,',
            'product_model' => 'nullable',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'points' => 'nullable',
            'buying_price' => 'nullable',
            'regular_price' => 'required',
            'discount_price' => 'nullable',
            'description' => 'nullable',
            'summary' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keyword' => 'nullable',
            'video_link' => 'nullable',
            'track_inventory' => 'nullable',
            'has_variants' => 'nullable',
            'is_featured' => 'nullable',
            'is_special' => 'nullable',
            'files' => 'nullable',
            'image' => 'required',
            'hover_image' => 'required',
            'additional_image' => 'required',
        ]);
        $timestamp = now()->format('YmdHis'); // Current timestamp
        $randomString = Str::random(6);
        $sku = 'SKU' . $timestamp . $randomString; // Random string of length 6
        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug ?? '';
        $product->sku =  $sku;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->product_model = $request->product_model;
        $product->points = $request->points;
        $product->buying_price = $request->buying_price;
        $product->regular_price = $request->regular_price;
        $product->discount_price = $request->discount_price ?? '';
        $product->description = $request->description;
        $product->summary = $request->summary;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keyword = $request->meta_keyword;
        $product->track_inventory = $request->track_inventory ? 1 : 0;
        $product->has_variants = $request->has_variants ? 1 : 0;
        $product->video_link = $request->video_link;
        $product->is_featured = $request->is_featured ? 1 : 0;
        $product->is_special = $request->is_special ? 1 : 0;

        $image = null;
        if ($request->hasFile('image')) {
            try {
                $imageData = [
                    'file' => $request->image,
                    'path' => $this->templateAssets . 'images/products/',
                    'size' => '1708x2560',
                    'prevFile' => null,
                ];
                $image = $this->uploadFile('image', $imageData);
            } catch (Exception $e) {
                $alert = ['danger', 'Something went wrong.'];
                return back()->withAlert($alert);
            }
        }
        $hoverImage = null;
        if ($request->hasFile('hover_image')) {
            try {
                $imageData = [
                    'file' => $request->hover_image,
                    'path' => $this->templateAssets . 'images/products/',
                    'size' => '1708x2560',
                    'prevFile' => null,
                ];
                $hoverImage = $this->uploadFile('image', $imageData);
            } catch (Exception $e) {
                $alert = ['danger', 'Something went wrong.'];
                return back()->withAlert($alert);
            }
        }
        $product->hover_image =  $hoverImage;
        $product->image =  $image;
        $product->save();
        $this->additionImage($request, $product);
        $alert = ['success', 'Product created successfully!'];
        return back()->withAlert($alert);
    }

    public function edit($id)
    {
        $data['product'] = Product::where('id', $id)->firstOrFail();
        $data['selectedCategories'] = $data['product']->categories()->pluck('categories.id')->toArray();
        $data['categories'] = Category::where('status', 1)->orderBy('id', 'desc')->get();
        $data['sub_categories'] = SubCategory::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.product.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'slug' => 'nullable|unique:products,slug,' . $product->id,
            // 'sku' => 'nullable|unique:products,sku,',
            'product_model' => 'nullable',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'points' => 'nullable',
            'buying_price' => 'nullable',
            'regular_price' => 'required',
            'description' => 'nullable',
            'summary' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keyword' => 'nullable',
            'video_link' => 'nullable',
            'track_inventory' => 'nullable',
            'has_variants' => 'nullable',
            'is_featured' => 'nullable',
            'is_special' => 'nullable',
            'files' => 'nullable',
            'image' => 'nullable',
            'hover_image' => 'nullable',
            'additional_image' => 'nullable',
        ]);


        $product->name = $request->name;
        $product->slug = $request->slug ?? '';
        // $product->sku = $sku;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->product_model = $request->product_model;
        $product->points = $request->points;
        $product->buying_price = $request->buying_price;
        $product->regular_price = $request->regular_price;
        $product->discount_price = $request->discount_price ?? '';
        $product->description = $request->description;
        $product->summary = $request->summary;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keyword = $request->meta_keyword;
        $product->track_inventory = $request->track_inventory ? 1 : 0;
        $product->has_variants = $request->has_variants ? 1 : 0;
        $product->video_link = $request->video_link;
        $product->is_featured = $request->is_featured ? 1 : 0;
        $product->is_special = $request->is_special ? 1 : 0;
        $image = $product->image;
        if ($request->hasFile('image')) {
            try {
                $imageData = [
                    'file' => $request->image,
                    'path' => $this->templateAssets . 'images/products/',
                    'size' => '1708x2560',
                    'prevFile' => $product->image,
                ];
                $image = $this->uploadFile('image', $imageData);
            } catch (Exception $e) {
                $alert = ['danger', 'Something went wrong.'];
                return back()->withAlert($alert);
            }
        }
        $hoverImage = $product->hover_image;
        if ($request->hasFile('hover_image')) {
            try {
                $imageData = [
                    'file' => $request->hover_image,
                    'path' => $this->templateAssets . 'images/products/',
                    'size' => '1708x2560',
                    'prevFile' => $product->hover_image,
                ];
                $hoverImage = $this->uploadFile('image', $imageData);
            } catch (Exception $e) {
                $alert = ['danger', 'Something went wrong.'];
                return back()->withAlert($alert);
            }
        }
        $product->hover_image =  $hoverImage;
        $product->image =  $image;
        $product->save();
        $this->additionImage($request, $product);
        $alert = ['success', 'Product updated successfully!'];
        return back()->withAlert($alert);
    }

    public function enable(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = 1;
        $product->save();

        $alert = ['success', 'Product enable successfully'];
        return back()->withAlert($alert);
    }

    public function disable(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->status = 0;
        $product->save();

        $alert = ['success', 'Product disable successfully'];
        return back()->withAlert($alert);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        $alert = ['success', 'Product deleted successfully'];
        return back()->withAlert($alert);
    }

    public function createAttribute($product_id)
    {
        $product                = Product::whereId($product_id)->first();
        if ($product->has_variants == 0) {
            $alert = ['error', 'Sorry! This Product Has No Variants'];
            return redirect()->back()->withAlert($alert);
        }
        $product_name           = $product->name;
        $title             = "Add Product Variants";
        $empty_message          = "No Variants Added Yet";

        $existing_attributes    = ProductAttribute::where('product_id', $product_id)
            ->with('productAttribute')
            ->get()
            ->groupBy('attribute_id');


        $attributes     = Attribute::where('status', 1)->get();
        return view('admin.product.attributes.create', compact('title', 'attributes', 'product_id', 'empty_message', 'existing_attributes', 'product_name'));
    }

    public function storeAttribute(Request $request, $id)
    {
        $data = [];
        $request->validate([
            'attr_type' => 'required|integer|in:1,2,3',
            'attr_id'   => 'required',

            'text' => 'required_if:attr_type,1|array|min:1',
            'text.*.name' => 'required_with:text|max:50',
            'text.*.value' => 'required_with:text|max:191',
            'color' => 'required_if:attr_type,2|array|min:1',
            'color.*.name' => 'required_with:color|max:50',
            'color.*.value' => 'required_with:color|max:191',

            'img' => 'required_if:attr_type,3|array|min:1',
            'img.*.name' => 'required_with:img|max:50',
            'img.*.value' => ['required_with:img', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])]
        ], [], [
            'text.*.name'   => 'Name Field',
            'color.*.name'  => 'Name Field',
            'color.*.value' => 'Value Field',
            'img.*.name'    => 'Name Field',
            'img.*.value'     => 'Image Field'
        ]);

        //Check Stock

        if ($request->attr_type == 1) {
            $data       = $request->text;
        } else if ($request->attr_type == 2) {
            $data = $request->color;
            $data_value = $request->value;
        } else if ($request->attr_type == 3) {
            foreach ($request->img as $key => $item) {
                $data[$key]['name'] = $item['name'];
                if (is_file($item['value'])) {
                    try {
                        $data[$key]['value'] = uploadImage($item['value'], imagePath()['attribute']['path'], imagePath()['attribute']['size']);
                    } catch (\Exception $exp) {
                        $alert = ['error', 'Couldn\'t upload the Image.'];
                        return back()->withAlert($alert);
                    }
                }
            }
        }

        // $exist = ProductAttribute::where('product_id',$id)->where('attribute_id',$request->attr_id)->count();

        // if($exist==0){
        //     $stocks = ProductStock::where('product_id', $id)->cursor();
        //     foreach($stocks as $stock){
        //         $stock->delete();
        //     }
        // }

        $attributeIds = [];
        $randomString = Str::random(6);

        foreach ($data as $attr) {
            $assign_attr = new ProductAttribute();
            $assign_attr->attribute_id = $request->attr_id;
            $assign_attr->product_id = $id;
            $assign_attr->name = $attr['name'];
            $assign_attr->content = $attr['value'] ?? '';
            $assign_attr->save();

            // Add the attribute ID as a string to the array only if it's not already present
            if (!in_array((string)$assign_attr->id, $attributeIds)) {
                $attributeIds = [(string)$assign_attr->id];

                $stock = new ProductStocks();
                $stock->product_id = $id;
                $stock->attributes = json_encode($attributeIds, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); // Apply necessary options
                $sku = Product::where('id', $id)->value('sku');
                $stock->sku = !empty($sku) ? $sku : $randomString;
                $stock->price = 0;
                $stock->save();
            }
        }

        $alert = ['success', 'New Variant Added Successfully'];
        return redirect()->back()->withAlert($alert);
    }


    public function addVariantImages($id)
    {
        $variant = ProductAttribute::whereId($id)->with('product', 'productImages', 'productAttribute')->firstOrFail();
        $product_name = $variant->product->name;
        $images = [];
        foreach ($variant->productImages as $key => $image) {
            $img['id'] = $image->id;
            $img['src'] = displayImage($this->templateAssets . 'images/products/attribute/' . $image->image);
            $images[] = $img;
        }
        $title = "Add Variant Images";
        return view('admin.product.attributes.add_variant_image', compact('title', 'variant', 'images', 'product_name'));
    }


    public function saveVariantImages(Request $request, $id)
    {
        $variant = ProductAttribute::whereId($id)->with('product', 'productImages')->firstOrFail();

        $validation_rule = [
            'photos'                =>  'required_if:id,0|array|min:1',
            'photos.*'              =>  ['image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ];

        $request->validate($validation_rule);

        //Check Old Images
        $previous_images = $variant->productImages->pluck('id')->toArray();

        $image_to_remove = array_values(array_diff($previous_images, $request->old ?? []));

        foreach ($image_to_remove as $item) {
            $productImage = ProductImage::find($item);
            if ($productImage) {
                $location = $this->templateAssets . 'images/products/attribute/';
                $this->deleteFile($location . $productImage->image);
                $productImage->delete();
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $image) {
                try {
                    $imageData = [
                        'file' => $image,
                        'path' => $this->templateAssets . 'images/products/attribute/',
                        'size' => '1708x2560',
                        'prevFile' => null,
                    ];
                    $image = $this->uploadFile('image', $imageData);
                } catch (Exception $e) {
                    $alert = ['danger', 'Something wrong'];
                    return back()->withAlert($alert);
                }
                $productImage = new ProductImage();
                $productImage->product_id                = $variant->product->id;
                $productImage->product_attribute_id      = $id;
                $productImage->image                     = $image;
                $productImage->save();
            }
        }
        $alert = ['success', 'Variant Deleted Successfully'];
        return back()->withAlert($alert);
    }

    public function updateAttribute(Request $request, $id)
    {
        $attr_data = ProductAttribute::findorFail($id);
        if ($attr_data->productAttribute->value_type == 1 || $attr_data->productAttribute->value_type == 2) {
            $request->validate([
                'name'  => 'required',
                'value' => 'required',
            ]);
        } elseif ($attr_data->productAttribute->value_type == 3) {
            $request->validate([
                'name'    => 'required',
                'image'   => ['required', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            ]);

            $old_img = (isset($attr_data->value)) ? $attr_data->value : '';

            if ($request->hasFile('image')) {
                try {
                    $request->merge(['value' => uploadImage($request->image, imagePath()['attribute']['path'], imagePath()['attribute']['size'], $old_img)]);
                } catch (\Exception $exp) {
                    $alert = ['error', 'Couldn\'t upload the Image.'];
                    return back()->withAlert($alert);
                }
            }
        }
        $attr_data->name   = $request->name;
        $attr_data->content  = $request->value ?? '';
        $attr_data->save();
        $alert = ['success', 'Product Variant Updated Successfully'];
        return redirect()->back()->withAlert($alert);
    }
    public function deleteAttribute($id)
    {
        $attr_data = ProductAttribute::findorFail($id);
        if ($attr_data->productAttribute->value_type == 3) {
            $location = $this->templateAssets . 'images/products/attribute/';
            $this->deleteFile($location . $attr_data->content);
            $attr_data->delete();
        }
        $attr_data->delete();
        $alert = ['success', 'Variant Deleted Successfully'];
        return back()->withAlert($alert);
    }

    protected function additionImage($request, $product)
    {
        if ($request->additional_image) {
            foreach ($request->additional_image as $key => $image) {
                try {
                    $imageData = [
                        'file' => $image,
                        'path' => $this->templateAssets . 'images/products/additionimage/',
                        'size' => '1708x2560',
                        'prevFile' => null,
                    ];
                    $image = $this->uploadFile('image', $imageData);
                } catch (Exception $e) {
                    $alert = ['danger', 'Something wrong'];
                    return back()->withAlert($alert);
                }
                $additionImage = new ProductImage();
                $additionImage->product_id = $product->id;
                $additionImage->image = $image;
                $additionImage->save();
            }
        }
    }


    public function deleteImage($imageId)
    {
        $image = ProductImage::find($imageId);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
        }
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }
}
