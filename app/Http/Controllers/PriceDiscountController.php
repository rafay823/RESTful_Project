<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Model\Product;

class PriceDiscountController extends Controller
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
            'UpdatePrice'=>'required',
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
            $updated_price=$request->get('UpdatePrice');


            if( $updated_price[-1]=='%' AND $updated_price[0]=='-' )
            {
                $Transformation=explode('-',$updated_price);
                $Transformation=(string)$Transformation[1];
                $required_value=explode('%',$Transformation);
                $required_value=$required_value[0];
                if(is_numeric($required_value))
                {     //$response=$current_Price->price;

                    $required_value=(float)$required_value;
                    $discounted_price=$current_Price->price - (($current_Price->price)*($required_value/100));
                    if($discounted_price<0){
                        $discounted_price=0;
                    }
                    $update_price_database=Product::find($id)->update(['price' => $discounted_price]);
                    $response=['Discounted_Price'=>$discounted_price,'Actual_Price'=>$current_Price->price];

                }
                else{
                    $response='invalid input';
                }


            }
            elseif ($updated_price[-1]!='%' AND $updated_price[0]=='-'){



                $Transformation=explode('-',$updated_price);
                $required_value=(string)$Transformation[1];
                if(is_numeric($required_value)) {
                    $required_value=(float)$required_value;
                    $discounted_price=$current_Price->price - $required_value;
                    if($discounted_price<0){
                        $discounted_price=0;
                    }
                    $update_price_database=Product::find($id)->update(['price' => $discounted_price]);
                    $response=['Discounted_Price'=>$discounted_price,'Actual_Price'=>$current_Price->price];



                }
                else{
                    $response='invalid input';
                }


            }
            else{

                $response='invalid input';
            }

            return $response;



        }

        else{

            return $response='user does not have admin rights';
        }



    }

}
