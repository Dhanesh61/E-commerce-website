@extends('layouts.admin-leyout')
@section('content')
<div class="container">
    <h1>Product History for {{ $product->name }}</h1>
    @if (!empty($oldData))
        <table class="table">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($oldData as $key => $values)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ is_array($values) ? implode(', ', $values) : $values }}</td>
                        <td>{{ $newData[$key] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No history available for this product.</p>
    @endif
    <a href="{{ route('product.index') }}" class="btn btn-primary">Back to Products</a>
</div>
@endsection