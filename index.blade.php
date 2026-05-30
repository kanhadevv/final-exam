@extends('layout')

@section('content')

<h2>Product List</h2>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Status</th>
        <th width="250px">Action</th>
    </tr>

    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->product_name }}</td>
        <td>{{ $product->category }}</td>
        <td>{{ $product->price }}</td>
        <td>{{ $product->quantity }}</td>
        <td>{{ $product->status }}</td>
        <td>
            <a class="btn btn-info btn-sm" href="{{ route('products.show',$product->id) }}">Show</a>
            <a class="btn btn-warning btn-sm" href="{{ route('products.edit',$product->id) }}">Edit</a>

            <form action="{{ route('products.destroy',$product->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $products->links() }}

@endsection
