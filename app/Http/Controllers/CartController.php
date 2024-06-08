<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\Cart;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Coupon;


class CartController extends Controller
{
    protected $setting;
    protected $template;

    public function __construct()
    {
        $this->setting = Setting::first();
        $this->template = 'templates.' . $this->setting->template . '.';
    }
    public function addToCart(Request $request)
    {
        // dd($request->attributes);
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity'  => 'required|numeric|gt:0'
        ]);
        // dd($request->attributes);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $product = Product::findOrFail($request->product_id);
        $user_id = auth()->user()->id ?? null;
        $attributes     = ProductAttribute::where('product_id', $request->product_id)->distinct('attribute_id')->with('productAttribute')->get('attribute_id');
        if ($attributes->count() > 0) {

            $count = $attributes->count();
            $validator = Validator::make($request->all(), [
                'attributes' => "required"
            ]);
        }
        if ($validator->fails()) {
            return response()->json(['error' => 'Select Attributes first']);
        }
        $selected_attr = $request['attributes'] ?? 'joy_bangla';
        if ($selected_attr == 'joy_bangla') {
            return response()->json(['error' => 'Select Attributes first']);
        }

        //        dd($selected_attr);

        $s_id = session()->get('session_id');
        if ($s_id == null) {
            session()->put('session_id', uniqid());
            $s_id = session()->get('session_id');
        }
        if ($user_id != null) {
            $cart = Cart::where('customer_id', $user_id)->where('product_id', $request->product_id)->where('product_attribute_id', $selected_attr)->first();
        } else {
            $cart = Cart::where('session_id', $s_id)->where('product_id', $request->product_id)->where('product_attribute_id', $selected_attr)->first();
        }

        // //Check Stock Status

        if ($product->track_inventory) {
            $stock_qty = showAvailableStock($request->product_id, $selected_attr);
            //             dd($stock_qty);
            if ($request->quantity > $stock_qty) {
                return response()->json(['error' => 'Sorry your requested amount of quantity is not available in our stock']);
            }
        }

        if ($cart) {
            if ($cart->product_attribute_id == $selected_attr) {
                $cart->quantity  += $request->quantity;
                if (isset($stock_qty) && $cart->quantity > $stock_qty) {
                    return response()->json(['error' => 'Sorry, You have already added maximum amount of stock']);
                }
                $cart->save();
            } else {
                // dd();
                $cart = new Cart();
                $cart->customer_id    = auth()->user()->id ?? null;
                $cart->session_id = $s_id;
                $cart->attributes = json_decode($selected_attr);
                $cart->product_attribute_id = json_decode($selected_attr);
                $cart->product_id = $request->product_id;
                $cart->quantity   = $request->quantity;
                $cart->save();
            };
        } else {
            $cart = new Cart();
            $cart->customer_id    = auth()->user()->id ?? null;
            $cart->session_id = $s_id;
            $cart->attributes = json_decode($selected_attr);
            $cart->product_attribute_id = json_decode($selected_attr);
            $cart->product_id = $request->product_id;
            $cart->quantity   = $request->quantity;
            $cart->save();
        }
        return response()->json(['success' => 'Added to Cart']);
    }

    public function getCart()
    {
        $user_id = auth()->user()->id ?? null;
        if ($user_id != null) {
            $data = Cart::where('customer_id', $user_id)->with(['product', 'product.stocks', 'product.categories'])
                ->get();
        } else {
            $s_id  = session()->get('session_id');
            $data = Cart::where('session_id', $s_id)->with(['product', 'product.stocks', 'product.categories'])
                ->get();
        }

        $subtotal = 0;
        $user_id    = auth()->user()->id ?? null;
        if ($user_id != null) {
            $total_cart = Cart::where('customer_id', $user_id)
                ->with(['product'])
                ->orderBy('id', 'desc')
                ->get();

            if ($total_cart->count() > 3) {
                $latest = $total_cart->sortByDesc('id')->take(3);
            } else {
                $latest = $total_cart;
            }
        } else {
            $s_id       = session()->get('session_id');
            $total_cart = Cart::where('session_id', $s_id)
                ->with(['product'])
                ->orderBy('id', 'desc')
                ->get();

            if ($total_cart->count() > 3) {
                $latest = $total_cart->sortByDesc('id')->take(3);
            } else {
                $latest = $total_cart;
            }
        }
        $more           = $total_cart->count() - count($latest);
        $empty_message  = 'No product in your cart';
        $coupon         = null;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
        }
        return view($this->template . 'partials.cart_items', ['data' => $data]);
    }

    public function getCartTotal()
    {
        $subtotal = 0;
        $user_id    = auth()->user()->id ?? null;
        if ($user_id != null) {
            $total_cart = Cart::where('customer_id', $user_id)
                ->with(['product'])
                ->get();
        } else {
            $s_id       = session()->get('session_id');
            $total_cart = Cart::where('session_id', $s_id)
                ->with(['product'])
                ->get();
        }
        return response($total_cart->count());
    }

    public function shoppingCart()
    {
        $user_id    = auth()->user()->id ?? null;
        if ($user_id != null) {
            $data = Cart::where('customer_id', $user_id)->with(['product', 'product.stocks', 'product.categories','productAttributes'])
                ->get();
        } else {
            $s_id       = session()->get('session_id');
            $data = Cart::where('session_id', $s_id)
                ->with(['product', 'product.stocks', 'product.categories','productAttributes'])
                ->get();
        }
        // dd($data);
        $page_title     = 'My Cart';
        $empty_message  = 'Cart is empty';
        return view($this->template . 'cart', compact('page_title', 'data', 'empty_message'));
    }




    public function updateCartItem(Request $request, $id)
    {


        if (session()->has('coupon')) {
            return response()->json(['danger' => 'You have applied a coupon on your cart. If you want to delete any item form your cart please remove the coupon first.']);
        }

        $cart_item = Cart::findorFail($id);

        $attributes = $cart_item->attributes ?? null;
        if ($attributes !== null) {
            sort($attributes);
            $attributes = json_encode($attributes);
        }
        if ($cart_item->product->show_in_frontend && $cart_item->product->track_inventory) {
            $stock_qty  = showAvailableStock($cart_item->product_id, $attributes);


            if ($request->quantity > $stock_qty) {
                return response()->json(['danger' => 'Sorry! your requested amount of quantity is not available in our stock', 'qty' => $stock_qty]);
            }
        }

        if ($request->quantity == 0) {
            return response()->json(['danger' => 'Quantity must be greater than  0']);
        }
        $cart_item->quantity = $request->quantity;
        $cart_item->save();
        return response()->json(['success' => 'Quantity updated']);
    }

    public function removeCartItem($id)
    {

        if (session()->has('coupon')) {
            return response()->json(['danger' => 'You have applied a coupon on your cart. If you want to delete any item form your cart please remove the coupon first.']);
        }
        $cart_item = Cart::findorFail($id);
        $cart_item->delete();
        return response()->json(['success' => 'Item Deleted Successfully']);
    }

    public function checkout()
    {
        $user_id    = auth()->user()->id ?? null;

        if ($user_id) {
            $data = Cart::where('customer_id', $user_id)->get();
        } else {
            $data = Cart::where('session_id', session('session_id'))->get();
        }
        if ($data->count() == 0) {
            $alert = ['success', 'No product in your cart'];
            return back()->withAlert($alert);
        }
        // $shipping_methods = ShippingMethod::where('status', 1)->get();
        $page_title = 'Checkout';
        return view($this->template . 'checkout', compact('page_title'));
    }


    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code'          => 'required|string'
        ]);

        $general = Setting::first();

        $coupon = Coupon::where('code', $request->code)->where('status', 1)->first();

        if ($coupon) {

            if ($coupon->discount_type == 1) {
                $amount = $coupon->coupon_amount;
            } else {
                $amount = floatval($request->subtotal) * floatval($coupon->coupon_amount) / 100;
            }

            // Check in session

            if (session()->has('coupon') && session('coupon')['code'] == $request->code) {
                return response()->json(['danger' => 'The coupon has already been applied']);
            }


            session()->put('coupon', ['code' => $request->code, 'amount' => $amount]);

            return response()->json([
                'success' => 'Copon applied successfully',
                'code'    => $coupon->code,
                'amount'  => $amount
            ]);
        } else {
            return response()->json(['danger' => 'The coupon does not exist']);
        }
    }


    public function update(Request $request)
    {
        // dd($request->prod_qty);
        
        if ($request->prod_qty <= 0) {
            return response()->json(['danger' => 'Quantity must be greater than  0']);
        }
        
        $prod_id = $request->input('prod_id');
        $prod_qty = $request->input('prod_qty');
        $attribute = $request->attribute;
        $cartId = $request->cartId;
        $stock_qty  = showAvailableStock($prod_id, $attribute);
        if($prod_qty > $stock_qty)
        {
            return response()->json(['error' => 'Sorry your requested amount of quantity is not available in our stock']);
        }else{
            $cart_item = Cart::where('id', $cartId)->first();
            // dd($cart_item);
            $cart_item->quantity = $prod_qty;
            $cart_item->update();
            return response()->json(['success' => 'Quantity updated']);
        }
        // dd($stock_qty);

    }
}