<?php

namespace App\Http\Controllers;

use App\group;
use App\Model\Product;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'group_name'=>'required',
            'group_price'=>'required',
            'product_ids'=> 'required',
            'user_id'=>'required'
        ]);

        $user_id=$request->get('user_id');
        if(is_numeric($user_id) and $user_id>0){
            $check_admin=User::select('admin')->where('user_id', $user_id)->first();
        }
        else{

            return $response='user_id field should be numeric and greater than 0';
        }

        if($check_admin->admin==1){
            $re = '/^\d+(?:,\d+)*$/';
            $product_ids=$request->get('product_ids');
            if ( preg_match($re, $product_ids) )
            {
                $product_array=array($product_ids);
                foreach ($product_array as $product_id)
                {
                    $id_check=Product::where('id', $product_id)->exists();
                    if($id_check==false){
                        return $response="entry against this".$product_id."does not exist in product table";
                    }

                }

            }
            else{
                return $response='product_ids variable should only contains numeric value greater than 0 and seprated by commas ';
            }


            if(is_numeric($request->get('group_price')) and $request->get('group_price')>=0){
                $group_price=$request->get('group_price');
            }
            else{
                return $response='group_price variable value should be numeric and greater than 0';
            }

            $group_name=$request->get('group_name');
            $group= new \App\Model\Group();
            $group->group_name=$group_name;
            $group->group_price=$group_price;
            $group->product_ids=$product_ids;
            $group->save();




            return $response='Group created succesfully';


        }
        else{

            return $response='user does not have admin rights';
        }



    }


}
