@extends('layouts.parent')

@section('title', 'Create Product')


@section('contant')
    <div class="container">
        <form action="{{ route('dashboard.products.update',$product->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name_en">Name EN</label>
                        <input type="text" class="form-control" value="{{$product->name_en}}" id="name_en" name="name_en">
                    </div>
                    @error('name_en')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="name_ar">Name AR</label>
                        <input type="text" class="form-control" value="{{$product->name_ar}}" id="name_ar" name="name_ar">
                    </div>
                    @error('name_ar')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="price"> Price</label>
                        <input type="number" class="form-control" value="{{$product->price}}" id="price" name="price">
                    </div>
                    @error('price')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="quantity">Quentity</label>
                        <input type="number" class="form-control" value="{{$product->quantity}}" id="quantity" name="quantity">
                    </div>
                    @error('quantity')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="number" class="form-control" value="{{$product->code}}" id="code" name="code">
                    </div>
                    @error('code')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="status"> Status</label>
                        <select class="form-control" id="status" value="{{$product->status}}" name="status">
                            <option @selected($product->status==1) value="1">Active</option>
                            <option @selected($product->status==0) value="0">Not active</option>
                        </select>
                    </div>
                    @error('status')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="brand_id">Brand</label>
                        <select class="form-control" id="brand_id" name="brand_id">
                            @foreach($brands as $brand)
                            <option @selected($product->brand_id== $brand->id) value="{{$brand->id}}">{{$brand->name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('brand_id')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="subcategory">Subcategory</label>
                        <select class="form-control" id="subcategory_id" name="subcategory_id">
                            @foreach($subcategories as $subcategory)
                            <option @selected($product->subcategory_id == $subcategory->id) value="{{$subcategory->id}}">{{$subcategory->name_en}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('subcategory_id')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="details_en">Details EN</label>
                        <textarea name="details_en" id="details_en"  cols="30" rows="10" class="form-control">{{$product->details_en}}</textarea>
                    </div>
                    @error('details_en')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="details_ar">Details AR</label>
                        <textarea name="details_ar" id="details_ar" cols="30" rows="10" class="form-control">{{$product->details_ar}}</textarea>
                    </div>
                    @error('details_ar')
                        <div class="alert alert-danger" role="alert">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <img src="{{asset('images/products/'.$product->image)}}" class="w-50" alt="product image">
            </div>

            <div class="form-row">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control" id="image">
                @error('image')
                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <button type="submit" class="btn btn-primary btn-block mt-4">Update</button>
            </div>


        </form>
    </div>

@endsection
