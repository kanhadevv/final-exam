@extends('layout')

@section('content')

<h2>Product Details</h2>

<div class="card">
    <div class="card-body">
        <h5>Product Name: {{ $product->product_name }}</h5>
        <span>Category: {{ $product->category }}</span><br>
        <span>Price: {{ $product->price }}</span><br>
        <span>Quantity: {{ $product->quantity }}</span><br>
        <span>Status: {{ $product->status }}</span><br>
    </div>
</div>

<a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back</a>

@endsection
