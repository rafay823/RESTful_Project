<?php

namespace App\Http\Controllers;

use App\Model\Product;
use App\User;
use Illuminate\Http\Request;

class PriceUpdateController extends Controller
{


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'user_id'=>'required',
            'SetPrice'=>'required',
        ]);
        $user_id=$request->get('user_id');
        if(is_numeric($user_id) and $user_id>0){
            $check_admin=User::select('admin')->where('user_id', $user_id)->first();
        }
        else{

            return $response='user_id field should be numeric and greater than 0';
        }
        if($check_admin->admin==1){
            $current_Price=Product::select('price')->where('id', $id)->first();
            $set_price=$request->get('SetPrice');
            if($set_price>0) {

                if (is_numeric($set_price)) {
                    $new_price = Product::find($id)->update(['price' => $set_price]);
                    $updated_price = Product::select('price')->where('id', $id)->first();
                    $response = ['New_Price' => $updated_price->price, 'Previous_Price' => $current_Price->price];
                } else {
                    $response = 'entered value is not numeric';

                }
            }
            else{
                $response='Entered value must me greater than 0 and it should be numeric value';
            }
            return $response;



        }
        else{

            return $response='user does not have admin rights';
        }




    }


}
