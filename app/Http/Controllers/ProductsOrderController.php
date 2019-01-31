<?php

namespace App\Http\Controllers;

use App\Model\Order;
use App\Model\Product;
use App\User;
use Illuminate\Http\Request;

class ProductsOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'user_id'=>'required',
            'ordered_product_ids'=>'required',
        ]);
        $ordered_products=array();
        $total_price=0;
        $re = '/^\d+(?:,\d+)*$/';
        $product_ids=$request->get('ordered_product_ids');
        $user_id=$request->get('user_id');
        $user_check=User::where('user_id', $user_id)->exists();
        if($user_check==false){
            return $response="user against this user_id does not exist in database";
        }

        if ( preg_match($re, $product_ids) )
        {
            $product_array=explode(',', $product_ids);
            foreach ($product_array as $product_id)
            {
                $id_check=Product::where('id', $product_id)->exists();
                if($id_check==false){
                    return $response="product_id(s) does not exist in product table";
                }

            }
        }

        else{
            return $response='Ordered_product_ids variable should only contains numeric value greater than 0 and separated by commas ';
        }


         foreach ($product_array as $item)
        {

            $product_details=Product::find($item);

            array_push($ordered_products, $product_details->name);

            $total_price=$total_price+$product_details->price;

        }

        $order=new Order();
        $order->user_id=$user_id;
        $order->ordered_product_ids=$product_ids;
        $order->total_price=$total_price;
        $order->save();

        $response=['Ordered_Products'=>$ordered_products,
        'Total_price'=>$total_price];
        return response()->json($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
