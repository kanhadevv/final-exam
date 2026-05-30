@extends('layout')

@section('content')
    <h2>Product Details</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->product_name }}</h5>
            <p class="card-text mb-2"><strong>Category:</strong> {{ $product->category }}</p>
            <p class="card-text mb-2"><strong>Price:</strong> {{ $product->price }}</p>
            <p class="card-text mb-2"><strong>Quality:</strong> {{ $product->quality }}</p>
            <p class="card-text mb-0"><strong>Status:</strong> {{ $product->status }}</p>
        </div>
    </div>

    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
