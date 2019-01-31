<?php

namespace App\Http\Controllers;

use App\Http\Resources\Product\ProductCollection;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  response()->json(Product::all());
    }


}
