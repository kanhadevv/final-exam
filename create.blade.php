@extends('layout')

@section('content')

<h2>Create Products</h2>

<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Product Name:</label>
        <input type="text" name="product_name" class="form-control">
    </div>

    <div class="mb-3">
        <label>Category:</label>
        <input type="text" name="category" class="form-control">
    </div>

    <div class="mb-3">
        <label>Price:</label>
        <input type="text" name="price" class="form-control">
    </div>

    <div class="mb-3">
        <label>Quantity:</label>
        <input type="text" name="quantity" class="form-control">
    </div>
        <div class="mb-3">
        <label>Status:</label>
        <input type="text" name="status" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Submit</button>
</form>

@endsection
