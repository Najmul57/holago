<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStocks;
use App\Models\StockLog;
use App\Models\ProductAttribute;

class ProductStocksController extends Controller
{
	public function stockCreate($product_id)
    {
        $product                = Product::find($product_id);
        if($product->track_inventory == 0){
            $alert = ['danger', 'Inventory tracking is disabled for this product'];
            return redirect()->back()->withAlert($alert);
        }
        $title             = 'Manage Inventory';

        $assigned_attributes    = ProductAttribute::where('product_id', $product_id)->with(['productAttribute'])->get()->groupBy('attribute_id');

        foreach($assigned_attributes as $attributes){
            foreach ($attributes as $attribute){
                $attr_array[] =  $attribute->id.'-'.$attribute->productAttribute->name. '-' . $attribute->name;
            }
            $attr_data[] = $attr_array;
            unset($attr_array);
        }
        if(isset($attr_data)){
            $combinations =  combinations($attr_data);
        }else{
            $combinations = [];
        }

        $data = [];

        foreach($combinations as $key=>$combination){
            unset($attr_id);
            $result = '';
            $temp_result = [];
            foreach($combination as $attribute){
                $temp       = [];
                $exp        = explode('-',$attribute);
                $result    .= $exp[1].' : ' . $exp[2];
                $attr_id[]  = $exp[0];

                if(end($combination) != $attribute){
                    $result .= ' - ';
                }

                $attr_val = json_encode($attr_id);
            }

            $stock = getStockData($product->id, $attr_val);
            $data[$key]['combination']  = $result;
            $data[$key]['attributes']   = $attr_val;
            $data[$key]['sku']          = $stock['sku']??null;
            $data[$key]['quantity']     = $stock['quantity']??0;
            $data[$key]['price']     = $stock['price']??0.00;
            $data[$key]['stock_id']     = $stock['id']??0;
        }

        return view('admin.product.stock.create', compact('title', 'data', 'product'));
    }

    public function stockAdd(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'attr'          =>'sometimes|required|string',
            'quantity'      =>'required|numeric|min:0',
            // 'sku'           =>'sometimes|required|string|max:100',
            // 'type'          =>'required|numeric|between:1,2',
            'price'          =>'nullable',
        ]);

        $attributes = $request->attr=='null'?null: $request->attr;

        if($attributes){
            $attributes = json_decode($attributes);
            sort($attributes);
            $attributes = json_encode($attributes);
        }


            $qty = $request->quantity;


        $stock = ProductStocks::where('product_id', $id)->where('attributes', $attributes)->first();

        if($stock){

            //check sku in product table
            $check_sku = Product::where('sku', $request->sku)->where('id', '!=', $id)->first();

            if($check_sku){
                $alert=['danger','This SKU has already been taken'];
                return back()->withAlert($alert);
            }else{
                $check_sku = ProductStocks::where('product_id', '!=' ,$id)->where('attributes', '!=' ,$attributes)->where('sku', $request->sku)->first();
                if($check_sku){
                    $alert=['danger','This SKU has already been taken'];
                    return back()->withAlert($alert);
                }else{
                    $stock->product_id = $id;
                    $stock->attributes = $attributes;
                    $stock->sku        = $request->sku;
                    $stock->price       = $request->price??0;
                    $stock->quantity   = $qty;
                    $stock->save();
                }
            }

        }else{
            //check sku
            $check_sku = Product::where('sku', $request->sku)->where('id', '!=', $id)->with('stocks')->orWhereHas('stocks', function($q)use($request){
                $q->where('sku', $request->sku);
            })->first();

             if($check_sku){
                 $alert = ['danger', 'This SKU has already been taken'];
                 return redirect()->back()->withAlert($alert);
             }

            $stock = new ProductStocks();
            $stock->product_id = $id;
            $stock->attributes = $attributes;
            $stock->sku        = $request->sku;
            $stock->price      = $request->price??0;
            $stock->quantity   = $request->quantity;
            $stock->save();
        }


        if($qty > 0){

            $log = new StockLog;
            $log->stock_id  = $stock->id;
            $log->quantity  = $qty;
            $log->type      = 1;
            $log->save();
        }

        $alert = ['success', 'Product Stock Updated Successfully'];
        return redirect()->back()->withAlert($alert);
    }

    public function stockLog($id)
    {

        $empty_message  = 'Stock log is empty';
        $product_stock  = ProductStocks::find($id);
        $title     = "Stock Logs For SKU:" .@$product_stock->sku;

        if($product_stock){
            $stock_logs     = $product_stock->stockLogs()->paginate(20);
        }else{
            $alert = ['danger', 'No inventory created yet'];
            return redirect()->back()->withAlert($alert);
        }
        return view('admin.product.stock.log', compact('title', 'empty_message', 'product_stock' , 'stock_logs'));
    }

    public function stocks()
    {
        $title     = 'Items in Stock';
        $empty_message  = 'Stock is empty';
        $stock_data     = ProductStocks::where('quantity', '>' , 0)->with('product', function($q){
            return $q->whereHas('categories')->whereHas('brand');
        })->paginate(20);
        return view('admin.product.items_in_stock', compact('stock_data', 'title', 'empty_message'));
    }

    public function stocksLow()
    {
        $title     = 'Quantity Low Stock';
        $empty_message  = 'No Product Available Here';
        $stock_data     = ProductStocks::where('quantity', '<=' , 5)->where('quantity','!=',0)->with('product', function($q){
            return $q->whereHas('categories')->whereHas('brand');
        })->paginate(20);
        return view('admin.product.items_in_stock', compact('stock_data', 'title', 'empty_message'));
    }

    public function stocksEmpty()
    {
        $title     = 'Quantity Low Stock';
        $empty_message  = 'No Product Available Here';
        $stock_data     = ProductStocks::where('quantity', 0)->with('product', function($q){
            return $q->whereHas('categories')->whereHas('brand');
        })->paginate(20);
        return view('admin.product.items_in_stock', compact('stock_data', 'title', 'empty_message'));
    }

}
