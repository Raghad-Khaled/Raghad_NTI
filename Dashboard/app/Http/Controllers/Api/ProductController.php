<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\HasMedia;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products= DB::select('select * from products');
        return response()->json(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands=DB::select('select id, name_en	from brands');
        $subcategories=DB::select('select id, name_en	from subcategories');
        return response()->json(compact('brands','subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $imageName =HasMedia::upload($request->file('image'),public_path('images\products'));
        $data = $request->except('image');
        $data['image'] = $imageName;
        Product::create($data);
        return response()->json(
            [
                'sucsses'=>true,
                'message'=>'Product created'
            ]
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::findOrFail($id);
        $brands=DB::select('select id, name_en	from brands');
        $subcategories=DB::select('select id, name_en	from subcategories');
        return response()->json(compact('product','brands','subcategories'));

    }


    public function update(UpdateProductRequest $request, $id)
    {
        $data = $request->except('image');
        $product=Product::findOrFail($id);
        if($request->hasFile('image')){
            $imageName=HasMedia::upload($request->file('image'),public_path('images\products'));
            HasMedia::delete(public_path('images\products\\'.$product->image));
            $data['image']=$imageName;
        }

        $product->update($data);
        return response()->json(
            [
                'sucsses'=>true,
                'message'=>'Product Updated sucessfully'
            ]
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        HasMedia::delete(public_path('images\products\\'.$product->image));
        $product->delete();
        return response()->json(
            [
                'sucsses'=>true,
                'message'=>'Product Deleted sucessfully'
            ]
        );
    }
}
