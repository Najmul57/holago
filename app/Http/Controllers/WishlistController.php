<?php

namespace App\Http\Controllers;
use App\Models\Wishlist;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    protected $setting;
    protected $template;

    public function __construct(){
        $this->setting = Setting::first();
        $this->template = 'templates.'.$this->setting->template.'.';
    }


    //WISH LIST
    public function addToWishList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',

        ]);

        if($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user_id = auth()->user()->id??null;

        $s_id = session()->get('session_id');
        if ($s_id == null) {
            session()->put('session_id', uniqid());
            $s_id = session()->get('session_id');
        }

        if($user_id != null){
            $wishlist = Wishlist::where('customer_id', $user_id)
            ->where('product_id', $request->product_id)
            ->first();
        }else{

            $wishlist = Wishlist::where('session_id', $s_id)
            ->where('product_id', $request->product_id)
            ->first();
        }

        if($wishlist) {
            return response()->json(['error' => 'Already in the wish list']);
        }else {
            $wishlist = new Wishlist();
            $wishlist->customer_id    = auth()->user()->id??null;
            $wishlist->session_id = $s_id;
            $wishlist->product_id = $request->product_id;
            $wishlist->save();
        }
        $wishlist = session()->get('wishlist');

        $wishlist[$request->product_id] = [
            "id" => $request->product_id,
        ];

        session()->put('wishlist', $wishlist);
        return response()->json(['success' => 'Added to Wishlist']);
    }


    public function getWsihList()
    {
        $date_now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $w_data     = [];
        $user_id    = auth()->user()->id??null;
        if($user_id != null){
            $w_data = Wishlist::where('customer_id', $user_id)
            ->with(['product', 'product.stocks', 'product.categories' ,'product.offer'])
            ->whereHas('product', function($q){
                return $q->whereHas('categories')->whereHas('brand');
            })
            ->orderBy('id', 'desc')
            ->get();
            if($w_data->count() >3){
                $latest = $w_data->sortByDesc('id')->take(3);
            }else{
                $latest = $w_data;
            }

        }else{
            $s_id       = session()->get('session_id');
            $w_data     = Wishlist::where('session_id', $s_id)
            ->with(['product', 'product.stocks', 'product.categories'])
            ->whereHas('product', function($q){
                return $q->whereHas('categories')->whereHas('brand');
            })
            ->orderBy('id', 'desc')
            ->get();

            if($w_data->count() >3){
                $latest = $w_data->sortByDesc('id')->take(5);
            }else{
                $latest = $w_data;
            }
        }
        $more = $w_data->count() - count($latest);
        $empty_message = 'No product in your wishlist';

        return view($this->template.'wishlist', ['data' => $latest, 'empty_message'=> $empty_message, 'more'=>$more]);
    }

    public function getWsihListTotal(){
//        $date_now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $w_data     = [];
        $user_id    = auth()->user()->id??null;
        if($user_id != null){
            $w_data = Wishlist::where('customer_id', $user_id)
//                ->with(['product', 'product.product_stocks', 'product.categories'])
//            ->whereHas('product', function($q){
//                return $q->whereHas('categories')->whereHas('brand');
//            })
            ->get();

        }else{
            $s_id       = session()->get('session_id');
            $w_data     = Wishlist::where('session_id', $s_id)->get();
//                ->with(['product', 'product.product_stocks', 'product.categories'])
//            ->whereHas('product', function($q){
//                return $q->whereHas('categories')->whereHas('brand');
//            })
//            ->get();
        }

        return response($w_data->count());
    }

    public function wishList()
    {

        $user_id    = auth()->user()->id??null;
        $notify[] = [];

        if($user_id != null){
            $wishlist_data = Wishlist::where('customer_id', $user_id)
            ->with(['product', 'product.stocks', 'product.categories'])
            // ->whereHas('product', function($q){
            //     return $q->whereHas('categories')->whereHas('brand');
            // })
            ->get();
        }else{
            $s_id       = session()->get('session_id');
            if(!$s_id){
                return redirect(route('home'))->withNotify($notify);
            }
            $wishlist_data = Wishlist::where('session_id', $s_id)
            ->with(['product', 'product.stocks', 'product.categories'])
            // ->whereHas('product', function($q){
            //     return $q->whereHas('categories')->whereHas('brand');
            // })
            ->get();
        }

        $page_title     = 'Wishlist';
        $empty_message  = 'No product in your wishlist';
        return view($this->template.'wishlist', compact('page_title', 'wishlist_data', 'empty_message'));
    }

    public function removeFromwishList($id)
    {
        if($id==0){
            $user_id    = auth()->user()->id??null;
            if($user_id != null){
                $wishlist = Wishlist::where('customer_id', $user_id);
            }else{
                $s_id       = session()->get('session_id');
                if(!$s_id){
                    abort(404);
                }
                $wishlist = Wishlist::where('session_id', $s_id);
            }

        }else{
            $wishlist   = Wishlist::findorFail($id);
            $product_id = $wishlist->product_id;
            $wl         = session()->get('wishlist');
            unset($wl[$product_id]);
            session()->put('wishlist', $wl);
        }
        Artisan::call('cache:clear');
        if($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => 'Deleted From Wishlist']);
        }

        return response()->json(['error' => 'This product isn\'t available in your wishlsit']);
    }
}
