@extends('layouts.app')

@section('content')
<div class="container">
  @if (request()->session()->has('message'))
  <div class="alert alert-success mt-3" role="alert">
    {{ request()->session()->pull('message') }}
  </div>
  @endif
  <div class="row mt-2">
    @foreach ($products as $product)
    <div class="col-6 col-md-3 mb-2">
      <div class="card">
        <img src="/images/{{ $product->image }}" class="card-img-top">
        <div class="card-body">
          <h5 class="card-title single-line">{{ $product->name }}</h5>
          <p class="text-danger">฿ {{ $product->price }}</p>
          <a href="/product/{{ $product->id }}" class="btn btn-outline-success w-100">เลือกสินค้า</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
