<!DOCTYPE html>


@extends('layout')

@section('content')
    <div class="container-flex">
        @foreach($products as $product)
            <div class="card">
                <div class="card-head">
                    <span class="product-price">
                    $<b>{{number_format( $product->price, 0 )}}</b>
                    </span>
                    <img widht="260" height="260" src="{{url('img/'.$product->product_image)}}" alt="logo" >
                </div>
                <div class="card-body">
                    <h2>{{$product->product_name}}</h2>
                    <a class="button" href="{{ route('orders.create', $product->id) }}">Comprar</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
