<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Setting;
use App\Models\Language;
use App\Models\Template;
use App\Http\Traits\ApiGateway;
use App\Http\Traits\IpnGateway;
use App\Models\GatewayCurrency;
use App\Models\Subscriber;
use App\Models\ProductAttribute;
use App\Models\Coupon;
use App\Models\ProductStocks;
use App\Models\SubCategory;
use Carbon\Carbon;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class SiteController extends Controller
{
    use ApiGateway, IpnGateway;

    protected $setting;
    protected $template;

    public function __construct(){
        $this->setting = Setting::first();
        $this->template = 'templates.'.$this->setting->template.'.';

    }

    public function home()
    {
        $data['banners'] = Template::where('name', 'banner')->where('template_name', $this->setting->template)->where('is_multiple', 1)->get();
        $data['refresh'] = Template::where('name', 'refresh')->where('template_name', $this->setting->template)->where('is_multiple', 0)->first();
        $data['vintage'] = Template::where('name', 'vintage')->where('template_name', $this->setting->template)->where('is_multiple', 0)->first();
        $data['vintages'] = Template::where('name', 'vintage')->where('template_name', $this->setting->template)->where('is_multiple', 1)->get();
        $data['products'] = Product::where('status',1)->latest()->limit(12)->get();
        $data['featured_products'] = Product::where('status',1)->where('is_featured',1)->latest()->limit(4)->get();
         $data['special_category'] = SubCategory::where('special_category',1)->where('status',1)->latest()->get();
        $data['categories'] = Category::where('status',1)->with('allSubCategories')->get();
        $data['coupons'] = Coupon::where('status',1)->orderBy('id','desc')->limit(1)->get();
        return view($this->template.'index',$data);
    }

    public function changeLang($langCode){
        $lang = Language::where('lang_code',$langCode)->first();
        $lang ? session()->put('lang', $lang->lang_code) : session()->put('lang','en');
        return back();
    }

    public function blog()
    {
        $data['blog'] = Template::where('name', 'blog')->where('template_name', $this->setting->template)->where('is_multiple', 0)->first();
        $templateData = Template::where('name', 'blog')->where('template_name', $this->setting->template)->get();

        // Convert LazyCollection to Collection
        $templateData = new Collection($templateData);

        $currentPage = \Illuminate\Support\Facades\Request::get('page', 1);
        $perPage = 6;
        $offset = ($currentPage - 1) * $perPage;

        $paginatedItems = $templateData->where('is_multiple', 1)->slice($offset, $perPage)->values();

        $data['blogs'] = new LengthAwarePaginator($paginatedItems, $templateData->count(), $perPage, $currentPage);

        $data['recent_blogs'] = $templateData->where('is_multiple', 1)->sortByDesc('id')->take(5);
        $data['popular_blogs'] = $templateData->where('is_multiple', 1)->sortByDesc('view')->take(5);

        return view($this->template . 'blog', $data);
    }

    public function blogDetails($slug,$id)
    {
        $templateData = Template::where('template_name',$this->setting->template)->where('name','blog')->cursor();
        $data['blog'] = $templateData->where('is_multiple',1)->where('id',$id)->first();
        $data['title'] = $data['blog']->data->title;
        if (!$data['blog']) {
            abort(404);
        }
        $data['blog']->view += 1;
        $data['blog']->save();
        $data['recent_blogs'] = $templateData->where('is_multiple',1)->sortByDesc('id')->take(5);
        $data['popular_blogs'] = $templateData->where('is_multiple',1)->sortByDesc('view')->take(5);

        return view($this->template.'blog_details',$data);
    }
    public function about()
    {
        $about = Template::where('template_name',$this->setting->template)->where('name','about')->where('is_multiple',0)->first();
        $teamSection = Template::where('template_name',$this->setting->template)->where('name','team')->where('is_multiple',0)->first();
        $teams = Template::where('template_name',$this->setting->template)->where('name','team')->where('is_multiple',1)->get();
        $testimonialSection = Template::where('template_name',$this->setting->template)->where('name','testimonial')->where('is_multiple',0)->first();
        $testimonials = Template::where('template_name',$this->setting->template)->where('name','testimonial')->where('is_multiple',1)->get();
        return view($this->template.'about',compact('about','teamSection','teams','testimonialSection','testimonials'));
    }
    public function subscribe(Request $request)
    {
        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();
        $alert = ['success','Subscribed successfully'];
        return redirect()->back()->withAlert($alert);
    }

    public function linkDetails($id){
        $link = Template::where('template_name',$this->setting->template)->where('name','usefull_links')->where('is_multiple',1)->where('id',$id)->firstOrFail();
        $title = $link->data->title;
        return view($this->template.'linkDetails',compact('link','title'));
    }

    public function contact()
    {
        $contact = Template::where('template_name',$this->setting->template)->where('name','contact')->where('is_multiple',0)->first();
        return view($this->template.'contact',compact('contact'));
    }
    public function contactSubmit (Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'subject'=>'required',
            'message'=>'required',
        ]);
        $email = $request->email;
        $username = $request->name;

        sendRegularEmail($email, $request->subject, $request->message, $username);
        $alert = ['success', $username . ' will receive an email shortly.'];
        return back()->withAlert($alert);
    }

    public function cookieAccept($value='')
    {
        session()->put('cookie_accepted',true);
        return response()->json('Cookie accepted successfully');
    }
    public function shop()
    {
        $data['products'] = Product::where('status',1)->latest()->paginate(20);
        return view($this->template.'shop',$data);
    }
    public function sort(Request $request)
    {
        // dd($request->all());
        if($request->category_id !==null){
            if ($request->sort_by ==='asc'){
                $products  = Product::orderBy('regular_price', 'asc')->where('status',1)->where('category_id',$request->category_id)->latest()->paginate(20);
            }elseif($request->sort_by ==='desc'){
                $products  = Product::orderBy('regular_price', 'desc')->where('status',1)->where('category_id',$request->category_id)->latest()->paginate(20);
            }elseif($request->sort_by ==='latest'){
                $products  = Product::orderBy('created_at', 'asc')->where('status',1)->where('category_id',$request->category_id)->latest()->paginate(20);
            }elseif($request->sort_by ==='0'){
                $products = Product::where('status',1)->where('category_id',$request->category_id)->latest()->paginate(20);
            }else
            {
                $products = Product::where('status',1)->where('category_id',$request->category_id)->latest()->paginate(20);
            }
            return response()->json(['results' => $products]);
        }else{
            if ($request->sort_by ==='asc'){
                $products  = Product::orderBy('regular_price', 'asc')->where('status',1)->where('sub_category_id',$request->sub_category_id)->latest()->paginate(20);
            }elseif($request->sort_by ==='desc'){
                $products  = Product::orderBy('regular_price', 'desc')->where('status',1)->where('sub_category_id',$request->sub_category_id)->latest()->paginate(20);
            }elseif($request->sort_by ==='latest'){
                $products  = Product::orderBy('created_at', 'asc')->where('status',1)->where('sub_category_id',$request->sub_category_id)->latest()->paginate(20);
            }elseif($request->sort_by ==='0'){
                $products = Product::where('status',1)->where('sub_category_id',$request->sub_category_id)->latest()->paginate(20);
            }else
            {
                $products = Product::where('status',1)->where('sub_category_id',$request->sub_category_id)->latest()->paginate(20);
            }
            return response()->json(['results' => $products]);
        }
    }
    public function sortByCategory(Request $request)
    {
         $products = Product::where('category_id', $request->sort_by_category)->where('status',1)->latest()->paginate(20);
        return response()->json(['results' => $products]);
    }
    // public function productDetails($id, $order_id =null)
    // {
    //     $date_now = Carbon::now()->format('Y-m-d H:i:s');
    //     $review_available = false;
    //     if($order_id){
    //         $order = Order::where('order_number', $order_id)->where('user_id', auth()->id())->first();
    //         if($order){
    //             $od = OrderDetail::where('order_id', $order->id)->where('product_id', $id)->first();
    //             if($od){
    //                 $review_available = true;
    //             }
    //         }
    //     }
    //   $product = Product::where('id', $id)->where('status',1)->with('categories','assignAttributes','reviews', 'product_image')
    //     ->first();
    //     // if(!$product){
    //     //     abort('404');
    //     // }
    //     $discount = 0;

    //     $rProducts = $product->categories()
    //                 ->with(
    //                     [
    //                         'products' => function($q){
    //                             return $q->whereHas('categories');
    //                         },
    //                         'products.reviews'
    //                     ]
    //                 )
    //                 ->get()->map(function($item) use($id){
    //                     return $item->products->where('id', '!=', $id)->take(5);
    //                 });

    //     $related_products = [];

    //     foreach ($rProducts as $childArray){
    //         foreach ($childArray as $value){
    //             $related_products[] = $value;
    //         }
    //     }

    //     $attributes     = ProductAttribute::where('status',1)->with('productAttribute')->where('product_id', $id)->distinct('attribute_id')->get(['attribute_id']);

    //     $seo_contents['meta_title']         = $product->meta_title;
    //     $seo_contents['meta_description']   = $product->meta_description;
    //     $seo_contents['meta_keywords']      = $product->meta_keywords;
    //     $relatedProduct = Product::where('status',1)->inRandomOrder()->limit(8)->get();
    //     $page_title = 'Product Details';
    //     return view($this->template.'product-details', compact('relatedProduct','product', 'page_title', 'review_available', 'related_products', 'discount', 'attributes', 'seo_contents'));
    // }

    public function productDetails($slug, $order_id = null)
    {
        // dd($slug);
        $productFind = Product::where('slug', $slug)->first();
        //dd($product);
        //dd($productFind->id);
        $id = $productFind->id;
        $date_now = Carbon::now()->format('Y-m-d H:i:s');
        $review_available = false;
        if ($order_id) {
            $order = Order::where('order_number', $order_id)->where('user_id', auth()->id())->first();
            if ($order) {
                $od = OrderDetails::where('order_id', $order->id)->where('product_id', $id)->first();
                if ($od) {
                    $review_available = true;
                }
            }
        }

        $product = Product::where('id', $id)->where('status', 1)->with('categories', 'assignAttributes', 'reviews', 'product_image')
         ->first();
            // dd($product);
        // if(!$product){
        //     abort('404');
        // }
        $discount = 0;

        $rProducts = $product->categories()->with(
            [
                'products' => function ($q) {
                    return $q->whereHas('categories');
                },
                'products.reviews'
            ]
        )
            ->get()->map(function ($item) use ($id) {
                return $item->products->where('id', '!=', $id)->take(5);
            });

        $related_products = [];

        foreach ($rProducts as $childArray) {
            foreach ($childArray as $value) {
                $related_products[] = $value;
            }
        }

        $attributes     = ProductAttribute::where('status', 1)->with('productAttribute')->where('product_id', $id)->distinct('attribute_id')->get(['attribute_id']);

        $seo_contents['meta_title']         = $product->meta_title;
        $seo_contents['meta_description']   = $product->meta_description;
        $seo_contents['meta_keywords']      = $product->meta_keywords;
        $relatedProduct = Product::where('status', 1)->inRandomOrder()->limit(8)->get();
        $page_title = 'Product Details';
        return view($this->template . 'product-details', compact('relatedProduct', 'product', 'page_title', 'review_available', 'related_products', 'discount', 'attributes', 'seo_contents'));
    }


    // public function productsByCategory(Request $request, $id)
    // {
    //      $products = Product::with('category')->where('status',1)->where('category_id',$id)->latest()->paginate(20);
    //      $category_id = $id;
    //     if ($products->count() > 0){
    //         return view($this->template.'shop', compact('products','category_id'));
    //     }else{
    //         $alert = ['Danger','Product Not Found!'];
    //         return redirect()->back()->withAlert($alert);
    //     }
    // }

    // public function productsByCategory(Request $request, $slug)
    // {
    //     $categoryId = Category::where('slug', $slug)->first();
    //     // dd($categoryId);
    //     $id = $categoryId->id;
    //     $products = Product::with('category')->where('status', 1)->where('category_id', $id)->latest()->paginate(20);
    //     $category_id = $id;
    //     if ($products->count() > 0) {
    //         return view($this->template . 'shop', compact('products', 'category_id'));
    //     } else {
    //         $alert = ['Danger', 'Product Not Found!'];
    //         return redirect()->back()->withAlert($alert);
    //     }
    // }

     public function productsByCategory(Request $request, $slug)
    {
        try {

            $category = Category::where('slug', $slug)->firstOrFail();
            $categoryId = $category->id;

            $products = Product::with('category')
                ->where('status', 1)
                ->where('category_id', $categoryId)
                ->latest()
                ->paginate(20);

            $category_id = $categoryId;

            if ($products->count() > 0) {
                return view($this->template . 'shop', compact('products', 'category_id'));
            } else {
                $alert = ['Danger', 'Products Not Found!'];
                return redirect()->back()->withAlert($alert);
            }
        } catch (\Exception $e) {
            $alert = ['Danger', 'Error retrieving data!'];
            return redirect()->back()->withAlert($alert);
        }}


    // public function productsBySubCategory(Request $request, $id)
    // {
    //     $products = Product::where('status',1)->with('category')->where('status',1)->where('sub_category_id',$id)->latest()->paginate(20);
    //      $subcategory_id = $id;
    //     if ($products->count() > 0){
    //         return view($this->template.'shop', compact('products','subcategory_id'));
    //     }else{
    //         $alert = ['Danger','Product Not Found!'];
    //         return redirect()->back()->withAlert($alert);
    //     }
    // }

       public function productsBySubCategory(Request $request, $slug)
    {
       $subcategoryId = SubCategory::where('slug', $slug)->first();
        // dd($subcategoryId);
        $id = $subcategoryId->id;
        $products = Product::where('status', 1)->with('category')->where('status', 1)->where('sub_category_id', $id)->latest()->paginate(20);
        $subcategory_id = $id;
        if ($products->count() > 0) {
            return view($this->template . 'shop', compact('products', 'subcategory_id'));
        } else {
            $alert = ['Danger', 'Product Not Found!'];
            return redirect()->back()->withAlert($alert);
}
}

    public function needHelp(Request $request){
        $request->validate([
            'name' =>'required',
            'phone' =>'required',
        ]);
        $data = new Contact();
        $data->fill($request->all());
        $data->save();
        $alert = ['success','Send Successfully!'];
        return redirect()->back()->withAlert($alert);
    }
    public function orderTrack(Request $request){
        $request->validate([
            'order_number' =>'required',
            'email' =>'nullable',
        ]);
        $trackData = Order::where('order_number',$request->order_number)->first();
        if(!$trackData){
            $alert = ['danger', 'Data Not Found!'];
            return  redirect()->to('/order-tracking')->withAlert($alert);
        }else {
            return view($this->template.'order-racking',compact('trackData'));
        }
    }

    // public function search(Request $request)
    // {
    //     $query = $request->input('search');
    //     try {
    //       $results = Product::where('status',1)->where('name', 'like', "%{$query}%")
    //             ->orWhere('product_model', 'like', "%{$query}%")
    //             ->limit(10)
    //             ->get();
    //         return response()->json(['results' => $results]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'An error occurred during the search.'], 500);
    //     }
    // }

      public function search(Request $request)
        {
        $query = $request->input('search');

        try {
            $category = Category::where('name', 'like', "%{$query}%")->first();

            // dd($category);

            if ($category) {
                $results = Product::where('status', 1)->with('category')
                    ->where('category_id', $category->id)
                    ->limit(10)
                    ->get();

                return response()->json(['results' => $results]);
            } else {
                $results = Product::where('status', 1)
                    ->where('name', 'like', "%{$query}%")
                    ->orWhere('product_model', 'like', "%{$query}%")
                    ->with('category')
                    ->limit(10)
                    ->get();

                return response()->json(['results' => $results]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred during the search.'], 500);
        }
        }


    public function offerProduct(Request $request){
      $data['products'] = Product::where('status', 1)
    ->whereNotNull('discount_price')
    ->where('discount_price', '!=', 0)
    ->latest()
    ->get();
        return view($this->template.'offer-product',$data);
    }
    public function quickView(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|gt:0',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors());
        }
        $id = $request->id;
        $product = Product::where('status',1)->with('product_attribute','product_image')->where('id', $id)->first();
        if(!$product){
            abort('404');
        }
        $page_title = 'Product Details';
        return view($this->template.'quickview', compact('product', 'page_title'));
    }


     public function getStockByAttribute(Request $request)
    {
        $productStock = ProductStocks::where('product_id', $request->productId)->whereJsonContains('attributes', $request->attributeId)->select('quantity')->first();
        // dd("product stock",$productStock);
        return response()->json([
            'message' => "attribute get successfully!",
            'data' => $productStock
        ]);
    }


    public function export($filename)
    {
        $products = Product::latest()->get();
        $filePath = public_path($filename);

        $fp = fopen($filePath, "w+");
        fputcsv($fp, array('id', 'title', 'image_link', 'price', 'description', 'stocks'));

        foreach ($products as $product) {
            $imageLink = url('/assets/classicmart/images/products/' . $product->image);

            $stockQuantity = 0;

            // Check if stocks relationship is loaded
            if ($product->stocks->isNotEmpty()) {
                // Sum up the quantities from all stocks
                $stockQuantity = $product->stocks->sum('quantity');
            }

            $descriptionWithoutTags = strip_tags(preg_replace('/(<[^>]+) style=".*?"/i', '$1', $product->description));
            fputcsv($fp, array($product->id, $product->name, $imageLink, $product->regular_price, $descriptionWithoutTags, $stockQuantity));
        }

        fclose($fp);

        $headers = array('Content-Type' => 'text/csv');

        // Return a response with a downloadable link
        return Response::download($filePath, $filename, $headers);
        }

}
