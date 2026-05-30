@extends('layout')

@section('content')

<h2>Edit Product</h2>

<form action="{{ route('products.update',$product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Product Name:</label>
        <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Category:</label>
        <input type="text" name="category" value="{{ $product->category }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Price:</label>
        <input type="text" name="price" value="{{ $product->price }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Quantity:</label>
        <input type="text" name="quantity" value="{{ $product->quantity }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Status:</label>
        <input type="text" name="status" value="{{ $product->status }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection
