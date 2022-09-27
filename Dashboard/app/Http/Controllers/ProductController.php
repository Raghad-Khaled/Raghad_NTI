<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\HasMedia;
use Illuminate\Http\Request;
use Doctrine\Inflector\InflectorFactory;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\fileExists;

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
        return view('product.index',compact('products'));
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
        return view('product.create',compact('brands','subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en'=>['required','string','between:2,512'],
            'name_ar'=>['required','string','between:2,512'],
            'price'=>['required','numeric','between:1,99999.99'],
            'quantity'=>['nullable','integer','between:1,999'],
            'code'=>['required','integer','digits:6','unique:products'],
            'status'=>['nullable','in:1,0'],
            'brand_id'=>['nullable','integer','exists:brands,id'],
            'subcategory_id'=>['required','integer','exists:subcategories,id'],
            'details_en'=>['required','string'],
            'details_ar'=>['required','string'],
            'image'=>['required','image','max:1024']
        ]);
        $imageName =HasMedia::upload($request->file('image'),public_path('images\products'));
        $data = $request->except('_token','image');
        $data['image'] = $imageName;
        //Product::create($data);
        DB::insert('insert into products (name_en,name_ar,price,quantity,code,
        status,brand_id,subcategory_id,details_en,details_ar,image) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', 
        [$data['name_en'],$data['name_ar'],$data['price'],
        $data['quantity'],$data['code'],$data['status'],$data['brand_id'],$data['subcategory_id'],
        $data['details_en'],$data['details_ar'],$data['image']]);
        return redirect()->route('dashboard.products')->with('success','Product Created Successfully');
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
        $product=DB::select('select * from products where id= ?',[$id]);
        $brands=DB::select('select id, name_en	from brands');
        $subcategories=DB::select('select id, name_en	from subcategories');
        if(count($product)==0){
            abort(404);
        }
        $product=$product[0];
        return view('product.edit',compact('product','brands','subcategories'));

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
        $data = $request->except('_token','image','_method');
        $request->validate([
            'name_en'=>['required','string','between:2,512'],
            'name_ar'=>['required','string','between:2,512'],
            'price'=>['required','numeric','between:1,99999.99'],
            'quantity'=>['required','integer','between:1,999'],
            'code'=>['required','integer','digits:6','unique:products,code,'.$id],
            'status'=>['nullable','in:1,0'],
            'brand_id'=>['nullable','integer','exists:brands,id'],
            'subcategory_id'=>['required','integer','exists:subcategories,id'],
            'details_en'=>['required','string'],
            'details_ar'=>['required','string'],
            'image'=>['nullable','image','max:1024']
        ]);
        $product=Product::findOrFail($id);
        if($request->hasFile('image')){
            // $imageName = $request->file('image')->hashName();
            // $request->file('image')->move(public_path('images\products'),$imageName);

            // if(fileExists(public_path('images\products\\'.$product->image))){ //delete old image
            //     unlink(public_path('images\products\\'.$product->image));
            // }

            $imageName=HasMedia::upload($request->file('image'),public_path('images\products'));
            HasMedia::delete(public_path('images\products\\'.$product->image));
            $data['image']=$imageName;
        }

        $product->update($data);
        return redirect()->route('dashboard.products')->with('success','Product Updated Successfully');
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
        if(fileExists(public_path('images\products\\'.$product->image))){ //delete old image
            unlink(public_path('images\products\\'.$product->image));
        }
        $product->delete();
        return redirect()->route('dashboard.products')->with('success','Product Deleted Successfully');
    }
}
